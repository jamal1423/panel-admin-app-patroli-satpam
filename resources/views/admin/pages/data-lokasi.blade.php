@extends('admin.layouts.main')
@push('styles')
    <style type="text/css">
        .controls {
            background-color: #fff;
            border-radius: 2px;
            border: 1px solid transparent;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            box-sizing: border-box;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            height: 29px;
            margin-left: 17px;
            margin-top: 10px;
            outline: none;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;

    }
    .pac-container{
        z-index: 1150 !important;
    }
    .controls:focus {
            border-color: #4d90fe;
    }
    .title {
            font-weight: bold;
    }
    #infowindow-content {
            display: none;
    }
    #map #infowindow-content {
            display: inline;
    }

    </style>
@endpush
@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data Lokasi
</h4>
{{-- <button type="button" class="btn btn-primary mb-4" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalForm">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Lokasi
</button> --}}
<button type="button" class="btn btn-primary mb-4" id="btnModal" onclick="add()">
  <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Lokasi
</button>

<div class="card">
  <h5 class="card-header">List Data Lokasi</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode Lokasi</th>
          <th>Nama Lokasi</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>Radius (meter)</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($dataLokasi as $key=>$lokasi)
        <tr>
          <td>{{ $dataLokasi->firstItem()+$key }}</td>
          <td>{{ $lokasi->kode_lokasi }}</td>
          <td>{{ $lokasi->nama_lokasi }}</td>
          <td>{{ number_format($lokasi->latitude,8) }}</td>
          <td>{{ number_format($lokasi->longitude,8) }}</td>
          <td>{{ number_format($lokasi->radius,0) }}</td>
          <td>
            <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="showMap('{{ $lokasi->latitude }}','{{ $lokasi->longitude }}','{{ $lokasi->radius }}','{{ $lokasi->nama }}')" data-toggle="modal"><i class="bx bx-map-alt me-1 text-info"></i> Show On Map</a>
                <a class="dropdown-item" href="#" id="lokasi-edit-{{ $lokasi->id }}" onClick="dataLokasiEdit(this)" data-id="{{ base64_encode($lokasi->id) }}"><i class="bx bx-edit-alt me-1 text-primary"></i> Edit</a>
                <a class="dropdown-item" href="#" id="lokasi-del-{{ $lokasi->id }}" onClick="dataLokasiDel(this)" data-id="{{ base64_encode($lokasi->id) }}"><i class="bx bx-trash me-1 text-danger"></i> Hapus</a>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7">Data tidak ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="demo-inline-spacing">
      <nav aria-label="Page navigation">
        {{ $dataLokasi->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  </div>

  {{-- TOAST NOTIFIKASI --}}
  <div style="display:none">
    <select id="selectTypeOpt" class="form-select color-dropdown">
        @if(Session::get('lokasiTambah'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('lokasiEdit'))
            <option value="bg-success">Success</option>
        @endif

        @if(Session::get('lokasiDelete'))
            <option value="bg-success">Success</option>
        @endif
        
        @if(Session::get('lokasiError'))
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
      @if(Session::get('lokasiError'))
      <i class='bx bx-error-alt me-2'></i>
      <div class="me-auto fw-semibold"> Error</div>
      @else
      <i class='bx bx-check me-2'></i>
      <div class="me-auto fw-semibold">Sukses</div>
      @endif
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if(Session::get('lokasiTambah'))
        Lokasi baru berhasil ditambahkan.
      @endif
      
      @if(Session::get('lokasiEdit'))
        Data lokasi berhasil diubah.
      @endif
      
      @if(Session::get('lokasiDelete'))
        Data lokasi berhasil dihapus.
      @endif
      
      @if(Session::get('lokasiError'))
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
        <h5 class="modal-title" id="label-modal">Tambah Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      <form id="modal-form" action="{{ url('/data-lokasi/add') }}" method="post">
        @csrf
        @method('post')
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Kode Lokasi</label>
                    <input type="text" class="form-control @error('kode_lokasi') is-invalid @enderror" placeholder="Kode Lokasi" id="kode-lokasi" name="kode_lokasi" value="{{ old('kode_lokasi') }}">
                    @error('kode_lokasi')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Nama Lokasi</label>
                    <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror" placeholder="Nama Lokasi" id="nama-lokasi" name="nama_lokasi" value="{{ old('nama_lokasi') }}">
                    @error('nama_lokasi')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="nameBasic" class="form-label">Map Lokasi</label>
                        <div class="pac-container" style="display: none">
                            <input id="pac-input" class="controls" type="text" placeholder="Masukan Lokasi">
                        </div>
                        <div id="map" style="height:300px;"></div>
                        <div id="infowindow-content">
                            <span id="place-name" class="title"></span><br>
                            <span id="place-address"></span>
                        </div>
                    </div>
                    <input id="modal-lat" class="form-control" name="latitude" type="hidden" required>
                    <input id="modal-long" class="form-control" name="longitude" type="hidden" required>
                    <input id="modal-radius" class="form-control" name="radius" type="hidden" required>
                    <input id="modal-id" class="form-control" name="id" type="hidden">
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

{{-- Modal Map --}}
<div class="modal fade" id="modal_map" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal">Lokasi Absensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript:window.location.reload()"></button>
      </div>
      
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <div id="show" style="height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="javascript:window.location.reload()">Close</button>
        </div>
    </div>
  </div>
</div>

<!-- Delete Lokasi -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="text-align:center;">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/data-lokasi/delete" method="post">
        @csrf
        @method('delete')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic">Yakin akan hapus data lokasi absen <strong id="label-del"></strong>?</label>
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
    <script src="{{ asset('admin/assets/js/ui-toasts.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $mapApiKey }}&libraries=drawing,geometry,places"></script>

    <script>
      var circle;
      var old_circle;
      var showcircle;
      
      function addMap() {
          var mapOptions = {
              center: new google.maps.LatLng(-7.4401466290744045, 112.6131897342075),
              zoom: 18  
          };
      
          var map = new google.maps.Map(document.getElementById('map'),
          mapOptions);
      
          var input = document.getElementById('pac-input');
      
          var autocomplete = new google.maps.places.Autocomplete(input);
          autocomplete.bindTo('bounds', map);
      
          // Specify just the place data fields that you need.
          autocomplete.setFields(['place_id', 'geometry', 'name']);
      
          map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
      
          var infowindow = new google.maps.InfoWindow();
          var infowindowContent = document.getElementById('infowindow-content');
          infowindow.setContent(infowindowContent);
      
          var marker = new google.maps.Marker({map: map});
      
          marker.addListener('click', function() {
            infowindow.open(map, marker);
          });
      
          autocomplete.addListener('place_changed', function() {
              infowindow.close();
      
              var place = autocomplete.getPlace();
      
              if (!place.geometry) {
              return;
              }
      
              if (place.geometry.viewport) {
                  map.fitBounds(place.geometry.viewport);
              } else {
                  map.setCenter(place.geometry.location);
                  map.setZoom(18);
              }
      
              // Set the position of the marker using the place ID and location.
                  marker.setPlace({
                  placeId: place.place_id,
                  location: place.geometry.location
              });
      
              marker.setVisible(true);
      
              infowindowContent.children['place-name'].textContent = place.name;
              //infowindowContent.children['place-id'].textContent = place.place_id;
              infowindowContent.children['place-address'].textContent = place.formatted_address;
              infowindow.open(map, marker);
          });
      
      
          var drawingManager = new google.maps.drawing.DrawingManager({
              // drawingMode: google.maps.drawing.OverlayType.MARKER,
              drawingControl: true,
              drawingControlOptions: {
                  position: google.maps.ControlPosition.LEFT_CENTER,
                  drawingModes: [google.maps.drawing.OverlayType.CIRCLE]
              },
              circleOptions: {
                  strokeColor: '#8080ff',
                  strokeOpacity: 0.7,
                  strokeWeight: 1,
                  fillColor: '#8080ff',
                  fillOpacity: 0.15,
                  clickable: false,
                  editable: true,
                  zIndex: 1
              }
          });  
            drawingManager.setMap(map);
          google.maps.event.addListener(drawingManager, 'circlecomplete', onCircleComplete);
      }
      
      function onCircleComplete(shape) {
          var lat = null;
          var lng = null;
          var radius = null;
      
          if (shape == null || (!(shape instanceof google.maps.Circle))) return; 
          if (circle != null) {
              circle.setMap(null);
              circle = null;
          }
          
          circle = shape;
          $('#modal-lat').val(circle.getCenter().lat());
          $('#modal-long').val(circle.getCenter().lng());
          $('#modal-radius').val(circle.getRadius());
      
          google.maps.event.addListener(circle, 'center_changed', function () {
              lat = circle.getCenter().lat();
              lng = circle.getCenter().lng();
              //alert(center);
              $('#modal-lat').val(lat);
              $('#modal-long').val(lng);
          });
      
          google.maps.event.addListener(circle, 'radius_changed', function () {
              radius = circle.getRadius();
              $('#modal-radius').val(radius);
          });
      }
      
      function showMapProcess(lat, lng, radius, nama, kota){
        var mapOptions = {
            center: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
            zoom: 18
            
        };
    
        var map = new google.maps.Map(document.getElementById('show'),
        mapOptions);
    
        var showcircle = new google.maps.Circle({
            strokeColor: '#8080ff',
            strokeOpacity: 0.7,
            strokeWeight: 1,
            fillColor: '#8080ff',
            fillOpacity: 0.15,
            draggable: false,
            map: map,
            center: mapOptions.center,
            radius: parseFloat(radius)
        });
        showcircle.setMap(map);
    
        var geocoder = new google.maps.Geocoder;
        
        geocoder.geocode({'location': mapOptions.center}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              
                var alamat = results[0].formatted_address;
                var contentString = '<div id="content">'+
                                        '<h4 id="firstHeading" class="firstHeading"> '+ nama +'</h4>'+
                                        '<div id="bodyContent">'+
                                            '<p> Kota : '+ kota + '</p>'+
                                            '<hr>'+
                                            '<p>' + alamat + '</p>'+
                                        '</div>'+
                                    '</div>';
    
                var info = new google.maps.InfoWindow();
    
                google.maps.event.addListener(showcircle, 'click', function(e) {
                    info.setContent(contentString);
                    info.setPosition(this.getCenter());
                    info.open(map);
                });
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
      
      function updateMap(lat, lng, radius){
        var mapOptions = {
            center: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
            zoom: 18
        };
    
        var map = new google.maps.Map(document.getElementById('map'),
        mapOptions);
    
        var old_circle = new google.maps.Circle({
            strokeColor: '#8080ff',
            strokeOpacity: 0.7,
            strokeWeight: 1,
            fillColor: '#8080ff',
            fillOpacity: 0.15,
            draggable: false,
            map: map,
            editable: true,
              draggable: true,
            center: mapOptions.center,
            radius: parseFloat(radius)
        });
        old_circle.setMap(map);
    
        google.maps.event.addListener(old_circle, 'center_changed', function () {
            lat = old_circle.getCenter().lat();
            lng = old_circle.getCenter().lng();
    
            $('#modal-lat').val(lat);
            $('#modal-long').val(lng);
        });
    
        google.maps.event.addListener(old_circle, 'radius_changed', function () {
            radius = old_circle.getRadius();
            $('#modal-radius').val(radius);
        });  
      }
    </script>

    <script>
      function showMap(lat, lng, radius, nama, kota){
          showMapProcess(lat, lng, radius, nama, kota);
          $('#modal_map').modal('show');
      };
      function add(){
          $('#modal-lat').val('');
          $('#modal-long').val('');
          $('#modal-radius').val('');
          addMap();
          $('#modalForm').modal('show');
      };

      function editLokasi(id, nama, lat, lng, radius){

      }
    </script>

    @if (count($errors) > 0)
    <script type="text/javascript">
      $(document).ready(function(){
          $("#btnModal").trigger("click");
      });
    </script>
    @endif

    @if(Session::get('lokasiTambah'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('lokasiEdit'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('lokasiDelete'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    @if(Session::get('lokasiError'))
    <script>
      window.onload = function() {
        $("#showToastPlacement").click();
        }
    </script>
    @endif

    <script>
        function dataLokasiEdit(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-lokasi/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              // console.log(data)
              let {
                dataLokasi
              } = data
              $('#modal-form').attr('action','{{ url("/data-lokasi/edit") }}');
              $('#modal-id').val(dataLokasi.id);
              $('#kode-lokasi').val(dataLokasi.kode_lokasi);
              $('#kode-lokasi').attr('readonly', true);
              $('#nama-lokasi').val(dataLokasi.nama_lokasi);
              $('#modal-lat').val(dataLokasi.latitude);
              $('#modal-long').val(dataLokasi.longitude);
              $('#modal-radius').val(dataLokasi.radius);
              updateMap(dataLokasi.latitude, dataLokasi.longitude, dataLokasi.radius);
              $('#modalForm').modal('show');
              $('#label-modal').text('Edit Data Lokasi');
              $('#btn-modal').text('Update Data');
            }
          });
        }
      
        function dataLokasiDel(element) {
          var id = $(element).attr('data-id');
          $.ajax({
            url: "/get-data-lokasi/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              let {dataLokasi} = data
              $('#id-del').val(dataLokasi.id);
              $('#label-del').text(dataLokasi.nama_lokasi);
              $('#modalHapus').modal('show');
            }
          });
        }
    </script>
@endpush