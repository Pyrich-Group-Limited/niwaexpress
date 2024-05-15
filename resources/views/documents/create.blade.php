@extends('layouts.app')

@section('title', 'Sub-Service')


@push('styles')
@endpush


@section('content')

    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Documents Upload</h3>
                <div class="nk-block-des text-soft">
                    <p>Upload documents and make payments</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <?php
                   $userId = \Auth::id(); // Get the authenticated user's ID
$userPayment = \App\Models\Payment::where('payment_type',4)->where('approval_status',1)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->latest()->first();
     if(!empty($userPayment) && $userPayment->document_uploads == 1){
                   ?>
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('documents.form')
                </form>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
    <?php }else{
        ?> 
        <div class="form-group">
            <label for="" class="">You can not upload documents till you make a new application fee & processing fee
                payments for a service and wait for approval</label>
                <br/>
                <a class="btn btn-primary me-n1" href="{{route('payment.index')}}">Make Application Fees Payments</a>
        </div>
        <?php
    } ?>
    {{-- </div><!-- .components-preview --> --}}

@endsection


@push('scripts')
   {{--  <script>
        $(document).ready(function() {
            //FETCH LGAs FROM STATE ID
            const lUrl = "{{ route('employer.lgas') }}?state=";
            $('#state_of_origin').change(function() {
                $.ajax({
                    url: lUrl + $(this).val(),
                    type: "GET",
                    data: null,
                    dataType: 'json',
                }).done(function(response) {
                    $('#local_govt_area').empty();
                    var lgas = '';
                    $.each(response.data, function(a, b) {
                        lgas += '<option value="' + b.id + '">' + b.name + '</option>';
                    });
                    $('#local_govt_area').html(lgas);
                });
            });

            $('#state_of_origin').trigger('change');
        });
    </script> --}}
@endpush
