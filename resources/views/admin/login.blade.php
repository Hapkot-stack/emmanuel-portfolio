<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Emmanuel Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="font-display font-bold text-3xl mb-2">
                <span class="text-blue-400">&lt;</span><span class="text-white">ET</span><span class="text-blue-400">/&gt;</span>
            </div>
            <p class="text-gray-400 text-sm">Admin Panel</p>
        </div>

        <div class="glass p-8">
            <h1 class="font-display font-bold text-xl text-white mb-6">Sign In</h1>

            @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-input" placeholder="admin@example.com">
                </div>
                <div>
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" required
                           class="form-input" placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-white/20 bg-dark-700 text-blue-500">
                    <label for="remember" class="text-sm text-gray-400">Remember me</label>
                </div>
                <button type="submit" class="btn-primary w-full justify-center mt-2">
                    Sign In to Admin Panel
                </button>
            </form>

            <div class="mt-6 pt-4 border-t border-white/5 text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-gray-300 transition-colors">← Back to Portfolio</a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-600 mt-4">Default: admin@emmanueltokpah.com / Admin@2025!</p>
    </div>

</body>
</html>
