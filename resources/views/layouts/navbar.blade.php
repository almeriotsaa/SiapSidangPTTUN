<nav class="navbar navbar-expand-md siap-navbar sticky-top">

    <div class="container-fluid px-4 px-xxl-5">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/">

            <div class="logo-box">
                <img src="{{ asset('assets/images/pttun logo.png') }}" alt="">
            </div>

            <div class="ms-3">

                <div class="brand-title">
                    SIAP SIDANG
                </div>

                <div class="brand-sub-title">
                    PT TUN Jakarta
                </div>

            </div>

        </a>

        <button class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSIAP">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSIAP">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}"
                        href="/dashboard">
                        Dashboard
                    </a>
                </li>

                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('perkara*') ? 'active' : '' }}"
                            href="/perkara">
                            Perkara
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hakim*') ? 'active' : '' }}"
                            href="/hakim">
                            Hakim/PP
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kelola*') ? 'active' : '' }}"
                        href="/kelola-jadwal">
                        Jadwal Sidang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kehadiran*') ? 'active' : '' }}"
                        href="/kehadiran">
                        Kehadiran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('riwayat*') ? 'active' : '' }}"
                        href="/riwayat">
                        Riwayat
                    </a>
                </li>

                <li class="nav-item ms-lg-2">
                    <button type="button" class="btn-keanggotaan btn-logout-danger"
                        data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Log out
                    </button>
                </li>

            </ul>

        </div>

    </div>

</nav>

<style>
    :root {
        --navy: #0F2C4C;
        --gold: #C9A227;
        --gold-light: #FFF8E8;
        --text: #4B5563;
    }

    .siap-navbar {
        background: #fff;
        height: auto;
        border-bottom: 1px solid #ececec;
        box-shadow: 0 4px 18px rgba(15, 44, 76, .06);
        z-index: 999;
    }

    .logo-box img{
        width: 64px;
        display: flex;
    }

    .brand-title {
        /* font-family: 'Source Serif 4', serif; */
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy);
        letter-spacing: .5px;
    }

    .brand-sub-title {
        font-size: 18px;
        color: var(--gold);
        font-weight: 600;
    }

    .nav-link {
        color: var(--text);
        font-weight: 500;
        padding: 10px 18px !important;
        border-radius: 10px;
        transition: .25s;
    }

    .nav-link:hover {
        background: #F7F8FA;
        color: var(--navy);
    }

    .nav-link.active {
        background: var(--gold-light);
        color: var(--gold) !important;
        font-weight: 600;
    }

    .btn-keanggotaan {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        color: var(--text);
        font-weight: 500;
        transition: .25s;
        background: none;
        border: none;
        cursor: pointer;
    }

    .btn-keanggotaan:hover {
        background: #F7F8FA;
        color: var(--gold);
    }

    .btn-logout-danger {
        color: #dc2626;
    }

    .btn-logout-danger:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    .dropdown-menu {
        margin-top: 12px;
        border: none;
        border-radius: 14px;
        overflow: hidden;
        min-width: 220px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
    }

    .dropdown-item {
        padding: 14px 18px;
        font-weight: 500;
        transition: .2s;
    }

    .dropdown-item:hover {
        background: var(--gold-light);
        color: var(--gold);
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    @media(max-width:991px) {

        .siap-navbar {
            height: auto;
            padding: 12px 0;
        }

        .navbar-nav {
            margin-top: 20px;
            gap: 2px;
        }

        .btn-keanggotaan {
            width: 100%;
            justify-content: space-between;
        }

    }
</style>

{{-- Modal Konfirmasi Logout --}}
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center pt-4 pb-2">
                <p class="fw-bold text-dark mb-1">Keluar dari akun?</p>
                <p class="text-secondary small mb-0">
                    Apakah Anda yakin ingin keluar dari halaman ini?
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    Kembali
                </button>
                <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>