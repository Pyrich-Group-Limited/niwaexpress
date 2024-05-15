@extends('layouts.app')

@section('title', 'Sub-Service')


@push('styles')
@endpush


@section('content')
<?php 
$userPayment = \App\Models\Payment::where('payment_type',0)->where('employer_id', auth()->user()->id)->first();
        if(!empty($userPayment) && $userPayment->payment_status == 1 && $userPayment->approval_status == 1){
?>
    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">NIWA Act</h3>
                <div class="nk-block-des text-soft">
                    <p>Click on the link below to download NIWA Act</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <a href="{{ asset('assets/images/act.pdf') }}" class="btn btn-primary btn-lg" download>Download NIWA Act</a>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
    
<?php }else{ ?>
<div class="row">
    @php
                                                $reg_setup = App\Models\RegistrationFee::where('branch_id', auth()->user()->branch->id)->first();
                                            @endphp
    <h3>Kindly pay the &#8358;{{ number_format($reg_setup->amount, 2) }} registration fee by clicking on the button below</h3>
    <div class="col-md-2">
        
        <a href="{{ route('payment.reg') }}"  class="btn btn-secondary btn-lg mt-2"><em
            class="icon ni ni-save me-2"></em> Pay Now</a>
    </div>
</div>
    
<?php } ?>
@endsection

