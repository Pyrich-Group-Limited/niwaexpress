@extends('layouts.app')

@section('title', 'Dashboard')


@push('styles')
@endpush


@section('content')


    <form class="form" method="POST" action="{{ route('the.store') }}">
        @csrf


        <div class="form-group">
            <select class=" form-control form-select" name="user_type" id="usertype">
                <option value="private">Private User</option>
                <option value="company">Company</option>
            </select>
        </div>

        <div class="row" id="company_name_address_row">

            <div class="form-group col-6">
                <label for="name">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name"
                    placeholder="Enter Company Name">
            </div>

            <div class="form-group col-6">
                <label for="address">Company Address</label>
                <input type="text" class="form-control" id="comapny_address" name="company_address"
                    placeholder="Enter address">
            </div>

        </div>
        <div class="row" id="company_phone_email">

            <div class="form-group col-6">
                <label for="company_phone">Company Phone Number</label>
                <input type="tel" class="form-control" id="company_number" name="company_phone"
                    placeholder="Enter phone number">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Company Email</label>
                <input type="email" class="form-control" id="company_email" name="company_email"
                    placeholder="Enter Email">
            </div>
            <input type="hidden" value="{{ auth()->user()->applicant_code }}" name="promotercode">

        </div>

        <div class="row">
            <div class="form-group col-6">
                <label for="phone_number">Contact Surname</label>
                <input type="text" name="contact_surname"  class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Contact First Name</label>
                <input type="text" name="contact_firstname" class=" form-control">
            </div>
        </div>


        <div class="row">
            <div class="form-group col-6">
                <label for="phone_number">Contact Phone Number</label>
                <input type="tel" name="contact_number" class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Company State</label>
                {{-- <input type="password" name="company_state" required
            class=" form-control"> --}}
                <select class=" form-control form-select" name="company_state" id="">
                    @foreach ($branches as $item)
                        <option value="{{ $item->id }}">{{ $item->branch_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label for="phone_number">Password</label>
                <input type="password" name="password" class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Confirm Password</label>
                <input type="password" name="password_confirmation"  class=" form-control">
            </div>
        </div>
        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" value="1" name="status" class="btn btn-primary">Submit</button>
        </div>


    </form>
    <script src="{{ asset('dev/js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var usertype = $('#usertype')
        var firstrow = $('#company_name_address_row')
        var secondrow = $('#company_phone_email')
        var companyname = $('#company_name')
        var companyaddress = $('#comapny_address')
        var company_number = $('#company_number')
        var company_email = $('#company_email')

        firstrow.hide()
        secondrow.hide()


        $(document).ready(function() {

            usertype.change(function(e) {
                e.preventDefault();

                if (this.value != 'private') {
                    firstrow.show(1000)
                    secondrow.show(1000)
                } else {
                    firstrow.hide(1000)
                    secondrow.hide(1000)
                    company_email.value = '';
                    company_number = '';
                    companyaddress = '';
                    companyname = '';

                }

            });
        });
    </script>
@endsection
