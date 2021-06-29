<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function show($id)
    {
        return array_merge(json_decode(Test::find($id)->testUser, true), json_decode(Test::find($id), true));
    }
}
