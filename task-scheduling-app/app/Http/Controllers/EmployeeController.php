<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    public static function create(){
        return view('registration');
    }
    public static function store(Request $request){
        $formData=$request->validate([
            'name'=>'required',
            'place'=>'required',
            'designation'=>'required'
        ]);
        Employee::create($formData);
        return redirect('/');
    }
    public static function index(){
        $data=[
            'employees'=>Employee::all()
        ];
        return view('display',$data);
    }
}
