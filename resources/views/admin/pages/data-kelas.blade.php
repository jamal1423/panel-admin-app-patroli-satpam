@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data Kelas
</h4>
<button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Kelas
</button>

<div class="card">
  <h5 class="card-header">List Data Kelas</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Kelas</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataKelas as $key=>$kelas)
        <tr>
          <td>{{ $dataKelas->firstItem()+$key }}</td>
          <td>{{ $kelas->kelas }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('/cetak-qr-code/'.base64_encode($kelas->kelas)) }}" target="_blank"><i class="bx bxs-printer me-1 text-info"></i> Cetak QR Code</a>
                <a class="dropdown-item" href="#" id="kelas-edit-{{ $kelas->id }}" onClick="dataKelasEdit(this)" data-id="{{ base64_encode($kelas->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="kelas-del-{{ $kelas->id }}" onClick="dataKelasDel(this)" data-id="{{ base64_encode($kelas->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5">Data tidak ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="demo-inline-spacing">
      <nav aria-label="Page navigation">
        {{ $dataKelas->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('kelasTambah') == 'ok')
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('kelasEdit') == 'ok')
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('kelasDelete') == 'ok')
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('kelasError') == 'ok')
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
      @if(Session::get('kelasError') == 'ok')
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('kelasTambah') == 'ok')
        Kelas baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('kelasEdit') == 'ok')
        Data kelas berhasil diubah.
      @endif
      
      @if(Session::get('kelasDelete') == 'ok')
        Data kelas berhasil dihapus.
      @endif
      
      @if(Session::get('kelasError') == 'ok')
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
        <h5 class="modal-title" id="label-modal">Tambah Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/data-kelas/add') }}" method="post">
        @csrf
        @method('post')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nama Kelas</label>
              <input type="hidden" name="id" id="id-kelas">
              <input type="text" class="form-control @error('kelas') is-invalid @enderror" placeholder="Nama Kelas" id="nama-kelas" name="kelas" value="{{ old('kelas') }}">
              @error('kelas')
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

<!-- Delete Kelas -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="text-align:center;">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/data-kelas/delete" method="post">
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

    @if(Session::get('kelasTambah') == 'ok')
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('kelasEdit') == 'ok')
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('kelasDelete') == 'ok')
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('kelasError') == 'ok')
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataKelasEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-kelas/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              // console.log(data)
              let {
                dataKelas
              } = data
              $('#modal-form').attr('action','{{ url("/data-kelas/edit") }}');
              $('#id-kelas').val(dataKelas.id);
              $('#nama-kelas').val(dataKelas.kelas);
              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data Kelas');
              $('#btn-modal').text('Update Data');
            }
          });
        }
      
        function dataKelasDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-kelas/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataKelas} = data
              $('#id-del').val(dataKelas.id);
              $('#label-del').text(dataKelas.kelas);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush