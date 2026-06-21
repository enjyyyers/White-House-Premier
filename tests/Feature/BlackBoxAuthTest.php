<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class BlackBoxAuthTest extends TestCase
{
    use DatabaseTransactions;

    private array $userData = [];
    private array $adminData = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->userData = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ];

        $this->adminData = [
            'name' => 'Admin Utama',
            'email' => 'admin@whitehouse.com',
            'phone' => '081234567891',
            'password' => 'admin1234',
            'password_confirmation' => 'admin1234',
            'role' => 'admin',
        ];
    }

    public function test_register_akun_baru()
    {
        $response = $this->post('/register', $this->userData);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'role' => 'user',
        ]);
        $this->assertAuthenticated();
    }

    public function test_register_email_duplikat()
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/register', $this->userData);

        $response->assertSessionHasErrors('email');
        $response->assertRedirect();
    }

    public function test_register_validasi_name_kosong()
    {
        $data = $this->userData;
        $data['name'] = '';

        $response = $this->post('/register', $data);

        $response->assertSessionHasErrors('name');
        $response->assertRedirect();
    }

    public function test_register_password_tidak_sama()
    {
        $data = $this->userData;
        $data['password_confirmation'] = 'berbeda123';

        $response = $this->post('/register', $data);

        $response->assertSessionHasErrors('password');
        $response->assertRedirect();
    }

    public function test_login_valid_user()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_login_valid_admin()
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@whitehouse.com',
            'phone' => '081234567891',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@whitehouse.com',
            'password' => 'admin1234',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_email_kosong()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email wajib diisi']);
        $response->assertRedirect();
    }

    public function test_login_password_kosong()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password' => 'Password wajib diisi']);
        $response->assertRedirect();
    }

    public function test_login_email_tidak_terdaftar()
    {
        $response = $this->post('/login', [
            'email' => 'tidakada@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau password salah']);
        $response->assertRedirect();
    }

    public function test_login_password_salah()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'passwordSALAH',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau password salah']);
        $response->assertRedirect();
    }

    public function test_login_format_email_invalid()
    {
        $response = $this->post('/login', [
            'email' => 'bukanemail',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'Format email tidak valid']);
        $response->assertRedirect();
    }

    public function test_login_password_kurang_8_karakter()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => '1234567',
        ]);

        $response->assertSessionHasErrors(['password' => 'Password minimal 8 karakter']);
        $response->assertRedirect();
    }

    public function test_login_email_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertRedirect();
    }

    public function test_login_rate_limit_5_percobaan()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'budi@example.com',
                'password' => 'passwordSALAH',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'passwordSALAH',
        ]);

        $response->assertStatus(429);
    }

    public function test_logout()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->post('/login', [
            'email' => 'budi@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_forgot_password_mengirim_link()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'budi@example.com',
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect();

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'budi@example.com',
        ]);
    }

    public function test_forgot_password_email_tidak_terdaftar()
    {
        $response = $this->post('/forgot-password', [
            'email' => 'tidakada@example.com',
        ]);

        $response->assertSessionHasErrors('email');
        $response->assertRedirect();
    }

    public function test_profile_user_dapat_diakses()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    public function test_profile_update_data()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Budi Santoso Update',
            'email' => 'budi@example.com',
            'phone' => '081234567891',
            'address' => 'Jl. Merdeka No. 1',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Budi Santoso Update',
            'phone' => '081234567891',
        ]);
    }

    public function test_profile_update_password()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_profile_update_password_salah()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'salahpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    public function test_hapus_akun()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->delete('/profile');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_toggle_favorite()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng, Jakarta Pusat',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah di kawasan Menteng',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post("/favorite/{$property->id}");
        $response->assertJson(['status' => 'added']);

        $this->assertDatabaseHas('saved_properties', [
            'user_id' => $user->id,
            'property_id' => $property->id,
        ]);

        $response2 = $this->actingAs($user)->post("/favorite/{$property->id}");
        $response2->assertJson(['status' => 'removed']);

        $this->assertDatabaseMissing('saved_properties', [
            'user_id' => $user->id,
            'property_id' => $property->id,
        ]);
    }

    public function test_saved_properties_halaman()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng, Jakarta Pusat',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $user->savedProperties()->attach($property->id);

        $response = $this->actingAs($user)->get('/saved-properties');
        $response->assertStatus(200);
    }

    public function test_user_dashboard()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard()
    {
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@whitehouse.com',
            'phone' => '081234567891',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_user_tidak_bisa_akses_admin()
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_halaman_publik_dapat_diakses()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/project');
        $response->assertStatus(200);

        $response = $this->get('/testimoni');
        $response->assertStatus(200);

        $response = $this->get('/contact');
        $response->assertStatus(200);
    }
}
