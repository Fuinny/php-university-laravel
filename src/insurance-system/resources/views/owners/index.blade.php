@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __('List of owners') }}</h2>
    </div>
    @can('create', App\Models\Owner::class)
        <div class="container d-grid gap-2">
            <a href="{{ route('owners.create') }}" class="btn btn-primary mb-3">{{ __('Add new owner') }}</a>
        </div>
    @endcan
    <div class="container mb-3">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Surname') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Address') }}</th>
                @auth
                    <th>{{ __('Actions') }}</th>
                @endauth
            </tr>
            @forelse($owners as $owner)
                <tr>
                    <td>{{ $owner->id }}</td>
                    <td>{{ $owner->name }}</td>
                    <td>{{ $owner->surname }}</td>
                    <td>{{ $owner->phone }}</td>
                    <td>{{ $owner->email }}</td>
                    <td>{{ $owner->address }}</td>
                    @auth
                        <td>
                            <div class="d-flex w-100">
                                @can('update', $owner)
                                    <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-success w-50 me-1">{{ __('Edit') }}</a>
                                @endcan
                                @can('delete', $owner)
                                    <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" class="w-50 ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger w-100"
                                                onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                         @endauth
                    @empty
                        <td colspan="7" align="center">{{ __('No Owners') }}</td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
