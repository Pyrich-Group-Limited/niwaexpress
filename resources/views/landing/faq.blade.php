<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ get_settings()['company_name'] }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset(get_settings()['company_favicon']) }}" rel="icon">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">

    <style>
        section{
            min-height: 100vh
        }

        .accordion h1{
            text-align: center;
            font-size: 2rem;
            margin: 30px;
        }

        .navbar-nav a{
            font-size: 1.4rem;
            color: #392C70;
        }

        .navbar-nav .active{
            color: green;
            border-bottom: 3px solid green;
        }

        .navbar-nav a:hover{
            color: green;
        }

        .navy{
            box-shadow: .5rem 2px .5rem rgba(0, 0, 0, .5);
        }
        
        .accordion-item a:hover{
            color: white
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-light"><i
                            class="fa fa-map-marker-alt me-2"></i>{{ get_settings()['company_address'] . ' ' . get_settings()['company_city'] . ' ' . get_settings()['company_state'] }}</small>
                    <small class="me-3 text-light"><i
                            class="fa fa-phone-alt me-2"></i>{{ get_settings()['company_telephone'] }}</small>
                    <small class="text-light"><i
                            class="fa fa-envelope-open me-2"></i>{{ get_settings()['company_email'] }}</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-twitter fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-linkedin-in fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href=""><i
                            class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar & Carousel Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg px-5 py-3 py-lg-0 navy">
            <a href="{{ url('/') }}" class="navbar-brand p-3">
                <h1 class="m-0">
                    <img style="height: 8vh;" src="{{ asset('assets/images/logo.png') }}" alt="">
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-3">
                    <a href="{{ url('/') }}" class="nav-item nav-link  px-3"
                        onclick="scrollToSection('homeSection')">Home</a>
                    {{-- <a href="#" class="nav-item nav-link" onclick="scrollToSection('aboutSection')">About</a>
                    <a href="#" class="nav-item nav-link"
                        onclick="scrollToSection('servicesSection')">Services</a> --}}
                    <a href="#" class="nav-item nav-link px-3 active">FAQ's</a>
                    <a href="{{ route('login') }}" class="nav-item nav-link px-3">Login</a>
                </div>
                <a href="{{ route('register') }}" class="btn btn-primary py-2 px-4 ms-3">REGISTER</a>
                {{-- <a href="https://seaexpresstransit.com" target="_blank" class="btn btn-primary py-2 px-4 ms-3">Buy Ferry Ticket</a> --}}
                {{-- <a class="btn btn-primary py-2 px-4 ms-3" href="{{ route('promoterlogin') }}">e-Promota</a> --}}

            </div>
        </nav>
    </div>


    {{-- FAQ's --}}

    <section>
        <div class="container-faq">
            <div class="accordion">
                <h1>FREQUENTLY ASKED QUESTIONS</h1>
                <div class="accordion-item" id="question1">
                    <span class="accordion-link">
                        What is ENIWA
                        <i class="fa fa-plus"></i>
                    </span>
                    <div class="answer">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea rerum dolores vel temporibus enim, 
                            optio dolore iste sapiente sed architecto quos ab quae tempora ipsa autem perspiciatis magni voluptate beatae?
                        </p>
                    </div>
                </div>
    
                <div class="accordion-item" id="question2">
                    <span href="" class="accordion-link">
                        How do i get registered
                        <i class="fa fa-plus"></i>
                    </span>
                    <div class="answer">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea rerum dolores vel temporibus enim, 
                            optio dolore iste sapiente sed architecto quos ab quae tempora ipsa autem perspiciatis magni voluptate beatae?
                        </p>
                    </div>
                </div>
    
                <div class="accordion-item" id="question3">
                    <span class="accordion-link">
                        Where is the nearest branch
                        <i class="fa fa-plus"></i>
                    </span>
                    <div class="answer">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea rerum dolores vel temporibus enim, 
                            optio dolore iste sapiente sed architecto quos ab quae tempora ipsa autem perspiciatis magni voluptate beatae?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-4 col-md-6 footer-about">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center text-center h-100 bg-primary p-4">
                        <a href="#" class="navbar-brand">
                            <h1 class="m-0 text-white"><i class="fa fa-user-tie me-2"></i>E-NIWA</h1>
                        </a>
                        <p class="mt-3 mb-4">Experience the transformational power of NIWA. We are committed to
                            continuously enhancing your journey</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control border-white p-3" placeholder="Your Email">
                                <button class="btn btn-dark">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="row gx-5">
                        <div class="col-lg-4 col-md-12 pt-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Get In Touch</h3>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <p class="mb-0">
                                    {{ get_settings()['company_address'] . ' ' . get_settings()['company_city'] . ' ' . get_settings()['company_state'] }}
                                </p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-envelope-open text-primary me-2"></i>
                                <p class="mb-0">{{ get_settings()['company_email'] }}</p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-telephone text-primary me-2"></i>
                                <p class="mb-0">{{ get_settings()['company_telephone'] }}</p>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-primary btn-square" href="#"><i
                                        class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Quick Links</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                                <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                                <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                                {{-- <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Locate us</a> --}}
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Popular Links</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                <a class="text-light mb-2" href="{{ route('login') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Login</a>
                                <a class="text-light" href="{{ route('register') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Register</a>
                                <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                            </div>
                        </div> --}}
                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">FAQ's</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                {{-- <a class="text-light mb-2" href="{{ route('login') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Login</a>
                                <a class="text-light" href="{{ route('register') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Register</a> --}}
                                {{-- <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a> --}}
                                <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>FAQ's</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-white" style="background: #061429;">
        <div class="container text-center">
            <div class="row justify-content-end">
                <div class="col-lg-8 col-md-6">
                    <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                        <p class="mb-0">&copy; <a class="text-white border-bottom" href="#">NIWA</a>. All
                            Rights Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed by <a class="text-white border-bottom" href="#">P2E Technologies
                                Nigeria</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./lib/wow/wow.min.js"></script>
    <script src="./lib/easing/easing.min.js"></script>
    <script src="./lib/waypoints/waypoints.min.js"></script>
    <script src="./lib/counterup/counterup.min.js"></script>
    <script src="./lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="./js/main.js"></script>
    <!-- Include jQuery (you can download it or use a CDN) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

    <!-- Smooth Scroll Script -->
    <script>
        // Function to handle smooth scroll to the about section
        /* function scrollToAbout() {
            $('html, body').animate({
                scrollTop: $('#aboutSection').offset().top
            }, 1000); // Adjust the duration as needed
        }
        function scrollToServices() {
            $('html, body').animate({
                scrollTop: $('#servicesSection').offset().top
            }, 1000); // Adjust the duration as needed
        } */
        function scrollToSection(sectionId) {
            $('html, body').animate({
                scrollTop: $('#' + sectionId).offset().top
            }, 1000);

            // Remove 'active' class from all nav links
            $('.navbar-nav a').removeClass('active');
            // Add 'active' class to the clicked nav link
            $('.navbar-nav a[href="#' + sectionId + '"]').addClass('active');
        }
    </script>
    <script>
        const plus = document.querySelectorAll('.fa-plus')
        const a = document.querySelectorAll('.answer')
        const q = document.querySelectorAll('.accordion-link')


        for(let i=0; i < q.length; i++){
            q[i].addEventListener('click', () => {
                a[i].classList.toggle('opened');
                plus[i].classList.toggle('plus');
            })
        };
    </script>
</body>

</html>
