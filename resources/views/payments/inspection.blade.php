@extends('layouts.app')

@section('title', 'Payments')


@push('styles')
@endpush


@section('content')
    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            {{-- <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">New Inspection Fees Payment</h6>
                </div>
            </div> --}}
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
        @if(isset($inspection_payment) && $inspection_payment->payment_status == 0)
       {{--  <div class="form-group mt-2">
            <div class="row">
                <div class="col-6 fw-bold">RRR:</div>
                <div class="col-6">{{ $inspection_payment->rrr }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-bold">Invoice:</div>
                <div class="col-6">{{ $inspection_payment->invoice_number }}</div>
            </div>
            <div class="row">
                <div class="col-6 fw-bold">Amount:</div>
                <div class="col-6">
                    &#8358;{{ number_format($inspection_payment->amount, 2) }}</div>
            </div>
            <div>
                <form onsubmit="makePayment()" id="payment-form">
                    <input type="hidden" class="form-control" id="js-rrr"
                        name="rrr" value="{{ $inspection_payment->rrr }}"
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
                            <input type="hidden" class="form-control" id="js-rrr"
                                name="rrr" value="{{ $inspection_payment->rrr }}"
                                placeholder="Enter RRR" />
                                <button type="button" class="btn btn-danger" onclick="makePayment()"><i class="fa fa-send fa-lg"></i> Pay Now</button>
                        </form>
                        <button class="btn btn-white" onclick="printDiv('print')"><i class="fa fa-print fa-lg"></i> Print</button>
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
                                        <h3 class="text-uppercase">Invoice #{{ $inspection_payment->invoice_number }}</h3>
                                        <ul class="list-unstyled">
                                            <li>Date: <span>{{ \Carbon\Carbon::parse($inspection_payment->created_at)->format('F j, Y') }}</span></li>
                                            <li>Due date: <span>{{ \Carbon\Carbon::parse($inspection_payment->created_at)->format('F j, Y') }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-6 m-b-20">
                                    
                                        <h5>Invoice to:</h5>
                                        <ul class="list-unstyled">
                                            @if(!empty(auth()->user()->contact_firstname) || !empty(auth()->user()->contact_surname))
                                                <li>
                                                    <h5><strong>{{ auth()->user()->contact_firstname.' '.auth()->user()->contact_surname }}</strong></h5>
                                                </li>
                                            @endif
                                        
                                            @if(!empty(auth()->user()->company_name))
                                                <li><span>{{ auth()->user()->company_name }}</span></li>
                                            @endif
                                        
                                            @if(!empty(auth()->user()->company_address))
                                                <li>{{ auth()->user()->company_address }}</li>
                                            @endif
                                        
                                            @if(!empty(auth()->user()->company_phone))
                                                <li>{{ auth()->user()->company_phone }}</li>
                                            @endif
                                        
                                            @if(!empty(auth()->user()->company_email))
                                                <li><a href="#">{{ auth()->user()->company_email }}</a></li>
                                            @endif
                                        </ul>                            
                                    
                                </div>
                                <div class="col-sm-6 col-lg-6 m-b-20">
                                    <div class="invoices-view">
                                        <span class="text-muted">Payment Details:</span>
                                        <ul class="list-unstyled invoice-payment-details">
                                            <li>
                                                <h5>Total Due: <span class="text-right">{{ $settings['site_currency_symbol'] }}{{ $inspection_payment->amount }}</span></h5>
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
                                            <td>{{ $inspection_payment->rrr }}</td>
                                            <td>{{ $settings['site_currency_symbol'] }}{{ $inspection_payment->amount }}</td>
                                            <td>1</td>
                                            <td>{{ $settings['site_currency_symbol'] }}{{ $inspection_payment->amount }}</td>
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
                                                            <td class="text-right">{{ $settings['site_currency_symbol'] }}{{ $inspection_payment->amount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tax: <span class="text-regular">(0%)</span></th>
                                                            <td class="text-right">{{ $settings['site_currency_symbol'] }}{{ '0.00' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td class="text-right text-primary">
                                                                <h5>{{ $settings['site_currency_symbol'] }}{{ $inspection_payment->amount }}</h5>
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
                                    <p class="text-muted">No refund of cash after payment. Do not disclose your Retrieval Reference Number (RRR) to anyone. All payments made here are subject to admin approval</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    @else
        <div class="row g-gs">
            <div class="col-xxl-6 col-sm-12">
                <div class="card h-100">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            {{-- @if (auth()->user()->employees->count() > 0) --}}
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">New Inspection Fees Payment</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="form-group w-100">
                                            {{-- @if (!$inspection_payment || $paid_months != 0) --}}
                                            <?php 
                                            //$pending_payments = Payment::where('payment_status',4)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->first();
                                            ?>
                                            {{-- @if (!$inspection_payment || $paid_months != 0) --}}
                                                {{-- <div class="form-group"> --}}
                                           
                                                {{--  </div> --}}
                                         
                                            <form method="POST" action="{{ route('payment.remita') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">
                                                        {{-- <label for="year">Payment year:</label>
                                                        <select name="year" id="year" class="form-select">
                                                            <option>{{ date('Y') }}
                                                            </option>
                                                            
                                                        </select>

                                                        <label for="contribution_period">Inspection Period:</label>
                                                        <select name="contribution_period" id="contribution_period"
                                                            class="form-select">
                                                            <option>Annually</option>
                                                        </select> --}}
                                                        <input type="hidden" name="year" id="year"
                                                        value="{{ date('Y') }}">
                                                        <input type="hidden" name="contribution_period" id="contribution_period"
                                                        value="Annually">
                                                            <?php 
                                                            /* $services = \App\Models\Service::join('payments', 'services.id', '=', 'payments.service_id')
    ->whereYear('payments.created_at', date('Y'))
    ->where('payments.payment_status', 1)
    ->where('payments.employer_id', auth()->user()->id)
    ->get(); */
    $services = \App\Models\Service::join('payments', 'services.id', '=', 'payments.service_id')
    ->whereYear('payments.created_at', date('Y'))
    ->where('payments.payment_status', 1)
    ->where('payments.approval_status', 1)
    ->where('payments.employer_id', auth()->user()->id)
    ->where('payments.service_id', $service_name->service_id)
    ->latest('payments.created_at') // Specify the table for ordering
    ->first();
                                                            ?>
                                                            
                                                            <label for="service_id">My Service:</label>
                                                            <input type="hidden" class="form-control" id="service_app"
                                                                            name="service_app" value="{{ $services->id }}" placeholder="{{ $services->name }}" readonly>
                                                                            <p><b>{{ $services->name }}</b></p>
                                                                  {{-- <select class="form-select" id="service_id"
                                                                        name="service_id" data-search="on" required>
                                                                        <option>Select A Service</option>
                                                                        @foreach($services as $service)
                                                                            <option value="{{ $service->id }}">{{ $service->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    <label for="service_type_id">Service Type:</label>
                                                                    <select class="form-select" id="service_type_id" name="service_type_id" onchange="calculateFees()" required>
                                                                        <option>Select Service Type</option>
                                                                        <option value="mechanical">Mechanical</option>
                                                                        <option value="manual">Manual</option>
                                                                    </select>
                                                            
                                                               {{-- <label class="form-label" for="default-06">Upload letter of intent (pdf only: .pdf)
                                                                </label>
                                                                <div class="form-control-wrap">
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-file-input" id="document"
                                                                            name="letter_of_intent" required>
                                                                        <label class="form-file-label" for="customFile">Choose file</label>
                                                                    </div>
                                                                </div> --}}
                                                            

                                                        <div id="nom_div" class="d-none">
                                                            <label for="number_of_months">Number of months</label>
                                                            <select name="number_of_months" id="number_of_months"
                                                                class="form-select">
                                                                <option>12</option>
                                                            </select>
                                                        </div>
                                                        <br/><br/><br/>

                                                        <button type="submit" class="btn btn-secondary btn-lg mt-2"><em
                                                                class="icon ni ni-save me-2"></em> Generate Invoice
                                                            (Remita
                                                            RR)</button>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="">Payment due is:</label><br />
                                                        
                                                        <p>Inspection Fees:
                                                            <strong class="fs-3" id="processing_fee">&#8358;{{ number_format(0.00, 2) }}</strong>
                                                        </p>
                                                        <p>Total Fees:
                                                            <strong class="fs-3" id="total_fees">&#8358;{{ number_format(0.00, 2) }}</strong>
                                                            <strong class="fs-3" id="total_fees1" style="display:none;"></strong>
                                                        </p>

                                                        <input type="hidden" name="payment_type" id="payment_type"
                                                            value="5">
                                                        <input type="hidden" name="employees" id="employees"
                                                            value="{{ $total_services }}">
                                                        <input type="hidden" name="amount" id="amount"
                                                            value="">

                                                        <label for=""><b>Note: </b>Only one contribution type
                                                            can be
                                                            used for a selected year.</label>
                                                    </div>
                                                </div>

                                            </form>
                                              
                                            
                                        </div>
                                    </div>
                                </div>
                           
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            
        </div><!-- .row -->
        @endif
    </div> <!-- nk-block -->

    {{-- </div><!-- .components-preview --> --}}
@endsection


@push('scripts')
    <!-- JavaScript -->
    <script src="./assets/js/libs/datatable-btns.js?ver=3.1.3"></script>

    <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
    <script>
        var cUrl = "{{ route('payment.callback') }}?";
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
        }
        /* window.onload = function() {
            //setDemoData();
        }; */
    </script>

    <script>
        $(document).ready(function() {
            const annual_pay = document.getElementById('total_fees1').textContent;
            const month_pay = annual_pay / 12;
            console.log(month_pay);
            $('#contribution_period, #number_of_months').change(function() {
                if ($('#contribution_period').val() == 'Monthly') {
                    $('#nom_div').removeClass('d-none');
                    //if its the last month
                    //((100000 - ((100000/12).toFixed(2)*11)).toFixed(2) ++++ ((100000/12).toFixed(2)*11))
                    //left of++++ is 12th month; right is sum of other months
                    const current_due = (month_pay * $('#number_of_months').val()).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    $('#contribution_amount').html('&#8358;' + current_due);
                    $('#amount').val(current_due.replace(',', ''));
                } else {
                    $('#nom_div').addClass('d-none');
                    $('#contribution_amount').html('&#8358;' + annual_pay.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                    $('#amount').val(annual_pay);
                }
            });
            //$('#contribution_period').trigger('change');
        });
    </script>
    <script>
        function calculateFees() {
            var appFees = 25000.00;
            var serviceType = document.getElementById('service_type_id').value;
            var processingFee = 0.00;
    
            if (serviceType === 'mechanical') {
                processingFee = 150000.00;
            } else if (serviceType === 'manual') {
                processingFee = 7500.00;
            }
    
            var totalFees = appFees + processingFee;
    
            document.getElementById('processing_fee').textContent = '₦' + processingFee.toFixed(2);
            document.getElementById('total_fees').textContent = '₦' + processingFee.toFixed(2);
            document.getElementById('total_fees1').textContent = processingFee.toFixed(2);
            document.getElementById('amount').value = processingFee.toFixed(2);
        }
    </script>
    <script>
        function printDiv(divId) {
            var content = document.getElementById(divId).innerHTML;
            var printWindow = window.open('', '', 'fullscreen=yes,scrollbars=no');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>NIWA_Inspection_Fee</title></head><body>' + content + '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
