@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Data Pelajaran</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPelajaranModal">Tambah Pelajaran</button>  
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelajaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelajaran as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $p->nama_pelajaran }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editPelajaranModal"
                                                    data-id="{{ $p->id }}" data-nama-pelajaran="{{ $p->nama_pelajaran }}"
                                                    onclick="editPelajaran(this)">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#hapusPelajaranModal"
                                                    data-id="{{ $p->id }}" data-nama-pelajaran="{{ $p->nama_pelajaran }}"
                                                    onclick="hapusPelajaran(this)">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="tambahPelajaranModal" tabindex="-1" role="dialog" aria-labelledby="tambahPelajaranModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahPelajaranModalLabel">Tambah Data Pelajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.data-pelajaran.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="tambahNamaPelajaran">Nama Pelajaran</label>
                                        <input type="text" name="nama_pelajaran" class="form-control" id="tambahNamaPelajaran" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     

                <div class="modal fade" id="editPelajaranModal" tabindex="-1" role="dialog" aria-labelledby="editPelajaranModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPelajaranModalLabel">Edit Data Pelajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="#" data-update-url="{{ route('admin.data-pelajaran.update', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editNamaPelajaran">Nama Pelajaran</label>
                                        <input type="text" name="nama_pelajaran" class="form-control" id="editNamaPelajaran" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="hapusPelajaranModal" tabindex="-1" role="dialog" aria-labelledby="hapusPelajaranModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusPelajaranModalLabel">Hapus Data Pelajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="hapusPelajaranForm">
                                    @csrf
                                    @method('DELETE')
                                    <p>Apakah Anda yakin ingin menghapus data pelajaran ini?</p>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <script>
                    function editPelajaran(button) {
                        const modal = document.getElementById('editPelajaranModal');
                        const form = modal.querySelector('form');

                        form.action = form.dataset.updateUrl.replace('__ID__', encodeURIComponent(button.dataset.id));
                        form.querySelector('[name="nama_pelajaran"]').value = button.dataset.namaPelajaran;
                    }

                    function hapusPelajaran(button) {
                        const modal = document.getElementById('hapusPelajaranModal');
                        const form = modal.querySelector('form');

                        form.action = '/admin/pelajaran/data-pelajaran/' + encodeURIComponent(button.dataset.id);
                        modal.querySelector('p').textContent = 'Apakah Anda yakin ingin menghapus data pelajaran "' + button.dataset.namaPelajaran + '"?';
                    }
                </script>
@endsection
