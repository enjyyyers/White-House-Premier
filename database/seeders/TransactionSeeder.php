<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'user@gmail.com')->first();
        if (!$user) return;

        $property1 = Property::find(1);
        $property2 = Property::find(2);
        if (!$property1 || !$property2) return;

        $bookingFee = config('payment.booking_fee');
        $adminRate = config('payment.admin_rate');
        $taxRate = config('payment.tax_rate');
        $dpRate = config('payment.dp_rate');

        $admin1 = $property1->price * $adminRate;
        $tax1 = $property1->price * $taxRate;

        \App\Models\Transaction::create([
            'transaction_code' => 'TRX-2026-001',
            'user_id' => $user->id,
            'property_id' => $property1->id,
            'payment_type' => 'booking',
            'property_price' => $property1->price,
            'gross_amount' => $bookingFee,
            'tax_amount' => 0,
            'admin_fee' => 0,
            'total_payable' => $bookingFee,
            'amount_paid' => $bookingFee,
            'payment_status' => 'success',
        ]);

        $admin2 = $property2->price * $adminRate;
        $tax2 = $property2->price * $taxRate;
        $dpRaw = $property2->price * $dpRate;
        $totalDp = $dpRaw + $admin2 + $tax2;

        \App\Models\Transaction::create([
            'transaction_code' => 'TRX-2026-002',
            'user_id' => $user->id,
            'property_id' => $property2->id,
            'payment_type' => 'dp',
            'property_price' => $property2->price,
            'gross_amount' => $totalDp,
            'tax_amount' => $tax2,
            'admin_fee' => 0,
            'total_payable' => $totalDp,
            'amount_paid' => 0,
            'payment_status' => 'pending',
        ]);
    }
}
