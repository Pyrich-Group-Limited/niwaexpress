@extends('layouts.app')

@section('title', 'Sub-Services')


@push('styles')
@endpush


@section('content')

    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Uploaded documents</h3>
                <div class="nk-block-des text-soft">
                    <p>List of uploaded documents</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <?php 
$payment_due = 150000;
?>
   
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init-export nowrap table" data-export-title="Export">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            {{-- <th>Name</th> --}}
                            <th>Document Name</th>
                            <th>Document (PDF)</th>
                            <th>Approval Status</th>
                            {{-- <th>Manage</th> --}}
                        </tr>
                    </thead>
                    <tbody> @php
                        $no = 1;
                    @endphp
                        @foreach ($employer_documents as $employer_document)
                            <tr>
                                <td>@php
                                echo $no++;
                                @endphp</td>
                                {{-- <td>{{ $employer_document->employer->contact_firstname }} {{ $employer_document->employer->contact_surname }}</td> --}}
                                <td>{{ $employer_document->title }}</td>
                                <td>
                                    <a href="{{ 'storage/'.$employer_document->file_path }}" target="_blank">
                                        View PDF
                                    </a>
                                </td>
                                 <td><span
                                        class="tb-status text-{{ $employer_document->payment_status == 1 ? 'success' : 'danger' }}">{{ $employer_document->payment_status == 1 ? 'APPROVED' : 'NOT APPROVED' }}</span>
                                </td>
                                {{-- <td>
                                    <a style="padding-right: 10px;" href="{{ route('sub-services.edit', $employee->id) }}" title="Edit Sub-Service"><span
                                            class="nk-menu-icon text-info"><em class="icon ni ni-edit"></em></span></a> --}}
                                    {{-- <a data-id="{{ $employee->id }}"><span class="nk-menu-icon text-danger eg-swal-av3"><em
                                                class="icon ni ni-trash"></em></span>
                                            </a> --}}

                                    {{-- <a id="delete-employee" title="Terminate Sub-Service" style="cursor: pointer;"
                                        onclick="event.preventDefault();
                                    document.getElementById('delete-employee-form').submit();"><span
                                            class="nk-menu-icon text-danger eg-swal-av3"><em
                                                class="icon ni ni-user-remove"></em></span>
                                    </a>
                                    <form id="delete-employee-form" action="{{ route('sub-services.destroy', $employee->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE') --}}
                                        {{-- <button onclick="return false" id="delete-employee"
                                            class="btn btn-danger">Delete</button> --}}
                                   {{--  </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
   
    {{-- </div><!-- .components-preview --> --}}

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#delete-employee').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "You won't be able to revert this !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //redirect to database
                    if (result.isConfirmed) {
                        $('#delete-employee-form').submit();
                    }
                    //handle through ajax
                    /* if (result.value) {
                        Swal.fire('Deleted!', 'Your selected item has been deleted.', 'success');
                    } */
                })
            });
        });
    </script>
    <!-- JavaScript -->
    <script src="./assets/js/libs/datatable-btns.js?ver=3.1.3"></script>
@endpush

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
            const annual_pay = {{ $payment_due }};
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
            $('#contribution_period').trigger('change');
        });
    </script>
@endpush