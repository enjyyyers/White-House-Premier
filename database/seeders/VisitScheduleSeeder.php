<?php

namespace Database\Seeders;

use App\Models\VisitSchedule;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;

class VisitScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $property1 = Property::find(1);
        $property2 = Property::find(2);

        if ($user && $property1) {
            VisitSchedule::create([
                'user_id' => $user->id,
                'property_id' => $property1->id,
                'visit_date' => now()->addDays(2)->format('Y-m-d'),
                'visit_time' => '10:00:00',
                'status' => 'pending',
                'notes' => 'Mau lihat sirkulasi udara di kamar utama.',
            ]);
        }

        if ($user && $property2) {
            VisitSchedule::create([
                'user_id' => $user->id,
                'property_id' => $property2->id,
                'visit_date' => now()->addDays(5)->format('Y-m-d'),
                'visit_time' => '14:00:00',
                'status' => 'approved',
                'notes' => 'Survei lokasi sore hari.',
            ]);
        }
    }
}
