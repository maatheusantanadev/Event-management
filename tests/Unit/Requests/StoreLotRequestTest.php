<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Models\Sector;
use App\Http\Requests\LotRequest\StoreLotsRequest;
use Illuminate\Support\Facades\Validator;

class StoreLotRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $sector = Sector::factory()->create();

        $data = [
            'sector_id' => $sector->id,
            'name' => 'Lote VIP',
            'price' => 150.00,
            'quantity' => 100,
            'start_date' => '2025-05-01',
            'end_date' => '2025-05-10',
        ];

        $request = new StoreLotsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = []; 

        $request = new StoreLotsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('sector_id', $validator->errors()->messages());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('price', $validator->errors()->messages());
        $this->assertArrayHasKey('quantity', $validator->errors()->messages());
        $this->assertArrayHasKey('start_date', $validator->errors()->messages());
        $this->assertArrayHasKey('end_date', $validator->errors()->messages());
    }

    public function test_end_date_before_start_date_fails_validation()
    {
        $sector = Sector::factory()->create();

        $data = [
            'sector_id' => $sector->id,
            'name' => 'Lote Econômico',
            'price' => 50.00,
            'quantity' => 50,
            'start_date' => '2025-05-10',
            'end_date' => '2025-05-05', 
        ];

        $request = new StoreLotsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('end_date', $validator->errors()->messages());
    }

    public function test_invalid_price_and_quantity_fails_validation()
    {
        $sector = Sector::factory()->create();

        $data = [
            'sector_id' => $sector->id,
            'name' => 'Lote Promo',
            'price' => -10, 
            'quantity' => 0, 
            'start_date' => '2025-05-01',
            'end_date' => '2025-05-10',
        ];

        $request = new StoreLotsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('price', $validator->errors()->messages());
        $this->assertArrayHasKey('quantity', $validator->errors()->messages());
    }
}