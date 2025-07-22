<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

/**
 * @summary Login
 * @description User authorization
 * @_200 Successful authorization
 * @_401 Invalid credentials
 */
class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
