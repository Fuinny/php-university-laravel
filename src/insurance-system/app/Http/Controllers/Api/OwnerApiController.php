<?php

namespace App\Http\Controllers\Api;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerApiController extends Controller
{
    public function index()
    {
        return Owner::all();
    }

    public function show($id)
    {
        return Owner::find($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'phone' => 'required|regex:/^[0-9+\-\s()]+$/|min:8|max:20',
            'email' => 'required|email|unique:owners,email',
            'address' => 'required|min:5|max:255',
        ]);

        $owner = new Owner();

        $owner->name = $request->name;
        $owner->surname = $request->surname;
        $owner->phone = $request->phone;
        $owner->email = $request->email;
        $owner->address = $request->address;

        $owner->user_id = 1;

        $owner->save();

        return $owner;
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::find($id);

        $owner->name = $request->name;
        $owner->surname = $request->surname;
        $owner->phone = $request->phone;
        $owner->email = $request->email;
        $owner->address = $request->address;

        $owner->save();

        return $owner;
    }

    public function destroy($id)
    {
        Owner::destroy($id);
        return $id;
    }
}
