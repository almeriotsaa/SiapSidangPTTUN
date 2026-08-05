<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">

<div class="container-fluid">

<a class="navbar-brand fw-bold text-primary"
href="/dashboard">

<i class="bi bi-building"></i>

SIAP SIDANG

</a>

<div class="ms-auto d-flex align-items-center">

<span class="text-secondary me-4">

<i class="bi bi-calendar-event"></i>

{{ date('d F Y') }}

</span>

<div class="dropdown">

<a href="#"

class="text-decoration-none dropdown-toggle"

data-bs-toggle="dropdown">

<i class="bi bi-person-circle fs-5"></i>

{{ Auth::user()->name ?? 'Admin' }}

</a>

<ul class="dropdown-menu dropdown-menu-end">

<li>

<a class="dropdown-item"

href="#">

Profil

</a>

</li>

<li><hr></li>

<li>

<a class="dropdown-item text-danger"

href="#">

Logout

</a>

</li>

</ul>

</div>

</div>

</div>

</nav>