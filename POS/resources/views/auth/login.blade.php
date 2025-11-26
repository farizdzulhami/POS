<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | POSLite</title>

  <!-- Fonts -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    crossorigin="anonymous"
  />

  <!-- Bootstrap & Icons -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  />

  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

  <style>
    body {
      background-color: #343a40;
      font-family: 'Source Sans 3', sans-serif;
    }

    .login-box {
      width: 380px;
    }

    .card {
      background-color: #f8f9fa;
      border-radius: 12px;
      border: none;
    }

    .card-header {
      background: transparent;
      border-bottom: none;
    }

    .card-header i {
      font-size: 3rem;
      color: #0d6efd;
      margin-bottom: 8px;
    }

    .card-header h1 {
      color: #212529;
      font-weight: 700;
    }

    .login-box-msg {
      color: #6c757d;
    }

    .form-floating label {
      color: #6c757d;
    }

    .input-group-text {
      background-color: #f1f3f5;
      border: 1px solid #ced4da;
    }

    .form-control {
      border: 1px solid #ced4da;
      background-color: #ffffff;
      color: #212529;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: none;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }

    a.text-decoration-none {
      color: #0d6efd;
    }

    a.text-decoration-none:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body class="login-page d-flex align-items-center justify-content-center vh-100">
  <div class="login-box">
    <div class="card shadow-lg">
      <div class="card-header text-center">
        <i class="bi bi-cart-check"></i>
        <h1 class="mb-0"><b>POS</b>Lite</h1>
      </div>

      <div class="card-body">
        <p class="login-box-msg">Sign in to start managing</p>

        <!-- LOGIN FORM -->
        <form action="{{ route('login.post') }}" method="POST">
          @csrf

          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="Email"
              />
              <label for="email">Email</label>
            </div>
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          </div>

          <div class="input-group mb-3">
            <div class="form-floating flex-grow-1">
              <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                placeholder="Password"
              />
              <label for="password">Password</label>
            </div>
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          </div>

          @if($errors->any())
            <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
          @endif

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Log In</button>
          </div>
        </form>

        <p class="mt-3 mb-0 text-center">
          Don't have an account?
          <a href="/register" class="text-decoration-none fw-semibold">Register</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>
