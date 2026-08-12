<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SIAP SIDANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <div class="flex items-center gap-3 mb-1">
            <div class="w-11 h-11 rounded-xl bg-[#17375E] flex items-center justify-center text-white font-bold text-sm">
                SS
            </div>
            <h1 class="text-xl font-bold text-[#17375E]">SIAP SIDANG</h1>
        </div>
        <p class="text-sm text-gray-500 mb-6">Sistem Informasi Absensi Persidangan</p>

        <p class="text-xs font-bold tracking-wide text-[#E4B028] mb-4">
            MASUK KE AKUN ANDA
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-2.5">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-800 mb-1.5">
                    Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Contoh: admin@siapsidang.id"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#17375E] focus:border-transparent"
                >
            </div>

            <div class="mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-800 mb-1.5">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="w-full rounded-lg border border-gray-200 pl-4 pr-11 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#17375E] focus:border-transparent"
                    >
                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                        aria-label="Tampilkan atau sembunyikan kata sandi"
                    >
                        {{-- Ikon mata terbuka (default, saat password disembunyikan) --}}
                        <svg id="iconEyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3.5c-4.4 0-8.1 2.8-9.5 6.5 1.4 3.7 5.1 6.5 9.5 6.5s8.1-2.8 9.5-6.5C18.1 6.3 14.4 3.5 10 3.5zm0 11a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"/>
                            <circle cx="10" cy="10" r="2.25"/>
                        </svg>
                        {{-- Ikon mata dicoret (saat password ditampilkan), tersembunyi secara default --}}
                        <svg id="iconEyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.98-1.98c1.5-1.13 2.7-2.65 3.45-4.24-1.4-3.7-5.1-6.5-9.5-6.5-1.35 0-2.63.27-3.79.76L3.28 2.22zM10 6.5c.5 0 .98.08 1.43.23l1.62 1.62A2.98 2.98 0 0 0 10 7a3 3 0 0 0-3 3c0 .34.06.66.16.96l1.62 1.62A2.98 2.98 0 0 1 7 10a3 3 0 0 1 3-3.5z" clip-rule="evenodd"/>
                            <path d="M2.06 8.72a10.6 10.6 0 0 0-1.56 1.78c1.4 3.7 5.1 6.5 9.5 6.5.85 0 1.67-.1 2.45-.3l-1.66-1.66c-.25.04-.52.06-.79.06a7.7 7.7 0 0 1-7.94-6.38z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <p class="text-xs text-gray-400 mb-5">
                Pastikan password yang Anda masukkan sudah benar
            </p>

            <button
                type="submit"
                class="w-full bg-[#17375E] hover:bg-[#122c4b] text-white font-semibold text-sm py-3 rounded-lg transition-colors"
            >
                Masuk
            </button>
        </form>

    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const eyeOpen = document.getElementById('iconEyeOpen');
        const eyeClosed = document.getElementById('iconEyeClosed');

        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';

        eyeOpen.classList.toggle('hidden', isHidden);
        eyeClosed.classList.toggle('hidden', !isHidden);
    }
</script>

</body>
</html>