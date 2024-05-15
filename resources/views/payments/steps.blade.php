@extends('layouts.app')

@section('title', 'Service Registration Steps')

@section('content')

    <style>
        .btn-dim.btn-danger {

            background-color: #392C70;
            border-color: transparent;
        }

        .tab-content {
            border: 0px solid #e0e0ef;
            border-top: 0;
            padding: 2rem 1rem;
            text-align: justify;
        }

        .col-sep-md>*+* {
            border-top: none;
            border-left: 0px solid #e5e9f2;
        }
    </style>
    <style>
        span.text-danger {
            font-size: 1.5rem;
            font-weight: 800;
        }

        body {
            background: #eee;
        }

        b {
            color: green;
        }
    </style>
    <div class="" style="">

        <div class="card card-bordered">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo pb-4 text-center mt-4">
                        <a href="#" class="logo-link">
                            {{-- <img class="logo-light logo-img logo-img-lg"
                                style="width: 125px !important;height: 125px !important;max-height: 125px !important;"
                                src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png') }}"
                                alt="logo"> --}}
                            <img class="logo-dark logo-img logo-img-lg"
                                style="width: auto;height: 125px !important;max-height: 125px !important;"
                                src="{{ asset('assets/images/logo.png') }}" srcset="{{ asset('assets/images/logo.png') }}"
                                alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title text-center">NIWA Service Application Status</h4>
                            {{-- <div class="nk-block-des">
                            <p>Create New Dashlite Account</p>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 col-sep col-sep-md col-sep-xl" style="overflow-x: auto;">

                <div class="col-md-12 col-xl-12">
                    <div class="card-inner">

                        <ul class="nk-stepper-nav nk-stepper-nav-s1 stepper-nav is-vr">

                            <?php
                            $settings = App\Models\Utility::settings();
                            $reg_payment = \App\Models\Payment::where('payment_type',1)->where('employer_id', auth()->user()->id)->where('amount', '5000.00')->latest()->first();
                            $inspection_payment = \App\Models\Payment::where('payment_type',5)->where('employer_id', auth()->user()->id)->latest()->first();
                           $service =  \App\Models\Payment::where('payment_type',4)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->latest()->first();
                           $service1 =  \App\Models\Payment::where('payment_type',4)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->sum('amount');
                           $service_count =  \App\Models\Payment::where('payment_type',4)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->count();
                           $documents = \App\Models\EmployerDocuments::whereYear('created_at', date('Y'))->where('employer_id', auth()->user()->id)->count();
                           $documents1 = \App\Models\EmployerDocuments::whereYear('created_at', date('Y'))->where('employer_id', auth()->user()->id)->latest()->first();
                           $notify = \App\Models\Notification::where('user_id', auth()->user()->id)->latest()->first();

                           if (!empty($reg_payment) && $reg_payment->payment_status == 1 && $reg_payment->approval_status == 1){
                          ?>
                            <li class="current">
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Sign Up</div>
                                        <div class="sub-text">Sign up completed</div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($reg_payment)) class="current"
                            @else
                            class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Registration Fees</div>
                                        <div class="sub-text">
                                            @if (!empty($reg_payment))
                                                <b>
                                                    {{ $settings['site_currency_symbol'] }}{{ number_format($reg_payment->amount, 2) }}</b>
                                                Paid
                                            @else
                                                <a href="{{ route('payment.reg') }}" class="btn btn-danger">Pay Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($service)) class="current"
                            @else
                            class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Apply For A Service</div>
                                        <div class="sub-text">
                                            @if (!empty($service))
                                            <b>{{ $service_count }}</b> applied service and <b>
                                                {{ $settings['site_currency_symbol'] }}{{ number_format($service1,2) }}</b> paid
                            @else
                             <a href="{{ route('payment.index') }}" class="btn btn-danger">Register</a>
                            @endif
                                            </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($service) && $service->approval_status == 1) class="current"
                            @else
                            class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Payment Approval</div>
                                        <div class="sub-text">
                                            @if (!empty($service) && $service->approval_status == 1)
                                                {{ $service_count }} service registered and
                                                <b>{{ $settings['site_currency_symbol'] }}{{ number_format($service1, 2) }}</b>
                                                payment confirmed & approved
                                            @else
                                                Wait for admin to confirm and approve your payments
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($documents)) class="current"
                            @else
                            class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Upload Documents</div>
                                        <div class="sub-text">
                                            @if (!empty($documents))
                                                <b>{{ $documents }}</b> documents uploaded
                                            @else
                                                <a href="{{ route('documents.create') }}" class="btn btn-danger">Upload
                                                    Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($documents1) && $documents1->payment_status == 1) class="current"
                            @else
                            class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Document Approval</div>
                                        <div class="sub-text">
                                            @if (!empty($documents1) && $documents1->payment_status == 1)
                                                All documents have been approved
                                            @else
                                                Wait for admin to confirm and approve your documents
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($inspection_payment)) class="current"
                                @else
                                class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Inspection Payments</div>
                                        <div class="sub-text">
                                            @if (!empty($inspection_payment))
                                                Inspection Fees of
                                                <b>{{ $settings['site_currency_symbol'] }}{{ number_format($inspection_payment->amount, 2) }}</b>
                                                has been paid
                                                @if ($notify)
                                                    <p class="noti-details"><span
                                                            class="noti-title">{{ 'Message: ' . $notify->data }}</span></p>
                                                    <p class="noti-time"><span
                                                            class="noti-title">{{ 'Date: ' . \Carbon\Carbon::parse($notify->type)->format('F j, Y H:i:s') }}
                                                        </span></p>
                                                @endif
                                            @else
                                                <a href="{{ route('payment.inspection') }}" class="btn btn-danger">Pay
                                                    Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                @if (!empty($inspection_payment) && $inspection_payment->approval_status == 1) class="current"
                                @else
                                class="" @endif>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Inspection Payments Approval</div>
                                        <div class="sub-text">
                                            @if (!empty($inspection_payment) && $inspection_payment->approval_status == 1)
                                                Inspection Fees of
                                                <b>{{ $settings['site_currency_symbol'] }}{{ number_format($inspection_payment->amount, 2) }}</b>
                                                has been confirmed and approved
                                            @else
                                                Wait for admin to confirm and approve your payments/notifications
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="step-item">
                                    <div class="step-text">
                                        <div class="lead-text">Completed</div>
                                        <div class="sub-text">Service registration is over</div>
                                    </div>
                                </div>
                            </li>
                            <?php }else{ ?>
                                @php
                                                $reg_setup = App\Models\RegistrationFee::where('branch_id', auth()->user()->branch->id)->first();
                                            @endphp
                            <h3>Kindly pay the &#8358;{{ number_format($reg_setup->amount, 2) }} registration fee by clicking on the button below</h3>
                            <div class="col-md-2">

                                <a href="{{ route('payment.reg') }}" class="btn btn-secondary btn-lg mt-2"><em
                                        class="icon ni ni-save me-2"></em> Pay Now</a>
                            </div>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
    

@endsection


@push('scripts')
    <script></script>
@endpush
