<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | MetaSoftBD</title>
  <link href="{{ asset('/') }}backend-assets/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
  <style>
    * {
      box-sizing: border-box;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      height: 100%;
      background: #f8f9fa;
    }

    .container-login {
      min-height: 100vh;
    }

    .left-panel {
      background: linear-gradient(45deg, #1789B3, #6A89A7);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
    }

    .carousel-inner,
    .carousel-item,
    .left-panel img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 20px;
    }

    .overlay-info {
      position: absolute;
      top: 4%;
      width: 100%;
      text-align: center;
      color: rgba(243, 240, 240, 0.815);
      font-size: 19px;
      font-weight: 500;
      z-index: 2;
    }

    .badge-tag {
      position: absolute;
      background-color: #194c45;
      color: white;
      padding: 10px 15px;
      border-radius: 10px;
      font-size: 14px;
      z-index: 2;
    }

    .badge-views {
      top: 18%;
      left: 12%;
    }

    .badge-inventory {
      bottom: 10%;
      right: 10%;
    }

    .right-panel {
      padding: 3rem 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #fff;
    }

    .form-box {
      width: 100%;
      max-width: 400px;
    }

    .form-box h1 {
      font-size: 26px;
      font-weight: 700;
      color: #0b2c4d;
      margin-bottom: 5px;
    }

    .form-box p.version {
      color: #6c757d;
      margin-bottom: 30px;
    }

    .form-box h2 {
      font-size: 22px;
      margin-bottom: 1rem;
    }

    .form-control {
      height: 45px;
    }

    .btn-login {
      background-color: #1789B3;
      color: white;
      padding: 0.7rem;
      width: 100%;
      border: none;
      font-weight: 500;
    }

    .btn-login:hover {
      background-color: #1789b3a4;
    }

    .divider {
      text-align: center;
      margin: 20px 0;
      color: #6c757d;
    }

    .divider::before,
    .divider::after {
      content: "";
      display: inline-block;
      width: 30px;
      height: 1px;
      background-color: #ccc;
      margin: 0 10px;
      vertical-align: middle;
    }

    @media (max-width: 767.98px) {
      .left-panel {
        order: 2;
        height: 250px;
        padding: 1rem;
      }

      .overlay-info,
      .badge-tag {
        font-size: 12px;
        padding: 6px 10px;
      }

      .right-panel {
        padding: 2rem 1rem;
        order: 1;
      }

      .carousel-inner,
      .carousel-item,
      .left-panel img {
        border-radius: 10px;
      }
    }

    @media (max-width: 575.98px) {
      .overlay-info {
        display: none;
      }

      .badge-tag {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid container-login">
    <div class="row g-0 h-100">
      <!-- Left: Image Slider -->
      <div class="col-md-6 left-panel">
        <div class="overlay-info">
          Manage all in one dashboard by<br />single hand at MetaSoft
        </div>

        <div class="badge-tag badge-views">
          <strong>Total 700 Views</strong><br />Most Clicked Product
        </div>

        <div class="badge-tag badge-inventory">
          <strong>✔ Full Automation</strong>
        </div>

        <div id="loginSlider" class="carousel slide" data-bs-ride="carousel" style="height: 80%; width: 80%;">
          <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
              <img src="{{ asset('backend-assets/images/login-images/slide1.jpg') }}" alt="Slide 1" />
            </div>
            <div class="carousel-item h-100">
              <img src="{{ asset('backend-assets/images/login-images/slide2.jpg') }}" alt="Slide 2" />
            </div>
            <div class="carousel-item h-100">
              <img src="{{ asset('backend-assets/images/login-images/slide3.jpg') }}" alt="Slide 3" />
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Login Form -->
      <div class="col-md-6 right-panel">
        <div class="form-box">
          <h1 class="text-primary">Meta Business Automation</h1>
          <p class="version">Version 2.00</p>
          <h2><span class="text-primary">Login</span> to <strong>Continue</strong></h2>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Password" required />
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <div class="mb-3 text-end">
              <a href="#" class="text-muted small">Forgot your password?</a>
            </div>
            <div class="divider">OR</div>
            <div class="text-center">
              Don’t have an account? <a href="{{ route('register') }}" class="text-danger">Contact Us</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('/') }}backend-assets/js/bootstrap.bundle.min.js"></script>
  <script>
    const carousel = document.querySelector('#loginSlider');
    if (carousel) {
      new bootstrap.Carousel(carousel, {
        interval: 5000,
        ride: 'carousel'
      });
    }
  </script>
</body>

</html>
