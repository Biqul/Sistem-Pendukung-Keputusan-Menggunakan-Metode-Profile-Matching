@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')
<div class="card shadow mb-4 mt-3">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
  </div>
  <div class="card-body">
    <form action="{{ url('aspeks') }}" method="post">
    @csrf
      <div class="mb-3">
        <label for="name" class="form-label"><b>Aspek Penilaian</b></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name') }}">
        @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <input type="hidden" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" readonly required value="{{ old('slug') }}">
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="persentase" class="form-label"><b>Persentase (%)</b></label>
            <input type="text" class="form-control @error('persentase') is-invalid @enderror" id="persentase" name="persentase" required value="{{ old('persentase') }}">
            @error('persentase')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="form-group col-sm-6 flex-column d-flex"> 
            <label for="core" class="form-label"><b>Core Factor (%)</b></label>
            <input type="text" class="form-control @error('core') is-invalid @enderror" id="core" name="core" required value="{{ old('core') }}">
            @error('core')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
      </div>
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="secondary" class="form-label"><b>Secondary Factor (%)</b></label>
            <input type="text" class="form-control @error('secondary') is-invalid @enderror" id="secondary" name="secondary" required value="{{ old('secondary') }}">
            @error('secondary')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="form-group col-sm-6 flex-column d-flex">
          <label for="status" class="form-label"><b>Status Aspek</b></label>
          <select class="form-select" name="status_id">
              @foreach($statuses as $status)
                @if(old('status_id') == $status->id)
                  <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                @else
                  <option value="{{ $status->id }}">{{ $status->name }}</option> 
                @endif 
              @endforeach
          </select>
          </div>
        </div>
      </div>
        <button type="submit" class="btn btn-success mb-2" style="float: right; border-radius: 20px;"><i class="fa-solid fa-floppy-disk fa-fw"></i> Tambah Aspek</button>
        <a href="{{ url('aspeks') }}" class="btn btn-primary mb-2" style="float: right; margin-right: 10px; border-radius: 20px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a>
    </form>
  </div>
</div>

<script>
  const name = document.querySelector("#name");
  const slug = document.querySelector("#slug");

  name.addEventListener("keyup", function() {
    let preslug = name.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
  });
</script>

@endsection
 