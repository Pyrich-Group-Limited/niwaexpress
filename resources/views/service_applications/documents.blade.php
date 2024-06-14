@extends('layouts.app')

@section('title', 'Service Applications')


@push('styles')
@endpush


@section('content')
<style>
    .progress-wrapper {
        width: 100%;
        height: 20px;
        margin-top: 10px;
        background-color: #f5f5f5;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        width: 0%;
        height: 100%;
        background-color: #007bff;
    }
</style>

    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
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
        <div class="row g-gs">
            <div class="col-xxl-6 col-sm-12">
                <div class="card h-100">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            @if ($errors->any())
                                @foreach ($errors as $error)
                                    <small class="text-danger">{{ $error }}</small>
                                @endforeach
                            @endif
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">New Document</h6>
                                </div>
                            </div>
                            <div class="data">
                                <div class="data-group">
                                    <div class="form-group w-100">
                                        <form id="uploadForm" method="POST" action="{{ route('service-applications.documents.store', $service_application->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="row col-12">
                                                    <div class="mt-5 col-sm-12">
                                                        <label class="form-label" for="default-06">Upload Documents</label>
                                                    </div>
                                                    <?php $n = 1; ?>
                                                    @foreach($doc_uploads as $doc_upload)
                                                    <div class="col-sm-6">
                                                        <label for="title_document">{{ $doc_upload->name }}:</label>
                                                        <p style="color: red">Allowed file upload format are images, .pdf, .doc, .docx</p>
                                                        <div class="form-control-wrap">
                                                            <div class="form-file">
                                                                <input type="hidden" name="title_document[]" value="{{ $doc_upload->name }}" />
                                                                <!-- Notice the [] here -->
                                                                <input type="file" class="form-file-input" id="document_{{ $n++ }}" name="title_document_file[]" required accept="image/*,.pdf,.doc,.docx">
                                                                <label class="form-file-label" for="document_{{ $n++ }}">Choose file</label>
                                                                <!-- Use loop index for unique IDs -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-md-12">
                                                        <div class="col-sm-3">
                                                            <button id="submitBtn" type="submit" class="mt-5 btn btn-secondary btn-lg mt-2">
                                                                <em class="icon ni ni-save me-2"></em>Submit
                                                            </button>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </form>

                                        <div id="progressWrapper" class="progress-wrapper" style="display: none;">
                                            <div id="progressBar" class="progress-bar"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->
            {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
            <script>
               document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();
    document.getElementById('loader').style.display = 'block';
    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    var progressBar = document.getElementById("progressBar");
    var progressWrapper = document.getElementById("progressWrapper");
    progressBar.style.width = "0%";
    progressWrapper.style.display = "block";
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // On Success
            progressWrapper.style.display = "none";
            console.log(xhr.responseText);
            //location.reload(); // Reload the page
            // Redirect to service-applications route page
            window.location.href = "{{ route('service-applications.index') }}";
        }
    };
    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var percentage = (event.loaded / event.total) * 100;
            progressBar.style.width = percentage + "%";
        }
    };
    xhr.open("POST", "{{ route('service-applications.documents.store', $service_application->id) }}", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(formData);
});

            </script>

            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Documents</h3>
                <div class="nk-block-des text-soft">
                    <p>List of Documents.</p>
                </div>
            </div>
        </div><!-- .row -->

        @include('service_applications.documents_table')

    </div> <!-- nk-block -->

    {{-- </div><!-- .components-preview --> --}}
@endsection
