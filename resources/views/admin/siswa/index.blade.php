@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswaModal">Tambah Siswa</button>  
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $s)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $s->nisn }}</td>
                                            <td>{{ $s->nama }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editSiswaModal"
                                                    data-id="{{ $s->id }}" data-nisn="{{ $s->nisn }}" data-nama="{{ $s->nama }}"
                                                    onclick="editSiswa(this)">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#hapusSiswaModal"
                                                    data-id="{{ $s->id }}" data-nama="{{ $s->nama }}"
                                                    onclick="hapusSiswa(this)">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="tambahSiswaModal" tabindex="-1" role="dialog" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.data-siswa.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="tambahNisn">NISN</label>
                                        <input type="text" name="nisn" class="form-control" id="tambahNisn" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tambahNama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="tambahNama" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     

                <div class="modal fade" id="editSiswaModal" tabindex="-1" role="dialog" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSiswaModalLabel">Edit Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="#" data-update-url="{{ route('admin.data-siswa.update', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editNisn">NISN</label>
                                        <input type="text" name="nisn" class="form-control" id="editNisn" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editNama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="editNama" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="hapusSiswaModal" tabindex="-1" role="dialog" aria-labelledby="hapusSiswaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusSiswaModalLabel">Hapus Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="hapusSiswaForm">
                                    @csrf
                                    @method('DELETE')
                                    <p>Apakah Anda yakin ingin menghapus data siswa ini?</p>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <script>
                    function editSiswa(button) {
                        const modal = document.getElementById('editSiswaModal');
                        const form = modal.querySelector('form');

                        form.action = form.dataset.updateUrl.replace('__ID__', encodeURIComponent(button.dataset.id));
                        form.querySelector('[name="nisn"]').value = button.dataset.nisn;
                        form.querySelector('[name="nama"]').value = button.dataset.nama;
                    }

                    function hapusSiswa(button) {
                        const modal = document.getElementById('hapusSiswaModal');
                        const form = modal.querySelector('form');

                        form.action = '/admin/siswa/data-siswa/' + encodeURIComponent(button.dataset.id);
                        modal.querySelector('p').textContent = 'Apakah Anda yakin ingin menghapus data siswa "' + button.dataset.nama + '"?';
                    }
                </script>
@endsection
