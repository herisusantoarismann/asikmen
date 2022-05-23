@extends('layouts.home')

@section('title')
About
@endsection

@section('content')
<div class="container py-4 text-justify">
    <h2 class="text-center">About Us</h2>
    <p style="text-indent: 40px;">Aplikasi Cek Mental adalah sebuah aplikasi yang memungkinkan pendeteksian dini keadaan
        mental seseorang. Gangguan
        yang di deteksi adalah Kecemasan Umum, Depresi, dan Somatoform. Dalam aplikasi juga tersedia solusi yang bisa
        anda lakukan dan akses ke layanan konsultasi terpecaya.</p>
    <div class="d-flex flex-column">
        <span>&#9642; Gangguan kecemasan umum adalah munculnya rasa cemas atau khawatir yang berlebihan dan tidak
            terkendali terhadap berbagai
            hal dan kondisi. Kondisi ini akan mengganggu aktivitas sehari-hari penderitanya.</span>
        <span>&#9642; Depresi adalah gangguan suasana hati (mood) yang ditandai dengan perasaan sedih yang mendalam dan
            rasa tidak peduli.
            Semua orang pasti pernah merasa sedih atau murung. Seseorang dinyatakan mengalami depresi jika sudah 2
            minggu merasa
            sedih, putus harapan, atau tidak berharga.</span>
        <span>&#9642; Gangguan somatoform merupakan kelainan psikologis pada seseorang yang ditandai dengan sekumpulan keluhan fisik yang tidak menentu, namun tidak tampak saat pemeriksaan fisik. Munculnya gangguan ini biasanya disebabkan oleh stres dan banyak pikiran.</span>
    </div>
    <div class="d-flex justify-content-center py-2">
        <button type="button" class="btn btn-primary">Coba Tes</button>
    </div>
</div>
@endsection
@section('footer')
<div class="text-center pt-4 pb-2 bg-black text-white fixed-bottom">
    <p>Copyright &copy;
        <?php echo date('Y'); ?>, Heri Susanto Arisman
    </p>
</div>
@endsection