@extends('layouts.app')

@section('title', 'Sub-Service')


@push('styles')
@endpush


@section('content')

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
    


  
@endsection

