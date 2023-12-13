@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Master Shift
</h4>
<button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Shift
</button>

<div class="card">
  <h5 class="card-header">List Master Shift</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode Shift</th>
          <th>Nama Shift</th>
          <th>Jam Masuk</th>
          <th>Jam Pulang</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataShift as $key=>$shift)
        <tr>
          <td>{{ $dataShift->firstItem()+$key }}</td>
          <td>{{ $shift->kode_shift }}</td>
          <td>{{ $shift->nama_shift }}</td>
          <td>{{ $shift->jam_masuk }}</td>
          <td>{{ $shift->jam_pulang }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                {{-- <a class="dropdown-item" href="{{ url('/cetak-qr-code/'.base64_encode($shift->shift)) }}" target="_blank"><i class="bx bxs-printer me-1 text-info"></i> Cetak QR Code</a> --}}
                <a class="dropdown-item" href="#" id="shift-edit-{{ $shift->id }}" onClick="dataShiftEdit(this)" data-id="{{ base64_encode($shift->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="shift-del-{{ $shift->id }}" onClick="dataShiftDel(this)" data-id="{{ base64_encode($shift->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
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
        {{ $dataShift->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('shiftTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('shiftEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('shiftDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('shiftError'))
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
      @if(Session::get('shiftError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('shiftTambah'))
        shift baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('shiftEdit'))
        Data shift berhasil diubah.
      @endif
      
      @if(Session::get('shiftDelete'))
        Data shift berhasil dihapus.
      @endif
      
      @if(Session::get('shiftError'))
        Terjadi kesalahan, silahkan ulangi proses.
      @endif
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal">Tambah Shift</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/master-shift/add') }}" method="post">
        @csrf
        @method('post')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kode Shift</label>
              <input type="hidden" name="id" id="id-shift">
              <input type="text" class="form-control @error('kode_shift') is-invalid @enderror" placeholder="Kode Shift" id="kode-shift" name="kode_shift" value="{{ old('kode_shift') }}">
              @error('kode_shift')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nama Shift</label>
              <input type="text" class="form-control @error('nama_shift') is-invalid @enderror" placeholder="Nama Shift" id="nama-shift" name="nama_shift" value="{{ old('nama_shift') }}">
              @error('nama_shift')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col col-lg-6 mb-3">
              <label for="nameBasic" class="form-label">Jam Masuk</label>
              <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" placeholder="Jam Masuk" id="jam-masuk" name="jam_masuk" value="{{ old('jam_masuk') }}">
              @error('jam_masuk')
                  <div class="form-text text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col col-lg-6 mb-3">
              <label for="nameBasic" class="form-label">Jam Pulang</label>
              <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror" placeholder="Jam Pulang" id="jam-pulang" name="jam_pulang" value="{{ old('jam_pulang') }}">
              @error('jam_pulang')
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

    @if(Session::get('shiftTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('shiftError'))
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