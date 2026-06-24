<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function index()
    {
        return view('bmi');
    }

    public function calculate(Request $request)
    {
        $weight = $request->weight;
        $height = $request->height;

        $request->validate([
            'weight' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
        ]);

        $height /= 100;

        $bmi = $weight / ($height * $height);

        return view('bmi', ['bmi' => round($bmi, 2)]);
    }
}
