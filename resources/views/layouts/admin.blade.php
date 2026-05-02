<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <style>
        h1, h2, h3, h4, .heading-text { letter-spacing: .055em; font-weight: 700; }
        h1, h2, h3 { color: #ffb07a; text-shadow: 0 0 14px rgba(255,102,0,.15); }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen" style="font-family:'Mona Sans','Segoe UI',sans-serif;font-optical-sizing:auto;font-variation-settings:'wdth' 100;">
<div class="min-h-screen flex">
    <aside class="w-72 bg-slate-900 border-r border-cyan-500/20 p-5">
        <h1 class="text-2xl font-bold text-cyan-400 mb-6">HilDes Admin</h1>
        <nav class="space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Dashboard</a>
            <a href="{{ route('admin.contact-settings.index') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Contact Settings</a>
            <a href="{{ route('admin.jobs.index') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Careers / Jobs</a>
            <a href="{{ route('admin.applications.index') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Applications</a>
            <a href="{{ route('admin.notifications.index') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Notifications</a>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">Users</a>
            <a href="{{ route('admin.profile.edit') }}" class="block px-3 py-2 rounded bg-slate-800 hover:bg-slate-700">My Profile</a>
        </nav>
    </aside>

    <main class="flex-1 p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <p class="text-slate-400 text-sm">Information Technology Services</p>
                <h2 class="text-2xl font-semibold">{{ $title ?? 'Dashboard' }}</h2>
            </div>
            <div class="flex gap-3 items-center">
                <button id="themeToggle" class="px-3 py-2 bg-cyan-600 rounded text-sm">Toggle Theme</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-3 py-2 bg-rose-600 rounded text-sm">Logout</button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-4 rounded border border-emerald-400/40 bg-emerald-400/10 p-3 text-emerald-300">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded border border-rose-400/40 bg-rose-400/10 p-3 text-rose-300">{{ $errors->first() }}</div>
        @endif

        {{ $slot }}
    </main>
</div>
<script>
    const key = 'hildes-theme';
    const html = document.documentElement;
    if (localStorage.getItem(key) === 'light') html.classList.remove('dark');
    document.getElementById('themeToggle').addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem(key, html.classList.contains('dark') ? 'dark' : 'light');
    });
</script>
</body>
</html>
