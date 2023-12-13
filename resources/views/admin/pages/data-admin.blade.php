@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data Admin
</h4>
<button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Admin
</button>

<div class="card">
  <h5 class="card-header">List Data Admin</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No.</th>
          {{-- <th></th> --}}
          <th>Nama</th>
          <th>Username</th>
          <th>Role</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataAdmin as $key=>$admin)
        <tr>
          <td>{{ $dataAdmin->firstItem()+$key }}</td>
          {{-- <td>
            @if($admin->foto == "")
            <img src="{{ asset('foto-admin/user.png') }}" width="40px">
            @else
            <img src="{{ asset('foto-admin/'.$admin->foto) }}" width="40px">
            @endif
          </td> --}}
          <td>{{ $admin->fullname }}</td>
          <td>{{ $admin->username }}</td>
          <td>{{ $admin->role }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" id="admin-edit-{{ $admin->id }}" onClick="dataAdminEdit(this)" data-id="{{ base64_encode($admin->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="admin-del-{{ $admin->id }}" onClick="dataAdminDel(this)" data-id="{{ base64_encode($admin->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
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
        {{ $dataAdmin->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('adminTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('adminAlready'))
            <option value="bg-warning">Warning</option>
        @endif
        
        @if(Session::get('adminEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('adminDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('adminError'))
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
      @if(Session::get('adminError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('adminTambah'))
        Admin baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('adminAlready'))
        Username telah tersedia, mohon cek kembali.
      @endif
      
      @if(Session::get('adminEdit'))
        Data admin berhasil diubah.
      @endif
      
      @if(Session::get('adminDelete'))
        Data admin berhasil dihapus.
      @endif
      
      @if(Session::get('adminError'))
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
        <h5 class="modal-title" id="label-modal">Tambah Data Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/data-admin/add') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="modal-body">
            <div class="row">
              <div class="col col-lg-12">
                <div id="imgAdmin"></div>
              </div>
            </div>
            <div class="row">
              <div class="col col-lg-12">
                  <div class="row">
                      <div class="col col-lg-6 mb-3">
                          <label for="nameBasic" class="form-label">Nama</label>
                          <input type="hidden" name="id" id="id-admin">
                          <input type="text" class="form-control @error('fullname') is-invalid @enderror" placeholder="Nama Admin" id="nama-admin" name="fullname" value="{{ old('fullname') }}">
                          @error('fullname')
                              <div class="form-text text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                      
                      <div class="col col-lg-6 mb-3">
                          <label for="nameBasic" class="form-label">Username</label>
                          <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Uername" id="username-admin" name="username" value="{{ old('username') }}">
                          @error('username')
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
                      <label for="emailBasic" class="form-label">Role</label>
                      <select class="form-select" aria-label="Default select example" id="role-admin" name="role">
                          <option selected="">Pilih Role</option>
                          <option value="Administrator">Administrator</option>
                          <option value="Staff">Staff</option>
                      </select>
                    </div>
                
                    <div class="col mb-3">
                      <label for="nameBasic" class="form-label">Foto Admin</label>
                      <div class="input-group">
                      <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto-admin" name="foto">
                      <input type="hidden" name="oldImage" id="oldImage">
                      </div>
                      @error('foto')
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
                      <label for="nameBasic" class="form-label">Password</label>
                      <input class="form-control" type="text" name="password" id="password-admin" autocomplete="off" placeholder="Password" value="{{ old('password') }}">
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
      <form action="/data-admin/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic">Yakin akan hapus data admin <strong id="label-del"></strong>?</label>
              <input type="hidden" id="id-del" name="id_del">
              <input type="hidden" name="oldImageDel" id="oldImageDel">
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

    @if(Session::get('adminTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif
    
    @if(Session::get('adminAlready'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('adminEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('adminDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('adminError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataAdminEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-admin/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              var imgElement = $('#imgAdmin');
					    imgElement.empty();

              let {
                dataAdmin,
              } = data
              $('#modal-form').attr('action','{{ url("/data-admin/edit") }}');
              $('#id-admin').val(dataAdmin.id);
              $('#nama-admin').val(dataAdmin.fullname);
              $('#username-admin').val(dataAdmin.username);
              $('#username-admin').prop('readonly', true);

              $('#oldImage').val(dataAdmin.foto);

              var selectElementRole = $('#role-admin')   
              selectElementRole.empty();
              selectElementRole.append(`
                <option>Pilih Role</option>
                <option value="Administrator">Administrator</option>
                <option value="Staff">Staff</option>
              `)
              $("#role-admin option[value='" + dataAdmin.role + "']").attr("selected", "selected");

              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data Admin');
              $('#btn-modal').text('Update Data');
              $('#imgAdmin').css("display","block");

              var imgs = dataAdmin.foto;
              var elem = document.createElement("img");
              elem.setAttribute("src", "/foto-admin/" + imgs);
              elem.className="rounded-circle avatar avatar-xl pull-up mb-2";
              document.getElementById("imgAdmin").appendChild(elem);
            }
          });
        }
      
        function dataAdminDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-admin/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataAdmin} = data
              $('#id-del').val(dataAdmin.id);
              $('#label-del').text(dataAdmin.fullname);
              $('#oldImageDel').val(dataAdmin.foto);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush