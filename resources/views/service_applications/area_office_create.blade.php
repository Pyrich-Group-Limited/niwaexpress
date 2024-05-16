@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h2>
                        Upload Letter Of Intent
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
       {{--  @if(session()->has('success'))
        <div class="alert alert-success" style="color: green; font-weight:bold">
        {{ session()->get('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-error" style="color: red; font-weight:bold">
        {{ session()->get('error') }}
        </div>
        @endif --}}
        
        
        <div class="card">

            <form action="{{ route('incoming_store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="card-body">

                <div class="row">
                    @include('service_applications.area_office_fields')



                </div>

            </div>

            <div class="card-footer" style="">
                <button type="submit" class="btn btn-primary">NEXT</button>
                {{-- <a href="{{ route('incoming_documents_manager.index') }}" class="btn btn-default"> Cancel </a> --}}
            </div>

            </form>

        </div>
    </div>
@endsection
