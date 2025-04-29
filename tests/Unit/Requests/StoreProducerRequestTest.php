<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\ProducerRequest\StoreProducersRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Models\User;

class StoreProducerRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
       
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'company_name' => 'Produtora Top',
            'cnpj' => '12345678000199', 
        ];

        $request = new StoreProducersRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StoreProducersRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('user_id', $validator->errors()->messages());
        $this->assertArrayHasKey('company_name', $validator->errors()->messages());
        $this->assertArrayHasKey('cnpj', $validator->errors()->messages());
    }


    public function test_invalid_cnpj_fails_validation()
    {
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'company_name' => 'Produtora Top',
            'cnpj' => 'invalido-cnpj', 
        ];

        $request = new StoreProducersRequest();
        $rules = $request->rules();

        // Adiciona regex personalizada para validar o cnpj
        $rules['cnpj'] = ['required', 'string', 'regex:/\d{14}/'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('cnpj', $validator->errors()->messages());
    }
}