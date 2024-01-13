<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="/img/student.png" type="image/x-icon">
    <title>FacultyScan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="FacultyScan" name="keywords">
    <meta content="FacultyScan" name="description">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax//libs/font-awesome/5.10.0//css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- /libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/tempusdominus//css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="/lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/uploadStyle.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>

    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    {{-- <small class="py-2"><i class="far fa-clock text-primary me-2"></i>Opening Hours: Mon - Tues : 6.00
                        am - 10.00 pm, Sunday Closed </small> --}}
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-end">
                <div class="position-relative d-inline-flex align-items-center bg-primary text-white top-shape px-5">
                    <div class="me-3 pe-3 border-end py-2">
                        <p class="m-0"><i class="fa fa-envelope-open me-2"></i>FacultyScan@gmail.com</p>
                    </div>
                    <div class="py-2">
                        <p class="m-0"><i class="fa fa-phone-alt me-2"></i>+012 345 6789</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="/" class="navbar-brand p-0">
            <h1 class="m-0 text-primary"><img src="/img/student.png" width="46px" height="46px" alt=""
                    srcset="">FacultyScan</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="/" class="nav-item nav-link">Home</a>
            </div>
            <a href="#" class="btn btn-primary py-2 px-4 ms-3" data-bs-target="#logoutModal"
                data-bs-toggle="modal">Logout</a>
        </div>
    </nav>
    <!-- Navbar End -->




    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">Sonogram Analysis</h5>
                        <h1 class="display-5 mb-0">Sonogram Results</h1>
                    </div>
                    <h3 class="display-12 mb-0">Pet Owner: </h3>
                    <h4 class="text-body fst mb-4">{{ $results['fullName'] }}</h4>
                    <h3 class="display-12 mb-0">Pet Name: </h3>
                    <h4 class="text-body fst mb-4">{{ $results['facultyName'] }}</h4>
                    <h3 class="display-12 mb-0">ToDos: </h3>
                    <h6 class="text-body fst mb-4">
                        @foreach ($todo as $item)
                            @if ($item == '')
                            @else
                                - {{ $item }}
                                <br>
                            @endif
                        @endforeach
                    </h6>
                    <div class="row g-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i><b>Pregnancy
                                    Stage:</b>
                                {{ $results['pregnancyStage'] }}</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i><b>Number of
                                    Fetus:</b>
                                {{ $results['numberOfFetus'] }}</h5>
                            @if ($results['healthStatus'] == 'Poor')
                            @else
                                <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i><b>Health
                                        Status:</b>
                                    {{ $results['healthStatus'] }}</h5>
                            @endif
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i><b>Approved
                                    By:</b>
                                {{ $results['approver'] }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                            src="{{ $results['imagePath'] }}" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <!-- About End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s"
        style="margin-top: -75px;">
        <div class="container pt-5">
            <div class="row g-5 pt-4">
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Quick Links</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="/userdashboard"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-light" href="/faculty"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Faculty</a>
                        <a class="text-light" href="/account"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Account</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Policies</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2"
                            href="https://www.termsandconditionsgenerator.com/live.php?token=1AWMHA6JxGsZYgUvZ0bLowsFtAgs34Hq"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Terms and Conditions</a>
                        <a class="text-light mb-2"
                            href="https://www.privacypolicygenerator.info/live.php?token=iavTXpkOxo2yxv1bM992g9ujDb9izow7"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Privacy Policy</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Get In Touch</h3>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>FacultyScan@gmail.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Follow Us</h3>
                    <div class="d-flex">
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i
                                class="fab fa-twitter fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i
                                class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i
                                class="fab fa-linkedin-in fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded" href="#"><i
                                class="fab fa-instagram fw-normal"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-light py-4" style="background: #051225;">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="/">FacultyScan</a>.
                        All Rights Reserved.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript /libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/wow/wow.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/waypoints/waypoints.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/lib/tempusdominus/js/moment.min.js"></script>
    <script src="/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/lib/twentytwenty/jquery.event.move.js"></script>
    <script src="/lib/twentytwenty/jquery.twentytwenty.js"></script>

    <!-- Template Javascript -->
    <script src="/js/main.js"></script>
    <div class="modal fade " id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signUpModalLabel">Signup</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/signup" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <center>
                                <div class="form-group">
                                    <input required class="form-control" type="text" name="firstName"
                                        id="fn" placeholder="First Name">
                                </div>
                                <br>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="middleName" id="mn"
                                        placeholder="Middle Name">
                                </div>
                                <br>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="lastName" id="ln"
                                        placeholder="Last Name">
                                </div>
                                <br>
                                <div class="form-group">
                                    <textarea required class="form-control" name="address" id="" cols="10" rows="3"
                                        placeholder="Address"></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="birthDate" class="for"
                                        style="float:left;margin-bottom: 10px;">Birth Date</label>
                                    <input required type="date" name="birthDate" id=""
                                        class="form-control">
                                </div>
                                <br>
                                <div class="form-group">
                                    <input required type="number" name="phoneNumber" id=""
                                        class="form-control" placeholder="Phone Number">
                                </div>
                                <br>
                                <div class="form-group">
                                    <input required class="form-control" type="email" name="email"
                                        id="un" placeholder="Email">
                                </div>
                                <br>
                                <div class="form-group">
                                    <input required class="form-control" type="password" name="password"
                                        id="pw" placeholder="Password">
                                </div>
                            </center>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btnSignup" value="yes">Signup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade " id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Sonogram</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/faculty" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <center>
                                <div class="form-group">
                                    <input required type="text" name="facultyName" id=""
                                        placeholder="Pet Name" class="form-control">
                                </div>
                                <div class="form-group" style="margin-top: 10px;">
                                    <button class="file-upload-btn" type="button"
                                        onclick="$('.file-upload-input').trigger( 'click' )">Add
                                        Image</button>

                                    <div class="image-upload-wrap">
                                        <input required class="file-upload-input" name="files" type='file'
                                            onchange="readURL(this);" accept="image/*" />
                                        <div class="drag-text">
                                            <h3>Drag and drop a file or select add Image</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="your image"
                                            width="100%" height="40%" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()"
                                                class="remove-image">Remove <span class="image-title">Uploaded
                                                    Image</span></button>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <p><b>Important Note:</b> To ensure accurate results for the sonogram analysis,
                                            we
                                            recommend a Shih Tzu's sonogram.
                                            Please note that using a different
                                            breed of pet may result in vague or inconclusive results. Thank you for your
                                            understanding and cooperation in helping us provide the best possible
                                            service.</p>
                                    </div>
                                </div>
                                <br>
                            </center>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btnLogin" value="yes">Proceed
                        Uploading</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div>
        <button hidden data-bs-target="#loadingModal" data-bs-toggle="modal" id="btnShowLoading"></button>
    </div>
    <div class="modal fade " id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <center>
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"> Loading... </span>
                            </div>
                        </center>

                    </div>
                </div>
                <div class="modal-footer">
                    <button style="opacity: 0;" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade " id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/signout" method="GET" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <center>
                                <div class="form-group">
                                    <h4>Are You Sure You Want To Logout ?</h4>
                                </div>
                            </center>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btnLogout" value="yes">Yes,
                        proceed</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>

    @if (session()->pull('errorMimeTypeInvalid'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Failed to add Sonogram, Invalid File Format, Please try accepted file format: .jpg, .png, .jpeg',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('errorMimeTypeInvalid') }}
    @endif

    @if (session()->pull('errorFileEmpty'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Uploaded file is empty, Please try again later',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('errorFileEmpty') }}
    @endif

    @if (session()->pull('errorDeleteSonogram'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Failed to delete Sonogram, Please try again later',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('errorDeleteSonogram') }}
    @endif

    @if (session()->pull('errorAddSonogram'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Failed to add Sonogram, Please try again later',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('errorAddSonogram') }}
    @endif

    @if (session()->pull('existEmail'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Email Already Exist, Please Try Again With New Email',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('existEmail') }}
    @endif

    @if (session()->pull('successDeleteSonogram'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully Deleted Sonogram',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('successDeleteSonogram') }}
    @endif

    @if (session()->pull('successAddSonogram'))
        <script>
            setTimeout(() => {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully Uploaded Sonogram',
                    showConfirmButton: false,
                    timer: 800
                });
            }, 500);
        </script>
        {{ session()->forget('successAddSonogram') }}
    @endif
    <script></script>
</body>

</html>
