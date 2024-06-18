<?php

use App\Filament\Resources\AdministratorResource;
use App\Models\Administrator;
use Database\Seeders\ShieldSeeder;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->admin = Administrator::factory()->create();
    $this->seed(ShieldSeeder::class);
    $this->actingAs($this->admin, 'admin');
    $this->admin->assignRole('super_admin');
});

describe('admin administrator', function () {

    test('can access administrator list', function () {
        $administrators = Administrator::factory()->count(10)->create();

        livewire(AdministratorResource\Pages\ListAdministrators::class)
            ->sortTable('id', 'desc')
            ->assertCanSeeTableRecords($administrators);
    });

    test('can create administrator', function () {
        $admin = Administrator::factory()->make();

        livewire(AdministratorResource\Pages\CreateAdministrator::class)
            ->fillForm([
                'username' => $admin->username,
                'name' => $admin->name,
                'password' => 'password',
                'passwordConfirmation' => 'password',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Administrator::class, [
            'username' => $admin->username,
            'name' => $admin->name,
        ]);
    });

    test('can update administrator', function () {
        $administrator = Administrator::factory()->create();
        $new_username = fake('en')->unique()->firstName;
        $new_name = fake()->unique()->name;
        echo $new_name.PHP_EOL;

        livewire(AdministratorResource\Pages\EditAdministrator::class, [
            'record' => $administrator->getRouteKey(),
        ])->assertFormSet([
            'username' => $administrator->username,
            'name' => $administrator->name,
        ])->fillForm([
            'username' => $new_username,
            'name' => $new_name,
        ])->call('save')->assertHasNoFormErrors();

        $this->assertDatabaseHas(Administrator::class, [
            'username' => $new_username,
            'name' => $new_name,
        ]);
    });

});
