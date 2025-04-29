<?php

namespace Tests\Unit\Requests;

use App\Models\Producer; 
use Tests\TestCase;
use App\Http\Requests\EventRequest\StoreEventsRequest;
use Illuminate\Support\Facades\Validator;

class StoreEventRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $producer = Producer::factory()->create();

        $data = [
            'producer_id' => $producer->id,
            'title' => 'Evento Teste',
            'description' => 'Descrição do evento de teste.',
            'date' => '2025-05-01',
            'location' => 'Local do evento',
            'banner_url' => 'https://example.com/banner.jpg',
        ];

        $request = new StoreEventsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StoreEventsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('producer_id', $validator->errors()->messages());
        $this->assertArrayHasKey('title', $validator->errors()->messages());
        $this->assertArrayHasKey('date', $validator->errors()->messages());
        $this->assertArrayHasKey('location', $validator->errors()->messages());
    }

    public function test_invalid_banner_url_fails_validation()
    {
        $data = [
            'producer_id' => 1,
            'title' => 'Evento Teste',
            'description' => 'Descrição do evento de teste.',
            'date' => '2025-05-01',
            'location' => 'Local do evento',
            'banner_url' => 'invalid-url', 
        ];

        $request = new StoreEventsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('banner_url', $validator->errors()->messages());
    }

    public function test_invalid_producer_id_fails_validation()
    {
        $data = [
            'producer_id' => 9999, 
            'title' => 'Evento Teste',
            'description' => 'Descrição do evento de teste.',
            'date' => '2025-05-01',
            'location' => 'Local do evento',
            'banner_url' => 'https://example.com/banner.jpg',
        ];

        $request = new StoreEventsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('producer_id', $validator->errors()->messages());
    }
}