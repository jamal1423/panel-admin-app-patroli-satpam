@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Transaksi Shift Detail
</h4>

<div class="card">
  {{-- <h5 class="card-header">List Transaksi Shift</h5> --}}
  <div class="table-responsive text-nowrap">
    <table class="table">
      {{-- <thead>
        <tr>
          <th>No.</th>
          <th>Tgl. Input</th>
          <th>Kode Shift</th>
          <th>Nama Shift</th>
          <th>Masa Berlaku Awal</th>
          <th>Masa Berlaku Akhir</th>
          <th>#</th>
        </tr>
      </thead> --}}
      <tbody class="table-border-bottom-0">
        @foreach($detailShiftHD as $detail)
        <tr>
          <td>Kode Shift</td>
          <td>:</td>
          <td>
            @foreach ($masterShift as $shift)
              @if($detail->kode_shift == $shift->id)              
                {{ $shift->kode_shift }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td>Nama Shift</td>
          <td>:</td>
          <td>
            @foreach ($masterShift as $shift)
              @if($detail->kode_shift == $shift->id)              
                {{ $shift->nama_shift }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td>Masa Berlaku Awal</td>
          <td>:</td>
          <td>{{ date('d-m-Y', strtotime($detail->masa_berlaku_awal)) }}</td>
        </tr>
        <tr>
          <td>Masa Berlaku Akhir</td>
          <td>:</td>
          <td>{{ date('d-m-Y', strtotime($detail->masa_berlaku_akhir)) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  {{-- <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('transaksiShiftTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('transaksiShiftEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('transaksiShiftDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('transaksiShiftError'))
        <option value="bg-danger">Danger</option>
        @endif
        
        @if(Session::get('transaksiShiftEksis'))
        <option value="bg-danger">Danger</option>
        @endif
        
        @if(Session::get('transaksiShiftExp'))
        <option value="bg-danger">Danger</option>
        @endif
        
        @if(Session::get('transaksiShiftLess'))
        <option value="bg-danger">Danger</option>
        @endif
    </select>
    <select class="form-select placement-dropdown" id="selectPlacement">
      <option value="top-0 end-0">Top right</option>
    </select>
    <button id="showToastPlacement" class="btn btn-primary d-block">Show Toast</button>
  </div> --}}

  {{-- <div class="bs-toast toast toast-placement-ex m-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
    <div class="toast-header">
      @if(Session::get('transaksiShiftError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @elseif(Session::get('transaksiShiftEksis'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @elseif(Session::get('transaksiShiftExp'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @elseif(Session::get('transaksiShiftLess'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('transaksiShiftTambah'))
        Transaksi shift baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('transaksiShiftEdit'))
        Data transaksi shift berhasil diubah.
      @endif
      
      @if(Session::get('transaksiShiftDelete'))
        Data transaksi shift berhasil dihapus.
      @endif
      
      @if(Session::get('transaksiShiftError'))
        Terjadi kesalahan, silahkan ulangi proses.
      @endif
      
      @if(Session::get('transaksiShiftEksis'))
        Data shift dengan masa berlaku tersebut sudah tersedia.
      @endif
      
      @if(Session::get('transaksiShiftExp'))
        Tanggal masa berlaku awal/akhir minimal sama dengan tanggal hari ini.
      @endif
      
      @if(Session::get('transaksiShiftLess'))
        Tanggal masa berlaku akhir tidak boleh kurang dari masa berlaku awal.
      @endif
    </div>
  </div> --}}
</div>

<button type="button" class="btn btn-primary mb-4 mt-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Data Satpam
</button>

<div class="card">
  <h5 class="card-header">List Satpam</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Employee ID</th>
          <th>Nama</th>
          <th>Kode Lokasi</th>
          <th>Nama Lokasi</th>
          <th>Keterangan</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($detailShiftDT as $key=>$shiftDT)
        <tr>
          <td>{{ $detailShiftDT->firstItem()+$key }}</td>
          <td>
            @foreach ($dataSecurity as $security)
              @if($shiftDT->employeeID == $security->employeeID)
                {{ $security->employeeID }} 
              @endif              
            @endforeach
          </td>
          <td>
            @foreach ($dataSecurity as $security)
              @if($shiftDT->employeeID == $security->employeeID)
                {{ $security->fullname }} 
              @endif              
            @endforeach
          </td>
          <td>
            @foreach ($mtLokasi as $lokasi)
              @if($shiftDT->kode_lokasi == $lokasi->kode_lokasi)
                {{ $lokasi->kode_lokasi }} 
              @endif              
            @endforeach
          </td>
          <td>
            @foreach ($mtLokasi as $lokasi)
              @if($shiftDT->kode_lokasi == $lokasi->kode_lokasi)
                {{ $lokasi->nama_lokasi }} 
              @endif              
            @endforeach
          </td>
          <td>{{ $shiftDT->keterangan }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                {{-- <a class="dropdown-item" href="{{ url('/transaksi-shift/detail/'.base64_encode($shiftDT->id)) }}"><i class="bx bx-group me-1 text-info"></i> Detail</a> --}}
                @if ($dtNow < $detail->masa_berlaku_akhir)
                  <a class="dropdown-item" href="#" id="shiftDT-edit-{{ $shiftDT->id }}" onClick="dataShiftDTEdit(this)" data-id="{{ base64_encode($shiftDT->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                @endif
                <a class="dropdown-item" href="#" id="shiftDT-del-{{ $shiftDT->id }}" onClick="dataShiftDTDel(this)" data-id="{{ base64_encode($shiftDT->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">Data tidak ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="demo-inline-spacing">
      <nav aria-label="Page navigation">
        {{ $detailShiftDT->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('shiftDetailTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('shiftDetailEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('shiftDetailDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('shiftDetailError'))
        <option value="bg-danger">Danger</option>
        @endif
        
        @if(Session::get('shiftDetailEksis'))
        <option value="bg-danger">Danger</option>
        @endif
        
    </select>
    <select class="form-select placement-dropdown" id="selectPlacement">
      <option value="top-0 end-0">Top right</option>
    </select>
    <button id="showToastPlacement" class="btn btn-primary d-block">Show Toast</button>
  </div>

  <div class="bs-toast toast toast-placement-ex m-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
    <div class="toast-header">
      @if(Session::get('shiftDetailError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @elseif(Session::get('shiftDetailEksis'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('shiftDetailTambah'))
        Detail shift berhasil ditambahkan.
      @endif
      
      @if(Session::get('shiftDetailEdit'))
        Detail shift berhasil diubah.
      @endif
      
      @if(Session::get('shiftDetailDelete'))
        Detail shift berhasil dihapus.
      @endif
      
      @if(Session::get('shiftDetailError'))
        Terjadi kesalahan, silahkan ulangi proses.
      @endif
      
      @if(Session::get('shiftDetailEksis'))
        Data lokasi user pada detail shift tersebut sudah tersedia.
      @endif

    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal">Tambah Data Satpam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/transaksi-shift/detail/add') }}" method="post">
        @csrf
        @method('post')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Employee ID</label>
              <input type="hidden" name="id" id="id-transaksi-shiftDT">
              <input type="hidden" name="idTransaksiHD" value="{{ $idHD }}">
              <select class="form-select @error('employeeID') is-invalid @enderror" aria-label="Default select example"  id="empliyee-id" name="employeeID">
                  @foreach ($dataSecurity as $security)
                    <option value="{{ $security->employeeID }}">{{ $security->employeeID." [".$security->fullname."]" }}</option>                    
                  @endforeach
              </select>
              @error('employeeID')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="row">
            <div class="col col-lg-12 mb-3">
              <label for="nameBasic" class="form-label">Kode Lokasi</label>
              <select class="form-select @error('kode_lokasi') is-invalid @enderror" aria-label="Default select example"  id="kode-lokasi" name="kode_lokasi">
                @foreach ($mtLokasi as $lokasi)
                  <option value="{{ $lokasi->kode_lokasi }}">{{ $lokasi->kode_lokasi." [".$lokasi->nama_lokasi."]" }}</option>                    
                @endforeach
            </select>
              @error('kode_lokasi')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col col-lg-12 mb-3">
              <label for="nameBasic" class="form-label">Keterangan</label>
              <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan" id="keterangan" name="keterangan" cols="30" rows="3">{{ old('keterangan') }}</textarea>
              @error('keterangan')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="javascript:window.location.reload()">Batal</button>
          <button type="submit" id="btn-modal" class="btn btn-primary">Tambahkan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete shift -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="text-align:center;">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/master-shift/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic">Yakin akan hapus data <strong id="label-del"></strong>?</label>
              <input type="hidden" id="id-del" name="id_del">
            </div>
          </div>

          <div class="row">
            <div class="col mb-3">
              <button type="button" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger mt-2">Hapus</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/ui-modals.js') }}"></script>
    <script src="{{ asset('admin/assets/js/ui-toasts.js') }}"></script>

    @if (count($errors) > 0)
    <script type="text/javascript">
      $(document).ready(function(){
          $("#btnModal").trigger("click");
      });
    </script>
    @endif

    @if(Session::get('shiftDetailTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftDetailEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftDetailDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftDetailError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif
    
    @if(Session::get('shiftDetailEksis'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataShiftEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-master-shift/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              // console.log(data)
              let {
                dataShift
              } = data
              $('#modal-form').attr('action','{{ url("/master-shift/edit") }}');
              $('#id-shift').val(dataShift.id);
              $('#kode-shift').val(dataShift.kode_shift);
              $('#kode-shift').attr('readonly', true);
              $('#nama-shift').val(dataShift.nama_shift);
              $('#jam-masuk').val(dataShift.jam_masuk);
              $('#jam-pulang').val(dataShift.jam_pulang);
              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data shift');
              $('#btn-modal').text('Update Data');
            }
          });
        }
      
        function dataShiftDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-master-shift/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataShift} = data
              $('#id-del').val(dataShift.id);
              $('#label-del').text(dataShift.nama_shift);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush