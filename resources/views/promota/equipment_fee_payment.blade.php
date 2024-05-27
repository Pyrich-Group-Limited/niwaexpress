@extends('layouts.app')

@section('title', 'Equipment Fee Payment')


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
                                    <h6 class="title">New Equipment Fee Payment</h6>
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
                                                    <form onsubmit="makePayment(event)" id="payment-form">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="js-rrr"
                                                            name="rrr" value="{{ $pending_payment->rrr }}"
                                                            placeholder="Enter RRR" />
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <input type="hidden" class="form-control" id="js-payment-id"
                                                            name="payment_id" value="{{ $pending_payment->id }}"
                                                            placeholder="Enter Payment ID" />
                                                        <button type="submit" class="btn btn-primary btn-lg mt-2">
                                                            <em class="icon ni ni-send me-2"></em> Click to pay online now!
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        @else
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
        var cUrl = "{{ route('payment.epromotacallback') }}?";
        var pubKey = "{{ env('REMITA_PUBLIC_KEY') }}";

        function makePayment(event) {
    event.preventDefault(); // Prevent form submission
    var form = document.querySelector("#payment-form");
    var tidParam = '';
    var user_id = form.querySelector('input[name="user_id"]').value;
    var rrr = form.querySelector('input[name="rrr"]').value;

    @if(!empty($pending_payment) && $pending_payment->id)
        tidParam = '&tid={{ $pending_payment->id }}';
    @endif

    window.location.href = cUrl + 'ref=' + rrr + '&user_id=' + user_id + tidParam;
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
