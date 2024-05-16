@extends('auth.auth')

@section('title', 'Login')

@section('content')

    <div class="row flex-grow">
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
                <div class="brand-logo">
                    <a href="{{ route('landing') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    </a>
                </div>
                <h4>Welcome e-Promota Portal!</h4>
                <h6 class="font-weight-light">Happy to see you again!</h6>
                @include('auth.messages')
                <form class="pt-3" method="POST" action="{{ route('loginprom') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail"> Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fa fa-user text-primary"></i>
                                </span>
                            </div>
                            <input type="email"
                                class="form-control form-control-lg border-left-0 @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Enter email" required autocomplete="username"
                                autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="fa fa-lock text-primary"></i>
                                </span>
                            </div>
                            <input type="password"
                                class="form-control form-control-lg border-left-0 @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter your password" required
                                autocomplete="current-password">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0">
                                    <i class="fa fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            {{-- <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input">
                Keep me signed in
            </label> --}}
                        </div>
                        @if (Route::has('password.request'))
                            <a href="#" class="auth-link text-black">Forgot password?</a>
                        @endif
                    </div>
                    <div class="my-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                    </div>
                    {{-- <div class="mb-2 d-flex">
        <button type="button" class="btn btn-facebook auth-form-btn flex-grow mr-1">
            <i class="fab fa-facebook-f mr-2"></i>Facebook
        </button>
        <button type="button" class="btn btn-google auth-form-btn flex-grow ml-1">
            <i class="fab fa-google mr-2"></i>Google
        </button>
    </div> --}}
                    <div class="text-center mt-4 font-weight-light">
                        Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy;
                <?php echo date('Y'); ?> All rights reserved.</p>
        </div>
    </div>



    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye icon
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
