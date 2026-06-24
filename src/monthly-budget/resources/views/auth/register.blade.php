@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2>{{ __('Registration') }}</h2>
                    <h5 class="text-muted">{{ __('Create a new account') }}</h5>
                </div>
                <div class="card border-0 p-4 shadow-sm bg-white">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name"
                                       class="form-label font-weight-bold small text-uppercase text-muted">
                                    {{ __('Name') }}
                                </label>
                                <input id="name"
                                       type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}"
                                       required
                                       autocomplete="name"
                                       autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="email"
                                       class="form-label font-weight-bold small text-uppercase text-muted">
                                    {{ __('Email Address') }}
                                </label>
                                <input id="email"
                                       type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       required
                                       autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="password"
                                       class="form-label font-weight-bold small text-uppercase text-muted">
                                    {{ __('Password') }}
                                </label>
                                <input id="password"
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="password-confirm"
                                       class="form-label font-weight-bold small text-uppercase text-muted">
                                    {{ __('Confirm Password') }}
                                </label>
                                <input id="password-confirm"
                                       type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password">
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-dark w-100 py-2 text-uppercase font-weight-bold small">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                        @if (Route::has('login'))
                            <div class="text-center mt-3">
                                <span class="text-muted small">{{ __('Already have an account?') }}</span>
                                <a href="{{ route('login') }}"
                                   class="small font-weight-bold text-dark text-decoration-none">
                                    {{ __('Login') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
