<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FARMS 2.0</title>
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

        .auth-container {
            width: 100%;
            max-width: 500px;
            padding: 3rem;
            background: rgba(0, 0, 0, 0.7);
            -webkit-backdrop-filter: blur(8px);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            color: #fff;
            animation: fadeIn 0.8s ease-in-out;
        }

        .auth-container .logo, .auth-container .lead {
            text-align: center;
        }
        
        .auth-container .logo {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .auth-container .lead {
            font-size: 1rem;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .auth-container .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .auth-container .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
        }

        .auth-container .form-control::placeholder {
            color: #adb5bd;
        }

        .auth-container a {
            color: #6ea8fe;
        }

        @keyframes fadeIn {
          from { opacity: 0; transform: scale(0.95); }
          to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="<?= (isset($_COOKIE['farms_theme']) && $_COOKIE['farms_theme'] == 'dark') ? 'dark-mode' : '' ?>">
    <div class="auth-container">
        <div class="logo">
            <i class="fas fa-tractor"></i> FARMS 2.0
        </div>
        <p class="lead">Buat akun baru untuk mulai mengelola pertanian Anda.</p>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/register/save') ?>" method="post" class="text-start">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Pilih username unik" value="<?= old('username') ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="mb-4">
                <label for="pass_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" placeholder="Ulangi password Anda" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
            <p class="text-center mt-4">Sudah punya akun? <a href="<?= base_url('/login') ?>">Login di sini</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>