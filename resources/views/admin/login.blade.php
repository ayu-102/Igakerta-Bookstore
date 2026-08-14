<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Igakerta Bookstore</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #1E0A3C;
            --primary-hover: #2D1058;
            --accent-color: #FFC700;
            --accent-hover: #E6B200;
            --violet-color: #6B21A8;
            --bg-body: #F4F5F9;
            --card-bg: #FFFFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-lg: 0 20px 40px rgba(15, 5, 30, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1E0A3C 0%, #11052C 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            padding: 45px 35px;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: rgba(30, 10, 60, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 1.6rem;
            border: 1px solid var(--border-color);
        }

        .login-card h2 {
            color: var(--primary-color);
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .login-card p {
            color: var(--text-muted);
            font-size: 0.88rem;
            margin-bottom: 28px;
            font-weight: 500;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 0.95rem;
            transition: color 0.25s ease;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            background-color: #FAFAFA;
            color: var(--text-main);
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--violet-color);
            background-color: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
        }

        .form-control:focus+i {
            color: var(--violet-color);
        }

        .btn-login {
            width: 100%;
            background: var(--primary-color);
            color: #FFFFFF;
            font-weight: 700;
            padding: 13px;
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-size: 0.95rem;
            margin-top: 8px;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(30, 10, 60, 0.25);
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .alert-error {
            background: #FEE2E2;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid #FCA5A5;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="brand-icon">
            <i class="fa-solid fa-user-shield"></i>
        </div>

        <h2>Login Admin</h2>
        <p>Masuk untuk mengelola katalog & toko</p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Admin</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-control" placeholder="admin@igakerta.com"
                        value="{{ old('email') }}" required autofocus autocomplete="off">
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Dashboard
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Website
        </a>
    </div>

</body>

</html>
