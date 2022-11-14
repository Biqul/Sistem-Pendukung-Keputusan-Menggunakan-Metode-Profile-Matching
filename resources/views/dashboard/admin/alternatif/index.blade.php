@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>


<div class="card rounded shadow border-0">
    <div class="card-body p-5 bg-white rounded">
        <div class="table-responsive" style="height: 550px;">
            <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
            @if ($alternatifs->count())
                <thead align="center" style="position: sticky; top: -1px; background: #2B4252">
                    <tr>
                        <th scope="col" style="color: white; width: 30px;">No.</th>
                        <th scope="col" style="color: white">Nama Lengkap</th>
                        <th scope="col" style="color: white; width: 200px;">Nomor Hp</th>
                        <th scope="col" style="color: white; width: 290px;">Email</th>
                        <th scope="col" style="color: white; width: 85px;">Status</th>
                        <th scope="col" style="color: white; width: 50px;">Aksi</th>
                    </tr>
                </thead>
                <tbody align="center">
                @foreach ($alternatifs as $alternatif)
                    <tr>
                        <td style='text-align:center; vertical-align:middle'>{{ $loop->iteration }}</td>
                        <td style='text-align:left; vertical-align:middle'>{{ $alternatif->name }}</td>
                        <td style='text-align:center; vertical-align:middle'>{{ $alternatif->no_hp }}</td>
                        <td style='text-align:center; vertical-align:middle'>{{ $alternatif->email }}</td>
                        @if($alternatif->status_id == 3)
                        <td style='text-align:center; vertical-align:middle'>
                            <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-success ganti" data-id="{{ $alternatif->id }}"><i class="fa-regular fa-circle-check fa-fw"></i> {{ $alternatif->status->name }}</a>
                        </td>
                        @elseif($alternatif->status_id == 4)
                        <td style='text-align:center; vertical-align:middle'>
                            <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-danger ganti" data-id="{{ $alternatif->id }}"><i class="fa-regular fa-circle-xmark fa-fw"></i> {{ $alternatif->status->name }}</a> 
                        </td>
                        @endif
                        <td style='text-align:center; vertical-align:middle'>
                            <a href="alternatifs/{{  $alternatif->id }}/edit" class="badge bg-warning"><i class="fa-regular fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <p class="text-center fs-4">Data alternatif tidak ditemukan.</p>
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
                window.location = "alternatifs/ganti-status/"+status_id+""
            }
        })
    })

    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection
@extends('dashboard.layouts.footer')
 