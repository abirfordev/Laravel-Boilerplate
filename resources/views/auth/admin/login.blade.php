@extends('layouts.auth.master')
@section('title', 'Admin Login')
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">

                            <img class="app-brand-logo demo img-fluid" src="{{ asset(config('settings.logo')) }}"
                                width="150" alt="">
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2 text-center">Welcome to CSEAA-PU</h4>

                        <h6 class="mb-2 text-center">Admin Login</h6>


                        <form id="formAuthentication" class="mb-3" autocomplete="off"
                            action="{{ route('admin.loginAdmin') }}" method="POST">
                            @csrf
                            @if ($errors->has('message'))
                                <div class="alert alert-danger" role="alert">{{ $errors->first('message') }}</div>
                            @endif
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    placeholder="Enter your email" required value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    {{-- <a href="auth-forgot-password-basic.html">
                                        <small>Forgot Password?</small>
                                    </a> --}}
                                </div>
                                <div class="input-group input-group-merge">
                                    <input id="password" class="form-control" type="password" name="password" required
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
