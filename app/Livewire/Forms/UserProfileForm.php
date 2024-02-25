<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UserProfileForm extends Form
{
    use WithFileUploads;

    #[Validate('image|max:512')]
    public $avatar;

    #[Validate('string|max:255')]
    public string $name = '';
}
