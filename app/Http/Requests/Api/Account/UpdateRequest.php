<?php

namespace App\Http\Requests\Api\Account;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;
use Str;

class UpdateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function standardize()
    {
        return collect([
            'name' => $this->input('name'),
        ]);
    }
}
