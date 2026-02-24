<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

test('database seeder provisions nick as admin with expected password and privileges', function () {
    $this->seed();

    $user = User::query()->where('email', 'nick@cara.dev')->first();

    expect($user)->not->toBeNull();
    expect(Hash::check('password', $user->password))->toBeTrue();
    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->getAllPermissions()->pluck('name')->sort()->values()->all())
        ->toEqual(Permission::query()->pluck('name')->sort()->values()->all());
});
