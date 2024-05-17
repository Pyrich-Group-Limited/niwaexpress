<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="PGL">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="National Inland Waterways Authority, Self Service Portal (NIWA).">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dev/img/favicon.ico') }}">
    <!-- Page Title  -->
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('dev/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dev/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dev/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <div class="main-wrapper  account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form action="{{ route('saverecordofapplicant') }}" method="POST" class="form-signin">
                        @csrf
                        <div class="account-logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.png') }}"
                                    alt=""></a>
                        </div>
                        <div>
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
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="user_type">Select User Type<span
                                    class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control" id="user_type" name="user_type" required>
                                    <option value="company">Registered Company</option>
                                    <option value="private">Private</option>
                                    <option value="e-promota">e-Promota</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group " id="servicerow">
                            <label class="form-label" for="services">Select Services<span
                                    class="text-danger">*</span></label>
                            <div class="form-control-wrap">

                                <select class="form-control" id="service" multiple name="service_type[]">
                                    @foreach ($services as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group my-3" id="areaofficerow">
                            <label class="form-label" for="user_type">Select Area Office<span
                                    class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select multiple class="form-control" id="areaoffice" name="areaoffice[]">
                                    @foreach ($branches as $item)
                                        <option value="{{ $item->id }}">{{ $item->branch_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        {{-- <div class="row" id="forthepromoter">




                        </div> --}}


                        <div class="row">

                            <div class="form-group col-6">
                                <label class="form-label" for="contact_firstname">First
                                    Name <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="contact_firstname"
                                        name="contact_firstname" placeholder="First name" required>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label" for="contact_surname">Other
                                    Name <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="contact_surname"
                                        name="contact_surname" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-label" for="company_phone">Contact
                                    Phone <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="company_phone"
                                        name="company_phone" placeholder="Enter Contact Phone" required
                                        pattern="\d+">
                                    <span id="phone-error" class="text-danger"></span>
                                    <!-- Display error message here -->

                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label" for="company_email">Email
                                    Address <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input type="email" class="form-control" id="company_email"
                                        name="company_email" placeholder="Email Address" required>
                                    <span id="email-error" class="text-danger"></span>
                                    <!-- Display error message here -->
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-6">
                                <label class="form-label" for="cp1-card-number">Password <span
                                        class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <input type="password" minlength="8" maxlength="12" class="form-control"
                                            id="password" name="password" placeholder="********" required>
                                        <button type="button" class="toggle-password btn btn-outline-secondary"><i
                                                class="fa fa-eye-slash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label" for="password_confirmation">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <input type="password" minlength="8" maxlength="12" class="form-control"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="********" required>
                                        <button type="button" class="toggle-password btn btn-outline-secondary"><i
                                                class="fa fa-eye-slash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="checkbox" required> I have read and agree the Terms &
                                Conditions
                            </label>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success account-btn" name="status" value="1"
                                type="submit">Signup</button>
                        </div>
                        <div class="text-center login-link">
                            Already have an account? <a href="{{ route('login') }}">Login </a>
                        </div>
                        {{-- <div class="text-center login-link">
                            Already have an account? <a href="{{ route('promoterlogin') }}">Login As e-Promota</a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dev/js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('dev/js/popper.min.js') }}"></script>
    <script src="{{ asset('dev/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('dev/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            var type = $('#user_type')
            var row = $('#forthepromoter')
            var office = $('#areaoffice')
            var service = $('#service')
            var servicerow = $('#servicerow')
            var officerow = $('#areaofficerow')


            officerow.hide(1000)
            servicerow.hide(1000)
            office.val('')
            service.val('')
            // row.hide();
            office.select2()
            service.select2()

            type.on('change', function() {
                if (this.value == 'e-promota') {
                    // row.show(1000)
                    officerow.show(1000)
                    servicerow.show(2000)

                    // office.select2()
                    service.select2()
                } else {
                    officerow.hide(1000)
                    servicerow.hide(2000)
                    // row.hide(1000)
                    office.val('')
                    service.val('')
                }
            })
        });







        document.getElementById('company_email').addEventListener('blur', function() {
            var email = this.value.trim();
            var emailError = document.getElementById('email-error');

            // Clear previous error message
            emailError.textContent = '';

            // Check if email is empty
            if (email === '') {
                return;
            }

            // Perform AJAX request to check if email already exists
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/check-email?email=' + encodeURIComponent(email), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            emailError.textContent = 'Email already exists';
                        }
                    } else {
                        console.error('Request failed:', xhr.status, xhr.statusText);
                    }
                }
            };
            xhr.send();
        });
    </script>
    <script>
        document.getElementById('company_phone').addEventListener('blur', function() {
            var phone = this.value.trim();
            var phoneError = document.getElementById('phone-error');

            // Clear previous error message
            phoneError.textContent = '';

            // Check if email is empty
            if (phone === '') {
                return;
            }

            // Perform AJAX request to check if email already exists
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/check-phone?phone=' + encodeURIComponent(phone), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            phoneError.textContent = 'Phone number already exists';
                        }
                    } else {
                        console.error('Request failed:', xhr.status, xhr.statusText);
                    }
                }
            };
            xhr.send();
        });
    </script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                } else {
                    input.type = "password";
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                }
            });
        });
    </script>
</body>


<!-- register24:03-->
</html>
