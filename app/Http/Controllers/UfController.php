<?php

namespace App\Http\Controllers;

use App\Models\Uf;

class UfController extends Controller
{
    public function index()
    {
        return response()->json(Uf::all());
    }

}
