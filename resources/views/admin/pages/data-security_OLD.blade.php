@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data Security
</h4>
<button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Security
</button>

<div class="card">
  <h5 class="card-header">List Data Security</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>ID Karyawan</th>
          <th>Nama Karyawan</th>
          <th>Gender</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataSecurity as $key=>$security)
        <tr>
          <td>{{ $dataSecurity->firstItem()+$key }}</td>
          <td>{{ $security->employeeID }}</td>
          <td>{{ $security->fullname }}</td>
          <td>{{ $security->gender }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" id="security-edit-{{ $security->id }}" onClick="dataSecurityEdit(this)" data-id="{{ base64_encode($security->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="security-del-{{ $security->id }}" onClick="dataSecurityDel(this)" data-id="{{ base64_encode($security->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
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
        {{ $dataSecurity->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('securityTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('idAlready'))
            <option value="bg-warning">Warning</option>
        @endif
        
        @if(Session::get('securityEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('securityDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('securityError'))
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
      @if(Session::get('securityError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('securityTambah'))
        Security baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('idAlready'))
        ID telah tersedia, mohon cek kembali.
      @endif
      
      @if(Session::get('securityEdit'))
        Data Security berhasil diubah.
      @endif
      
      @if(Session::get('securityDelete'))
        Data Security berhasil dihapus.
      @endif
      
      @if(Session::get('securityError'))
        Terjadi kesalahan, silahkan ulangi proses.
      @endif
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal">Tambah Data Security</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/data-security/add') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="modal-body">
            {{-- <div class="row">
              <div class="col col-lg-12">
                <div id="imgSecurity"></div>
              </div>
            </div> --}}
            <div class="row">
              <div class="col col-lg-12">
                  <div class="row">
                    <div class="col col-lg-6 mb-3">
                      <label for="nameBasic" class="form-label">ID Security</label>
                      <input type="text" class="form-control @error('employeeID') is-invalid @enderror" placeholder="ID Security" id="employee-id" name="employeeID" value="{{ old('employeeID') }}">
                      @error('employeeID')
                          <div class="form-text text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col col-lg-6 mb-3">
                      <label for="nameBasic" class="form-label">Nama Security</label>
                      <input type="hidden" name="id" id="id-security">
                      <input type="text" class="form-control @error('fullname') is-invalid @enderror" placeholder="Nama Security" id="nama-security" name="fullname" value="{{ old('fullname') }}">
                      @error('fullname')
                          <div class="form-text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col col-lg-12">
                  <div class="row">
                    <div class="col mb-3">
                      <label for="emailBasic" class="form-label">Jenis Kelamin</label>
                      <select class="form-select" aria-label="Default select example" id="gender" name="gender">
                          <option selected="">Pilih Jenis Kelamin</option>
                          <option value="Pria">Pria</option>
                          <option value="Wanita">Wanita</option>
                      </select>
                    </div>
                    
                    <div class="col mb-3">
                      <label for="nameBasic" class="form-label">Password</label>
                      <input class="form-control" type="text" name="password" id="password-security" placeholder="Password" value="{{ old('password') }}" autocomplete="off">
                      @error('password')
                          <div class="form-text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
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

<!-- Delete Siswa -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="text-align:center;">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/data-security/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic">Yakin akan hapus data siswa <strong id="label-del"></strong>?</label>
              <input type="hidden" id="id-del" name="id_del">
              {{-- <input type="hidden" name="oldImageDel" id="oldImageDel"> --}}
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
    <script src="{{ asset('admin/assets/js/ui-toasts.js') }}"></script>

    @if (count($errors) > 0)
    <script type="text/javascript">
      $(document).ready(function(){
          $("#btnModal").trigger("click");
      });
    </script>
    @endif

    @if(Session::get('securityTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif
    
    @if(Session::get('nisAlready'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('securityEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('securityDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('securityError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataSecurityEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-security/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              // var imgElement = $('#imgSiswa');
					    // imgElement.empty();

              let {
                dataSecurity
              } = data
              $('#id-security').val(dataSecurity.id);
              $('#modal-form').attr('action','{{ url("/data-security/edit") }}');
              $('#employee-id').val(dataSecurity.employeeID);
              $('#nama-security').val(dataSecurity.fullname);
              $('#employee-id').prop('readonly', true);
              
              var selectElementJk = $('#gender')   
              selectElementJk.empty();
              selectElementJk.append(`
                <option>Pilih Jenis Kelamin</option>
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
              `)
              $("#gender option[value='" + dataSecurity.gender + "']").attr("selected", "selected");

              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data Security');
              $('#btn-modal').text('Update Data');
              // $('#imgSiswa').css("display","block");

              // var imgs = dataSiswa.foto;
              // var elem = document.createElement("img");
              // elem.setAttribute("src", "/foto-siswa/" + imgs);
              // elem.className="rounded-circle avatar avatar-xl pull-up mb-2";
              // document.getElementById("imgSiswa").appendChild(elem);
            }
          });
        }
      
        function dataSecurityDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-security/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataSecurity} = data
              $('#id-del').val(dataSecurity.id);
              $('#label-del').text(dataSecurity.fullname);
              // $('#oldImageDel').val(dataSiswa.foto);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush