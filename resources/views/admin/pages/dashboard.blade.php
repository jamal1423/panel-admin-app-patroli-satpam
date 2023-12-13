@extends('admin.layouts.main')

@section('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 order-1">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  {{-- <img src="{{ asset('backend/assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded"> --}}
                  <span class="bx bxs-package rounded text-info fs-2"></span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Total Kelas</span>
              <h3 class="card-title mb-2" id="totalKelas">0</h3>
            </div>
          </div>
        </div>
    
        <div class="col-lg-4 col-md-4 col-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  {{-- <img src="{{ asset('backend/assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded"> --}}
                  <span class="bx bx-user rounded text-secondary fs-2"></span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Total Siswa</span>
              <h3 class="card-title mb-2" id="totalSiswa">0</h3>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  {{-- <img src="{{ asset('backend/assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded"> --}}
                  <span class="bx bx-map-pin rounded text-danger fs-2"></span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Total Lokasi Absen</span>
              <h3 class="card-title mb-2" id="totalLokasi">0</h3>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
