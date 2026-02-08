<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Dark mode persistence
        (function () {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = saved ? saved === 'dark' : prefersDark;
            if (isDark) document.documentElement.classList.add('dark');
        })();

        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }
    </script>

    {{-- Animations (light & pro) --}}
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-6px); }
        }
        @keyframes glow {
            0%,100% { opacity: .30; transform: translate(-50%, -50%) scale(1); }
            50%     { opacity: .55; transform: translate(-50%, -50%) scale(1.08); }
        }
        .card-animate {
            animation: fadeUp .65s ease-out both, floaty 6s ease-in-out infinite;
            animation-delay: .05s, .7s;
        }
        .glow-blob {
            position: absolute;
            left: 50%;
            top: 45%;
            width: 520px;
            height: 520px;
            border-radius: 9999px;
            filter: blur(55px);
            opacity: .45;
            animation: glow 6s ease-in-out infinite;
            pointer-events: none;
        }
        .input-anim {
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .input-anim:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(59,130,246,.18);
        }
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -120%;
            width: 60%;
            height: 200%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,.35), transparent);
            transform: rotate(20deg);
            transition: left .6s ease;
        }
        .btn-shine:hover::after { left: 130%; }

        @keyframes pulseSoft {
            0%,100% { transform: scale(1); }
            50%     { transform: scale(1.03); }
        }
        .logo-pulse { animation: pulseSoft 2.8s ease-in-out infinite; }

        @media (prefers-reduced-motion: reduce) {
            .card-animate, .logo-pulse, .glow-blob { animation: none !important; }
            .input-anim, .btn-shine::after { transition: none !important; }
        }
    </style>
</head>

<body class="h-full min-h-screen">
    {{-- Background image --}}
    <div class="fixed inset-0 bg-cover bg-center"
         style="background-image:url('{{ asset('images/login-bg.jpg') }}')"></div>

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50 dark:bg-black/70"></div>

    {{-- Content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">

        {{-- Glow blob (behind card) --}}
        <div class="glow-blob bg-gradient-to-tr from-blue-500/60 via-indigo-500/40 to-cyan-400/40"></div>

        <div class="w-full max-w-md">
            {{-- Top bar --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2 text-white">
                    <div class="h-10 w-10 rounded-full bg-white/15 backdrop-blur flex items-center justify-center font-extrabold logo-pulse">
                        MF
                    </div>
                    <div class="leading-tight">
                        <div class="font-bold">Ministère des Finances</div>
                        <div class="text-xs text-white/80">Gestion des pannes</div>
                    </div>
                </div>

                <button type="button" onclick="toggleTheme()"
                        class="inline-flex items-center gap-2 rounded-xl bg-white/15 hover:bg-white/20
                               text-white px-3 py-2 text-sm backdrop-blur transition duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    Dark
                </button>
            </div>

            {{-- Card --}}
            <div class="card-animate rounded-2xl bg-white/95 dark:bg-gray-900/95 backdrop-blur shadow-2xl border border-white/30 dark:border-gray-700">
                <div class="p-7 sm:p-8">
                    <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Créer un compte</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Inscrivez-vous pour accéder à votre espace.</p>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Nom</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m8-10a4 4 0 100-8 4 4 0 000 8z"/>
                                    </svg>
                                </span>
                                <input type="text" name="name" required
                                       value="{{ old('name') }}"
                                       class="input-anim w-full rounded-xl border-gray-300 dark:border-gray-700
                                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                              pl-10 pr-4 py-2.5
                                              focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l9 6 9-6M4 6h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                    </svg>
                                </span>
                                <input type="email" name="email" required
                                       value="{{ old('email') }}"
                                       class="input-anim w-full rounded-xl border-gray-300 dark:border-gray-700
                                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                              pl-10 pr-4 py-2.5
                                              focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Mot de passe</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 11c1.657 0 3 1.343 3 3v2H9v-2c0-1.657 1.343-3 3-3zm6-2V7a6 6 0 10-12 0v2m-2 0h16a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2v-9a2 2 0 012-2z"/>
                                    </svg>
                                </span>
                                <input type="password" name="password" required
                                       class="input-anim w-full rounded-xl border-gray-300 dark:border-gray-700
                                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                              pl-10 pr-4 py-2.5
                                              focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Confirmer</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 11c1.657 0 3 1.343 3 3v2H9v-2c0-1.657 1.343-3 3-3zm6-2V7a6 6 0 10-12 0v2m-2 0h16a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2v-9a2 2 0 012-2z"/>
                                    </svg>
                                </span>
                                <input type="password" name="password_confirmation" required
                                       class="input-anim w-full rounded-xl border-gray-300 dark:border-gray-700
                                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                              pl-10 pr-4 py-2.5
                                              focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="btn-shine w-full rounded-xl bg-blue-600 hover:bg-blue-700
                                       text-white font-bold py-2.5
                                       shadow-lg shadow-blue-600/30 transition duration-200
                                       hover:-translate-y-0.5 active:translate-y-0">
                            Créer un compte
                        </button>

                        {{-- Login link --}}
                        <p class="text-center text-sm text-gray-500 dark:text-gray-300">
                            Déjà un compte ?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">
                                Se connecter
                            </a>
                        </p>
                    </form>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 px-7 py-4 text-xs text-gray-500 dark:text-gray-400">
                    ©️ {{ date('Y') }} Ministère des Finances – Gestion des pannes
                </div>
            </div>
        </div>

    </div>
</body>
</html>