<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - JobFair 2026</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex flex-col">

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center h-16 w-16 ">
                    <img src="{{ asset('template/LOGO USH NEW.png') }}" alt="" class="w-full h-full object-contain">
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Admin Panel
                </h2>
                <p class="text-slate-400">
                    Silakan masuk untuk mengelola sistem JobFair
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 border border-slate-200">
                @if($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                            <span class="text-sm font-medium text-red-800">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="pl-10 block w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Masukan Email Anda" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" name="password" id="password" class="pl-10 block w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Masukan Password Anda" required>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                        <label for="remember" class="ml-2 block text-sm text-slate-600">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Masuk ke Dashboard
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>

                </form>
            </div>

            <div class="mt-8 text-center text-sm text-slate-500">
                <p>&copy; 2026 JobFair Administrator. Secure Login.</p>
            </div>

        </div>
    </div>

</body>

</html>