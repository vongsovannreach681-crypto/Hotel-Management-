<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function index()
    {
        $message = 'Hello from SampleController';
        return view('sample', compact('message'));
    }
}
