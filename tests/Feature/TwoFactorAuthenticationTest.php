<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;


class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_to_2fa_page_if_device_is_unfamiliar()
    {
        Mail::fake();

        $user = User::factory()->create([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'familiar_devices' => [],
        ]);

        $this->post('/login/save', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'two_factor_code' => $user->two_factor_code,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'two_factor_expires_at' => $user->two_factor_expires_at,
        ]);

        $this->get('/2fa')
            ->assertStatus(200)
            ->assertSee('Two Factor Authentication');
    }

    public function test_user_can_verify_2fa_code()
    {
        Mail::fake();

        $user = User::factory()->create([
            'two_factor_code' => '123456',
            'two_factor_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        $this->actingAs($user);

        $response = $this->post('/2fa', [
            'code' => '123456',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }

    public function test_user_cannot_verify_expired_2fa_code()
    {
        Mail::fake();

        $user = User::factory()->create([
            'two_factor_code' => '123456',
            'two_factor_expires_at' => Carbon::now()->subMinutes(10),
        ]);

        $this->actingAs($user);

        $response = $this->post('/2fa', [
            'code' => '123456',
        ]);

        $response->assertRedirect('/2fa');

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'two_factor_code' => '123456',
        ]);
    }
}