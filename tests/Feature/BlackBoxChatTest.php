<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class BlackBoxChatTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Chat',
            'email' => 'admin@whitehouse.com',
            'phone' => '081234567891',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);
    }

    public function test_user_buat_percakapan_baru()
    {
        $response = $this->actingAs($this->user)->post('/chat', [
            'subject' => 'Info The Grand Residence',
            'message' => 'Saya tertarik dengan properti ini. Apakah masih tersedia?',
        ]);

        $conversation = Conversation::where('user_id', $this->user->id)->first();
        $response->assertRedirect(route('chat.show', $conversation->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('conversations', [
            'user_id' => $this->user->id,
            'subject' => 'Info The Grand Residence',
            'status' => 'open',
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $this->user->id,
            'sender_type' => 'user',
            'message' => 'Saya tertarik dengan properti ini. Apakah masih tersedia?',
        ]);
    }

    public function test_user_buat_percakapan_validasi()
    {
        $response = $this->actingAs($this->user)->post('/chat', [
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['subject', 'message']);
        $response->assertRedirect();
    }

    public function test_user_kirim_pesan()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->user)->post("/chat/{$conversation->id}/send", [
            'message' => 'Apakah bisa diangsur?',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $this->user->id,
            'sender_type' => 'user',
            'message' => 'Apakah bisa diangsur?',
        ]);
    }

    public function test_user_kirim_pesan_ke_percakapan_tertutup()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'closed',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->user)->post("/chat/{$conversation->id}/send", [
            'message' => 'Pesan ini seharusnya ditolak.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('messages', [
            'conversation_id' => $conversation->id,
            'message' => 'Pesan ini seharusnya ditolak.',
        ]);
    }

    public function test_user_lihat_percakapan()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $this->user->id,
            'message' => 'Halo, saya tertarik.',
            'sender_type' => 'user',
        ]);

        $response = $this->actingAs($this->user)->get("/chat/{$conversation->id}");
        $response->assertStatus(200);
    }

    public function test_user_tidak_bisa_lihat_percakapan_orang_lain()
    {
        $userLain = User::create([
            'name' => 'User Lain',
            'email' => 'lain@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $conversation = Conversation::create([
            'user_id' => $userLain->id,
            'subject' => 'Info Properti Lain',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->user)->get("/chat/{$conversation->id}");

        $response->assertStatus(404);
    }

    public function test_user_lihat_daftar_percakapan()
    {
        Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Percakapan 1',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Percakapan 2',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->user)->get('/chat');
        $response->assertStatus(200);
        $response->assertSee('Percakapan 1');
        $response->assertSee('Percakapan 2');
    }

    public function test_admin_bisa_lihat_semua_percakapan()
    {
        Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Percakapan User',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/chat');
        $response->assertStatus(200);
        $response->assertSee('Percakapan User');
    }

    public function test_admin_bisa_balas_percakapan()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/chat/{$conversation->id}/send", [
            'message' => 'Terima kasih sudah menghubungi kami. Properti masih tersedia.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $this->admin->id,
            'sender_type' => 'admin',
            'message' => 'Terima kasih sudah menghubungi kami. Properti masih tersedia.',
        ]);
    }

    public function test_admin_tutup_percakapan()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/chat/{$conversation->id}/close");
        $response->assertRedirect();

        $this->assertDatabaseHas('conversations', [
            'id' => $conversation->id,
            'status' => 'closed',
        ]);
    }

    public function test_admin_buka_percakapan()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $this->user->id,
            'message' => 'Pesan dari user',
            'sender_type' => 'user',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/chat/{$conversation->id}");
        $response->assertStatus(200);
    }

    public function test_fetch_messages()
    {
        $conversation = Conversation::create([
            'user_id' => $this->user->id,
            'subject' => 'Info Properti',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $this->admin->id,
            'message' => 'Balasan admin',
            'sender_type' => 'admin',
        ]);

        $response = $this->actingAs($this->user)->get("/chat/{$conversation->id}/fetch");
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
