@extends('dashboard.layouts.main')


@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <div class="d-flex" style="margin-left: 0;">
        <a href="{{ url('pembukaans/create') }}" class="btn btn-primary mb-2" style="border-radius: 20px;"><i class="fas fa-square-plus text-gray-300"></i> Buat Seleksi Baru</a>
    </div>
</div>

<div class="card rounded shadow border-0">
    <div class="card-body p-5 bg-white rounded">
        <div class="table-responsive" style="height: 550px;">
            <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
            @if ($pembukaans->count())
                <thead align="center" style="position: sticky; top: -1px; background: #2B4252">
                    <tr>
                        <th scope="col" style="color: white; width: 30px;">No.</th>
                        <th scope="col" style="color: white">Nama Seleksi</th>
                        <th scope="col" style="color: white; width: 85px;">Periode</th>
                        <th scope="col" style="color: white; width: 150px;">Dibuat Tanggal</th>
                        <th scope="col" style="color: white; width: 85px;">Status</th>
                        <th scope="col" style="color: white; width: 85px;">Aksi</th>
                    </tr>
                </thead>
                <tbody align="center">
                @foreach ($pembukaans as $pembukaan)
                    <tr>
                        <td style='text-align:center; vertical-align:middle'>{{  $loop->iteration }}</td>
                        <td style='text-align:left; vertical-align:middle'>{{ $pembukaan->name }}</td>
                        <td style='text-align:center; vertical-align:middle'>{{ $pembukaan->periode }}</td>
                        <td style='text-align:center; vertical-align:middle'>{{ date('d M Y', strtotime($pembukaan->created_at)) }}</td>
                        @if($pembukaan->status_id == 1)
                        <td style='text-align:center; vertical-align:middle'>
                            <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-success ganti" data-id="{{ $pembukaan->id }}"><i class="fa-regular fa-circle-check fa-fw"></i> {{ $pembukaan->status->name }}</a>
                        </td>
                        @else
                        <td style='text-align:center; vertical-align:middle'>
                            <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-danger ganti" data-id="{{ $pembukaan->id }}"><i class="fa-regular fa-circle-xmark fa-fw"></i> {{ $pembukaan->status->name }}</a> 
                        </td\>
                        @endif
                        <td style='text-align:center; vertical-align:middle'>
                            <a href="pembukaans/{{  $pembukaan->slug }}" class="badge bg-info"><i class="fa-regular fa-eye"></i></a>
                            <a href="pembukaans/{{  $pembukaan->slug }}/edit" class="badge bg-warning"><i class="fa-regular fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <p class="text-center fs-4">Seleksi tidak ditemukan.</p>
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
                window.location = "pembukaans/ganti-status/"+status_id+""
            }
        })
    })

    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection
@extends('dashboard.layouts.footer')