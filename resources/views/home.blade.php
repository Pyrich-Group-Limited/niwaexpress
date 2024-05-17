@extends('layouts.app')

@section('title', 'Dashboard')


@push('styles')
@endpush


@section('content')

    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title text-center">Welcome <span
                        class=" text-primary">{{ auth()->user()->contact_surname . ',' . auth()->user()->contact_firstname }}
                    </span></h3>
                <div class="nk-block-des text-soft">
                    {{-- <p>Welcome to the NIWA Dashboard.</p> --}}
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->












    @if (auth()->user()->user_type == 'e-promota')

        @if (auth()->user()->status > 1)
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1"><i class="fa fa-cube" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ number_format($total, 2) }}</h3>
                            <span class="widget-title1">My Clients <i class="fa fa-cube" aria-hidden="true"></i></span>
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
                            <span class="widget-title3">Inspection Fee <i class="fa fa-check-square-o"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4"><i class="fa fa-flag-o" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>{{ number_format($metrics['demand'], 2) }}</h3>
                            <span class="widget-title4">Demand Notice Fee <i class="fa fa-flag-o"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block">
                {{-- @dd(auth()->user()); --}}
                <div class="row g-gs">
                    <a class="btn  btn-primary " href="{{route('the.create')}}"> Register New Applicant</a>
                    {{-- <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Register New Applicant
                    </button> --}}
                    {{-- <form action="{{ route('login') }}" method="get">
                        @csrf
                        <button type="submit" >Go</button>
                    </form> --}}
                    {{-- <a href="{{route('promotercreate')}}">R</a> --}}
                    <table id="myTable" class="table data-table">
                        <thead>
                            <tr>
                                <th>Applicant Code</th>
                                <th>Applicant Type</th>
                                <th>Date Applied</th>
                                <th>Applicant Name</th>

                                <th>Applicant Email</th>
                                <th>Applicant Address</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($applicants as $item)
                                <tr>
                                    {{-- @dd($item); --}}
                                    <td>{{ $item->applicant_code }}</td>
                                    <td>{{ $item->user_type }}</td>
                                    <td>{{ date('l, d, Y', strtotime($item->created_at)) }}</td>

                                    <td>{{ $item->company_name }}</td>
                                    <td>{{ $item->company_email }}</td>
                                    <td>{{ $item->company_address }}</td>
                                    <td><a href="#" class="btn btn-secondary">View</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!-- Modal -->

                    {{-- <div class="col-xxl-6">
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
                </div><!-- .col --> --}}
                    {{-- <div class="col-xxl-3 col-md-6">
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
                </div><!-- .col --> --}}
                    {{-- <div class="col-xxl-3 col-md-6">
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
                </div><!-- .col --> --}}
                </div><!-- .row -->
            </div><!-- .nk-block -->
        @else
            <h4>Hello {{ auth()->user()->contact_surname }}</h4>
            {{-- @dd(auth()->user()->contact_surname); --}}
            <span>You Account is not Yet Activated,</span>
        @endif
    @else
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
                        <span class="widget-title3">Inspection Fee <i class="fa fa-check-square-o"
                                aria-hidden="true"></i></span>
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

                {{-- <div class="col-xxl-6">
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
                </div> --}}<!-- .col -->
                <div class="col-xxl-3 col-md-6">
                    @foreach ($service_applications as $application)
                    <table id="myTable" class="table data-table">
                        <thead>
                            <tr>
                                <th>Applicant Code</th>
                                <th>Applicant Type</th>
                                <th>Date Applied</th>
                                <th>Applicant Name</th>

                                <th>Applicant Email</th>
                                <th>Applicant Address</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    @endforeach
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
    @endif


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
