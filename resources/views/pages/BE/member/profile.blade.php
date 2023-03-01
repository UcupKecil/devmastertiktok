@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dataTables')
    @include('components.styles.CDN.font-awesome')
    @include('components.styles.CDN.lightbox2')
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <br>
                               
                                <div class="row">
                                    <div class="col-lg-6">
                                        <strong>Nama</strong><br>
                                        <span id="labelName">{{ $currentUser->name }}</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <strong>Rekenening</strong><br>
                                        <span>{{ $detailUser->account_number }}</span>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <strong>Email</strong><br>
                                        <span>{{ $currentUser->email }}</span>
                                    </div>
                                    <div class="col-lg-6">
                                    <strong>No Telepon</strong><br>
                                        <span>{{ $detailUser->phone }}</span>
                                    </div>
                                </div>

                               

                                @include('components.buttons.BE.manage.profile')
                            
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @include('components.modals.profile.selfData.edit')
    @include('components.modals.profile.selfPassword.edit')
@endsection
@push('script')
    @include('components.scripts.CDN.dataTables')
    @include('components.scripts.CDN.font-awesome')
    @include('components.scripts.CDN.lightbox2')
    @include('components.scripts.CDN.sweetalert2')
  
    @include($js)
@endpush
