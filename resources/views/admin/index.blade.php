@extends('layout.app')
@section('content')
<!-- main Content "Template" -->
<!-- card total siswa -->
 <div class='card shadow mb-4'>
    <div class='card-header py-3'>
        <h6 class='m-0 font-weight-bold text-primary'>Total Data</h6>
    </div>
    <div class='card-body'>
        <div class='row'>
            <div class='col-md-3 mb-4'>
                <div class='card border-left-primary shadow h-100 py-2'>
                    <div class='card-body'>
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Total Siswa</div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>{{ $siswaCount }}</div>
                            </div>
                            <div class='col-auto'>
                                <i class='fas fa-user-graduate fa-2x text-gray-300'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card total guru -->
            <div class='col-md-3 mb-4'>
                <div class='card border-left-success shadow h-100 py-2'>
                    <div class='card-body'>
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-success text-uppercase mb-1'>Total Guru</div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>{{ $guruCount }}</div>
                            </div>
                            <div class='col-auto'>
                                <i class='fas fa-chalkboard-teacher fa-2x text-gray-300'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card total kelas -->
            <div class='col-md-3 mb-4'>
                <div class='card border-left-info shadow h-100 py-2'>
                    <div class='card-body'>
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-info text-uppercase mb-1'>Total Kelas</div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>{{ $kelasCount }}</div>
                            </div>
                            <div class='col-auto'>
                                <i class='fas fa-school fa-2x text-gray-300'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card total pelajaran -->
            <div class='col-md-3 mb-4'>
                <div class='card border-left-warning shadow h-100 py-2'>
                    <div class='card-body'>
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-warning text-uppercase mb-1'>Total</div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>0</div>
                            </div>
                            <div class='col-auto'>
                                <i class='fas fa-book fa-2x text-gray-300'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- card total data lain -->
@endsection
