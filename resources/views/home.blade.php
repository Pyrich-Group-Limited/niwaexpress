@extends('layouts.app')

@section('title', 'Dashboard')


@push('styles')
@endpush


@section('content')

    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Dashboard</h3>
                <div class="nk-block-des text-soft">
                    {{-- <p>Welcome to the NIWA Dashboard.</p> --}}
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg1"><i class="fa fa-cube" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{ number_format($metrics['app_fee'], 2) }}</h3>
                    <span class="widget-title1">Application Fee <i class="fa fa-cube" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg2"><i class="fa fa-check"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{ number_format($metrics['pro_fee'], 2) }}</h3>
                    <span class="widget-title2">Processing Fee <i class="fa fa-check" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg3"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{ number_format($metrics['inspect'], 2) }}</h3>
                    <span class="widget-title3">Inspection Fee <i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="dash-widget">
                <span class="dash-widget-bg4"><i class="fa fa-flag-o" aria-hidden="true"></i></span>
                <div class="dash-widget-info text-right">
                    <h3>{{ number_format($metrics['demand'], 2) }}</h3>
                    <span class="widget-title4">Demand Notice Fee <i class="fa fa-flag-o" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-gs">
          
            <div class="col-xxl-6">
                <div class="card card-full">
                    <div class="nk-ecwg nk-ecwg8 h-100">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Payments Statistics</h6>
                                </div>
                            </div>
                            <ul class="nk-ecwg8-legends">
                                <li>
                                    <div class="title">
                                        <span class="dot dot-lg sq" data-bg="#0fac81"></span>
                                        <span>Yearly Contribution</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="nk-ecwg8-ck">
                                <canvas class="ecommerce-line-chart-s4" id="salesStatistics"></canvas>
                            </div>
                            <div class="chart-label-group ps-5">
                                <div class="chart-label">01 Jul, 2020</div>
                                <div class="chart-label">30 Jul, 2023</div>
                            </div>
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-md-6">
                <div class="card card-full overflow-hidden">
                    <div class="nk-ecwg nk-ecwg7 h-100">
                        <div class="card-inner flex-grow-1">
                            <div class="card-title-group mb-4">
                                <div class="card-title">
                                    <h6 class="title">Compensation Distribution</h6>
                                </div>
                            </div>
                            <div class="nk-ecwg7-ck">
                                <canvas class="ecommerce-doughnut-s1" id="orderStatistics"></canvas>
                            </div>
                            <ul class="nk-ecwg7-legends">
                                <li>
                                    <div class="title">
                                        <span class="dot dot-lg sq" data-bg="#0fac81"></span>
                                        <span>Inspection</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <span class="dot dot-lg sq" data-bg="#816bff"></span>
                                        <span>License</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="title">
                                        <span class="dot dot-lg sq" data-bg="#e85347"></span>
                                        <span>Report</span>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- .card-inner -->
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="col-xxl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-inner">
                        <div class="card-title-group mb-2">
                            <div class="card-title">
                                <h6 class="title"> Statistics</h6>
                            </div>
                        </div>
                        <ul class="nk-store-statistics">
                            <li class="item">
                                <div class="info">
                                    <div class="title">Inspection</div>
                                    <div class="count">{{ $metrics['accident_claims']['number'] }}</div>
                                </div>
                                <em class="icon bg-primary-dim ni ni-user-add"></em>
                            </li>
                            <li class="item">
                                <div class="info">
                                    <div class="title">License</div>
                                    <div class="count">{{ $metrics['disease_claims']['number'] }}</div>
                                </div>
                                <em class="icon bg-purple-dim ni ni-user-list"></em>
                            </li>
                            <li class="item">
                                <div class="info">
                                    <div class="title">Report</div>
                                    <div class="count">{{ $metrics['death_claims']['number'] }}</div>
                                </div>
                                <em class="icon bg-danger-dim ni ni-user-cross"></em>
                            </li>
                            <li class="item">
                                <div class="info">
                                    <div class="title">Total</div>
                                    <div class="count">
                                        {{ $metrics['accident_claims']['number'] + $metrics['disease_claims']['number'] + $metrics['death_claims']['number'] }}
                                    </div>
                                </div>
                                <em class="icon bg-info-dim ni ni-users"></em>
                            </li>
                        </ul>
                    </div><!-- .card-inner -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .nk-block -->

@endsection


@push('scripts')
    <!-- JavaScript -->
    <script>
        //for doughnut chart
        var claims = [
            {{ $metrics['accident_claims']['number'] }},
            {{ $metrics['disease_claims']['number'] }},
            {{ $metrics['death_claims']['number'] }}
        ];
    </script>
    <script src="./assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
@endpush
