<?php

namespace App\Http\Controllers\Users;


use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return  Inertia::render("Users/Index", [
            "users"=> User::all()
        ]);
    }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
    return Inertia::render("Users/Create");
   }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return to_route('users.index')
            ->withSuccess('User created successfully!');
    }

//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//        //
//    }

//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(string $id)
//    {
//        $editUser = User::findOrFail($id);
//        return inertia('Users/Index', compact('editUser'));
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
