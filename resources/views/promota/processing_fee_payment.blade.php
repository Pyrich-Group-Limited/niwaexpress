@extends('layouts.app')

@section('title', 'Processing Fee Payment')


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
                            {{-- @if (auth()->user()->employees->count() > 0) --}}
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">New Processing Fee Payment</h6>
                                </div>
                            </div>
                            <div class="data">
                                <div class="data-group">
                                    <div class="form-group w-100">
                                        @if (!empty($pending_payment) && $pending_payment->payment_status == 0)
                                            <div class="form-group mt-2">
                                                <div class="row">
                                                    <div class="col-6 fw-bold">RRR:</div>
                                                    <div class="col-6">{{ $pending_payment->rrr }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 fw-bold">Invoice:</div>
                                                    <div class="col-6">{{ $pending_payment->invoice_number }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 fw-bold">Amount:</div>
                                                    <div class="col-6">
                                                        &#8358;{{ number_format($pending_payment->amount, 2) }}</div>
                                                </div>
                                                <div>
                                                    <form onsubmit="makePayment()" id="payment-form">
                                                        <input type="hidden" class="form-control" id="js-rrr"
                                                            name="rrr" value="{{ $pending_payment->rrr }}"
                                                            placeholder="Enter RRR" />
                                                        <button type="button" onclick="makePayment()"
                                                            class="btn btn-primary btn-lg mt-2"><em
                                                                class="icon ni ni-send me-2"></em> Click to pay online
                                                            now!</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <form method="POST" action="{{ route('epromotapayment.remita',[$user->id]) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">


                                                        <button type="submit" class="btn btn-secondary btn-lg mt-2"><em
                                                                class="icon ni ni-save me-2"></em> Generate Invoice
                                                            (Remita
                                                            RR)</button>
                                                    </div>
                                                    <div class="col-6">
                                                        @php $user = Auth::user();
                                                        $service_app = \App\Models\ServiceApplication::findOrFail($service_application_id);
                                                        if ($service_app) {
    $app_form_fee_type = \App\Models\ProcessingFee::where("service_id", $service_app->service_id)->where("processing_type_id", $service_app->service_type_id)->first();
    if ($app_form_fee_type && $app_form_fee_type->processing_type_id != 0) {
        $app_form_fee = $app_form_fee_type;
    } else {
        $app_form_fee = \App\Models\ProcessingFee::where("service_id", $service_app->service_id)->first();
    }
} else {
    // Handle the case when the ServiceApplication is not found
    $app_form_fee = null;
}

                                                        @endphp
                                                        <label for="">Payment due for <b>{{ $service_app->service ? $service_app->service->name : 'NILL' }}</b> is:</label><br />
                                                        <p>Processing Fee:
                                                            <strong class="fs-3"
                                                                    id="processing_fee">&#8358;{{ number_format($app_form_fee ? $app_form_fee->amount : '0', 2) }}</strong>
                                                            {{-- @if ($service_application->service_type_id == 'mechanical')
                                                                <strong class="fs-3"
                                                                    id="processing_fee">&#8358;{{ number_format($app_form_fee ? $app_form_fee->amount : '0', 2) }}</strong>
                                                            @else
                                                                <strong class="fs-3"
                                                                    id="processing_fee">&#8358;{{ number_format(7500.0, 2) }}</strong>
                                                            @endif --}}
                                                        </p>
                                                        <input type="hidden" name="payment_type" id="payment_type"
                                                            value="2">
                                                        <input type="hidden" name="amount" id="amount"
                                                            value="{{ $app_form_fee->amount }}">
                                                        {{-- @if ($service_application->service_type_id == 'mechanical')
                                                            <input type="hidden" name="amount" id="amount"
                                                                value="150000">
                                                        @else
                                                            <input type="hidden" name="amount" id="amount"
                                                                value="7500">
                                                        @endif --}}
                                                        <input type="hidden" name="service_application_id"
                                                            value="{{ $service_application->id }}">
                                                    </div>
                                                </div>

                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->

        @include('partials.payments-table')

    </div> <!-- nk-block -->

    {{-- </div><!-- .components-preview --> --}}
@endsection


@push('scripts')
    <!-- JavaScript -->
    <script src="./assets/js/libs/datatable-btns.js?ver=3.1.3"></script>

    {{-- <script type="text/javascript" src="https://demo.remita.net/payment/v1/remita-pay-inline.bundle.js"></script> --}}
    <script>
        var cUrl = "{{ route('payment.callback') }}?";
        var pubKey = "{{ env('REMITA_PUBLIC_KEY') }}";

        function makePayment() {
    var form = document.querySelector("#payment-form");
    var tidParam = '';

    @if(!empty($pending_payment) && $pending_payment->id)
        tidParam = '&tid={{ $pending_payment->id }}';
    @endif

    window.location.href = cUrl + 'ref=' + form.querySelector('input[name="rrr"]').value + tidParam;
}
        /*  function makePaymentOld() {
            var form = document.querySelector("#payment-form");
            var paymentEngine = RmPaymentEngine.init({
                key: pubKey,
                processRrr: true,
                transactionId: Math.floor(Math.random() * 1101233),
                // Replace with a reference you generated or remove the entire field for us to auto-generate a reference for you. Note that you will be able to check the status of this transaction using this transaction Id
                extendedData: {
                    customFields: [{
                        name: "rrr",
                        value: form.querySelector('input[name="rrr"]').value
                    }, {
                        name: "payment_type",
                        value: 4
                    }]
                },
                onSuccess: function(response) {
                    console.log('callback Successful Response', response);
                    window.location.href = cUrl + 'ref=' + form.querySelector('input[name="rrr"]').value +
                        '&tid=' + response.transactionId;
                },
                onError: function(response) {
                    console.log('callback Error Response', response);
                },
                onClose: function() {
                    console.log("closed");
                }
            });
            paymentEngine.showPaymentWidget();
        } */
        /* window.onload = function() {
            //setDemoData();
        }; */
    </script>
@endpush
