@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __('List of cars') }}</h2>
    </div>
    @can('create', App\Models\Car::class)
        <div class="container d-grid gap-2">
            <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">{{ __('Add new car') }}</a>
        </div>
    @endcan
    <div class="container mb-3">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>{{ __('Photos') }}</th>
                <th>{{ __('Registration number') }}</th>
                <th>{{ __('Brand') }}</th>
                <th>{{ __('Model') }}</th>
                <th>{{ __('Owner') }}</th>
                @auth
                    <th>{{ __('Actions') }}</th>
                @endauth
            </tr>
            @forelse($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-1" style="min-width: 120px;">
                            @forelse($car->photos as $photo)
                                <img src="{{ asset('storage/' . $photo->path) }}" width="80" height="80" class="rounded object-fit-cover">
                            @empty
                                <span>{{__('No Photos')}}</span>
                            @endforelse
                        </div>
                    </td>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->owner->name }} {{ $car->owner->surname }}</td>
                    @auth
                        <td>
                            <div class="d-flex w-100">
                                @can('update', $car)
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-success w-50 me-1">{{ __('Edit') }}</a>
                                @endcan
                                @can('delete', $car)
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="w-50 ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger w-100"
                                                onclick="return confirm('Are you sure?')">{{ __('Delete') }}</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    @endauth
                </tr>
            @empty
                <tr>
                    <td colspan="7" align="center">{{ __('No cars') }}</td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
