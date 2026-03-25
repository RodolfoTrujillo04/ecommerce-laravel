<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $users = User::all();
    return view('usuarios.index', compact('users'));
}
    

 public function create()
{
    return view('usuarios.create');
}

public function store(Request $request)
{
    User::create($request->all());
    return redirect()->route('usuarios.index');
}

public function destroy($id)
{
    User::find($id)->delete();
    return redirect()->route('usuarios.index');
}
}