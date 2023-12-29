@extends('admin.layouts.login')
@section('content')
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index-2.html" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
          <img src="{{ asset('gambar-umum/logo.png') }}" alt="SMKN 1 Wongsorejo" width="45">
        </span>
        <span class="app-brand-text demo text-body fw-bolder">SISFO SECURITY</span>
      </a>
    </div>
    <h4 class="mb-2">Selamat Datang di Admin Login!</h4>
    
    <form class="mb-3" action="{{ url('/login') }}" method="post">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Username" value="{{ old('employeeID') }}" name="employeeID" autofocus>
      </div>
      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password</label>
        </div>
        <div class="input-group input-group-merge">
          <input type="password" id="password" class="form-control" name="password" placeholder="Password" aria-describedby="password" />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
      </div>
    </form>
  </div>
</div>

{{-- TOAST NOTIFIKASI --}}
<div style="display:none">
  <select id="selectTypeOpt" class="form-select color-dropdown">
    <option value="bg-danger">Danger</option>
  </select>
  <select class="form-select placement-dropdown" id="selectPlacement">
    <option value="top-0 end-0">Top right</option>
  </select>
  <button id="showToastPlacement" class="btn btn-primary d-block">Show Toast</button>
</div>

<div class="bs-toast toast toast-placement-ex m-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
  <div class="toast-header">
    <i class='bx bx-check me-2'></i>
    <div class="me-auto fw-semibold">Gagal</div>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    @if(Session::has('loginError'))
      Login tidak ditemukan!
    @endif
    
    @if(Session::has('invalid-token'))
      Incorret token!.
    @endif
  </div>
</div>

@endsection

@push('scripts')
  <!-- Modals -->
  <script src="{{ asset('admin/assets/js/ui-modals.js') }}"></script>
  <script src="{{ asset('admin/assets/js/ui-toasts.js') }}"></script>

  @if(Session::has('loginError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
  @endif
  
  @if(Session::has('invalid-token'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
  @endif
@endpush