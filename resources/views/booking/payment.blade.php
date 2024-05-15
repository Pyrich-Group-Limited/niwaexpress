@extends('layouts.app')
@section('content')
    <div class=" container mx-5">

        <form class="form" onsubmit="makePayment()" method="POST" action="{{ route('storepayment') }}" id="payment-form">
            @csrf
            <div class="form-group">

                <label class=" form-label">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" required value="" class=" form-control"
                    placeholder="NAME" />&nbsp;

            </div>
            <div class="form-group">

                <label class=" form-label">Email Address <span class="required">*</span></label>
                <input type="email" id="email" value="" required name="email" class=" form-control" />

            </div>
            <input type="hidden" id="narration" name="narration" class=" form-control" />
            <div class="form-group">

                <label class=" form-label">PHONE NUMBER: <span class="required">*</span></label>

                <input type="tel" name="phone_number" required class=" form-control" id="">
            </div>

            <div class="form-group">

                <label class=" form-label">AMOUNT <span class="required">*</span></label>
                <input type="text" value="{{ $amount }}" id="amount" name="amount" readonly
                    class=" form-control" />
            </div>


            <button class=" btn btn-success" type="submit">Pay For Trip</button>



            {{-- <li>
            <input type="button" onclick="makePayment()" value="Pay" />
            </li> --}}

        </form>

    </div>

    <script type="text/javascript" src="https://login.remita.net/payment/v1/remita-pay-inline.bundle.js"></script>




    {{-- YOU ACTUALLY DON'T NEED  THIS SCRIPT BECAUSE IT WILL BE DONE FROM THE BACKEND --}}
    <script>
        function makePayment() {
            var pubKey = "{{ env('REMITA_PUBLIC_KEY') }}";
            var cUrl = "{{ route('payment.callbackdata') }}?";

            var form = document.querySelector("#payment-form");
            var handler = RmPaymentEngine.init({
                    key: pubKey,
                    processRrr: true,
                    transactionId: Math.floor(Math.random() * 1101233),

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



                },
                onSuccess: function(response) {
                    console.log('callback Successful Response', response);
                    window.location.href = cUrl + 'ref=' + form.querySelector('input[name="rrr"]').value +
                        '&tid=' + response.transactionId;
                },onError: function(response) {
                    console.log('callback Error Response', response);
                },
                onClose: function() {
                    console.log("closed");
                }
            });
            paymentEngine.showPaymentWidget();
        }

        // window.onload =
        //     function() { // Optional. This function is passed when the integration is at the demo stage and can be removed immediately for live.
        //         setDemoData();
        //     };
    </script>
@endsection
