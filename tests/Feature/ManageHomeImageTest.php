<?php

namespace Tests\Feature;

use App\Livewire\ManageHomeImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    Permission::findOrCreate('manage home image');
});

test('component can be rendered', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage home image');

    $this->actingAs($user);

    Livewire::test(ManageHomeImage::class)
        ->assertStatus(200);
});

test('user with permission can upload an image', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('manage home image');

    $this->actingAs($user);

    if (! function_exists('imagecreatetruecolor')) {
        $this->markTestSkipped('GD extension is not installed.');
    }

    $file = UploadedFile::fake()->image('home.jpg');

    Livewire::test(ManageHomeImage::class)
        ->set('image', $file)
        ->call('uploadImage')
        ->assertHasNoErrors()
        ->assertSet('image', null)
        ->assertSessionHas('success', 'Image updated successfully!');

    $user->refresh();
    expect($user->home_image)->not->toBeNull();
    Storage::disk('public')->assertExists($user->home_image);
});

test('user without permission cannot upload an image', function () {
    $user = User::factory()->create();
    // No permission given

    $this->actingAs($user);

    if (! function_exists('imagecreatetruecolor')) {
        $this->markTestSkipped('GD extension is not installed.');
    }

    $file = UploadedFile::fake()->image('home.jpg');

    Livewire::test(ManageHomeImage::class)
        ->set('image', $file)
        ->call('uploadImage')
        ->assertSessionHas('error', 'You do not have permission to manage the home image.');

    $user->refresh();
    expect($user->home_image)->toBeNull();
});

test('user with permission can delete an image', function () {
    $user = User::factory()->create(['home_image' => 'home-images/test.jpg']);
    $user->givePermissionTo('manage home image');

    Storage::disk('public')->put('home-images/test.jpg', 'fake content');

    $this->actingAs($user);

    Livewire::test(ManageHomeImage::class)
        ->call('deleteImage')
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->home_image)->toBeNull();
    Storage::disk('public')->assertMissing('home-images/test.jpg');
});
