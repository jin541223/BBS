<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function authorize()
    {
        return [
            'content' => 'required|min:2',
        ];
    }
}
