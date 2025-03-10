@extends('layouts.main')

@section('container')

<div class="container mt-5 text-center">
    <h1 class="fw-bold">Selamat Datang di NebulaCode</h1>
    <h5>Tempat berbagi informasi, pengalaman, dan inspirasi.</h5>

    <!-- Hero Section -->
    <div class="jumbotron bg-light p-4 rounded">
        <h2>Jelajahi Konten Menarik</h2>
        <p>Temukan berbagai artikel bermanfaat dan insight menarik setiap hari.</p>
        <a href="/about" class="btn btn-primary me-2">Tentang Kami</a>
    </div>

    <hr>
    <!-- Section Tambahan -->
    <div class="row mt-5">
        <div class="col-md-4">
            <h3>Artikel Terbaru</h3>
            <p>Baca berbagai artikel informatif dan menarik.</p>
            <a href="/posts" class="btn btn-dark">Lihat Artikel</a>
        </div>
        <div class="col-md-4">
            <h3>Kategori</h3>
            <p>Jelajahi berbagai kategori artikel yang tersedia.</p>
            <a href="/categories" class="btn btn-outline-primary">Lihat Kategori</a>
        </div>
        <div class="col-md-4">
            <h3>Gabung Komunitas</h3>
            <p>Bergabunglah dengan komunitas.</p>
            <a href="https://discord.gg/C6Kr9KfX" class="btn" style="background-color: #5865F2; color: white; font-weight: bold;">Join Community 🚀</a>
        </div>
    </div>
</div>


@endsection