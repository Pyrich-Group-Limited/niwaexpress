@extends('layouts.app')

@section('title', 'Service Registration Steps')

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Service Registration</h3>
                <div class="nk-block-des text-soft">
                    <p>Make payment to complete your registration and unlock Service Dashboard.</p>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    @php
        //Check if there is a registration payment
        $pending = auth()->user()->payments()->latest()->first();
    @endphp

    @if ($pending && $pending->payment_status == 0)
        {{-- IF NO RRR IS GENERATED --}}
        {{-- <div class="form-group mt-2">
    <div class="row">
        <div class="col-6 fw-bold">RRR:</div>
        <div class="col-6">{{ $pending->rrr }}</div>
    </div>
    <div class="row">
        <div class="col-6 fw-bold">Invoice:</div>
        <div class="col-6">{{ $pending->invoice_number }}</div>
    </div>
    <div>
        <form onsubmit="makePayment()" id="payment-form">
            <input type="hidden" class="form-control" id="js-rrr"
                name="rrr" value="{{ $pending->rrr }}"
                placeholder="Enter RRR" />
            <button type="button" onclick="makePayment()"
                class="btn btn-primary btn-lg mt-2"><em
                    class="icon ni ni-send me-2"></em> Click to pay online
                now!</button>
        </form>
    </div>
</div> --}}
        <div id="print">
            <div class="row">
                <div class="col-sm-5 col-4">
                    <h4 class="page-title">Remita Payment Invoice</h4>
                </div>
                <div class="col-sm-7 col-8 text-right m-b-30">
                    <div class="btn-group btn-group-sm">

                        <form onsubmit="makePayment()" id="payment-form">
                            <input type="hidden" name="approval_status" id="approval_status" value="1">
                            <input type="hidden" class="form-control" id="js-rrr" name="rrr"
                                value="{{ $pending->rrr }}" placeholder="Enter RRR" />
                            <button type="button" class="btn btn-danger" onclick="makePayment()"><i
                                    class="fa fa-send fa-lg"></i> Pay Now</button>
                        </form>
                        <button class="btn btn-white" onclick="printDiv('print')"><i class="fa fa-print fa-lg"></i>
                            Print</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row custom-invoice">
                                <div class="col-6 col-sm-6 m-b-20">
                                    <img src="{{ asset('assets/images/logo.png') }}" class="inv-logo" alt="NIWA Logo">
                                    <ul class="list-unstyled">
                                        <?php
                                        $settings = App\Models\Utility::settings();
                                        ?>
                                        <li>{{ $settings['company_name'] }}</li>
                                        <li>{{ $settings['company_address'] }}</li>
                                        <li>{{ $settings['company_city'] }}</li>
                                        <li>{{ $settings['company_state'] }}</li>
                                        <li>{{ $settings['company_country'] }}</li>
                                    </ul>
                                </div>
                                <div class="col-6 col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Invoice #{{ $pending->invoice_number }}</h3>
                                        <ul class="list-unstyled">
                                            <li>Date:
                                                <span>{{ \Carbon\Carbon::parse($pending->created_at)->format('F j, Y') }}</span>
                                            </li>
                                            <li>Due date:
                                                <span>{{ \Carbon\Carbon::parse($pending->created_at)->format('F j, Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-6 m-b-20">

                                    <h5>Invoice to:</h5>
                                    <ul class="list-unstyled">
                                        @if (!empty(auth()->user()->contact_firstname) || !empty(auth()->user()->contact_surname))
                                            <li>
                                                <h5><strong>{{ auth()->user()->contact_firstname . ' ' . auth()->user()->contact_surname }}</strong>
                                                </h5>
                                            </li>
                                        @endif

                                        @if (!empty(auth()->user()->company_name))
                                            <li><span>{{ auth()->user()->company_name }}</span></li>
                                        @endif

                                        @if (!empty(auth()->user()->company_address))
                                            <li>{{ auth()->user()->company_address }}</li>
                                        @endif

                                        @if (!empty(auth()->user()->company_phone))
                                            <li>{{ auth()->user()->company_phone }}</li>
                                        @endif

                                        @if (!empty(auth()->user()->company_email))
                                            <li><a href="#">{{ auth()->user()->company_email }}</a></li>
                                        @endif
                                    </ul>

                                </div>
                                <div class="col-sm-6 col-lg-6 m-b-20">
                                    <div class="invoices-view">
                                        <span class="text-muted">Payment Details:</span>
                                        <ul class="list-unstyled invoice-payment-details">
                                            <li>
                                                <h5>Total Due: <span
                                                        class="text-right">{{ $settings['site_currency_symbol'] }}{{ $pending->amount }}</span>
                                                </h5>
                                            </li>
                                            {{-- <li>Bank name: <span>Profit Bank Europe</span></li>
                                <li>Country: <span>United Kingdom</span></li>
                                <li>City: <span>London E1 8BF</span></li>
                                <li>Address: <span>3 Goodman Street</span></li>
                                <li>IBAN: <span>KFH37784028476740</span></li>
                                <li>SWIFT code: <span>BPT4E</span></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ITEM</th>
                                            <th>RRR</th>
                                            <th>UNIT COST</th>
                                            <th>QUANTITY</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ 'Registration Fee' }}</td>
                                            <td>{{ $pending->rrr }}</td>
                                            <td>{{ $settings['site_currency_symbol'] }}{{ $pending->amount }}</td>
                                            <td>1</td>
                                            <td>{{ $settings['site_currency_symbol'] }}{{ $pending->amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div class="row invoice-payment">
                                    <div class="col-sm-7">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="m-b-20">
                                            <h6>Total due</h6>
                                            <div class="table-responsive no-border">
                                                <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th>Subtotal:</th>
                                                            <td class="text-right">
                                                                {{ $settings['site_currency_symbol'] }}{{ $pending->amount }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tax: <span class="text-regular">(0%)</span></th>
                                                            <td class="text-right">
                                                                {{ $settings['site_currency_symbol'] }}{{ '0.00' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td class="text-right text-primary">
                                                                <h5>{{ $settings['site_currency_symbol'] }}{{ $pending->amount }}
                                                                </h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-info">
                                    <h5>Other information</h5>
                                    <p class="text-muted">No refund of cash after payment. Do not disclose your Retrieval
                                        Reference Number (RRR) to anyone. All payments made here are subject to admin
                                        approval</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="nk-block nk-block-lg">
            <div class="row g-gs">
                <div class="col-xxl-6 col-sm-12">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title"> Welcome to NIWA Self Service Dashboard </h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="form-group">
                                            @php
                                                $reg_setup = App\Models\RegistrationFee::where(
                                                    'branch_id',
                                                    auth()->user()->branch->id,
                                                )->first();
                                            @endphp
                                            <label for="">Complete
                                                &#8358;{{ number_format($reg_setup->amount, 2) }} registration fee
                                                payment</label>

                                            {{-- WHEN RRR HAS BEEN GENERATED --}}
                                            <div class="form-group">
                                                <form method="POST" action="{{ route('payment.remita') }}">
                                                    @csrf

                                                    {{-- <input type="hidden" name="payment_type" id="payment_type"
                                                        value="1"> --}}
                                                    <input type="hidden" name="payment_type" id="payment_type"
                                                        value="0">

                                                    <input type="hidden" name="amount" id="amount"
                                                        value="{{ $reg_setup->amount }}">
                                                    <button type="submit" class="btn btn-secondary btn-lg mt-2"><em
                                                            class="icon ni ni-save me-2"></em> Generate Invoice (Remita
                                                        RR)</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
        </div><!-- .row -->
    @endif
    @php
        $payments = auth()->user()->payments()->get();
    @endphp

    @include('partials.payments-table')

    </div> <!-- nk-block -->

    <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
    <script>
        var cUrl = "{{ route('payment.callbackdata') }}?";
        var pubKey = "{{ env('REMITA_PUBLIC_KEY') }}";

        function makePayment() {
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
                        value: 1
                    }, {
                        name: "approval_status",
                        value: 1
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
        }
        /* window.onload = function() {
            //setDemoData();
        }; */
    </script>
    <script>
        function printDiv(divId) {
            var content = document.getElementById(divId).innerHTML;
            var printWindow = window.open('', '', 'fullscreen=yes,scrollbars=no');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>NIWA_Registration_Fee</title></head><body>' + content +
                '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
