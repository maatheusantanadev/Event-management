<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Models\Event;
use App\Http\Requests\SectorRequest\StoreSectorsRequest;
use Illuminate\Support\Facades\Validator;

class StoreSectorRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
       
        $event = Event::factory()->create();

        $data = [
            'event_id' => $event->id, 
            'name' => 'Setor A',
            'capacity' => 100,
        ];

        $request = new StoreSectorsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StoreSectorsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('event_id', $validator->errors()->messages());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('capacity', $validator->errors()->messages());
    }

    public function test_invalid_event_id_fails_validation()
    {
        $data = [
            'event_id' => 999, 
            'name' => 'Setor B',
            'capacity' => 200,
        ];

        $request = new StoreSectorsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('event_id', $validator->errors()->messages());
    }

    public function test_invalid_capacity_fails_validation()
    {
        $event = Event::factory()->create(); 

        $data = [
            'event_id' => $event->id,
            'name' => 'Setor C',
            'capacity' => 'abc', 
        ];

        $request = new StoreSectorsRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('capacity', $validator->errors()->messages());
    }
}