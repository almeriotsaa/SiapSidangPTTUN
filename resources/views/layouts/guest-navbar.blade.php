<nav class="navbar navbar-expand-lg siap-navbar sticky-top">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/">

            <div class="logo-box">
                <i class="bi bi-building"></i>
            </div>

            <div class="ms-3">

                <div class="brand-title">
                    SIAP SIDANG
                </div>

            </div>

        </a>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSIAP">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSIAP">

            <ul class="navbar-nav mx-auto">

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

            </ul>

            <div class="d-flex">

                <a href="/login" class="btn-login">

                    Login

                </a>

            </div>

        </div>

    </div>

</nav>

<style>
    .siap-navbar{

    background:#fff;

    min-height:72px;

    box-shadow:0 3px 12px rgba(0,0,0,.05);

    border-bottom:1px solid #ececec;

}

.logo-box{

    width:32px;

    height:32px;

    border-radius:8px;

    background:#2F6FED;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    font-weight:bold;

}

.brand-title{

    font-weight:700;

    font-size:22px;

    color:#1E293B;

    line-height:1;

}

.brand-subtitle{

    color:#6B7280;

    font-size:12px;

}

.navbar-nav{

    gap:8px;

}

.nav-link{

    color:#4B5563;

    font-weight:500;

    border-radius:8px;

    padding:10px 18px !important;

    transition:.25s;

}

.nav-link:hover{

    background:#EEF4FF;

    color:#2563EB;

}

.nav-link.active{

    background:#E8F1FF;

    color:#2563EB !important;

    font-weight:600;

}

.btn-login{

    border:1px solid #DC2626;

    color:#DC2626;

    text-decoration:none;

    padding:9px 20px;

    border-radius:8px;

    transition:.25s;

    font-weight:500;

}

.btn-login:hover{

    background:#DC2626;

    color:white;

}

@media(max-width:991px){

    .navbar-nav{

        margin-top:20px;

        margin-bottom:20px;

    }

    .btn-login{

        width:100%;

        text-align:center;

    }

}
</style>