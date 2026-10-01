@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahKelasModal">Tambah Kelas</button>  
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nama_kelas }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editKelasModal"
                                                    data-id="{{ $k->id }}" data-nama_kelas="{{ $k->nama_kelas }}"
                                                    onclick="editKelas(this)">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#hapusKelasModal"
                                                    data-id="{{ $k->id }}" data-nama_kelas="{{ $k->nama_kelas }}"
                                                    onclick="hapusKelas(this)">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="tambahKelasModal" tabindex="-1" role="dialog" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahKelasModalLabel">Tambah Data Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.data-kelas.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Kelas</label>
                                        <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     
                
                <div class=modal fade id="editKelasModal" tabindex="-1" role="dialog" aria-labelledby="editKelasModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editKelasModalLabel">Edit Data Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="editKelasForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="edit_nama_kelas">Nama Kelas</label>
                                        <input type="text" name="nama_kelas" class="form-control" id="edit_nama_kelas" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="hapusKelasModal" tabindex="-1" role="dialog" aria-labelledby="hapusKelasModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusKelasModalLabel">Hapus Data Kelas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="hapusKelasForm">
                                    @csrf
                                    @method('DELETE')
                                    <p>Apakah Anda yakin ingin menghapus data kelas ini?</p>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function editKelas(button) {
                        var id = button.getAttribute('data-id');
                        var nama_kelas = button.getAttribute('data-nama_kelas');
                        document.getElementById('edit_nama_kelas').value = nama_kelas;
                        document.getElementById('editKelasForm').action = '/admin/kelas/data-kelas/' + id;
                    }
                    function hapusKelas(button) {
                        var id = button.getAttribute('data-id');
                        var nama_kelas = button.getAttribute('data-nama_kelas');
                        document.getElementById('hapusKelasForm').action = '/admin/kelas/data-kelas/' + id;
                        document.getElementById('hapusKelasForm').querySelector('p').textContent = 'Apakah Anda yakin ingin menghapus data kelas "' + nama_kelas + '"?';
                    }
                </script>
@endsection
