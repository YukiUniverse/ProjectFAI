<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreparationController extends Controller
{
    public function index()
    {
        return view('siswa.pengurus-inti');
    }
}
