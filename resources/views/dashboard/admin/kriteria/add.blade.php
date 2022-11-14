@extends('dashboard.layouts.main')

@section('container')
<div class="card shadow mb-4 mt-3">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
  </div>
  <div class="card-body">
    <form action="{{ url('kriterias') }}" method="post">
    @csrf
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="aspek" class="form-label"><b>Aspek Penilaian</b></label>
            <select class="form-select" name="aspek_id">
                @foreach($aspeks as $aspek)
                @if($aspek->status_id == 3)
                  @if(old('aspek_id') == $aspek->id)
                    <option value="{{ $aspek->id }}" selected>{{ $aspek->name }}</option>
                  @else
                    <option value="{{ $aspek->id }}">{{ $aspek->name }}</option> 
                  @endif
                @endif 
                @endforeach
            </select>
          </div>
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="type" class="form-label"><b>Tipe</b></label>
            <select class="form-select" name="type_id">
                @foreach($types as $type)
                  @if(old('type_id') == $type->id)
                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                  @else
                    <option value="{{ $type->id }}">{{ $type->name }}</option> 
                  @endif 
                @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="name" class="form-label"><b>Kriteria Penilaian</b></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Kriteria" required autofocus value="{{ old('name') }}">
            @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <input type="hidden" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" readonly required value="{{ old('slug') }}">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="value" class="form-label"><b>Target Nilai</b></label>
            <select class="form-select" name="value">
                    <option value="1" selected>1 - Sangat Kurang</option>
                    <option value="2">2 - Kurang</option>
                    <option value="3">3 - Cukup</option>
                    <option value="4">4 - Baik</option>
                    <option value="5">5 - Sangat Baik</option>
            </select>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <div class="row justify-content-between text-left">
          <div class="form-group col-sm-6 flex-column d-flex">
            <label for="kode_kriteria" class="form-label"><b>Kode Kriteria</b></label>
            <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror" id="kode_kriteria" name="kode_kriteria" required value="{{ old('kode_kriteria') }}">
            @error('kode_kriteria')
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
        <button type="submit" class="btn btn-success mb-2" style="float: right; border-radius: 20px;"><i class="fa-solid fa-floppy-disk fa-fw"></i> Tambah Kriteria</button>
        <a href="{{ url('kriterias') }}" class="btn btn-primary mb-2" style="float: right; margin-right: 10px; border-radius: 20px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a>
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
 