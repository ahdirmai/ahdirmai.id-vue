<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/messages/Index', [
            'messages' => ContactMessage::query()
                ->orderByDesc('created_at')
                ->paginate(20),
        ]);
    }

    public function show(ContactMessage $message): Response
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return Inertia::render('admin/messages/Show', [
            'message' => $message,
        ]);
    }

    public function destroy(ContactMessage $message): \Illuminate\Http\RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index');
    }
}
