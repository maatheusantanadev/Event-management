<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TicketRequest\StoreTicketsRequest;

class StoreTicketRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $user = User::factory()->create();
        $lot = Lot::factory()->create();

        $data = [
            'user_id' => $user->id,
            'lot_id' => $lot->id,
            'status' => 'pago',
            'qr_code' => Str::uuid()->toString(),
        ];

        $request = new StoreTicketsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = []; 

        $request = new StoreTicketsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('user_id', $validator->errors()->messages());
        $this->assertArrayHasKey('lot_id', $validator->errors()->messages());
        $this->assertArrayHasKey('status', $validator->errors()->messages());
        $this->assertArrayHasKey('qr_code', $validator->errors()->messages());
    }

    public function test_invalid_status_fails_validation()
    {
        $user = User::factory()->create();
        $lot = Lot::factory()->create();

        $data = [
            'user_id' => $user->id,
            'lot_id' => $lot->id,
            'status' => 'usado', 
            'qr_code' => Str::uuid()->toString(),
        ];

        $request = new StoreTicketsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('status', $validator->errors()->messages());
    }

    public function test_invalid_qr_code_fails_validation()
    {
        $user = User::factory()->create();
        $lot = Lot::factory()->create();

        $data = [
            'user_id' => $user->id,
            'lot_id' => $lot->id,
            'status' => 'pendente',
            'qr_code' => 'not-a-valid-uuid',
        ];

        $request = new StoreTicketsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('qr_code', $validator->errors()->messages());
    }
}