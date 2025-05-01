<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('/')}}backend-assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="{{asset('/')}}backend-assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
	<link href="{{asset('/')}}backend-assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="{{asset('/')}}backend-assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="{{asset('/')}}backend-assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="{{asset('/')}}backend-assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('/')}}backend-assets/css/pace.min.css" rel="stylesheet" />
	<script src="{{asset('/')}}backend-assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('/')}}backend-assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{asset('/')}}backend-assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('/')}}backend-assets/css/app.css" rel="stylesheet">
	<link href="{{asset('/')}}backend-assets/css/icons.css" rel="stylesheet">
	<link href="{{asset('/')}}backend-assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset('/')}}backend-assets/css/dark-theme.css" />
	<link rel="stylesheet" href="{{asset('/')}}backend-assets/css/semi-dark.css" />
	<link rel="stylesheet" href="{{asset('/')}}backend-assets/css/header-colors.css" />
	<link rel="stylesheet" href="{{asset('/')}}backend-assets/snackbar/dist/js-snackbar.css">

    <title>MetaStore - Register</title>
</head>
<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center" style="font-size: 30px;">
                            MetaStore
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="login-separater text-center mb-4"> 
                                        <span>SIGN UP WITH EMAIL</span>
                                        <hr/>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('register.store') }}">
                                            @csrf
                                            <!-- Name Field -->
                                            <div class="col-12">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="John Doe" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email Field -->
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmailAddress" placeholder="example@user.com" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Phone Field -->
                                            <div class="col-12">
                                                <label for="number" class="form-label">Phone</label>
                                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="number" placeholder="Enter your phone number" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Password Field -->
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password" class="form-control border-end-0 @error('password') is-invalid @enderror" id="inputChoosePassword" placeholder="Enter Password" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Confirm Password Field -->
                                            <div class="col-12">
                                                <label for="inputChoosePasswordConfirmation" class="form-label">Confirm Password</label>
                                                <div class="input-group" id="show_hide_password_confirmation">
                                                    <input type="password" name="password_confirmation" class="form-control border-end-0 @error('password_confirmation') is-invalid @enderror" id="inputChoosePasswordConfirmation" placeholder="Confirm Password" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Tenant Name Field -->
                                            <div class="col-12">
                                                <label for="tenant_name" class="form-label">Tenant Name</label>
                                                <input type="text" name="tenant_name" class="form-control @error('tenant_name') is-invalid @enderror" id="tenant_name" placeholder="Your Tenant Name" required>
                                                @error('tenant_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i class='bx bx-user'></i> Sign up</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('/') }}backend-assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('/') }}backend-assets/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}backend-assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('/') }}backend-assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('/') }}backend-assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function () {
            // Toggle Password Visibility for Password Field
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                togglePassword("#show_hide_password");
            });

            // Toggle Password Visibility for Confirm Password Field
            $("#show_hide_password_confirmation a").on('click', function (event) {
                event.preventDefault();
                togglePassword("#show_hide_password_confirmation");
            });

            function togglePassword(selector) {
                let input = $(selector + " input");
                let icon = $(selector + " i");
                if (input.attr("type") == "text") {
                    input.attr('type', 'password');
                    icon.addClass("bx-hide").removeClass("bx-show");
                } else {
                    input.attr('type', 'text');
                    icon.removeClass("bx-hide").addClass("bx-show");
                }
            }
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('/') }}backend-assets/js/app.js"></script>
</body>
</html>