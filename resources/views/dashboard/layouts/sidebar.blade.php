<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <img src="{{ asset('img/iaas2.png') }}" alt="Logo IAAS" style="display:block; width: 100px; height: 100px; margin-left: auto; margin-right: auto;">
      @can('admin')
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
        <span>Administrator</span>
      </h6>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ url('dashboard') }}">
          <i class="fas fa-house fa-fw"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{  Request::is('pembukaans*') ? 'active' : ''}}" href="{{ url('pembukaans') }}">
          <i class="fas fa-door-open fa-fw"></i>
          Pembukaan Seleksi
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('alternatifs*') ? 'active' : '' }}" href="{{ url('alternatifs') }}">
          <i class="fas fa-users fa-fw"></i>
          Data Calon Anggota
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('aspeks*') ? 'active' : '' }}" href="{{ url('aspeks') }}">
          <i class="fas fa-brain fa-fw"></i>
          Aspek Penilaian
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('kriterias*') ? 'active' : '' }}" href="{{ url('kriterias') }}">
          <i class="fas fa-glasses fa-fw"></i>
          Kriteria Penilaian
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('penilaians*') ? 'active' : '' }}" href="{{ url('penilaians') }}">
          <i class="fas fa-box-archive fa-fw"></i>
          Input Nilai Calon Anggota
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('hasils*') ? 'active' : '' }}" href="{{ url('hasils') }}">
          <i class="fas fa-percent fa-fw"></i>
          Hasil Perhitungan
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Data Pengguna</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('profiles*') ? 'active' : '' }}" href="{{ url('profiles') }}">
          <i class="fas fa-lock fa-fw"></i>
          Ubah Kata Sandi
        </a>
      </li>
      <li class="nav-item">
          <form action="{{ url('logout') }}" method="post">
            @csrf
            <button type="submit" class="nav-link" style="border: 0px; background: none;"><i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i> Logout</button>
        </form>
      </li>
    </ul>
    @endcan
    @can('alternatif')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
        <span>Calon Anggota</span>
    </h6>
    <ul class="nav flex-column mb-2">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ url('dashboard') }}">
          <i class="fas fa-house fa-fw"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <div class="d-flex" style="margin-left: 0;">
          <a class="nav-link {{ Request::is('pendaftarans') ? 'active' : '' }}" href="{{ url('pendaftarans') }}">
            <i class="fas fa-door-open fa-fw"></i>
            Pendaftaran
            @if($new == true)
              <img src="{{ asset('img/notification.png') }}" alt="notifications" style="width: 18px; height: 18px; float: right;">
            @endif
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('seleksis*') ? 'active' : '' }}" href="{{ url('seleksis') }}">
          <i class="fas fa-hourglass-end fa-fw"></i>
          Hasil Seleksi
        </a>
      </li>
    </ul>
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>Data Pengguna</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('profiles*') ? 'active' : '' }}" href="{{ url('profiles') }}">
          <i class="fas fa-lock fa-fw"></i>
          Ubah Kata Sandi
        </a>
      </li>
      <li class="nav-item">
          <form action="{{ url('logout') }}" method="post">
            @csrf
            <button type="submit" class="nav-link" style="border: 0px; background: none;"><i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i> Logout</button>
        </form>
      </li>
    </ul>
  @endcan
  </div>
</nav>
