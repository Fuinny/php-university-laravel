@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __("Update car's information") }}</h2>
    </div>
    <div class="container mb-3">
        <div class="mb-3">
            <label class="form-label">{{ __('Current Photos') }}</label>
            <div class="d-flex flex-wrap gap-2">
                @forelse($car->photos as $photo)
                    <div class="card" style="width: 150px;">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top">
                        @auth
                            @if(auth()->user()->type === 'admin')
                                <div class="card-body p-1 text-center">
                                    <form action="{{ route('cars.photos.destroy', $photo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @empty
                    <span>{{ __('No Photos') }}</span>
                @endforelse
            </div>
        </div>
        <form method="POST" action="{{ route('cars.update', $car->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="reg_number" class="form-label">{{ __('Registration number') }}</label>
                <input type="text" id="reg_number" name="reg_number" class="form-control @error('reg_number') is-invalid @enderror" value="{{ old('reg_number') ?? $car->reg_number }}" required>
                <div class="invalid-feedback">@error('reg_number') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label">{{ __('Brand') }}</label>
                <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') ?? $car->brand }}" required>
                <div class="invalid-feedback">@error('brand') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">{{ __('Model') }}</label>
                <input type="text" id="model" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') ?? $car->model }}" required>
                <div class="invalid-feedback">@error('model') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="owner_id" class="form-label">{{ __('Owner') }}</label>
                <select id="owner_id" name="owner_id" class="form-control @error('owner_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ old('owner_id', $car->owner_id ?? '') == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} {{ $owner->surname }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">@error('owner_id') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="photos" class="form-label">{{ __('Upload New Photos') }}</label>
                <input type="file" id="photos" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>
                <div class="invalid-feedback">@error('photos.*') {{ $message }} @enderror</div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('cars.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
