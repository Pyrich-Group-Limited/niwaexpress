@extends('layouts.app')
@section('title', 'CONFIRMATION PAGE')

@section('content')
    <div class="card">

        <div class="card-header">

            <div class=" card-title-group">

                <div class=" card-title">
                    <span>COMPLETE BOOKING</span>
                    <span> BOOKING ID</span>
                    <span>{{ 'NIWA 00' . $booking->id }}</span>
                </div>
                {{-- <div class=" card-title">
                    <span></span>
                    <span>FULLNAME</span>
                    <span>{{ Auth::user()->first_name }}</span>
                </div> --}}
            </div>
        </div>

        <div class="card-body ">
            <form action="{{route('paybook')}}" class=" form my-4" method="post">
                @csrf
                {{-- <div class="form">
                    <div class="form-group">
                        <label for="">NAME:</label>
                        <input type="text" placeholder="Full Name" class=" form-control" name="name" id="">

                    </div>
                    <div class="form-group">
                        <label for="">EMAIL:</label>
                        <input type="email" class=" form-control" placeholder="Email Address" name="email"
                            id="">
                    </div>
                    <div class="form-group">
                        <label for="">PHONE NUMBER:</label>
                        <input type="tel" class=" form-control" placeholder="Phone Number" name="phone"
                            id="">
                    </div>
                </div> --}}
                <div class="row  12">

                    <div class="col-6">No Of Passenger</div>
                    <div class="col-6">{{ $persons }}</div>
                </div>
                <div class="row 12">

                    <div class="col-6">Subtotal</div>
                    <div class="col-6">{{ intval($persons) * intval($booking->price) }}</div>
                </div>
                <div class="row 12">

                    <div class="col-6">Discount</div>
                    <div class="col-6">{{ $booking->discount }}</div>
                </div>
                <div class="row 12">

                    <div class="col-6">State Tax</div>
                    <div class="col-6">{{ $booking->tax }}</div>
                </div>
                <div class="row 12">

                    <div class="col-6"> Levy</div>
                    <div class="col-6">{{ $booking->levy }}</div>
                </div>

                <div class="row 12">

                    <div class="col-6">VAT </div>
                    <div class="col-6">{{ $booking->vat }}</div>
                </div>
                <div class="row 12">

                    <div class="col-6">Total</div>
                    <div class="col-6">{{ $total }}</div>
                </div>

                <input type="hidden" value="{{$booking->id}}" name="booking_id">
                <input type="hidden" value="{{$total}}" name="thetotalprice">
                <button class=" btn float-end btn-success" type="submit">PROCEED TO PAYMENT</button>
            </form>
        </div>
    </div>
@endsection
