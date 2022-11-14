<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background: #018A5A;">
  @can('admin')
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ url('dashboard') }}" style="text-align: center;">SPK IAAS LC Universitas Udayana</a>
  @endcan
  @can('alternatif')
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ url('dashboard') }}" style="text-align: center">IAAS LC Universitas Udayana</a>
  @endcan
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>