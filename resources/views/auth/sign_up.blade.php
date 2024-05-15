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

</head>

<body>
    <div class="main-wrapper  account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form action="{{ route('register') }}" method="POST" class="form-signin">
                        @csrf
						<div class="account-logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a>
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
                            <label class="form-label" for="user_type">Select User Type<span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control" id="user_type"
                                    name="user_type" required>
                                    <option value="company">Registered Company</option>
                                    <option value="private">Private</option>
                                    <option value="e-promta">e-Prompta</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact_firstname">First
                                Name <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control"
                                    id="contact_firstname" name="contact_firstname"
                                    placeholder="First name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact_surname">Last
                                Name <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control"
                                    id="contact_surname" name="contact_surname"
                                    placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company_phone">Contact
                                Phone <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control"
                                    id="company_phone" name="company_phone"
                                    placeholder="Enter Contact Phone" required
                                    pattern="\d+">
                                <span id="phone-error" class="text-danger"></span>
                                <!-- Display error message here -->

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company_email">Email
                                Address <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control"
                                    id="company_email" name="company_email"
                                    placeholder="Email Address" required>
                                <span id="email-error" class="text-danger"></span>
                                <!-- Display error message here -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cp1-card-number">Password <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="password" minlength="8" maxlength="12" class="form-control" id="password" name="password" placeholder="********" required>
                                    <button type="button" class="toggle-password btn btn-outline-secondary"><i class="fa fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="password" minlength="8" maxlength="12" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********" required>
                                    <button type="button" class="toggle-password btn btn-outline-secondary"><i class="fa fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox" name="checkbox" required> I have read and agree the Terms & Conditions
                            </label>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success account-btn" type="submit">Signup</button>
                        </div>
                        <div class="text-center login-link">
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dev/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('dev/js/popper.min.js') }}"></script>
    <script src="{{ asset('dev/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dev/js/app.js') }}"></script>

    <script>
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