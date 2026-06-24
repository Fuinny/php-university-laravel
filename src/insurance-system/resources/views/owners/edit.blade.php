@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __('Update owner\'s information') }}</h2>
    </div>
    <div class="container mb-3">
        <form method="POST" action="{{ route('owners.update', $owner->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $owner->name }}"required>
                <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">{{ __('Surname') }}</label>
                <input type="text" id="surname" name="surname" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname') ?? $owner->surname }}" required>
                <div class="invalid-feedback">@error('surname') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">{{ __('Phone') }}</label>
                <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') ?? $owner->phone }}" required>
                <div class="invalid-feedback">@error('phone') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? $owner->email }}" required>
                <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">{{ __('Address') }}</label>
                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') ?? $owner->address }}" required>
                <div class="invalid-feedback">@error('address') {{ $message }} @enderror</div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
