<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Models\CarPhoto;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        // $this->middleware(RoleMiddleware::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->isAdmin() || auth()->user()->isReadonly())
        {
            $cars = Car::with('owner', 'photos')->get();
        }
        else
        {
            $cars = auth()->user()->cars()->with('owner', 'photos')->get();
        }

        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->isAdmin() || auth()->user()->isReadonly())
        {
            $owners = Owner::all();
        }
        else
        {
            $owners = Owner::where('user_id', auth()->id())->get();
        }

        return view('cars.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg_number' => [
                'required',
                'regex:/^[A-Z]{3}[0-9]{3}$/',
                'unique:cars,reg_number'
            ],
            'brand' => 'required|min:2|max:50',
            'model' => 'required|min:1|max:50',
            'owner_id' => 'required|exists:owners,id',
            'photos.*' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ],[
            'reg_number.required' => __('Reg number is required'),
            'reg_number.regex' => __('Reg number is not in correct format'),
            'reg_number.unique' => __('Reg number is already registered'),
            'brand.required' => __('Brand is required'),
            'brand.min' => __('Brand must be at least 2 characters'),
            'brand.max' => __('Brand must be less than 50 characters'),
            'model.required' => __('Model is required'),
            'model.min' => __('Model must be at least 1 characters'),
            'model.max' => __('Model must be less than 50 characters'),
            'owner_id.required' => __('Owner is required'),
            'owner_id.exists' => __('Owner not found'),
            'photos.*.mimes' => __('Only JPEG/JPG and PNG images are supported'),
            'photos.*.max'   => __('Photos must be smaller than 2MB each')
        ]);

        if (!auth()->user()->isAdmin()) {
            $owner = Owner::find($validated['owner_id']);

            if ($owner->user_id !== auth()->id()) {
                abort(403, 'You cannot assign a car to an owner you do not own.');
            }
        }

        Car::create($validated);

        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load('owner');
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        if (auth()->user()->isAdmin() || auth()->user()->isReadonly())
        {
            $owners = Owner::all();
        }
        else
        {
            $owners = Owner::where('user_id', auth()->id())->get();
        }

        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'reg_number' => [
                'required',
                'regex:/^[A-Z]{3}[0-9]{3}$/',
                Rule::unique('cars')->ignore($car->id)
            ],
            'brand' => 'required|min:2|max:50',
            'model' => 'required|min:1|max:50',
            'owner_id' => 'required|exists:owners,id',
            'photos.*' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ],[
            'reg_number.required' => __('Reg number is required'),
            'reg_number.regex' => __('Reg number is not in correct format'),
            'reg_number.unique' => __('Reg number is already registered'),
            'brand.required' => __('Brand is required'),
            'brand.min' => __('Brand must be at least 2 characters'),
            'brand.max' => __('Brand must be less than 50 characters'),
            'model.required' => __('Model is required'),
            'model.min' => __('Model must be at least 1 characters'),
            'model.max' => __('Model must be less than 50 characters'),
            'owner_id.required' => __('Owner is required'),
            'owner_id.exists' => __('Owner not found'),
            'photos.*.mimes' => __('Only JPEG/JPG and PNG images are supported'),
            'photos.*.max'   => __('Photos must be smaller than 2MB each')
        ]);

        if (!auth()->user()->isAdmin()) {
            $owner = Owner::find($validated['owner_id']);

            if ($owner->user_id !== auth()->id()) {
                abort(403, 'You cannot assign a car to an owner you do not own.');
            }
        }

        $car->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('cars', 'public');
                $car->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('cars.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();
        return redirect()->route('cars.index');
    }

    public function destroyPhoto(CarPhoto $photo)
    {
        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        return back();
    }
}
