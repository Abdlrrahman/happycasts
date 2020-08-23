<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>HappyCasts - Login</title>

    <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/thesaas.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
  </head>

  <body class="mh-fullscreen bg-img center-vh p-20" style="background-image: url(assets/img/bg-girl.jpg);">




    <div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
      <h5 class="text-uppercase text-center">Login</h5>
      <br><br>

      <form class="form-type-material" action="/login" method="post">
          {{ csrf_field() }}
 @if ($errors->has('email') || $errors->has('password'))
                                    <ul class="alert alert-danger">
                                       <p>{{ $errors->first('email') }}</p>
                                    </ul>
                                @endif
        <div class="form-group">
          <input type="email" class="form-control" placeholder="Email address" name="email">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="password">
        </div>

        <br>
        <button class="btn btn-bold btn-block btn-primary" type="submit">Login</button>
      </form>

      <hr class="w-30">

      <p class="text-center text-muted fs-13 mt-20">No account yet? <a href="/register">Register</a></p>
    </div>


 <!-- Scripts -->
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/thesaas.min.js"></script>
    <script src="assets/js/script.js"></script>

  </body>
</html>