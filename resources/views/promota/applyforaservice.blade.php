@extends('layouts.app')

@section('title', 'Service Applications')


@push('styles')
@endpush


@section('content')
    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                            class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            {{-- <li class="nk-block-tools-opt">
                                <a href="#" class="btn btn-primary">
                                    <em class="icon ni ni-money"></em>
                                    <span>Make ECS Payment</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->

    <div class="nk-block nk-block-lg">
        <div class="row g-gs">
            <div class="col-xxl-6 col-sm-12">
                <div class="card h-100">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            @if ($errors->any())
                                @foreach ($errors as $error)
                                    <small class="text-danger">{{ $error }}</small>
                                @endforeach
                            @endif
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
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h3 class="title">New Application</h3>
                                </div>
                            </div>
                            <div class="data">
                                <div class="data-group">
                                    <div class="form-group w-100">
                                        <form method="POST" action="{{ route('epro_service_app_store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="row col-12">
                                                    <input type="hidden" name="promotacode"
                                                        value="{{ auth()->user()->applicant_code }}">
                                                        <input type="hidden" value="{{$user}}" name="applicant_id">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="cp1-team-size">Select
                                                                Location <span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select js-select2" id="branch_id"
                                                                    name="branch_id" data-placeholder="Select Area Office"
                                                                    data-search="on" required>
                                                                    <option value=""></option>
                                                                    @foreach ($branches as $branch)
                                                                        <option
                                                                            value="{{ $branch->id ?? $branch->branch_id }}">
                                                                            {{ $branch->branch_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6" style="display: none" id="my_axis_id">
                                                        <div class="form-group">
                                                            <label class="form-label" for="axis_id">Select
                                                                Zone/Units/Axis</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control" id="axis_id" name="axis_id">
                                                                    @foreach ($axis as $axis)
                                                                        <option value="{{ $axis->id }}">
                                                                            {{ $axis->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 mb-3">
                                                        <label for="service_id">Select Service Type:</label>
                                                        <select
                                                            class="form-select js-select2"data-placeholder="Select A Service"
                                                            data-ui="xl" id="service_id2" name="service_id"
                                                            data-search="on" required>
                                                            <option value="">Select A Service</option>
                                                            @foreach ($services as $service)
                                                                <option value="{{ $service->id }}">
                                                                    {{ $service->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6 mb-3">
                                                        <label for="service_type_id">Sub-Service Type:</label>
                                                        <select class="form-select js-select2" data-ui="xl"
                                                            id="service_type_id2" name="service_type_id" required>
                                                            <option>Select Sub-Service Type</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="service_type_id">Do you know the coordinates:</label>
                                                        <div class="form-control-wrap form-check">
                                                            <input name="show-coordinates" class="form-check-input"
                                                                type="radio" name="toggle" value="show"
                                                                id="showCoordinates">
                                                            <p>Yes</p>
                                                        </div>
                                                        <div class="form-control-wrap form-check">
                                                            <input name="show-coordinates" class="form-check-input"
                                                                type="radio" name="toggle" value="hide"
                                                                id="hideCoordinates">
                                                            <p>No</p>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 row" id="targetDiv">
                                                        <div class="col-sm-12 mb-1">Coordinate 1:</div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="latitude">Latitude (Optional):</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        name="latitude1" id="latitude1" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="longitude">Longitude (Optional):</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        name="longitude1" id="longitude1" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mb-1">Coordinate 2:</div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="latitude">Latitude (Optional):</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        name="latitude2" id="latitude2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="longitude">Longitude (Optional):</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        name="longitude2" id="longitude2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-sm-3">
                                                        <button type="submit"
                                                            class="mt-5 btn btn-secondary btn-lg mt-2"><em
                                                                class="icon ni ni-save me-2"></em>NEXT</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{--  @endif --}}



                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->

        </div><!-- .row -->

    </div> <!-- nk-block -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    @push('scripts')
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

        <script>
            $(document).ready(function() {
                const formRadios = document.querySelectorAll(`input[type='radio'][name='show-coordinates']`);
                const targetDiv = document.getElementById('targetDiv');

                targetDiv.style.display = 'none';
                formRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'show') {
                            targetDiv.style.display = 'block';
                        } else {
                            targetDiv.style.display = 'none';
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#branch_id').change(function() {
                    var branchId = $(this).val();
                    if (branchId == 1) {
                        $('#my_axis_id').show();
                    } else {
                        $('#my_axis_id').hide();
                    }
                });
            });
        </script>
    @endpush
@endsection
