@extends('layouts.app')

@section('title', 'Payments')


@section('content')
    {{-- <div class="components-preview wide-md mx-auto"> --}}
  
    <div class="nk-block nk-block-lg">
         
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">My Payments</h6>
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
            document.getElementById('total_fees').textContent = '₦' + totalFees.toFixed(2);
            document.getElementById('total_fees1').textContent = totalFees.toFixed(2);
            document.getElementById('amount').value = totalFees.toFixed(2);
        }
    </script>
    <script>
        function printDiv(divId) {
            var content = document.getElementById(divId).innerHTML;
            var printWindow = window.open('', '', 'fullscreen=yes,scrollbars=no');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>NIWA_Application_and_Processing_Fees</title></head><body>' + content + '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
