<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff6a6a, #ff9a9e);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .error-icon {
            font-size: 80px;
            color: #fff;
        }

        .btn-home {
            background-color: #fff;
            color: #ff6a6a;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-home:hover {
            background-color: #ffdadb;
        }
    </style>
</head>
<body>

    <div class="animate__animated animate__fadeInDown">
        <i class="fas fa-ban error-icon animate__animated animate__tada animate__delay-1s"></i>
        <h1 class="display-4 mt-4">403</h1>
        <p class="lead">Forbidden. Kamu tidak punya akses ke halaman ini.</p>
        <a href="{{ url('/') }}" class="btn btn-home mt-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>

</body>
</html>