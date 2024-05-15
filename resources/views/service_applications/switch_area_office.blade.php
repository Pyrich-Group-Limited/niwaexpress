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
                           
                            {{-- @endif
                            @if(!empty($service_app) && $service_app->current_step == 15) --}}
                            <div class="card-title-group ">
                                <div class="card-title">
                                    <h3 class="title">Switch Area Office</h3>
                                </div>
                            </div>
                            <div class="data" style="margin-top: 20px;">
                                <div class="data-group">
                                    <div class="form-group w-100">
                                        <form method="POST" action="{{ route('switch.area.office.save') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="row col-12">
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                        <label class="form-label" for="cp1-team-size">Select Area
                                                            Office <span class="text-danger">*</span></label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" id="branch_id"
                                                                name="branch_id" data-placeholder="Select Area Office"
                                                                data-search="on" required>
                                                                <option value="">Select Area Office</option>
                                                                @foreach ($branches as $branch)
                                                                    <option
                                                                        value="{{ $branch->id ?? $branch->branch_id }}">
                                                                        {{ $branch->branch_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div></div>
                                                    </div>
                                                   
                                                    <div class="col-sm-3">
                                                        <button type="submit"
                                                            class="mt-5 btn btn-secondary btn-lg mt-2"><em
                                                                class="icon ni ni-save me-2"></em>SUBMIT</button>
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
   @endsection
