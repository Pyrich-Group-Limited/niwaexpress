@extends('layouts.app')

@section('title', 'Service Applications')


@push('styles')
@endpush


@section('content')


    <div class="nk-block nk-block-lg">
        <div class="row g-gs">
            <div class="col-xxl-6 col-sm-12" style="display: none">
                <div class="card h-100">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">

                            {{--  @if (empty($service_app))
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">New Application</h6>
                                </div>
                            </div>
                            <div class="data">
                                <div class="data-group">
                                    <div class="form-group w-100">
                                        <form method="POST" action="{{ route('service-applications.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="row col-12">

                                                    <div class="col-sm-6 mb-3">
                                                        <label for="service_id">Select Service:</label>
                                                        <select class="form-select js-select2" data-ui="xl" id="service_id1" name="service_id" data-search="on" required>
                                                            <option>Select A Service</option>
                                                            @foreach ($services as $service)
                                                            <option value="{{ $service->id }}">{{ ucfirst($service->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6 mb-3">
                                                        <label for="service_type_id">Service Type:</label>
                                                        <select class="form-select js-select2" data-ui="xl" id="service_type_id1" name="service_type_id" required>
                                                            <option>Select Service Type</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 mb-1">Coordinate 1:</div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group mb-3">
                                                            <label for="latitude">Latitude:</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="latitude1" id="latitude1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="longitude">Longitude:</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="longitude1" id="longitude1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-1">Coordinate 2:</div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="latitude">Latitude:</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="latitude2" id="latitude2" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="longitude">Longitude:</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="longitude2" id="longitude2" />
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-3">
                                                        <button type="submit"
                                                            class="mt-5 btn btn-secondary btn-lg mt-2"><em
                                                                class="icon ni ni-save me-2"></em>Submit</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- @endif
                            @if (!empty($service_app) && $service_app->current_step == 15) --}}


                            {{--  @endif --}}



                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Transactions</h3>
                <div class="nk-block-des text-soft">
                    <p>List of Transactions.</p>
                    @if ($errors->any())
                        @foreach ($errors as $error)
                            <small class="text-danger">{{ $error }}</small>
                        @endforeach
                    @endif
                </div>
            </div>
        </div><!-- .row -->
        @foreach ($service_applications as $application)

            @php
                // $user = Auth::user();
                $app_form_fee = \App\Models\ApplicationFormFee::where('service_id', $application->service_id)
                    ->where('processing_type_id', $application->service_type_id)
                    ->first();
                $doc_upload = \App\Models\DocumentUpload::where('service_id', $application->service_id)->first();
                $pro_fee = \App\Models\ProcessingFee::where('service_id', $application->service_id)
                    ->where('processing_type_id', $application->service_type_id)
                    ->first();
                $ins_fee = \App\Models\InspectionFee::where('service_id', $application->service_id)
                    ->where('processing_type_id', $application->service_type_id)
                    ->first();
                $app_fee = \App\Models\Payment::where('payment_status', 1)
                    ->where('approval_status', 1)
                    ->where('payment_type', 1)
                    ->where('employer_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
            @endphp
 {{-- @dd($application->service_id); --}}
            <div class="card card-bordered card-preview mt-4 mb-3">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Service: {{ $application->service ? $application->service->name : '' }}</h4>
                    </div>
                    <div class="row">
                        <div class="row col-6">
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Location:</span>
                                <span>{{ $application->branch ? $application->branch->branch_name : '' }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Application Form Payment Status:</span>
                                <span>{{ $application->application_form_payment_status ? 'Paid' : 'Not Paid' }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Date of Inspection:</span>
                                <span>{{ $application->date_of_inspection }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Inspection Message:</span>
                                <span>{{ $application->comments_on_inspection }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Service Type:</span>
                                <span>{{ $application->processingType ? ucwords($application->processingType->name) : '' }}</span>
                            </div>
                        </div>
                        <div class="row col-6">
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Status Summary:</span>
                                <span>{{ $application->status_summary }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">My Documents:</span>
                                <span>
                                    @if ($application->current_step > 5)
                                        <a href="{{ route('service-applications.documents.index', $application->id) }}"
                                            title="Documents"><span class="nk-menu-icon text-secondary">View
                                                Documents</span></a>
                                    @endif
                                </span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Created:</span>
                                <span>{{ $application->created_at }}</span>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                                <span class="sub-text">Action:</span>
                                <span>
                                    @if ($app_form_fee)
                                        @if ($application->current_step == 2)
                                            <a href="{{ route('epromota_application_form_payment', [$application->id, $user->id]) }}"
                                                title="Application form payment"><span class="nk-menu-icon text-danger">Pay
                                                    for
                                                    Application form</span>
                                            </a>
                                        @endif
                                    @endif
                                    {{-- @dd($application->id); --}}
                                    @if ($doc_upload)
                                    {{--  @if ($app_fee) --}}

                                    @if ($application->current_step == 41)
                                        <a href="{{ route('epromota.documents.index', [$application->id,$user->id]) }}"
                                            title="Documents"><span class="nk-menu-icon text-danger">Add
                                                Documents</span></a>
                                    @endif
                                    {{--  @endif --}}
        @endif
        @php
            $processing_fee_payment = $application->payments()->where('payment_type', '=', 2)->first();

            if ($processing_fee_payment) {
                $is_processing_fee_paid = $processing_fee_payment->payment_status;
            } else {
                $is_processing_fee_paid = 0;
            }

        @endphp
        {{--  @if ($application->current_step == 4 && !$is_processing_fee_paid) --}}
        @if ($pro_fee)
            @if ($application->current_step == 6)
                <a href="{{ route('epromota_processing_fee_payment', [$application->id,$user->id]) }}" title="Processing fee payment"><span
                        class="nk-menu-icon text-danger">Pay
                        for
                        Processing Fee</span>
                </a>
            @endif
        @endif

        @if ($ins_fee)
            @if ($application->current_step == 7)
                <a href="{{ route('epromota.inspection_fee_payment', [$application->id,$user->id]) }}" title="Inspection fee payment"><span
                        class="nk-menu-icon text-danger">Pay
                        for
                        Inspection Fee</span>
                </a>
            @endif
        @endif

        @if ($application->current_step == 13)
            <a href="{{ route('epromota.equipment_fee_payment', [$application->id,$user->id]) }}" title="Equipment fee payment"><span
                    class="nk-menu-icon text-danger">Pay for
                    Equipment and Monitoring Fees</span>
            </a>
        @endif

        @if ($application->current_step == 15)
            <a href="{{ route('download_permit', $application->id) }}" title="Download Permit" target="_blank"><span
                    class="nk-menu-icon text-secondary">Download Permit</span>
            </a>
        @endif
        </span>
    </div>
    </div>


    </div>

    </div>
    </div>
    @endforeach

    <div class="card">
        {{ $service_applications->links() }}
    </div>

    {{-- @include('service_applications.table') --}}

    </div> <!-- nk-block -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#service_id1').change(function() {
                var serviceId = $(this).val();
                if (serviceId) {
                    $.ajax({
                        type: "GET",
                        url: "/services/" + serviceId + "/processing-types",
                        success: function(data) {
                            $('#service_type_id1').empty();
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#service_type_id1').append('<option value="' +
                                        value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                $('#service_type_id1').append(
                                    '<option value="none">No result</option>');
                            }
                        }
                    });
                } else {
                    $('#service_type_id1').empty();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#service_id2').change(function() {
                var serviceId = $(this).val();
                if (serviceId) {
                    $.ajax({
                        type: "GET",
                        url: "/services/" + serviceId + "/processing-types",
                        success: function(data) {
                            $('#service_type_id2').empty();
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#service_type_id2').append('<option value="' +
                                        value.id + '">' + value.name + '</option>');
                                });
                            } else {
                                $('#service_type_id2').append(
                                    '<option value="0">No result</option>');
                            }
                        }
                    });
                } else {
                    $('#service_type_id2').empty();
                }
            });
        });
    </script>
    {{-- </div><!-- .components-preview --> --}}
@endsection
