@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data User
</h4>
<button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah User
</button>

<div class="card">
  <h5 class="card-header">List Data User</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No.</th>
          {{-- <th></th> --}}
          <th>Nama</th>
          <th>Employee ID</th>
          <th>Role</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataUser as $key=>$user)
        <tr>
          <td>{{ $dataUser->firstItem()+$key }}</td>
          {{-- <td>
            @if($admin->foto == "")
            <img src="{{ asset('foto-admin/user.png') }}" width="40px">
            @else
            <img src="{{ asset('foto-admin/'.$admin->foto) }}" width="40px">
            @endif
          </td> --}}
          <td>{{ $user->fullname }}</td>
          <td>{{ $user->employeeID }}</td>
          <td>{{ $user->role }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" id="user-edit-{{ $user->id }}" onClick="dataUserEdit(this)" data-id="{{ base64_encode($user->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="user-del-{{ $user->id }}" onClick="dataUserDel(this)" data-id="{{ base64_encode($user->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
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
        {{ $dataUser->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('userTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('userAlready'))
            <option value="bg-warning">Warning</option>
        @endif
        
        @if(Session::get('userEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('userDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('userError'))
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
      @if(Session::get('userError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('userTambah'))
        User baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('userAlready'))
        ID employee telah tersedia, mohon cek kembali.
      @endif
      
      @if(Session::get('userEdit'))
        Data user berhasil diubah.
      @endif
      
      @if(Session::get('userDelete'))
        Data user berhasil dihapus.
      @endif
      
      @if(Session::get('userError'))
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
        <h5 class="modal-title" id="label-modal">Tambah Data User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/data-user/add') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="modal-body">
            <div class="row">
              <div class="col col-lg-12">
                <div id="imgUser"></div>
              </div>
            </div>
            <div class="row">
              <div class="col col-lg-12">
                  <div class="row">
                      <div class="col col-lg-6 mb-3">
                          <label for="nameBasic" class="form-label">Nama</label>
                          <input type="hidden" name="id" id="id-user">
                          <input type="text" class="form-control @error('fullname') is-invalid @enderror" placeholder="Nama User" id="nama-user" name="fullname" value="{{ old('fullname') }}">
                          @error('fullname')
                              <div class="form-text text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                      
                      <div class="col col-lg-6 mb-3">
                          <label for="nameBasic" class="form-label">Employee ID</label>
                          <input type="text" class="form-control @error('employeeID') is-invalid @enderror" placeholder="Employee ID" id="employee-id" name="employeeID" value="{{ old('employeeID') }}">
                          @error('employeeID')
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
                      <select class="form-select" aria-label="Default select example" id="role-user" name="role">
                          <option selected="">Pilih Role</option>
                          <option value="Administrator">Administrator</option>
                          <option value="Staff">Staff</option>
                      </select>
                    </div>
                    
                    <div class="col mb-3">
                      <label for="emailBasic" class="form-label">Gender</label>
                      <select class="form-select" aria-label="Default select example" id="gender" name="gender">
                        <option selected="">Pilih Jenis Gender</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                      </select>
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col col-lg-12">
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Foto User</label>
                    <div class="input-group">
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto-user" name="foto">
                    <input type="hidden" name="oldImage" id="oldImage">
                    </div>
                    @error('foto')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="col mb-3">
                      <label for="nameBasic" class="form-label">Password</label>
                      <input class="form-control" type="text" name="password" id="password-user" autocomplete="off" placeholder="Password" value="{{ old('password') }}">
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
      <form action="/data-user/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic">Yakin akan hapus data user <strong id="label-del"></strong>?</label>
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

    @if(Session::get('userTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif
    
    @if(Session::get('userAlready'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('userEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('userDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('userError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataUserEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-user/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              var imgElement = $('#imgUser');
					    imgElement.empty();

              let {
                dataUser,
              } = data
              $('#modal-form').attr('action','{{ url("/data-user/edit") }}');
              $('#id-user').val(dataUser.id);
              $('#nama-user').val(dataUser.fullname);
              $('#employee-id').val(dataUser.employeeID);
              $('#employee-id').prop('readonly', true);

              $('#oldImage').val(dataUser.foto);

              var selectElementRole = $('#role-user')   
              selectElementRole.empty();
              selectElementRole.append(`
                <option>Pilih Role</option>
                <option value="Administrator">Administrator</option>
                <option value="Staff">Staff</option>
              `)
              $("#role-user option[value='" + dataUser.role + "']").attr("selected", "selected");
              
              var selectElementJk = $('#gender')   
              selectElementJk.empty();
              selectElementJk.append(`
                <option>Pilih Jenis Gender</option>
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
              `)
              $("#gender option[value='" + dataUser.gender + "']").attr("selected", "selected");

              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data User');
              $('#btn-modal').text('Update Data');
              $('#imgUser').css("display","block");

              var imgs = dataUser.foto;
              var elem = document.createElement("img");
              elem.setAttribute("src", "/foto-user/" + imgs);
              elem.className="rounded-circle avatar avatar-xl pull-up mb-2";
              document.getElementById("imgUser").appendChild(elem);
            }
          });
        }
      
        function dataUserDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-user/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataUser} = data
              $('#id-del').val(dataUser.id);
              $('#label-del').text(dataUser.fullname);
              $('#oldImageDel').val(dataUser.foto);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush