<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos= Todo::all();
        return view('index', ['todos' => $todos]);
    }
    public function add(Request $request){
        if ($request->ajax()) {
        $todo= new Todo;
        $todo->title = $request->title;
        $todo->save();
        $lastTodo = Todo::where('id', $todo->id)->get();
        return view('ajaxData',['todos' => $lastTodo]);
        }
       
    }

    
    public function update(Request $request, $id){
       if($request->ajax()){
           $todo= Todo::find($id);
           $todo->title = $request->title;
           $todo->save();
           return "OK";
       }
    }
    public function done(Request $request,$id){
        if($request->ajax()){
            $todo= Todo::find($id);
            $todo->status = 1;
            $todo->save();
            return "OK";
        }

    }

    public function delete(Request $request, $id){
       if($request->ajax()){
           $todo= Todo::find($id);
           $todo->delete();
           return "OK";
       }
    }
    
    
}

