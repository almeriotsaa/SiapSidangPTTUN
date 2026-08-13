<nav class="navbar navbar-expand-lg siap-navbar sticky-top">

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
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                        href="/">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('jadwal*') ? 'active' : '' }}"
                        href="/jadwal">
                        Jadwal Sidang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('tentang*') ? 'active' : '' }}"
                        href="/tentang">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kontak*') ? 'active' : '' }}"
                        href="/kontak">
                        Kontak
                    </a>
                </li>

                <!-- Dropdown Keanggotaan -->
                <li class="nav-item dropdown">

                    <a class="btn-keanggotaan dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Keanggotaan

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end membership-dropdown">

                        <li>
                            <a class="dropdown-item membership-item" href="/login">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Login</span>
                            </a>
                        </li>

                    </ul>

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

    .logo-box img {
        width: 48px;
        display: flex;
    }

    .brand-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--navy);
        letter-spacing: .5px;
    }

    .brand-sub-title {
        font-size: 14px;
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
    }

    .btn-keanggotaan:hover {
        background: #F7F8FA;
        color: var(--gold);
    }

    .dropdown-menu {
        margin-top: 12px;
        border: none;
        border-radius: 14px;
        overflow: hidden;
        min-width: 220px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
    }

    .membership-dropdown {
        min-width: 180px;
        padding: 8px;
        margin-top: 10px !important;

        border: 1px solid #eeeeee;
        border-radius: 14px;
        background: #ffffff;

        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .membership-item {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 10px 14px !important;

        border-radius: 9px;

        color: #26364a !important;
        font-size: 15px;
        font-weight: 500;

        transition: all 0.2s ease;
    }

    .membership-item i {
        font-size: 18px;
        color: #17375E;
    }

    .membership-item:hover {
        background: #f5f7fa !important;
        color: #17375E !important;
    }

    .membership-item:hover i {
        color: #c9a227;
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