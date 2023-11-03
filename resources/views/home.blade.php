@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50">Tableau de bord</h1>
        <!-- Default box statut de activite-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">RESSOURCES</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">MEMBRE</span>
                                <span class="info-box-number">{{ $data['member'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">COTISATION</span>
                                <span class="info-box-number">{{ $data['contribution'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">SANCTION</span>
                                <span class="info-box-number">{{ $data['sanction'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-user-injured"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">PRET</span>
                                <span class="info-box-number">{{ $data['loan'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['fund'] }}</h3>

                                <p>FONT</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list">{{ $data['fund']  }}</i>
                            </div>
                            <a href="{{ route('fund.index') }}" class="small-box-footer">Voir plus <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @if (Auth::user()->is_admin)
                        <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $data['association'] }}<sup style="font-size: 20px"></sup></h3>

                                        <p>Associations</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-database">{{ $data['association'] }}</i>
                                    </div>
                                    <a href="{{ route('admin.associations.index') }}" class="small-box-footer">Voir plus <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                    @endif

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['meeting'] }}</h3>

                                <p>Reunion</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users-slash">{{ $data['meeting'] }}</i>
                            </div>
                            <a href="{{ route('meeting.index') }}" class="small-box-footer">Voir plus <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $data['session'] }}</h3>

                                <p>Sessions</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-credit-card">{{ $data['session'] }}</i>
                            </div>
                            <a href="{{ route('sessions.index') }}" class="small-box-footer">Voir plus <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>
        </div>
    </div>
@endsection
