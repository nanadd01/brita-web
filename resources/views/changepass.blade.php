<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/uplon/layouts/vertical/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Feb 2023 09:15:50 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Log In | Uplon - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css"  id="app-stylesheet" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages pt-5 my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body p-4">
                                    
                                    <div class="text-center">
                                        <div class="my-3">
                                                <span><img width="100" src="{{asset('logoatn.png')}}" alt=""></span>
                                        </div>
                                        <h5 class="text-muted text-uppercase py-3 font-16">Perbarui Kata Sandi</h5>
                                    </div>
                                    @if (session('status'))
                                        <div class="alert alert-danger">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    <form action=""  method="POST" class="mt-2">
                                        @csrf
    
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="password" name="old_password" required placeholder="password lama">
                                        </div>
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="password"  name="new_password" id="password" placeholder="Password Baru">
                                        </div>
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="password"  name="repeat_password" id="password" placeholder="Konfirmasi Password">
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit"> Perbarui Kata Sandi </button>
                                        </div>

    
                                    </form>
    
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Belum Punya Akun? <a href="{{url('register')}}" class="text-white ml-1"><b>Daftar</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

<!-- Mirrored from coderthemes.com/uplon/layouts/vertical/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Feb 2023 09:15:50 GMT -->
</html>