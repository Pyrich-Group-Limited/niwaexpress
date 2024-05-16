<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Promota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

</head>

<body>

    <div class="container my-4  mx-5">
        <div class="brand-logo">
            <a href="#">
                <img class=" img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </a>
        </div>
        <h1 class="text-center">WELCOME <span
                class="text-center text-primary">{{ $user->first_name . ', ' . $user->other_name }}</span></h1>

        @if ($user->status > 1)

            <div class="container mx-5">

                {{-- <a href="#" class="btn btn-success float-end" data-toggle="modal"
                    data-target="#registerModal"> <i class="fa fa-plus bi bi-plus"></i></a> --}}
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Register Applicant
                </button>

                <table id="myTable" class="table data-table">
                    <thead>
                        <tr>
                            <th>Applicant Code</th>
                            <th>Applicant Type</th>
                            <th>Date Applied</th>
                            <th>Applicant Name</th>

                            <th>Applicant Email</th>
                            <th>Applicant Address</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($applicants as $item)
                        <tr>
                            {{-- @dd($item); --}}
                                <td>{{ $item->applicant_code }}</td>
                                <td>{{ $item->user_type }}</td>
                                <td>{{ date('l, d, Y', strtotime($item->created_at)) }}</td>

                                <td>{{ $item->company_name }}</td>
                                <td>{{ $item->company_email }}</td>
                                <td>{{ $item->company_address }}</td>
                                <td><a href="#" class="btn btn-secondary">View</a></td>
                            </tr>
                            @endforeach

                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form class=" form " method="POST" action="{{ route('thenewapplicant') }}">
                               @csrf
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registeration Of New Applicant
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Registration Form -->
                                    @csrf
                                    <div class="form-group">
                                        <select class=" form-control form-select" name="user_type" id="">
                                            <option value="private">Private User</option>
                                            <option value="company">Company</option>
                                        </select>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-6">
                                            <label for="name">Company Name</label>
                                            <input type="text" class="form-control" id="name"
                                                name="company_name" required placeholder="Enter Company Name">
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="address">Company Address</label>
                                            <input type="text" class="form-control" id="address"
                                                name="company_address" required placeholder="Enter address">
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="form-group col-6">
                                            <label for="company_phone">Company Phone Number</label>
                                            <input  type="tel" class="form-control" id="phone_number"
                                                name="company_phone" placeholder="Enter phone number">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phone_number">Company Email</label>
                                            <input type="email" class="form-control" id="phone_number"
                                                name="company_email" placeholder="Enter phone number">
                                        </div>
                                        <input type="hidden" value="{{ $user->promotercode }}" name="promotercode">

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="phone_number">Contact Surname</label>
                                            <input type="text" name="contact_surname" required class=" form-control">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phone_number">Contact First Name</label>
                                            <input type="text" name="contact_firstname" required
                                                class=" form-control">
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="phone_number">Contact Phone Number</label>
                                            <input type="tel" name="contact_number" required class=" form-control">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phone_number">Company Stae</label>
                                            {{-- <input type="password" name="company_state" required
                                                class=" form-control"> --}}
                                            <select class=" form-control form-select" name="company_state"
                                                id="">
                                                @foreach ($branches as $item)
                                                    <option value="{{ $item->id }}">{{ $item->branch_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="phone_number">Password</label>
                                            <input type="password" name="password" required class=" form-control">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phone_number">Confirm Password</label>
                                            <input type="password" name="password_confirmation" required
                                                class=" form-control">
                                        </div>
                                    </div>
                                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" value="1" name="status"
                                        class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <h4 class="text-success text-center">Your Account Has Not Yet Been Approved</h4>
        @endif

    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
