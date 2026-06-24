<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin() || auth()->user()->isReadonly())
        {
            $owners = Owner::all();
        }
        else
        {
            $owners = Owner::where('user_id', auth()->id())->get();
        }

        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'phone' => 'required|regex:/^[0-9+\-\s()]+$/|min:8|max:20',
            'email' => 'required|email|unique:owners,email',
            'address' => 'required|min:5|max:255',
        ],[
            "name.required" => __("Name is required"),
            "name.min" => __("Name must be at least 2 characters"),
            "name.max" => __("Name must be less than 50 characters"),
            "surname.required" => __("Surname is required"),
            "surname.min" => __("Surname must be at least 2 characters"),
            "surname.max" => __("Surname must be less than 50 characters"),
            "phone.required" => __("Phone is required"),
            "phone.regex" => __("Please enter a valid phone number"),
            "phone.min" => __("Phone must be at least 8 characters"),
            "phone.max" => __("Phone must be less than 20 characters"),
            "email.required" => __("Email is required"),
            "email.email" => __("Please enter a valid email address"),
            "email.unique" => __("Email address already exists"),
            "address.required" => __("Address is required"),
            "address.min" => __("Address must be at least 5 characters"),
            "address.max" => __("Address must be less than 255 characters"),
        ]);

        $owner = new Owner();

        $owner->name = $validated['name'];
        $owner->surname = $validated['surname'];
        $owner->phone = $validated['phone'];
        $owner->email = $validated['email'];
        $owner->address = $validated['address'];

        $owner->user_id = auth()->id();

        $owner->save();

        return redirect()->route('owners.index');
    }

    public function edit(Owner $owner)
    {
        $this->authorize('update', $owner);

        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $this->authorize('update', $owner);

        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'surname' => 'required|min:2|max:50',
            'phone' => 'required|regex:/^[0-9+\-\s()]+$/|min:8|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('owners')->ignore($owner->id)
            ],
            'address' => 'required|min:5|max:255',
        ],[
            "name.required" => __("Name is required"),
            "name.min" => __("Name must be at least 2 characters"),
            "name.max" => __("Name must be less than 50 characters"),
            "surname.required" => __("Surname is required"),
            "surname.min" => __("Surname must be at least 2 characters"),
            "surname.max" => __("Surname must be less than 50 characters"),
            "phone.required" => __("Phone is required"),
            "phone.regex" => __("Please enter a valid phone number"),
            "phone.min" => __("Phone must be at least 8 characters"),
            "phone.max" => __("Phone must be less than 20 characters"),
            "email.required" => __("Email is required"),
            "email.email" => __("Please enter a valid email address"),
            "email.unique" => __("Email address already exists"),
            "address.required" => __("Address is required"),
            "address.min" => __("Address must be at least 5 characters"),
            "address.max" => __("Address must be less than 255 characters"),
        ]);

        $owner->name = $validated['name'];
        $owner->surname = $validated['surname'];
        $owner->phone = $validated['phone'];
        $owner->email = $validated['email'];
        $owner->address = $validated['address'];

        $owner->save();

        return redirect()->route('owners.index');
    }

    public function destroy(Owner $owner)
    {
        $this->authorize('delete', $owner);

        $owner->delete();
        
        return redirect()->route('owners.index');
    }
}
