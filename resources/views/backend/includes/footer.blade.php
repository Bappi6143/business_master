
  <!-- CSS Files -->
  <style>
    .chat-box-btn {
      position: fixed;
      bottom: 25px;
      right: 25px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      padding: 12px;
      z-index: 9999;
      transition: all 0.3s ease;
    }

    .chat-box-btn:hover {
      transform: scale(1.05);
    }

    .chat-icon-img {
      width: 32px;
      height: 32px;
    }
  </style>
<footer class="page-footer">
    <p class="mb-0">Copyright © 2025. All right reserved.</p>
</footer>
</div>
<!--end wrapper-->
<a  class="chat-box-btn" target="_blank" title="Chat with us on Messenger">
  <img src="{{ asset('backend-assets/images/avatars/chat.png') }}" class="chat-icon-img" alt="Chat">
</a>
<!--start switcher-->
<div class="switcher-wrapper">
<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
</div>
<div class="switcher-body">
    <div class="d-flex align-items-center">
        <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
        <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
    </div>
    <hr/>
    <h6 class="mb-0">Theme Styles</h6>
    <hr/>
    <div class="d-flex align-items-center justify-content-between">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
            <label class="form-check-label" for="lightmode">Light</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
            <label class="form-check-label" for="darkmode">Dark</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
            <label class="form-check-label" for="semidark">Semi Dark</label>
        </div>
    </div>
    <hr/>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
        <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
    </div>
    <hr/>
    <h6 class="mb-0">Header Colors</h6>
    <hr/>
    <div class="header-colors-indigators">
        <div class="row row-cols-auto g-3">
            <div class="col">
                <div class="indigator headercolor1" id="headercolor1"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor2" id="headercolor2"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor3" id="headercolor3"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor4" id="headercolor4"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor5" id="headercolor5"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor6" id="headercolor6"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor7" id="headercolor7"></div>
            </div>
            <div class="col">
                <div class="indigator headercolor8" id="headercolor8"></div>
            </div>
        </div>
    </div>
    <hr/>
    <h6 class="mb-0">Sidebar Colors</h6>
    <hr/>
    <div class="header-colors-indigators">
        <div class="row row-cols-auto g-3">
            <div class="col">
                <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
            </div>
            <div class="col">
                <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
            </div>
        </div>
    </div>
</div>
</div>
<!--end switcher-->


<!-- Bootstrap JS -->
<script src="{{asset('/')}}backend-assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="{{asset('/')}}backend-assets/js/jquery.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/')}}backend-assets/js/index.js"></script>
<script src="{{asset('/')}}backend-assets/js/parsley.min.js"></script>
<script src="{{asset('/')}}backend-assets/snackbar/dist/js-snackbar.js"></script>
<script src="{{asset('/')}}backend-assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
	
<!--app JS-->
<script src="{{asset('/')}}backend-assets/js/app.js"></script>

<script>
    $(document).ready(function() {
        $("#menu").metisMenu();
    });
</script>
<script>
    $(document).ready(function() {
        $('.toggle-icon').on('click', function() {
            $('.sidebar-wrapper').toggleClass('collapsed'); // Add/remove collapsed class
            $('.toggle-icon i').toggleClass('bx-arrow-to-left bx-arrow-to-right'); // Toggle icon direction
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#image-uploadify').imageuploadify();
    })
</script>
<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#formSubmit').on('submit', function (e) {
            e.preventDefault();
            if ($(this).parsley().validate()) {
                var formData = new FormData(this);

                // Show loading spinner inside the button
                $('#submitButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json', // Ensures the response is treated as JSON
                    success: function (result) {
                        console.log(result);

                        // Re-enable button and restore original text
                        $('#submitButton').html('Save Changes').prop('disabled', false);

                        if (result.status === 200 || result.status === 'Success') {
                            alert(result.message); // Show success message
                        } else {
                            alert('An unexpected error occurred.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON);
                        alert(xhr.responseJSON.message); // Show validation error message

                        // Re-enable button on error
                        $('#submitButton').html('Save Changes').prop('disabled', false);
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(() =>{
        $("#photo").change(function () {
            const file = this.files[0];
            if(file){
                let reader = new FileReader();
                reader.onload = function (event) {
                    $('#imgPreview').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>


//data table
<script>
    $(document).ready(function() {
        $('#example').DataTable();
      } );
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
</script>

