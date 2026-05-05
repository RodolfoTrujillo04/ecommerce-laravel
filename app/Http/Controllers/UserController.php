<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{

 use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $this->authorize('viewAny', User::class);

    $users = User::all();
    return view('usuarios.index', compact('users'));
}
    

 public function create()
{
        $this->authorize('create', User::class);

    return view('usuarios.create');
}

public function store(Request $request)
{
    $this->authorize('create', User::class);

    User::create($request->all());

    return redirect()->route('usuarios.index');
}

public function destroy($id)
{
    User::find($id)->delete();
    return redirect()->route('usuarios.index');
}
}