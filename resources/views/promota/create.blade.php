@extends('layouts.app')

@section('title', 'Dashboard')


@push('styles')
@endpush


@section('content')

<form class=" form " method="POST" action="{{ route('the.store') }}">
    @csrf

        @csrf
        <div class="form-group">
            <select class=" form-control form-select" name="user_type" id="">
                <option value="private">Private User</option>
                <option value="company">Company</option>
            </select>
        </div>
        <div class="row">

            <div class="form-group col-6">
                <label for="name">Company Name</label>
                <input type="text" class="form-control" id="name"
                    name="company_name" required placeholder="Enter Company Name">
            </div>

            <div class="form-group col-6">
                <label for="address">Company Address</label>
                <input type="text" class="form-control" id="address"
                    name="company_address" required placeholder="Enter address">
            </div>

        </div>
        <div class="row">

            <div class="form-group col-6">
                <label for="company_phone">Company Phone Number</label>
                <input type="tel" class="form-control" id="phone_number"
                    name="company_phone" placeholder="Enter phone number">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Company Email</label>
                <input type="email" class="form-control" id="phone_number"
                    name="company_email" placeholder="Enter phone number">
            </div>
            <input type="hidden" value="{{ auth()->user()->applicant_code }}"
                name="promotercode">

        </div>

        <div class="row">
            <div class="form-group col-6">
                <label for="phone_number">Contact Surname</label>
                <input type="text" name="contact_surname" required
                    class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Contact First Name</label>
                <input type="text" name="contact_firstname" required
                    class=" form-control">
            </div>
        </div>


        <div class="row">
            <div class="form-group col-6">
                <label for="phone_number">Contact Phone Number</label>
                <input type="tel" name="contact_number" required
                    class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Company Stae</label>
                {{-- <input type="password" name="company_state" required
            class=" form-control"> --}}
                <select class=" form-control form-select" name="company_state"
                    id="">
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
                <input type="password" name="password" required class=" form-control">
            </div>
            <div class="form-group col-6">
                <label for="phone_number">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class=" form-control">
            </div>
        </div>
        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">Close</button>
        <button type="submit" value="1" name="status"
            class="btn btn-primary">Submit</button>
    </div>


</form>
@endsection

