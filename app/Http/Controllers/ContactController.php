<?php
namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'reason'  => 'required|in:' . implode(',', array_keys(ContactInquiry::REASONS)),
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:3000',
        ]);

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr($request->userAgent() ?? '', 0, 500);
        $data['status']     = 'new';

        ContactInquiry::create($data);
        AnalyticsEvent::track('contact_submit', '/contact', $data['reason']);

        return back()->with('contact_success', 'Message sent! Emmanuel will get back to you soon.');
    }
}
