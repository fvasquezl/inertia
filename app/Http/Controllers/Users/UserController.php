<?php

namespace App\Http\Controllers\Users;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()->get();
        $editUser = null;

        if ($request->filled('edit_user')) {
            $editUser = User::findOrFail($request->get('edit_user'));
        }

        return inertia('Users/Index', [
            'users' => $users,
            'editUser' => $editUser,
        ]);
    }

//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
