<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestUser;

class TestUserController extends Controller
{
    public function show($id)
    {
        return array_merge(json_decode(TestUser::find($id)->test, true), json_decode(TestUser::find($id), true));
    }
}
