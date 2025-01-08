<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transactions;
use App\Models\transaction_items;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            $cart = $request->input('cart');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $finalTotal = $request->input('finalTotal');
            $paymentMethod = $request->input('paymentMethod');
            $promotionId = $request->input('promotionId');

            $transaction = transactions::create([
                'total_price' => $total,
                'discount' => $discount,
                'final_price' => $finalTotal,
                'payment_method' => $paymentMethod,
                'status' => 'completed',
                'promotion_id' => $promotionId,
            ]);

            foreach ($cart as $item) {
                transaction_items::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity']
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error processing payment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error processing payment'], 500);
        }
    }
}
