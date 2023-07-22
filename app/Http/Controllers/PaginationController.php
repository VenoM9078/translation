<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginationController extends Controller
{
    public function updateLimit(Request $request)
    {
        $request->session()->put('limit', $request->input('limit'));
        return response()->json(['status' => 'success']);
    }
}
