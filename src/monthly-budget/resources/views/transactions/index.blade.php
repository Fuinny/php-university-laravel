@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mb-4 align-items-end">
            <div class="col-md-6">
                <h2>{{ __('Transactions') }}</h2>
                <h5 class="text-muted">{{ __('Track your income and expenses.') }}</h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('transactions.index') }}" method="GET" class="row g-2 justify-content-md-end">
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
                            @foreach(range(now()->year - 5, now()->year + 1) as $y)
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
                        <h5 class="fw-bold mb-4">{{ __('Add New') }}</h5>
                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="category_id" class="form-label small text-uppercase text-muted fw-bold">
                                    {{ __('Category') }}
                                </label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>{{ __('Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->type == 'income' ? __('Income') : __('Expenses') }})</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label small text-uppercase text-muted fw-bold">
                                    {{ __('Amount') }} (€)
                                </label>
                                <input type="number"
                                       step="0.01"
                                       name="amount"
                                       id="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       required>
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label small text-uppercase text-muted fw-bold">
                                    {{ __('Date') }}
                                </label>
                                <input type="date"
                                       name="date"
                                       id="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       value="{{ date('Y-m-d') }}"
                                       required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label small text-uppercase text-muted fw-bold">
                                    {{ __('Description') }}
                                </label>
                                <textarea name="description"
                                          id="description"
                                          rows="2"
                                          class="form-control @error('description') is-invalid @enderror"
                                          style="resize: none; overflow: scroll">
                            </textarea>
                                @error('description')
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
                        <span>{{ __('Transactions – ') }} {{ __(date('F', mktime(0, 0, 0, $month, 10))) }} {{ $year }}</span>
                        <span class="badge bg-dark rounded-pill">{{ $transactions->count() }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <div class="fw-bold">{{ $transaction->category->name }}</div>
                                            <small class="text-muted">{{ $transaction->date }}</small>
                                        </td>
                                        <td class="py-3 align-middle">
                                            <small class="text-muted">{{ $transaction->description }}</small>
                                        </td>
                                        <td class="py-3 text-end align-middle">
                                            <span class="fw-bold {{ $transaction->category->type == 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->category->type == 'income' ? '+' : '-' }}
                                                {{ number_format($transaction->amount, 2) }} €
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-end align-middle">
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this transaction?') }}')">
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
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            {{ __('No registered transactions for this period.') }}
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
