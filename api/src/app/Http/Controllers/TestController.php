<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function tests()
    {
        return response()->json(['aaa'=>'bbb']);
    }
}
