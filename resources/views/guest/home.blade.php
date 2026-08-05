@extends('layouts.guest')

@section('title','Home')

@section('content')

<!-- HERO -->
<section class="py-5 text-white"
style="background:linear-gradient(135deg,#17375E,#0F2C4C);">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-6">

<h1 class="fw-bold display-5">

SIAP SIDANG

</h1>

<h4 class="mb-4">

Sistem Informasi Presensi Sidang

</h4>

<p class="lead">

Website resmi SIAP SIDANG Pengadilan Tinggi Tata Usaha Negara Jakarta.

Masyarakat dapat melihat jadwal sidang secara online, sedangkan petugas internal dapat melakukan validasi kehadiran pihak yang berperkara.

</p>

<a href="/jadwal"

class="btn btn-warning btn-lg">

<i class="bi bi-calendar-event"></i>

Lihat Jadwal Sidang

</a>

</div>

<div class="col-lg-6 text-center">

<img src="https://cdn.betahita.id/7/8/5/7/7857.jpeg"

class="img-fluid"

style="max-height:420px;">

</div>

</div>

</div>

</section>

<!-- FITUR -->

<section class="py-5 bg-light">

<div class="container">

<div class="text-center mb-5">

<h2 class="fw-bold">

Fitur SIAP SIDANG

</h2>

<p class="text-muted">

Mendukung proses persidangan yang lebih cepat dan transparan.

</p>

</div>

<div class="row">

<div class="col-md-4">

<div class="card shadow-sm border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-calendar-week display-5 text-primary"></i>

<h5 class="mt-3">

Jadwal Sidang

</h5>

<p>

Melihat informasi jadwal sidang secara online.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow-sm border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-clock-history display-5 text-success"></i>

<h5 class="mt-3">

Monitoring Kehadiran

</h5>

<p>

Memantau status kehadiran pihak secara real-time.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow-sm border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-shield-lock display-5 text-danger"></i>

<h5 class="mt-3">

Akses Internal

</h5>

<p>

Admin, Front Office, dan Panitera memiliki hak akses masing-masing.

</p>

</div>

</div>

</div>

</div>

</div>

</section>

@endsection