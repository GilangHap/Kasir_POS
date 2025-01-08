<!-- filepath: /c:/laragon/www/POS-Kasir/resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .blur {
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body style="background-image: url('img/kasirbg.jpg'); background-size: cover;">
    <div class="d-flex min-vh-100 justify-content-center align-items-center">
        <div class="blur shadow-lg text-center rounded-3 p-5">
            <div class="card-body">
                <h1 class="card-title display-4 mb-4 fw-bold text-white">Kasirin</h1>
                <p class="card-text mb-4 text-white">Selamat datang di sistem kasir</p>
                <a href="{{ url('/admin/login') }}" class="btn btn-light btn-lg">
                    Login Admin
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>