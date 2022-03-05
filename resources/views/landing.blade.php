@extends('layouts.home')

@section('title')
Home
@endsection

@section('content')
<!-- Page Heading -->
<div class="w-100 position-relative" style="height: 95vh">
    <img src="/img/about.jpg" alt="" class="h-100 w-100 position-absolute" style="transform:scaleX(-1)">
    <div class="h-100 w-50 d-flex justify-content-center flex-column text-white position-relative"
        style="padding: 0 70px;">
        <h1>There is a crack in everything,</h1>
        <h3>That’s how the light gets in.</h3>
        <button type="button" class="btn btn-primary w-25">Our Services</button>
    </div>
</div>
<div class="container py-4">
    <h1 class="text-center">Our Services</h1>
    <div class="d-flex justify-content-between py-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <img class="card-img-top" src="/img/stress.jpg" alt="Card image cap">
                <h5 class="card-title">Anxiety Test</h5>
                <p class="card-text">To check the level of anxiety and the best solution.</p>
                <a href="#" class="btn btn-primary">Try it.</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <img class="card-img-top" src="/img/depression.jpg" alt="Card image cap">
                <h5 class="card-title">Depression Test</h5>
                <p class="card-text">To check the level of depression and the best solution.</p>
                <a href="#" class="btn btn-primary">Try it.</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <img class="card-img-top" src="/img/somatoform.jpg" alt="Card image cap">
                <h5 class="card-title">Somatoform Test</h5>
                <p class="card-text">To check the level of somatoform and the best solution.</p>
                <a href="#" class="btn btn-primary">Try it.</a>
            </div>
        </div>
    </div>
</div>
<div class="bg-light w-100" style="height:50vh;">
    <div class="h-100 w-50 container d-flex justify-content-around align-items-center">
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <img class="card-img-top" src="/img/asoka.jpg" alt="Card image cap">
                <h5 class="card-title text-center">Asoka Consulting</h5>
            </div>
        </div>
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title">Need Professional Treatment?</h5>
                <p class="card-text">Contact Asoka Consulting which is a consultant engaged in psychology, especially
                    mental health based in Yogyakarta and
                    Serang.</p>
                <a href="#" class="btn btn-primary">Visit.</a>
            </div>
        </div>
    </div>

</div>
<div class="text-center pt-4 pb-2 bg-black text-white">
    <p>Copyright &copy;
        <?php echo date('Y'); ?>, Heri Susanto Arisman
    </p>
</div>

@endsection