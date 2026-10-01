@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Data Guru</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahGuruModal">Tambah Guru</button>  
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guru as $g)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $g->nip }}</td>
                                            <td>{{ $g->nama }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editGuruModal"
                                                    data-id="{{ $g->id }}" data-nip="{{ $g->nip }}" data-nama="{{ $g->nama }}"
                                                    onclick="editGuru(this)">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#hapusGuruModal"
                                                    data-id="{{ $g->id }}" data-nama="{{ $g->nama }}"
                                                    onclick="hapusGuru(this)">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="tambahGuruModal" tabindex="-1" role="dialog" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahGuruModalLabel">Tambah Data Guru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.data-guru.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" name="nip" class="form-control" id="nip" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="nama" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
           
                <div class=modal fade id="editGuruModal" tabindex="-1" role="dialog" aria-labelledby="editGuruModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editGuruModalLabel">Edit Data Guru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="editGuruForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editNip">NIP</label>
                                        <input type="text" name="nip" class="form-control" id="editNip" required>
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

                <div class="modal fade" id="hapusGuruModal" tabindex="-1" role="dialog" aria-labelledby="hapusGuruModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusGuruModalLabel">Hapus Data Guru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="hapusGuruForm">
                                    @csrf
                                    @method('DELETE')
                                    <p>Apakah Anda yakin ingin menghapus data guru ini?</p>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function editGuru(button) {
                        var id = button.getAttribute('data-id');
                        var nip = button.getAttribute('data-nip');
                        var nama = button.getAttribute('data-nama');

                        // Set the form action URL
                        var form = document.getElementById('editGuruForm');
                        form.action = '/admin/guru/data-guru/' + id;

                        // Set the input values
                        document.getElementById('editNip').value = nip;
                        document.getElementById('editNama').value = nama;
                    }
                    function hapusGuru(button) {
                        var id = button.getAttribute('data-id');
                        var nama = button.getAttribute('data-nama');

                        // Set the form action URL
                        var form = document.getElementById('hapusGuruForm');
                        form.action = '/admin/guru/data-guru/' + id;

                        // Set the confirmation message
                        var confirmationMessage = 'Apakah Anda yakin ingin menghapus data guru "' + nama + '"?';
                        document.querySelector('#hapusGuruModal p').textContent = confirmationMessage;
                    }
                </script>
@endsection
