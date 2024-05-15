@extends('layouts.app')
@section('content')
    <div class="container">
        <div class=" float-left">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class=" form" action="{{route('showbooking')}}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">

                                    <label for=""> From </label>
                                    <select class=" form-select" name="from" id="">
                                        @foreach ($loc as $item)
                                            <option value="{{ $item->id }}">{{ $item->branch_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">To</label>
                                    <select class=" form-select" name="to" id="">
                                        @foreach ($loc as $item)
                                            <option value="{{ $item->id }}">{{ $item->branch_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">

                                    <label for="">Departure Date</label>
                                    <input type="date" name="departure_date" class=" form-control" id="">

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">

                                    <label for="">Passenger(s)</label>
                                    <input type="number" class="form-control" name="no_of_passengers" id="">
                                </div>
                            </div>

                        </div>


                        <div class="row mt-4">
                            <button type="submit" class="btn btn-success" >Search <i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
