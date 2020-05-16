<?php

namespace App\Http\Requests\Api\Account;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class ChangePasswordRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        return [
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    public function standardize()
    {
        return collect([
            'password' => $this->input('password'),
        ]);
    }
}
