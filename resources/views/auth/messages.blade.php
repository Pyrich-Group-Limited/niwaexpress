{{-- <div class="offset-lg-4 col-lg-4 offset-sm-1 col-sm-10 my-4"> --}}
    @if (session('success'))
        <div class="example-alert">
            <div class="alert alert-primary alert-icon alert-dismissible">
                <em class="icon ni ni-alert-circle"></em>
                <strong>Success:</strong>
                <span>{{ session('success') }}</span>
                <button class="close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @elseif (session('info'))
        <div class="example-alert">
            <div class="alert alert-info alert-icon alert-dismissible">
                <em class="icon ni ni-alert-circle"></em>
                <strong>Info:</strong>
                <span>{{ session('info') }}</span>
                <button class="close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @elseif (session('warning'))
        <div class="example-alert">
            <div class="alert alert-warning alert-icon alert-dismissible">
                <em class="icon ni ni-alert-circle"></em>
                <strong>Warning:</strong>
                <span>{{ session('warning') }}</span>
                <button class="close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @elseif (session('error'))
        <div class="example-alert">
            <div class="alert alert-danger alert-icon alert-dismissible">
                <em class="icon ni ni-alert-circle"></em>
                <strong>Error:</strong>
                <span>{{ session('error') }}</span>
                <button class="close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="example-alert">
            <div class="alert alert-danger alert-icon alert-dismissible">
                <em class="icon ni ni-alert-circle"></em>
                <strong>Error:</strong>
                <p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </p>
                <button class="close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
{{-- </div> --}}