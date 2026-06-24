@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mb-4 align-items-center">
            <h2>{{ __('Hello') }}, {{ Auth::user()->name }}!</h2>
            <h5 class="text-muted">{{ __('This is your monthly budget overview.') }}</h5>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-dark shadow-sm text-center text-white p-3">
                    <div class="card-body">
                        <h5 class="text-uppercase small">{{ __('Balance') }}</h5>
                        <h2>{{ number_format($balance ?? 0, 2) }} €</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success shadow-sm text-center text-white p-3">
                    <div class="card-body">
                        <h5 class="text-uppercase small">{{ __('Income') }}</h5>
                        <h2>{{ number_format($totalIncome ?? 0, 2) }} €</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-danger shadow-sm text-center text-white p-3">
                    <div class="card-body">
                        <h5 class="text-uppercase small">{{ __('Expenses') }}</h5>
                        <h2>{{ number_format($totalExpense ?? 0, 2) }} €</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3">{{ __('Budget Execution') }}</div>
                    <div class="card-body bg-white">
                        <div class="row">
                            @forelse($budgets as $budget)
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold">{{ $budget->category->name }}</span>
                                        <span class="small text-muted">
                                            {{ number_format($budget->actual_spending, 2) }} €
                                            / {{ number_format($budget->amount_limit, 2) }} €
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar {{ $budget->percentage >= 90 ? 'bg-danger' : ($budget->percentage >= 75 ? 'bg-warning' : 'bg-primary') }}"
                                             role="progressbar"
                                             style="width: {{ $budget->percentage }}%"
                                             aria-valuenow="{{ $budget->percentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">{{ __('No budget limits set for this month.') }}</p>
                                    <a class="btn btn-outline-dark btn-sm" href="{{ route('budgets.index') }}" >{{ __('Set Budget') }}</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3">{{ __('Latest Transactions') }}</div>
                    <div class="card-body bg-white p-0">
                        @if($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td class="px-4 py-3 align-middle">
                                                    <div class="fw-bold">{{ $transaction->category->name }}</div>
                                                    <small class="text-muted">{{ $transaction->date }}</small>
                                                </td>
                                                <td class="py-3 align-middle">
                                                    <small class="text-muted">{{ $transaction->description }}</small>
                                                </td>
                                                <td class="px-4 py-3 text-end align-middle">
                                                    <span class="fw-bold {{ $transaction->category->type == 'income' ? 'text-success' : 'text-danger' }}">
                                                        {{ $transaction->category->type == 'income' ? '+' : '-' }} {{ number_format($transaction->amount, 2) }} €
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">{{ __('No transactions yet.') }}</p>
                                <a class="btn btn-outline-dark btn-sm" href="{{ route('transactions.index') }}">
                                    {{ __('Create Transaction') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
