<?php

namespace Tests;

use App\Models\Company;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Create fake user
        $user = User::factory()->create();
        // Create fake companies
        $companies = Company::factory()->count(2)->create();
        // Attach company to user
        $user->companies()->attach($companies);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);
        // Set the tenant
        Filament::setTenant($companies->first());
    }
}
