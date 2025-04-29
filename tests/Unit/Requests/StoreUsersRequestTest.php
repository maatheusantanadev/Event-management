<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use App\Http\Requests\UserRequest\StoreUsersRequest;
use Illuminate\Support\Facades\Validator;

class StoreUsersRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $data = [
            'name' => 'Matheus',
            'email' => 'matheus@email.com',
            'password' => 'senha1234',
            'password_confirmation' => 'senha1234',
            'phone' => '75999999999',
            'cpf_cnpj' => '12345678900',
            'role' => 'admin',
        ];

        $request = new StoreUsersRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_missing_required_fields_fails_validation()
    {
        $data = [];

        $request = new StoreUsersRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
        $this->assertArrayHasKey('cpf_cnpj', $validator->errors()->messages());
        $this->assertArrayHasKey('role', $validator->errors()->messages());
    }

    public function test_invalid_role_fails_validation()
    {
        $data = [
            'name' => 'Matheus',
            'email' => 'matheus@email.com',
            'password' => 'senha1234',
            'password_confirmation' => 'senha1234',
            'phone' => '75999999999',
            'cpf_cnpj' => '12345678900',
            'role' => 'hacker',
        ];

        $request = new StoreUsersRequest();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('role', $validator->errors()->messages());
    }
}