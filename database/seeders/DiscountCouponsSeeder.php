<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\DiscountCoupon;

class DiscountCouponsSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'BEMVINDO10',
                'discount' => 10.0,
                'max_uses' => 100,
                'expires_at' => Carbon::now()->addDays(30),
            ],
            [
                'code' => 'SUPER25',
                'discount' => 25.0,
                'max_uses' => 50,
                'expires_at' => Carbon::now()->addDays(15),
            ],
            [
                'code' => 'VIP50',
                'discount' => 50.0,
                'max_uses' => 20,
                'expires_at' => Carbon::now()->addDays(7),
            ],
        ];

        foreach ($coupons as $coupon) {
            DiscountCoupon::create($coupon);
        }
    }
}