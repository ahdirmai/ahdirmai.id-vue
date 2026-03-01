<?php

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

it('stores a contact message', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class)
         ->post(route('contact.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Hello, I have a question about your services.',
    ])->assertRedirect();

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('validates required fields', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class)
         ->post(route('contact.store'), [])
         ->assertSessionHasErrors(['name', 'email', 'message']);
});

it('silently rejects honeypot submissions', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class)
         ->post(route('contact.store'), [
        'name' => 'Bot',
        'email' => 'bot@spam.com',
        'message' => 'Buy cheap stuff!',
        'website' => 'http://spam.com', // honeypot filled = bot
    ])->assertRedirect();

    $this->assertDatabaseMissing('contact_messages', [
        'email' => 'bot@spam.com',
    ]);
});

it('stores the ip address', function () {
    $this->withoutMiddleware(ValidateCsrfToken::class)
         ->post(route('contact.store'), [
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'message' => 'Testing IP capture.',
    ]);

    expect(ContactMessage::first()->ip_address)->not->toBeNull();
});

it('requires auth to view admin messages', function () {
    $this->get('/admin/messages')->assertRedirect(route('login'));
});

it('allows admin to view messages', function () {
    $user = User::factory()->create();
    ContactMessage::create([
        'name' => 'Visitor',
        'email' => 'visitor@test.com',
        'message' => 'Hello!',
        'ip_address' => '127.0.0.1',
    ]);

    $this->actingAs($user)
        ->get('/admin/messages')
        ->assertSuccessful();
});

it('marks message as read when viewed', function () {
    $user = User::factory()->create();
    $message = ContactMessage::create([
        'name' => 'Visitor',
        'email' => 'visitor@test.com',
        'message' => 'Hello!',
        'ip_address' => '127.0.0.1',
    ]);

    expect($message->refresh()->is_read)->toBeFalse();

    $this->actingAs($user)
        ->get("/admin/messages/{$message->id}")
        ->assertSuccessful();

    expect($message->refresh()->is_read)->toBeTrue();
});

it('allows admin to delete messages', function () {
    $user = User::factory()->create();
    $message = ContactMessage::create([
        'name' => 'Visitor',
        'email' => 'visitor@test.com',
        'message' => 'Hello!',
        'ip_address' => '127.0.0.1',
    ]);

    $this->actingAs($user)
        ->withoutMiddleware(ValidateCsrfToken::class)
        ->delete("/admin/messages/{$message->id}")
        ->assertRedirect('/admin/messages');

    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});
