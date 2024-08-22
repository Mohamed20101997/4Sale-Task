<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function listMenuItems()
    {
        $meals = Meal::all();
        return response()->json($meals);
    }

}
