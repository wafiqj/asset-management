<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Asset Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FFCC00 0%, #E6B800 50%, #D4A700 100%);
            font-family: 'Inter', system-ui, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            border-top: 5px solid #D40511;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo i {
            font-size: 3rem;
            color: #D40511;
        }
        .login-logo h4 {
            margin-top: 0.5rem;
            color: #333333;
            font-weight: 700;
        }
        .login-logo p {
            color: #666;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 2px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255,204,0,0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, #D40511 0%, #B00410 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #B00410 0%, #900310 100%);
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-box-seam"></i>
            <h4>Asset Management</h4>
            <p class="text-muted">IT Infrastructure Team</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>