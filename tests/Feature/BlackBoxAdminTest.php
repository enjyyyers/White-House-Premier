<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use App\Models\Type;
use App\Models\Facility;
use App\Models\Testimonial;
use App\Models\VisitSchedule;
use App\Models\Transaction;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class BlackBoxAdminTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;
    private User $user;

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

        $this->user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }

    public function test_admin_dashboard_statistik()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('The Grand Residence');
    }

    public function test_admin_tambah_properti()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $file = UploadedFile::fake()->image('properti.jpg', 800, 600);

        $response = $this->actingAs($this->admin)->post('/admin/properties', [
            'name' => 'The Grand Residence',
            'location' => 'Menteng, Jakarta Pusat',
            'price' => 5000000000,
            'category_id' => $category->id,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah di kawasan Menteng dengan desain arsitektur modern.',
            'status' => 'available',
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('properties', [
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'price' => 5000000000,
        ]);
    }

    public function test_admin_tambah_properti_validasi()
    {
        $response = $this->actingAs($this->admin)->post('/admin/properties', [
            'name' => '',
            'location' => '',
            'price' => 'bukanangka',
        ]);

        $response->assertSessionHasErrors(['name', 'location', 'price', 'category_id', 'image']);
        $response->assertRedirect();
    }

    public function test_admin_edit_properti()
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

        $response = $this->actingAs($this->admin)->put("/admin/properties/{$property->id}", [
            'name' => 'The Grand Residence Updated',
            'location' => 'Menteng, Jakarta Selatan',
            'price' => 6000000000,
            'category_id' => $category->id,
            'bedrooms' => 6,
            'bathrooms' => 5,
            'building_area' => 500,
            'land_area' => 700,
            'description' => 'Rumah mewah updated',
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'name' => 'The Grand Residence Updated',
            'price' => 6000000000,
        ]);
    }

    public function test_admin_hapus_properti()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/properties/{$property->id}");

        $response->assertRedirect(route('admin.properties.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_admin_lihat_properti()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/properties/{$property->id}");
        $response->assertRedirect(route('admin.properties.edit', $property->id));
    }

    public function test_admin_tambah_kategori()
    {
        $response = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'Rumah Mewah',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'name' => 'Rumah Mewah',
        ]);
    }

    public function test_admin_hapus_kategori()
    {
        $category = Category::create(['name' => 'Rumah Mewah', 'slug' => 'rumah-mewah']);

        $response = $this->actingAs($this->admin)->delete("/admin/categories/{$category->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_tambah_tipe()
    {
        $response = $this->actingAs($this->admin)->post('/admin/types', [
            'name' => 'Apartemen',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('types', [
            'name' => 'Apartemen',
        ]);
    }

    public function test_admin_hapus_tipe()
    {
        $type = Type::create(['name' => 'Apartemen', 'slug' => 'apartemen']);

        $response = $this->actingAs($this->admin)->delete("/admin/types/{$type->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('types', ['id' => $type->id]);
    }

    public function test_admin_tambah_fasilitas()
    {
        $response = $this->actingAs($this->admin)->post('/admin/facilities', [
            'name' => 'Kolam Renang',
            'icon' => 'pool',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('facilities', [
            'name' => 'Kolam Renang',
        ]);
    }

    public function test_admin_edit_fasilitas()
    {
        $facility = Facility::create(['name' => 'Kolam Renang', 'icon' => 'pool']);

        $response = $this->actingAs($this->admin)->put("/admin/facilities/{$facility->id}", [
            'name' => 'Kolam Renang Premium',
            'icon' => 'pool',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('facilities', [
            'id' => $facility->id,
            'name' => 'Kolam Renang Premium',
        ]);
    }

    public function test_admin_hapus_fasilitas()
    {
        $facility = Facility::create(['name' => 'Kolam Renang', 'icon' => 'pool']);

        $response = $this->actingAs($this->admin)->delete("/admin/facilities/{$facility->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('facilities', ['id' => $facility->id]);
    }

    public function test_admin_kelola_testimoni()
    {
        $testimonial = Testimonial::create([
            'user_id' => $this->user->id,
            'name' => 'Budi Santoso',
            'review' => 'Rumah bagus sekali!',
            'rating' => 5,
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/testimonials');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->put("/admin/testimonials/{$testimonial->id}", [
            'name' => 'Budi Santoso',
            'review' => 'Rumah bagus sekali! Update',
            'rating' => 5,
            'is_active' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'review' => 'Rumah bagus sekali! Update',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/testimonials/{$testimonial->id}/reply", [
            'reply' => 'Terima kasih atas reviewnya!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'reply' => 'Terima kasih atas reviewnya!',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/testimonials/{$testimonial->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_admin_kelola_inquiry()
    {
        $inquiry = Inquiry::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Info Properti',
            'message' => 'Saya tertarik dengan properti The Grand Residence.',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/inquiries');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get("/admin/inquiries/{$inquiry->id}");
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post("/admin/inquiries/{$inquiry->id}/reply", [
            'reply' => 'Terima kasih, akan kami hubungi.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'reply' => 'Terima kasih, akan kami hubungi.',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/inquiries/{$inquiry->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('inquiries', ['id' => $inquiry->id]);
    }

    public function test_admin_manajemen_user()
    {
        $response = $this->actingAs($this->admin)->get('/admin/manajemen-users');
        $response->assertStatus(200);

        $userToDelete = User::create([
            'name' => 'User To Delete',
            'email' => 'todelete@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/manajemen-users/{$userToDelete->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_admin_kelola_jadwal_kunjungan()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $visitSchedule = VisitSchedule::create([
            'user_id' => $this->user->id,
            'property_id' => $property->id,
            'visit_date' => now()->addDays(1)->format('Y-m-d'),
            'visit_time' => '10:00',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/visit-schedules');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->patch("/admin/visit-schedules/{$visitSchedule->id}/status", [
            'status' => 'approved',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('visit_schedules', [
            'id' => $visitSchedule->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_transaksi()
    {
        $category = Category::create(['name' => 'Rumah', 'slug' => 'rumah']);

        $property = Property::create([
            'name' => 'The Grand Residence',
            'slug' => 'the-grand-residence',
            'location' => 'Menteng',
            'price' => 5000000000,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'building_area' => 450,
            'land_area' => 600,
            'description' => 'Rumah mewah',
            'status' => 'available',
            'category_id' => $category->id,
        ]);

        $transaction = Transaction::create([
            'user_id' => $this->user->id,
            'property_id' => $property->id,
            'transaction_code' => 'TR-WH-2026001',
            'property_price' => 5000000000,
            'tax_amount' => 100000000,
            'admin_fee' => 10000000,
            'total_payable' => 5110000000,
            'amount_paid' => 10000000,
            'payment_status' => 'pending',
            'payment_type' => 'booking',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/transactions');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get("/admin/transactions/{$transaction->id}");
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->delete("/admin/transactions/{$transaction->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    public function test_admin_laporan_admin()
    {
        $response = $this->actingAs($this->admin)->get('/admin/laporan-admin');
        $response->assertStatus(200);
    }

    public function test_submit_kontak()
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Info Properti',
            'message' => 'Saya ingin informasi lebih lanjut.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'email' => 'budi@example.com',
            'subject' => 'Info Properti',
        ]);
    }

    public function test_submit_testimoni()
    {
        $response = $this->actingAs($this->user)->post('/testimoni', [
            'name' => 'Budi Santoso',
            'position' => 'Pengusaha',
            'review' => 'Rumah sangat bagus dan pelayanan memuaskan!',
            'rating' => 5,
        ]);

        $response->assertRedirect(route('testimoni'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonials', [
            'user_id' => $this->user->id,
            'rating' => 5,
        ]);
    }
}
