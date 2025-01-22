<?php

namespace App\Http\Controllers;

use App\Models\Rodovia;

class RodoviaController extends Controller
{
    public function index()
    {
        return response()->json(Rodovia::all());
    }

}
