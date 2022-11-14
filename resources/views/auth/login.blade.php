@extends('layouts.main')

<title>SPK | Login </title>

@include('sweetalert::alert')
@section('container')

        @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

<div class="wrapper">
    <div class="logo">
        <img src="img/iaas2.png" alt="Logo IAAS">
    </div>
    <div class="text-center mt-4 name">
        IAAS Local Committee
        Universitas Udayana
    </div>
        <form class="p-3 mt-3" action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" class="@error('username') is-invalid @enderror" id="username" placeholder="Username" autofocus required value="{{ old('username') }}">
                @error('username')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <button class="btn mt-3">Login</button>
        </form>
    <div class="text-center fs-6">
        @if (Route::has('password.request'))
            <small class="d-block text-center"><a href="{{ route('password.request') }}">
                {{ __('Lupa kata sandi?') }}
            </a></small>
        @endif
        <small class="d-block text-center mt-3">Belum memiliki akun? <a href="{{ url('register') }}">Daftar sekarang!</a></small>
        <p class="mt-4 text-center text-muted">&copy; 2022. IAAS Local Committee Universitas Udayana</p>  
    </div>
</div>
@endsection
