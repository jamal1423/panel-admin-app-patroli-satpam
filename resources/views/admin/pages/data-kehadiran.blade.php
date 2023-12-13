@extends('admin.layouts.main')

@section('content')
<h4 class="fw-bold">
  <span class="text-muted fw-light">Admin /</span> Data Kehadiran
</h4>

<div class="card">
    <h5 class="card-header">List Data Kehadiran Siswa</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped" style="font-size: 14px">
            <thead>
                <tr>
                    <th>No.</th>
                    <th></th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($dataKehadiran as $key=>$hadir)
                <tr>
                    <td>{{ $dataKehadiran->firstItem()+$key }}</td>
                    <td><img src="{{ asset('foto-siswa/'.$hadir->foto) }}" width="40px"></td>
                    <td>{{ $hadir->nis }}</td>
                    <td>{{ $hadir->nama }}</td>
                    <td>{{ $hadir->kelas }}</td>
                    <td>
                        <span class="badge bg-label-success me-1">{{ date('d-m-Y H:i:s', strtotime($hadir->tgl_clock_in)) }}</span>
                    </td>
                    <td>
                        @if($hadir->clock_out == "")
                            <span class="badge bg-label-danger me-1">Belum Clock-Out</span>
                        @else
                            <span class="badge bg-label-success me-1">{{ date('d-m-Y H:i:s', strtotime($hadir->tgl_clock_out)) }}</span>
                        @endif
                    </td>
                    <td>{{ $hadir->lokasi }}</td>
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
                {{ $dataKehadiran->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>
</div>
@endsection