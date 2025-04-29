<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\PaymentRequest\StorePaymentsRequest;
use App\Models\Ticket;
use App\Models\DiscountCoupon;
use App\Models\Payment;

class StorePaymentRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $ticket = Ticket::factory()->create();
        $coupon = DiscountCoupon::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => (string) Str::uuid(),
            'discount_coupon_id' => $coupon->id,
            'amount' => 100.50,
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('ticket_id', $validator->errors()->messages());
        $this->assertArrayHasKey('transaction_id', $validator->errors()->messages());
        $this->assertArrayHasKey('amount', $validator->errors()->messages());
    }

    public function test_invalid_uuid_transaction_id_fails_validation()
    {
        $ticket = Ticket::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => 'not-a-uuid',
            'amount' => 80,
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('transaction_id', $validator->errors()->messages());
    }

    public function test_duplicate_transaction_id_fails_validation()
    {
        $existingPayment = Payment::factory()->create();
        $ticket = Ticket::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => $existingPayment->transaction_id,
            'amount' => 70,
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('transaction_id', $validator->errors()->messages());
    }

    public function test_optional_discount_coupon_id_can_be_null()
    {
        $ticket = Ticket::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => (string) Str::uuid(),
            'discount_coupon_id' => null,
            'amount' => 99.90,
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_discount_coupon_id_fails_validation()
    {
        $ticket = Ticket::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => (string) Str::uuid(),
            'discount_coupon_id' => 999999, 
            'amount' => 99.90,
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('discount_coupon_id', $validator->errors()->messages());
    }

    public function test_invalid_amount_fails_validation()
    {
        $ticket = Ticket::factory()->create();

        $data = [
            'ticket_id' => $ticket->id,
            'transaction_id' => (string) Str::uuid(),
            'amount' => 0, 
        ];

        $request = new StorePaymentsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('amount', $validator->errors()->messages());
    }
}