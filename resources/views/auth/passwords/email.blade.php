@extends('layouts.app')
@section('title','Email')
@section('main_content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed"
        data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-lg-6 col-xl-8 col-xxl-9">
                        <a href="#" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                          
                        </a>
                        <div class="d-none d-lg-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px);">
                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg"
                                alt="" class="img-fluid" width="500">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
                            <div class="d-flex align-items-center w-100 h-100">
                                <div class="card-body">
                                    <div class="mb-5">
                                        <h6 class="fw-bolder fs-7 mb-3">{{  __('Forgot your password?') }}</h6>
                                        <p class="mb-0 ">
                                          {{ __('  Please enter the email address associated with your account and We will email
                                          you a link to reset your password.') }}
                                        </p>
                                    </div>
                                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">{{ __('Email address') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                                                aria-describedby="emailHelp"name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 py-8 mb-3"> {{ __('Send Password Reset Link') }}</button>
                                        <a href="{{ route('login') }}"
                                            class="btn btn-light-primary text-primary w-100 py-8">Back to Login</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
