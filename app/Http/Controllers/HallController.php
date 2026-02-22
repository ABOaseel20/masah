<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    //

    public function index(){
        $halls=Hall::all();
        return view('hall.index', compact('halls'));

    }

    public function create(){
        return view('hall.create');
    }
    public function store(Request $request){
        Hall::create(
            [
                'name'=>$request->name, 
                'capacity'=>$request->capacity, 
                'price'=>$request->price, 
                'status'=>$request->status, 
            ]
        ); 
        return redirect()->route('halls.index');
    }
}
