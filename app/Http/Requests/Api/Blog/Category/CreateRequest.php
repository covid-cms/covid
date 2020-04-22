<?php

namespace App\Http\Requests\Api\Blog\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Standardizable;
use App\Http\Requests\ResponseJsonOnFail;

class CreateRequest extends FormRequest implements Standardizable
{
    use ResponseJsonOnFail;

    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function standardize()
    {
        return collect([
            'title' => str($this->input('title'))->trim()->filter(FILTER_SANITIZE_STRING),
            'slug' => str($this->input('slug'))->slug(),
            'parent_id' => str($this->input('parent_id'))->integer()
        ]);
    }
}
