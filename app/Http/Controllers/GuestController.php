<?php

namespace App\Http\Controllers;

use App\Models\FreeQuote;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function freequote(Request $request) {
        $validate = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'message' => 'string|max:255'
        ]);

        $freequote = FreeQuote::create($validate);

        return redirect()->route('/');

    }
}
