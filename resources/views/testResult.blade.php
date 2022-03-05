@extends('layouts.home')

@section('title')
Test Result
@endsection

@section('content')
<div class="container py-4">
    <h2 class="text-center">Test Result</h2>
    <div class="d-flex justify-content-between">
        <div style="flex:1; padding-right:50px;">
            <img src="/img/stress.jpg" alt="" style="width:600px;height:400px;">
        </div>
        <div style="flex:1;" class="d-flex justify-content-center flex-column">
            <div class="level">
                <h5 class="text-">Anxiety Level : Medium</h5>
            </div>
            <div class="solution d-flex flex-column">
                <span>&#9642; Think Postivity</span>
                <span>&#9642; Calm the Mind and Relax</span>
                <span>&#9642; Do activities according to interest</span>
                <span>&#9642; Doing a useful hobby</span>
            </div>
        </div>
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