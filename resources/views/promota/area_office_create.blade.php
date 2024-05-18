@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h2>
                        Submit Letter Of Intent
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
                  <!-- Select Area Office -->
<div class="form-group col-sm-12 mb-3">
    <label for="branch_id">Select Area Office:</label>
    <select id="branch_id" name="branch_id" class="form-select" required>
        @foreach($branches as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>

<!-- Input Service Type -->
{{-- <div class="form-group col-sm-12 mb-3">
    <label for="title">Input Service Type:</label>
    <input type="text" id="title" name="title" class="form-control" required>
</div> --}}

<div class="form-group col-sm-12 mb-3">
    <label for="service_id">Service Type:</label>
    <select class="form-control" id="service_id" name="title" required>
        <option value="">Select Service Type</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
        @endforeach
    </select>
</div>


<!-- Sender Full Name -->
<div class="form-group col-sm-12 mb-3">
    <label for="full_name">Sender Full Name:</label>
    <input type="text" id="full_name" name="full_name" value="{{$user->contact_firstname.' '.$user->contact_surname }}" class="form-control" required readonly >
</div>

<!-- Sender Email -->
<div class="form-group col-sm-6 mb-3">
    <label for="email">Sender Email:</label>
    <input type="email" id="email" name="email" class="form-control" value="{{$user->company_email }}" readonly required>
</div>

<!-- Sender Phone -->
<div class="form-group col-sm-6 mb-3">
    <label for="phone">Sender Phone:</label>
    <input type="tel" id="phone" name="phone" class="form-control" value="{{$user->contact_number }}" readonly required>
    <input type="hidden" name="department_id" value="16" class="form-control" required>
    <input type="hidden" name="status" value="1" class="form-control" required>
</div>

<!-- Description -->
<div class="form-group col-sm-12 col-lg-12 mb-3">
    <label for="description">Description:</label>
    <textarea id="description" name="description" class="form-control" required></textarea>
</div>

<!-- Upload Letter Of Intent -->
<div class="form-group col-sm-6">
    <label for="file">Upload Letter Of Intent:</label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" id="file" name="file" class="form-control" accept=".pdf,.doc,.docx,image/*" required>
        </div>
    </div>
</div>

<!-- File Upload Validation Script -->

@push('scripts')
<script>
    document.getElementById('file').addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 1048576; // 1MB in bytes
        const allowedFormats = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/gif'];

        if (file) {
            if (!allowedFormats.includes(file.type)) {
                alert('Please select a valid file format (PDF, DOC, DOCX, JPEG, PNG, GIF).');
                this.value = ''; // Clear the file input
            } else if (file.size > maxSize) {
                alert('File size exceeds the maximum limit of 1MB.');
                this.value = ''; // Clear the file input
            }
        }
    });
</script>
<script>
   /*  $(document).ready(function() {
        $('#branch_id').change(function() {
            var serviceId = $(this).val();
            if (serviceId) {
                $.ajax({
                    type: "GET",
                    url: "/services/" + serviceId + "/services-types",
                    success: function(data) {
                        $('#service_id').empty();
                        if (data.length > 0) {
                            $('#service_id').append(
                                '<option value="">Select A Service</option>');
                            $.each(data, function(key, value) {
                                $('#service_id').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#service_id').append(
                                '<option value="0">No result</option>');
                        }
                    }
                });
            } else {
                $('#service_id').empty();
            }
        });

    }); */
    </script>
@endpush




                </div>

            </div>

            <div class="card-footer" style="">
                <button type="submit" class="btn btn-primary">SUBMIT</button>
                {{-- <a href="{{ route('incoming_documents_manager.index') }}" class="btn btn-default"> Cancel </a> --}}
            </div>

            </form>

        </div>
    </div>
@endsection
