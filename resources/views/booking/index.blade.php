@extends('layouts.app')

@section('title', 'Bookings')


@push('styles')
@endpush


@section('content')


    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">NIWA BOOKING FURRY</h3>
                <div class="nk-block-des text-soft">
                    <p>List of all Bookings</p>
                </div>
            </div><!-- .nk-block-head-content -->


            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                            class="icon ni ni-more-v"></em></a>

                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt"><a href="{{ route('booking.index') }}"
                                    class="btn btn-primary"><em class="icon ni  ni-search"></em><span>Search Again
                                    </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init-export nowrap table" data-export-title="Export">
                    <thead>
                        <tr>
                            <th>Departure Time</th>
                            <th>Departure Day</th>
                            <th>Departure Location</th>
                            <th>Arrival Time</th>
                            <th>Arrival Day</th>
                            <th>Arrival Location</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>

                                {{-- @php
                                    dd( );
                                @endphp --}}

                                <td>{{ $item->departure_time }}</td>
                                <td>{{ $item->departure_day }}</td>
                                <td>{{ $item->departurebranch->branch_name }}</td>
                                <td>{{ $item->arrival_time }}</td>
                                <td>{{ $item->arrival_day }}</td>
                                <td>{{ $item->arrivalbranch->branch_name }}</td>
                                <td id="theamount">{{ (intval($item->price) * intval($amount) )}}</td>


                                <td>
                                    <a class="btn btn-success BookTicket" id="BookTicket" href="{{route('bookingpage',[$item->id, $amount])}}">Book Ticket</a>
                               {{-- <button type="button" class="btn btn-success BookTicket ">Book Ticket</button> --}}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        var sumbitbtn= $('.BookTicket');
        var amount= $('#theamount');
        $(document).ready(function () {
            alert(sumbitbtn)

            sumbitbtn.submit(function(){
                alert('hello Atp');
            })
        });

    </script> --}}

@endsection

@push('scripts')
    <script src="./assets/js/libs/datatable-btns.js?ver=3.1.3"></script>
@endpush
