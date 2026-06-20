<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perusahaan — JobFair</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2847 0%, #1e3a5f 50%, #0f766e 100%);
            display: flex; align-items: center; justify-content: center; padding: 1.5rem;
        }
        .card {
            background: white; border-radius: 16px; padding: 2.5rem;
            width: 100%; max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
        .logo-wrap { text-align: center; margin-bottom: 2rem; }
        .logo-wrap img { max-height: 56px; }
        h1 { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 0.25rem; text-align: center; }
        p.subtitle { font-size: 0.875rem; color: #64748b; text-align: center; margin-bottom: 2rem; }
        label { display: block; font-weight: 600; font-size: 0.875rem; color: #374151; margin-bottom: 0.4rem; }
        input {
            width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-family: 'Inter', sans-serif; font-size: 0.95rem; transition: border-color 0.2s;
            outline: none;
        }
        input:focus { border-color: #14b8a6; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15); }
        .form-group { margin-bottom: 1.25rem; }
        .btn-submit {
            width: 100%; padding: 0.8rem;
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            color: white; border: none; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer;
            transition: opacity 0.2s; margin-top: 0.5rem;
        }
        .btn-submit:hover { opacity: 0.9; }
        .alert-error {
            background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;
            padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.875rem; margin-bottom: 1.25rem;
        }
        .back-link { display: block; text-align: center; margin-top: 1.25rem; font-size: 0.85rem; color: #64748b; text-decoration: none; }
        .back-link:hover { color: #0f172a; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo-wrap">
            <img src="{{ asset('template/LOGO USH NEW.png') }}" alt="Logo">
        </div>
        <h1>Portal Perusahaan</h1>
        <p class="subtitle">Portal Login Perusahaan</p>

        @if(session('error'))
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('company.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="login_code">Kode Login Perusahaan</label>
                <input type="text" id="login_code" name="login_code" placeholder="Masukan Code Login" required autofocus autocomplete="off">
                @error('login_code')
                    <small style="color:#e11d48;margin-top:0.25rem;display:block;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukan Password" required>

                @error('password')
                    <small style="color:#e11d48;margin-top:0.25rem;display:block;">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk
            </button>
        </form>
        <a href="/" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke halaman utama</a>
    </div>
</body>
</html>
