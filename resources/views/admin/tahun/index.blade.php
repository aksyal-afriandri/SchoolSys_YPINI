@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Data Tahun Ajaran</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahTahunModal">Tambah Tahun Ajaran</button>  
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahunAjaran as $t)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->tahun_ajaran }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editTahunModal"
                                                    data-id="{{ $t->id }}" data-tahun-ajaran="{{ $t->tahun_ajaran }}"
                                                    onclick="editTahun(this)">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal" data-target="#hapusTahunModal"
                                                    data-id="{{ $t->id }}" data-tahun-ajaran="{{ $t->tahun_ajaran }}"
                                                    onclick="hapusTahun(this)">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="tambahTahunModal" tabindex="-1" role="dialog" aria-labelledby="tambahTahunModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahTahunModalLabel">Tambah Data Tahun Ajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.data-tahun.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="tambahTahunAjaran">Tahun Ajaran</label>
                                        <input type="text" name="tahun_ajaran" class="form-control" id="tambahTahunAjaran" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     

                <div class="modal fade" id="editTahunModal" tabindex="-1" role="dialog" aria-labelledby="editTahunModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTahunModalLabel">Edit Data Tahun Ajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="#" data-update-url="{{ route('admin.data-tahun.update', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editTahunAjaran">Tahun Ajaran</label>
                                        <input type="text" name="tahun_ajaran" class="form-control" id="editTahunAjaran" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="hapusTahunModal" tabindex="-1" role="dialog" aria-labelledby="hapusTahunModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusTahunModalLabel">Hapus Data Tahun Ajaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" id="hapusTahunForm">
                                    @csrf
                                    @method('DELETE')
                                    <p>Apakah Anda yakin ingin menghapus data tahun ajaran ini?</p>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <script>
                    function editTahun(button) {
                        const modal = document.getElementById('editTahunModal');
                        const form = modal.querySelector('form');

                        form.action = form.dataset.updateUrl.replace('__ID__', encodeURIComponent(button.dataset.id));
                        form.querySelector('[name="tahun_ajaran"]').value = button.dataset.tahunAjaran;
                    }

                    function hapusTahun(button) {
                        const modal = document.getElementById('hapusTahunModal');
                        const form = modal.querySelector('form');

                        form.action = '/admin/tahun/data-tahun/' + encodeURIComponent(button.dataset.id);
                        modal.querySelector('p').textContent = 'Apakah Anda yakin ingin menghapus data tahun ajaran "' + button.dataset.tahunAjaran + '"?';
                    }
                </script>
@endsection
