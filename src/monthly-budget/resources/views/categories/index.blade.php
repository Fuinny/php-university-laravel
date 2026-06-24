@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>{{ __('Categories') }}</h2>
            <h5 class="text-muted">{{ __('Manage your income and expense categories.') }}</h5>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm bg-white p-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">{{ __('Add New') }}</h5>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label small text-uppercase text-muted fw-bold">
                                {{ __('Name') }}
                            </label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="type" class="form-label small text-uppercase text-muted fw-bold">
                                {{ __('Type') }}
                            </label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="expense">{{ __('Expenses') }}</option>
                                <option value="income">{{ __('Income') }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2 text-uppercase fw-bold small">
                            {{ __('Save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span>{{ __('Your Categories') }}</span>
                    <span class="badge bg-dark rounded-pill">{{ $categories->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <span class="fw-bold">{{ $category->name }}</span>
                                        </td>
                                        <td class="py-3 align-middle">
                                            <span class="badge rounded-pill {{ $category->type == 'income' ? 'bg-success' : 'bg-danger' }} text-uppercase small">
                                                {{ $category->type == 'income' ? __('Income') : __('Expenses') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-end align-middle">
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none">
                                                    <small class="text-uppercase fw-bold">{{ __('Delete') }}</small>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            {{ __('No categories created.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
