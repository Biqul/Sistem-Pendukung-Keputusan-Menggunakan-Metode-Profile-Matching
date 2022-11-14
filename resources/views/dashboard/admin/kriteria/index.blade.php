@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <div class="d-flex" style="margin-left: 0;">
        <a href="{{ 'kriterias/create' }}" class="btn btn-primary mb-2" style="border-radius: 20px;"><i class="fas fa-square-plus text-gray-300"></i> Tambah Kriteria Baru</a>
    </div>
</div>

<div class="card rounded shadow border-0">
    <div class="card-body p-5 bg-white rounded">
        <div class="table-responsive" style="height: 550px;">
            <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
            @if ($kriterias->count())
                <thead align="center" style="position: sticky; top: -1px; background: #2B4252">
                    <tr>
                        <th scope="col" style="color: white; width: 30px;">No.</th>
                        <th scope="col" style="color: white">Aspek Penilaian</th>
                        <th scope="col" style="color: white; width: 50px;">Kode</th>
                        <th scope="col" style="color: white">Kriteria</th>
                        <th scope="col" style="color: white; width: 100px;">Target Nilai</th>
                        <th scope="col" style="color: white; width: 120px;">Tipe</th>
                        <th scope="col" style="color: white; width: 85px;">Status</th>
                        <th scope="col" style="color: white; width: 50px;">Aksi</th>
                    </tr>
                </thead>
                <tbody align="center">
                @foreach ($kriterias as $kriteria)
                    <tr>
                        <td style='text-align:center; vertical-align:middle'>{{ $loop->iteration }}</td>
                        @foreach($aspeks as $aspek)
                            @if($kriteria->aspek_id == $aspek->id)
                                <td style='text-align:left; vertical-align:middle'>{{ $kriteria->aspek->name }}</td>
                            @endif
                        @endforeach
                        <td style='text-align:center; vertical-align:middle'>{{ $kriteria->kode_kriteria }}</td>
                        <td style='text-align:left; vertical-align:middle'>{{ $kriteria->name }}</td>
                        <td style='text-align:center; vertical-align:middle'>{{ $kriteria->value }}</td>
                        @if($kriteria->type_id == 1)
                            <td style='text-align:center; vertical-align:middle'>{{ $kriteria->type->name }}</td>
                        @else
                            <td style='text-align:center; vertical-align:middle'>{{ $kriteria->type->name }}</td>
                        @endif
                        @if($kriteria->status_id == 3)
                            <td style='text-align:center; vertical-align:middle'>
                                <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-success ganti" data-id="{{ $kriteria->id }}"><i class="fa-regular fa-circle-check fa-fw"></i> {{ $kriteria->status->name }}</a>
                            </td>
                        @else
                            <td style='text-align:center; vertical-align:middle'>
                                <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-danger ganti" data-id="{{ $kriteria->id }}"><i class="fa-regular fa-circle-xmark fa-fw"></i> {{ $kriteria->status->name }}</a> 
                            </td\>
                        @endif
                        <td style='text-align:center; vertical-align:middle'>
                            <a href="kriterias/{{  $kriteria->slug }}/edit" class="badge bg-warning"><i class="fa-regular fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <p class="text-center fs-4">Belum ada kriteria yang dibuat.</p>
            @endif
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ganti').click(function(){
        var status_id = $(this).attr('data-id');
        Swal.fire({
            title: 'Ubah status?',
            text: "Apakah anda yakin ingin mengubah status?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "kriterias/ganti-status/"+status_id+""
            }
        })
    })

    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection
@extends('dashboard.layouts.footer')