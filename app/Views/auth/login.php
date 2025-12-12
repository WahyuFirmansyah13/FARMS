<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FARMS 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/custom.css?v=4.0') ?>">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('<?= base_url('assets/img/bg.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            animation: fadeIn 0.8s ease-in-out;
            background: rgba(0, 0, 0, 0.6);
            -webkit-backdrop-filter: blur(8px);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-box {
            display: flex;
            flex-wrap: wrap;
        }

        .login-left {
            flex: 1;
            min-width: 300px;
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-left .brand-logo .fa-tractor {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .login-left h1 {
            font-weight: 700;
            font-size: 2.5rem;
        }

        .login-right {
            flex: 1;
            min-width: 300px;
            padding: 4rem;
            color: #fff;
        }

        .login-right h2 {
            font-weight: 700;
            font-size: 2.2rem;
            color: #fff;
        }

        .login-right p.text-muted {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #adb5bd !important;
        }

        .login-right .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .login-right .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .login-right .form-control::placeholder {
            color: #adb5bd;
        }
        
        .btn-primary {
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-right a {
            color: #6ea8fe;
        }

        @keyframes fadeIn {
          from { opacity: 0; transform: scale(0.95); }
          to { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 768px) {
            .login-left, .login-right {
                padding: 2.5rem;
                flex-basis: 100%;
                border-right: none;
            }
            .login-left {
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
    </style>
</head>
<body class="<?= (isset($_COOKIE['farms_theme']) && $_COOKIE['farms_theme'] == 'dark') ? 'dark-mode' : '' ?>">
    
    <div class="login-wrapper">
        <div class="login-box">
            <div class="login-left">
                <div class="brand-logo">
                    <i class="fas fa-tractor"></i>
                    <h1>FARMS 2.0</h1>
                </div>
                <p class="lead mt-3">Sistem Manajemen Pertanian Modern untuk Masa Depan yang Lebih Hijau.</p>
            </div>
            <div class="login-right">
                <h2 class="text-center mb-2">Selamat Datang!</h2>
                <p class="text-center text-muted mb-4">Silakan masukkan detail Anda untuk melanjutkan.</p>

                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-warning"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    <p class="text-center mt-4">Belum punya akun? <a href="<?= base_url('/register') ?>">Daftar di sini</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>