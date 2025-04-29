<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DiscountCouponsRequest\StoreDiscountCouponsRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\DiscountCoupon;

class StoreDiscountCouponRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $data = [
            'code' => 'DESCONTO50',
            'discount' => 50,
            'max_uses' => 10,
            'expires_at' => Carbon::tomorrow()->toDateString(),
        ];

        $request = new StoreDiscountCouponsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StoreDiscountCouponsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('code', $validator->errors()->messages());
        $this->assertArrayHasKey('discount', $validator->errors()->messages());
        $this->assertArrayHasKey('max_uses', $validator->errors()->messages());
        $this->assertArrayHasKey('expires_at', $validator->errors()->messages());
    }

    public function test_invalid_discount_fails_validation()
    {
        $data = [
            'code' => 'INVALIDO1',
            'discount' => 150, 
            'max_uses' => 5,
            'expires_at' => Carbon::tomorrow()->toDateString(),
        ];

        $request = new StoreDiscountCouponsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('discount', $validator->errors()->messages());
    }

    public function test_expired_date_fails_validation()
    {
        $data = [
            'code' => 'EXPIRADO',
            'discount' => 20,
            'max_uses' => 3,
            'expires_at' => Carbon::yesterday()->toDateString(), 
        ];

        $request = new StoreDiscountCouponsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('expires_at', $validator->errors()->messages());
    }

    public function test_duplicate_code_fails_validation()
    {
        DiscountCoupon::factory()->create([
            'code' => 'REPETIDO123',
        ]);

        $data = [
            'code' => 'REPETIDO123',
            'discount' => 10,
            'max_uses' => 5,
            'expires_at' => Carbon::tomorrow()->toDateString(),
        ];

        $request = new StoreDiscountCouponsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('code', $validator->errors()->messages());
    }
}