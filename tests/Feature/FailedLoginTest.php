<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class FailedLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'phone' => '08123456789',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }

    public function test_login_dengan_email_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email wajib diisi']);
        $response->assertRedirect();
    }

    public function test_login_dengan_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password' => 'Password wajib diisi']);
        $response->assertRedirect();
    }

    public function test_login_dengan_email_tidak_terdaftar()
    {
        $response = $this->post('/login', [
            'email' => 'tidakada@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau password salah']);
        $response->assertRedirect();
    }

    public function test_login_dengan_password_salah()
    {
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'passwordSALAH',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau password salah']);
        $response->assertRedirect();
    }

    public function test_login_dengan_format_email_invalid()
    {
        $response = $this->post('/login', [
            'email' => 'bukanemail',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Format email tidak valid']);
        $response->assertRedirect();
    }

    public function test_login_dengan_password_kurang_dari_8_karakter()
    {
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password' => 'Password minimal 8 karakter']);
        $response->assertRedirect();
    }

    public function test_login_dengan_email_dan_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertRedirect();
    }

    public function test_login_rate_limit_setelah_5_percobaan_gagal()
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'testuser@example.com',
                'password' => 'passwordSALAH',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'passwordSALAH',
        ]);

        $response->assertStatus(429);
    }
}
