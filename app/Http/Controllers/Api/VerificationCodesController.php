<?php

namespace App\Http\Controllers\Api;

class VerificationCodesController extends Controller
{
    public function store()
    {
        return $this->response->array(['test_message' => 'store verification code']);
    }
}
