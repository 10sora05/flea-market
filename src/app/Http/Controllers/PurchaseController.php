<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function showPurchasePage()
    {
        $user = Auth::user();
        return view('purchase', compact('user'));
    }
}
