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
            <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                SS
            </div>
            <h1 class="text-xl font-bold text-gray-900">SIAP SIDANG</h1>
        </div>
        <p class="text-sm text-gray-500 mb-6">Sistem Informasi Absensi Persidangan</p>

        <p class="text-xs font-bold tracking-wide text-gray-600 mb-4">
            MASUK SEBAGAI PANITERA PENGGANTI
        </p>

        <form method="POST" action="#">
            <div class="mb-4">
                <label for="nip" class="block text-sm font-semibold text-gray-800 mb-1.5">
                    NIP / Username
                </label>
                <input
                    id="nip"
                    type="text"
                    name="nip"
                    placeholder="Contoh: 19850312"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
            </div>

            <div class="mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-800 mb-1.5">
                    Kata Sandi
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
            </div>

            <p class="text-xs text-gray-400 mb-5">
                Pastikan password yang Anda masukkan sudah benar
            </p>

            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-3 rounded-lg transition-colors"
            >
                Masuk
            </button>
        </form>

        <hr class="my-6 border-gray-100">

        <div class="text-sm">
            <p class="text-gray-500 mb-2">Akses tanpa login:</p>
            <a href="#" class="flex items-center gap-1 text-indigo-600 font-medium hover:underline mb-1.5">
                Check-in Mandiri (Kiosk) <span aria-hidden="true">→</span>
            </a>
            <a href="#" class="flex items-center gap-1 text-indigo-600 font-medium hover:underline">
                Loket Depan (Verifikasi) <span aria-hidden="true">→</span>
            </a>
        </div>

    </div>
</div>

</body>
</html>