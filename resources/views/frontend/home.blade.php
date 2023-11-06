@extends('layouts.frontend.master')
@section('title', 'Home')

@section('content')
    <div class="container-xxl container-p-y">
        <!-- Logo -->
        <div class="app-brand justify-content-center">

            <img class="app-brand-logo demo img-fluid" src="{{ asset(config('settings.logo')) }}" width="180" alt="">
        </div>
        <!-- /Logo -->
        <h4 class="mb-5 text-center">Welcome to {{ config('settings.website_full_name') }}</h4>

        <!-- Examples -->
        <div class="row g-3 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 align-items-center">
                    <img class="card-img-top w-50" src="{{ asset('assets/img/elements/admin.png') }}"
                        alt="Card image cap" />
                    <div class="card-body ">
                        <h5 class="card-title">Admin Login</h5>

                        <a href="{{ route('admin.login') }}" class="btn btn-outline-primary">Click Here</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 align-items-center">
                    <img class="card-img-top w-50" src="{{ asset('assets/img/avatars/male_avatar.png') }}"
                        alt="Card image cap" />
                    <div class="card-body ">
                        <h5 class="card-title">User Login</h5>

                        <a href="{{ route('user.login') }}" class="btn btn-outline-primary">Click Here</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 align-items-center">
                    <img class="card-img-top w-50" src="{{ asset('assets/img/elements/graduates2.png') }}"
                        alt="Card image cap" />
                    <div class="card-body ">
                        <h5 class="card-title">Admin Login</h5>

                        <a href="{{ route('admin.login') }}" class="btn btn-outline-primary">Click Here</a>
                    </div>
                </div>
            </div>


        </div>
        <!-- Examples -->

    </div>

@endsection
