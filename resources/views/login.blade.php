<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Login</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap-login-form.min.css" />
</head>

<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
            alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <!-- Form Login -->
          <form role="form" method="POST" action="{{ route('login') }}">
            @csrf
            <label>Email</label>
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">
            </div>
            <label>Kata Sandi</label>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Kata Sandi" aria-label="Password" aria-describedby="password-addon">
            </div>
            <div class="text-center">
              <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Masuk</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
</body>

</html>
