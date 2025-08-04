<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item; 
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class PurchaseController extends Controller
{
    public function showPurchasePage(Item $item)
    {
        $user = Auth::user();
        return view('purchase', compact('user', 'item'));
    }

public function purchase(Request $request, Item $item)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment');

        if ($item->is_sold || $item->buyer_id !== null) {
            return redirect()->route('index')->with('status', 'この商品はすでに購入済みです');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($paymentMethod === 'カード支払い') {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['item' => $item->id]),
                'cancel_url' => route('purchase.cancel'),
                'customer_email' => $user->email,
            ]);

            return redirect($session->url);
        }

        if ($paymentMethod === 'コンビニ払い') {
            $paymentIntent = PaymentIntent::create([
                'amount' => $item->price,
                'currency' => 'jpy',
                'payment_method_types' => ['konbini'],
                'payment_method_data' => [
                    'type' => 'konbini',
                    'billing_details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => '08012345678',
                    ],
                ],
                'confirmation_method' => 'automatic',
                'confirm' => true,
                'receipt_email' => $user->email,
                'payment_method_options' => [
                    'konbini' => [
                        'expires_after_days' => 3,
                    ],
                ],
                'description' => $item->name,
            ]);

            return view('purchase.konbini', [
                'item' => $item,
                'paymentIntent' => $paymentIntent,
            ]);
        }
        return back()->with('status', '不正な支払い方法です');
    }

    public function success(Item $item)
    {
        $user = Auth::user();

        if (!$item->is_sold) {
            $item->is_sold = true;
            $item->buyer_id = $user->id;
            $item->save();
        }

        return redirect()->route('index')->with('status', '購入が完了しました');
    }

    public function cancel()
    {
        return redirect()->route('index')->with('status', '購入がキャンセルされました');
    }
}
