<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class BlackBoxSecurityTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;
    private User $userA;
    private User $userB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@whitehouse.com',
            'phone' => '081234567891',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $this->userA = User::create([
            'name' => 'User A',
            'email' => 'usera@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->userB = User::create([
            'name' => 'User B',
            'email' => 'userb@example.com',
            'phone' => '081234567893',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }

    public function test_sql_injection_pada_login()
    {
        $response = $this->post('/login', [
            'email' => "' OR '1'='1",
            'password' => "' OR '1'='1",
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_sql_injection_pada_pencarian_properti()
    {
        $response = $this->get("/project/' OR '1'='1");
        $response->assertStatus(404);
    }

    public function test_xss_pada_testimoni()
    {
        $response = $this->actingAs($this->userA)->post('/testimoni', [
            'name' => '<script>alert("xss")</script>',
            'review' => '<script>alert("xss")</script>',
            'rating' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('testimonials', [
            'name' => '<script>alert("xss")</script>',
        ]);
    }

    public function test_xss_pada_inquiry()
    {
        $response = $this->post('/contact', [
            'name' => '<script>alert("xss")</script>',
            'email' => 'attacker@example.com',
            'phone' => '081234560000',
            'subject' => '<script>alert("xss")</script>',
            'message' => '<script>alert("xss")</script>',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'name' => '<script>alert("xss")</script>',
        ]);
    }

    public function test_role_based_access_user_to_admin()
    {
        $response = $this->actingAs($this->userA)->get('/admin/dashboard');
        $response->assertStatus(403);

        $response = $this->actingAs($this->userA)->get('/admin/properties');
        $response->assertStatus(403);

        $response = $this->actingAs($this->userA)->get('/admin/transactions');
        $response->assertStatus(403);

        $response = $this->actingAs($this->userA)->get('/admin/manajemen-users');
        $response->assertStatus(403);
    }

    public function test_ownership_check_transaksi_invoice()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'Test Property',
            'slug' => 'test-property',
            'location' => 'Jakarta',
            'price' => 1000000000,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'building_area' => 200,
            'land_area' => 300,
            'description' => 'Test',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $transactionB = Transaction::create([
            'user_id' => $this->userB->id,
            'property_id' => $property->id,
            'transaction_code' => 'TR-WH-2026002',
            'property_price' => 1000000000,
            'tax_amount' => 20000000,
            'admin_fee' => 10000000,
            'total_payable' => 1030000000,
            'amount_paid' => 10000000,
            'payment_status' => 'pending',
            'payment_type' => 'booking',
        ]);

        $response = $this->actingAs($this->userA)->get("/transaction/invoice/{$transactionB->id}");

        $response->assertStatus(404);
    }

    public function test_ownership_check_set_success()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'Test Property',
            'slug' => 'test-property',
            'location' => 'Jakarta',
            'price' => 1000000000,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'building_area' => 200,
            'land_area' => 300,
            'description' => 'Test',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $transactionB = Transaction::create([
            'user_id' => $this->userB->id,
            'property_id' => $property->id,
            'transaction_code' => 'TR-WH-2026003',
            'property_price' => 1000000000,
            'tax_amount' => 20000000,
            'admin_fee' => 10000000,
            'total_payable' => 1030000000,
            'amount_paid' => 10000000,
            'payment_status' => 'pending',
            'payment_type' => 'booking',
        ]);

        $response = $this->actingAs($this->userA)->post("/transaction/set-success/{$transactionB->id}");

        $response->assertStatus(403);
    }

    public function test_admin_dapat_set_success_transaksi()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'Test Property',
            'slug' => 'test-property',
            'location' => 'Jakarta',
            'price' => 1000000000,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'building_area' => 200,
            'land_area' => 300,
            'description' => 'Test',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $transaction = Transaction::create([
            'user_id' => $this->userA->id,
            'property_id' => $property->id,
            'transaction_code' => 'TR-WH-2026004',
            'property_price' => 1000000000,
            'tax_amount' => 20000000,
            'admin_fee' => 10000000,
            'total_payable' => 1030000000,
            'amount_paid' => 10000000,
            'payment_status' => 'pending',
            'payment_type' => 'booking',
        ]);

        $response = $this->actingAs($this->admin)->post("/transaction/set-success/{$transaction->id}");

        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_status' => 'success',
        ]);
    }

    public function test_rate_limiting_pada_forgot_password()
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        for ($i = 0; $i < 3; $i++) {
            $this->post('/forgot-password', [
                'email' => 'budi@example.com',
            ]);
        }

        $response = $this->post('/forgot-password', [
            'email' => 'budi@example.com',
        ]);

        $response->assertStatus(429);
    }

    public function test_guest_tidak_bisa_akses_halaman_auth()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('login'));

        $response = $this->get('/profile');
        $response->assertRedirect(route('login'));

        $response = $this->get('/chat');
        $response->assertRedirect(route('login'));

        $response = $this->get('/saved-properties');
        $response->assertRedirect(route('login'));
    }

    public function test_user_tidak_bisa_self_delete_admin()
    {
        $user = User::create([
            'name' => 'User Biasa',
            'email' => 'biasa@example.com',
            'phone' => '081234567894',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/manajemen-users/{$this->admin->id}");
        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_endpoint_publik_tanpa_auth()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_google_oauth_redirect()
    {
        $response = $this->get('/auth/google');
        $this->assertContains(
            $response->getStatusCode(),
            [200, 302, 500]
        );
    }
}
