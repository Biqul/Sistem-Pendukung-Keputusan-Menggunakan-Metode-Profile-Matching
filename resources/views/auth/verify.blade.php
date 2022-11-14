@extends('layouts.main')

<title>SPK | Verify Email </title>

@section('container')
<div class="card rounded shadow border-0" style="height: 755px;">
        <div class="card-body p-5 bg-white rounded">
            <div class="card shadow mb-4 mt-3">
                <div class="card-header py-3">
                <strong>{{ __('Verify Your Email Address') }}</strong>
                </div>
                
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email, click the button below.') }}</br>
                        <div class="d-flex" style="float: right; margin-right: 10px;">
                            <form  method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary mb-2" style="margin-right: 10px;">{{ __('Click here to request another') }}</button>.
                            </form>
                            <form action="{{ url('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-dark mb-2" style="margin-right: 10px;"><i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i> Logout</button>
                            </form>
                        </div>
                </div>
            </div>
    </div>
</div>
@endsection
