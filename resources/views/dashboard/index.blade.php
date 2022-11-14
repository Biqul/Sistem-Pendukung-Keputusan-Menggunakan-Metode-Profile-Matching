@extends('dashboard.layouts.main')
<link href="css/sb-admin-2.css?version=3" rel="stylesheet">

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>


<div class="card shadow mb-4 mt-3">
    @can('admin')
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Halo, {{ auth()->user()->name }}.</h6>
        </div>
        <div class="card-body">
            <p>Selamat datang di Sistem Pendukung Keputusan IAAS Local Committee Universitas Udayana.</p>
            <p class="mb-0">Di bawah ini berisi total Seleksi yang sedang buka, total Calon Anggota aktif, total Aspek yang aktif maupun tidak, dan total Kriteria yang aktif maupun tidak.</p>
        </div>
  @endcan
  @can('alternatif')
    <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Selamat datang di Pendaftaran Seleksi IAAS Local Committee Universitas Udayana.</h6>
    </div>
    <div class="card-body">
        <img src="img/iaas2.png" alt="Logo IAAS" style="display:block; width: 200px; height: 200px; margin-left: auto; margin-right: auto;">
        <p><strong>Halo, {{ auth()->user()->name }}.</strong></br>
        Untuk dapat berpartisipasi dalam seleksi, silahkan mendaftar pada seleksi yang dibuka pada menu "Pendaftaran".</p>
        <p class="mb-0" style="text-align: justify">
            <i><strong>What is IAAS ?</strong></br>
            International Association of Students in Agricultural and Related Sciences is the world 
            Biggest Student Association in The Field of Agriculture and Related Sciences. IAAS was founded in 
            1975 and started with only 8 member countries. For the last 60 years, IAAS has grown into a big organization 
            with 53 member countries and more than 10,000 active members. IAAS Indonesia was found by Mr. Arif Satria on 
            Desember 29th 1992. By the year of 2020, IAAS Indonesia has 11 Local Committees across the country with more 
            than 1,200 active members.</p></i>
    </div>
  @endcan
</div>
 
@can('admin')
  <!-- Content Row -->
  <div class="row">

    <!-- Pembukaan Seleksi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('pembukaans') }}" style="text-decoration: none;">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Seleksi Sedang Buka</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_seleksi }}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Alternatif -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('alternatifs') }}" style="text-decoration: none;">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Calon Anggota Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_alternatif }}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Aspek -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('aspeks') }}" style="text-decoration: none;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Aspek</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_aspek }}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-brain fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Kriteria -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('kriterias') }}" style="text-decoration: none;">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Kriteria</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_kriteria }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-glasses fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
  </div>
@endcan
@endsection