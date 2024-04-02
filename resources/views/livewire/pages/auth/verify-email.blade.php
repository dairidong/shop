<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\computed;
use function Livewire\Volt\layout;
use function Livewire\Volt\protect;

layout('layouts.app');

$sendVerification = function () {
    if (!$this->isNotRateLimited()) {
        return;
    }

    if (Auth::user()->hasVerifiedEmail()) {
        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
        return;
    }

    Auth::user()->sendEmailVerificationNotification();

    RateLimiter::hit($this->throttleKey());

    Session::flash('status', 'verification-link-sent');
};

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

$seconds = computed(fn() => RateLimiter::availableIn($this->throttleKey()));

$isNotRateLimited = protect(fn() => !RateLimiter::tooManyAttempts($this->throttleKey(), 1));

$throttleKey = protect(fn() => 'resend-email-user:' . auth()->user()->id);

?>

<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-20 sm:mt-60">
    <div>
        <a href="/" wire:navigate>
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="w-full max-w-sm sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden">
        <div>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <x-primary-button x-data="{
                                        locked: {{ json_encode($this->seconds > 0) }},
                                        seconds: {{ json_encode($this->seconds > 0 ? $this->seconds : 60) }},
                                        interval: null,
                                        startInterval(seconds) {
                                            this.locked = true;
                                            this.seconds = seconds;
                                            this.interval = setInterval(() => {
                                                this.seconds--;
                                                if (this.seconds === 0 && this.interval) {
                                                    this.locked = false;
                                                    clearInterval(this.interval)
                                                }
                                            }, 1000)
                                        }
                                  }"
                                  x-init="locked && startInterval(seconds)"
                                  @click="
                                        if(locked) return;
                                        $wire.sendVerification();
                                        startInterval(60);
                                  "
                                  class="px-6 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:shadow"
                                  ::disabled="locked"
                >
                    <div class="w-40"
                         x-text="locked ? `${seconds} 秒后可以重新发送` : '{{ __('Resend Verification Email') }}'"></div>
                </x-primary-button>

                <button wire:click="logout" type="submit"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>
</div>
