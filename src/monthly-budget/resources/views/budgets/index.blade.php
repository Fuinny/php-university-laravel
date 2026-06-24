@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mb-4 align-items-end">
        <div class="col-md-6">
            <h2>{{ __('Budget') }}</h2>
            <h5 class="text-muted">{{ __('Set monthly spending limits.') }}</h5>
        </div>
        <div class="col-md-6">
            <form action="{{ route('budgets.index') }}" method="GET" class="row g-2 justify-content-md-end">
                <div class="col-auto">
                    <select name="month" class="form-select form-select-sm border-0 shadow-sm">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ __(date('F', mktime(0, 0, 0, $m, 10))) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <select name="year" class="form-select form-select-sm border-0 shadow-sm">
                        @foreach(range(now()->year - 2, now()->year + 2) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-dark btn-sm px-3 shadow-sm">{{ __('Show') }}</button>
                </div>
            </form>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm bg-white p-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">{{ __('Set Limit') }}</h5>
                    <form action="{{ route('budgets.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">
                        <div class="mb-3">
                            <label for="category_id" class="form-label small text-uppercase text-muted fw-bold">
                                {{ __('Category') }}
                            </label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" selected disabled>{{ __('Select Category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="amount_limit" class="form-label small text-uppercase text-muted fw-bold">
                                {{ __('Monthly Limit') }} (€)
                            </label>
                            <input type="number" step="0.01" name="amount_limit" id="amount_limit" class="form-control @error('amount_limit') is-invalid @enderror" required>
                            @error('amount_limit')
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
                    <span>{{ __('Budget Limit – ') }} {{ __(date('F', mktime(0, 0, 0, $month, 10))) }} {{ $year }}</span>
                    <span class="badge bg-dark rounded-pill">{{ $budgets->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="px-4 py-2 border-0 small text-uppercase text-muted">{{ __('Category') }}</th>
                                    <th class="py-2 border-0 small text-uppercase text-muted">{{ __('Limit') }}</th>
                                    <th class="py-2 border-0 small"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($budgets as $budget)
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <span class="fw-bold">{{ $budget->category->name }}</span>
                                        </td>
                                        <td class="py-3 align-middle">
                                            <span class="fw-bold">{{ number_format($budget->amount_limit, 2) }} €</span>
                                        </td>
                                        <td class="px-4 py-3 text-end align-middle">
                                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this budget limit?') }}')">
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
                                            {{ __('No budget limits set for this month.') }}
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
