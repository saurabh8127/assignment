<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    public function create(Request $request)
    {
        $data = [
            'name' => "saurabh",
            'email' => "saurabh@gmail.com",
            "password" =>  12345678,
        ];
        User::create($data);
    }
}
