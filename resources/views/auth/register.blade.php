@extends('layouts.main')

<title>SPK | Registrasi </title>

@section('container')
<div class="trapper">
    <div class="text-left mt-2 name">
        {{ __('Registrasi') }}
    </div>
        <form class="p-3 mt-3" action="{{ route('register') }}" method="post">
            @csrf
            <label for="name">Nama Lengkap</label>
            <div class="form-field d-flex align-items-center">
                <input type="text" name="name" class="@error('name') is-invalid @enderror" id="name" placeholder="Nama Lengkap" required value="{{ old('name') }}" autofocus>
                @error('name')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="username">Username</label>
            <div class="form-field d-flex align-items-center">
                <input type="text" name="username" class="@error('username') is-invalid @enderror" id="username" placeholder="Username" required value="{{ old('username') }}">
                @error('username')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="email">Email</label>
            <div class="form-field d-flex align-items-center">
                <input type="email" name="email" class="@error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                @error('email')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="no_hp">Nomor Handphone</label>
            <div class="form-field d-flex align-items-center">
                <input type="text" name="no_hp" class="@error('no_hp') is-invalid @enderror" id="no_hp" placeholder="Nomor Handphone" required value="{{ old('no_hp') }}">
                @error('no_hp')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="password">Kata Sandi</label>
            <div class="form-field d-flex align-items-center">
                <input type="password" name="password"class="@error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                @error('password')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <div class="form-field d-flex align-items-center">
            <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Konfirmasi Password">
                @error('password_confirmation')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn mt-3">Daftar</button>
        </form>
    <div class="text-center fs-6">
        <small class="d-block text-center mt-3">Sudah memiliki akun? <a href="{{ url('login') }}">Masuk!</a></small>
    </div>
</div>
@endsection
