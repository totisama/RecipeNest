<?php

namespace App\Http\Controllers;

class TokensManagementController extends Controller
{
    public function __invoke()
    {
        return view('tokens-management');
    }
}
