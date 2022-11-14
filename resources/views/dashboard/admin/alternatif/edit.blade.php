@extends('dashboard.layouts.main')

@section('container')
<div class="card shadow mb-4 mt-3">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
  </div>
  <div class="card-body">
    <form action="{{ url('alternatifs/'.$alternatif->id) }}" method="post">
    @method('put')
    @csrf
      <div class="mb-3">
        <label for="name" class="form-label"><b>Nama Lengkap</b></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $alternatif->name) }}">
        @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="no_hp" class="form-label"><b>Nomor Hp</b></label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" required value="{{ old('no_hp', $alternatif->no_hp) }}">
            @error('no_hp')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="email" class="form-label"><b>Email</b></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $alternatif->email) }}">
            @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
      </div>
        <button type="submit" class="btn btn-success mb-2" style="float: right; border-radius: 20px;"><i class="fa-solid fa-floppy-disk fa-fw"></i> Ubah Data</button>
        <a href="{{ url('alternatifs') }}" class="btn btn-primary mb-2" style="float: right; margin-right: 10px; border-radius: 20px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a>
      </form>
  </div>
</div>


@endsection
 