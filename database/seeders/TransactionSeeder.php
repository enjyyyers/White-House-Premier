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

        \App\Models\Transaction::create([
            'transaction_code' => 'TRX-2026-001',
            'user_id' => $user->id,
            'property_id' => $property1->id,
            'payment_type' => 'booking',
            'property_price' => $property1->price,
            'tax_amount' => 550000000,
            'admin_fee' => 10000000,
            'total_payable' => 5560000000,
            'amount_paid' => 10000000,
            'payment_status' => 'success',
        ]);

        \App\Models\Transaction::create([
            'transaction_code' => 'TRX-2026-002',
            'user_id' => $user->id,
            'property_id' => $property2->id,
            'payment_type' => 'dp',
            'property_price' => $property2->price,
            'tax_amount' => 220000000,
            'admin_fee' => 10000000,
            'total_payable' => 2230000000,
            'amount_paid' => 400000000,
            'payment_status' => 'pending',
        ]);
    }
}
