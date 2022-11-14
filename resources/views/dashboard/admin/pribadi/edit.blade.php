@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ url('profiles/'.auth()->user()->id) }}" method="post">
        @method('put')
        @csrf
            <div class="mb-3">
                <label for="current_password"><b>Kata Sandi Saat Ini</b></label>
                <input type="password" name="current_password"class="form-control rounded-bottom @error('current_password') is-invalid @enderror" id="current_password" placeholder="Password Saat Ini" required autofocus>
                @error('current_password')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password"><b>Kata Sandi Baru</b></label>
                <input type="password" name="password"class="form-control rounded-bottom @error('password') is-invalid @enderror" id="password" placeholder="Password Baru" required>
                @error('password')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation"><b>Konfirmasi Kata Sandi</b></label>
                <input type="password" name="password_confirmation"class="form-control rounded-bottom @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Konfirmasi Password" required>
                @error('password_confirmation')
                    <div id="validationServer03Feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="float:right; border-radius: 20px;"><i class="fa-solid fa-floppy-disk fa-fw"></i> Simpan</button>
        </form>
    </div>
</div>


@endsection
 