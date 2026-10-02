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
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <!-- <th><input type="checkbox"></th> -->
                                            <th>No</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $s)
                                        <tr>
                                            <!-- <td><input type="checkbox"></td>  -->
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $s->nisn }}</td>
                                            <td>{{ $s->nama }}</td>
                                            <td>
                                                @if ($s->photo)
                                                    <button type="button" class="btn p-0 border-0 bg-transparent" data-toggle="modal" data-target="#previewFotoSiswaModal" data-photo="{{ asset('storage/' . $s->photo) }}" data-name="{{ $s->nama }}" onclick="previewFotoSiswa(this)" aria-label="Lihat foto {{ $s->nama }}">
                                                        <img src="{{ asset('storage/' . $s->photo) }}" alt="Foto {{ $s->nama }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                                    </button>
                                                @else
                                                    <span>No Photo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#editSiswaModal"
                                                    data-id="{{ $s->id }}" data-nisn="{{ $s->nisn }}" data-nama="{{ $s->nama }}"
                                                    data-photo="{{ $s->photo ? asset('storage/' . $s->photo) : '' }}"
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

                <div class="modal fade" id="previewFotoSiswaModal" tabindex="-1" role="dialog" aria-labelledby="previewFotoSiswaTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewFotoSiswaTitle">Foto Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="" alt="" id="previewFotoSiswaImage" class="img-fluid" style="max-height: 75vh;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal add -->
                <div class="modal fade" id="tambahSiswaModal" tabindex="-1" role="dialog" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs mb-3" id="tambahSiswaTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="manualSiswaTab" data-toggle="tab" href="#manualSiswaPane" role="tab" aria-controls="manualSiswaPane" aria-selected="true">Tambah Manual</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="importSiswaTab" data-toggle="tab" href="#importSiswaPane" role="tab" aria-controls="importSiswaPane" aria-selected="false">Import Excel</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="manualSiswaPane" role="tabpanel" aria-labelledby="manualSiswaTab">
                                        @if (session('manual_success'))
                                            <div class="alert alert-success">{{ session('manual_success') }}</div>
                                        @endif
                                        <form method="POST" action="{{ route('admin.data-siswa.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="tambahNisn">NISN</label>
                                                <input type="text" name="nisn" class="form-control" id="tambahNisn" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tambahNama">Nama</label>
                                                <input type="text" name="nama" class="form-control" id="tambahNama" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tambahPhoto">Foto (opsional)</label>
                                                <input type="file" name="photo" class="form-control-file" id="tambahPhoto" accept="image/jpeg,image/png,image/gif">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="importSiswaPane" role="tabpanel" aria-labelledby="importSiswaTab">
                                        <form method="POST" action="{{ route('admin.data-siswa.import') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row align-items-end">
                                                <div class="col-md-8 form-group mb-md-0">
                                                    <label for="fileSiswa">Pilih file Excel</label>
                                                    <input type="file" name="file" id="fileSiswa" class="form-control-file" accept=".xlsx,.xls,.csv" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-success btn-block">Import</button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted mt-3">teks jadi export template later</small>
                                        </form>
                                    </div>
                                </div>
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
                                <form method="POST" action="#" enctype="multipart/form-data" data-update-url="{{ route('admin.data-siswa.update', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="student_id" id="editSiswaId">
                                    <div class="form-group">
                                        <label for="editNisn">NISN</label>
                                        <input type="text" name="nisn" class="form-control" id="editNisn" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editNama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="editNama" required>
                                    </div>
                                    <div class="form-group">
                                        <img src="" alt="Foto siswa saat ini" id="editPhotoPreview" class="img-thumbnail mb-2 d-none" style="max-width: 120px;">
                                        <label for="editPhoto">Ganti foto (opsional)</label>
                                        <input type="file" name="photo" class="form-control-file" id="editPhoto" accept="image/jpeg,image/png,image/gif">
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
                    @if (session('manual_success') || session('import_success') || $errors->has('file'))
                        $(function () {
                            $('#tambahSiswaModal').modal('show');
                            @if (session('import_success') || $errors->has('file'))
                                $('#importSiswaTab').tab('show');
                            @endif
                        });
                    @endif

                    function previewFotoSiswa(button) {
                        document.getElementById('previewFotoSiswaImage').src = button.dataset.photo;
                        document.getElementById('previewFotoSiswaImage').alt = 'Foto ' + button.dataset.name;
                        document.getElementById('previewFotoSiswaTitle').textContent = 'Foto ' + button.dataset.name;
                    }

                    function editSiswa(button) {
                        const modal = document.getElementById('editSiswaModal');
                        const form = modal.querySelector('form');

                        form.action = form.dataset.updateUrl.replace('__ID__', encodeURIComponent(button.dataset.id));
                        form.querySelector('[name="nisn"]').value = button.dataset.nisn;
                        form.querySelector('[name="nama"]').value = button.dataset.nama;
                        form.querySelector('[name="student_id"]').value = button.dataset.id;
                        form.querySelector('[name="photo"]').value = '';

                        const preview = document.getElementById('editPhotoPreview');
                        if (button.dataset.photo) {
                            preview.src = button.dataset.photo;
                            preview.classList.remove('d-none');
                        } else {
                            preview.removeAttribute('src');
                            preview.classList.add('d-none');
                        }
                    }

                    function hapusSiswa(button) {
                        const modal = document.getElementById('hapusSiswaModal');
                        const form = modal.querySelector('form');

                        form.action = '/admin/siswa/data-siswa/' + encodeURIComponent(button.dataset.id);
                        modal.querySelector('p').textContent = 'Apakah Anda yakin ingin menghapus data siswa "' + button.dataset.nama + '"?';
                    }

                    // add later checkbox all between entries
                </script>
@endsection
