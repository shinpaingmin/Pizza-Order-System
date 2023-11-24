<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // direct to contact page
    public function contactList() {
        $contacts = Contact::when(request('searchKey'), function($query) {
            $query->orWhere('name', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('email', 'like', '%' . request('searchKey') . '%')
                    ->orWhere('subject', 'like', '%' . request('searchKey') . '%');
        })
        ->orderBy('created_at', 'desc')->paginate(3);

        return view('admin.contact.list', compact('contacts'));
    }
}
