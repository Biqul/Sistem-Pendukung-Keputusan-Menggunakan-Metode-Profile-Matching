@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
  <h1 class="h2">{{ $title }}</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
  <div class="d-flex" style="margin-left: 0;">
  </div>
  <div>
    <a href="{{ url('pembukaans') }}" class="btn btn-primary mb-2" style="border-radius: 20px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a> 
  </div>
</div>

<div class="card rounded shadow border-0">
  <div class="card-body p-5 bg-white rounded">
    <div class="table-responsive" style="height: 450px;">
      <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
      @if ($alternatifs->count())
        <thead align="center" style="position: sticky; top: -1px; background: #2B4252">
          <tr>
            <th scope="col" style="color: white; width: 30px;">No.</th>
            <th scope="col" style="color: white">Nama Lengkap</th>
            <th scope="col" style="color: white; width: 200px;">Nomor Handphone</th>
            <th scope="col" style="color: white; width: 350px;">Email</th>
            @if($kosong == 0)
              <th scope="col" style="color: white">Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody align="center">
        @foreach ($alternatifs as $alternatif)
            <tr>
                <td style='text-align:center; vertical-align:middle'>{{ $loop->iteration }}</td>
                <td style='text-align:left; vertical-align:middle'>{{ $alternatif->name }}</td>
                <td style='text-align:center; vertical-align:middle'>{{ $alternatif->no_hp }}</td>
                <td style='text-align:center; vertical-align:middle'>{{ $alternatif->email }}</td>
                @if($alternatif->hasil_id == null)
                  <td style='text-align:center; vertical-align:middle'>
                      <a class="badge bg-danger delete" href="#"  data-id="{{ $alternatif->id }}"><i class="fa-solid fa-trash"></i></a>
                  </td>
                @endif
            </tr>
            @endforeach
        </tbody>
      @else
        <p class="text-center fs-4">Belum memiliki alternatif.</p>
      @endif
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
    $('.delete').click(function(){
        var alter_id = $(this).attr('data-id');
        Swal.fire({
            title: 'Hapus Calon Anggota?',
            text: "Apakah anda yakin ingin menghapus calon anggota dari seleksi ini?",
            icon: 'warning',
            showCancelButton: true, 
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "delete/"+alter_id+""
            }
        })
    })

    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection
@extends('dashboard.layouts.footer')