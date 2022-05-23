@extends('layouts.home')

@section('title')
Test Result
@endsection

@section('content')
<div class="container py-4">
    <h2 class="text-center title-page" data-id="{{$data['id']}}">Test Result</h2>
    <div class="d-flex justify-content-between">
        <div style="flex:1; padding-right:50px;">
            <img src="/img/stress.jpg" alt="" style="width:600px;height:400px;">
        </div>
        <div style="flex:1;" class="d-flex justify-content-center flex-column">
            <div class="level">
                <h5 class="text-">{{$data['name']}} Level : {{ $data['hasil'] }} </h5>
            </div>
            <div class="solution d-flex flex-column">
                @for($i = 0; $i < count($data['solusi']); $i++) <span>&#9642; {{$data['solusi'][$i]}}</span>
                    @endfor
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
@section('jsTes')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function(){
        let id = $('.title-page').data('id')

        $.ajax({
            url: "/test-result/"+id,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res)
            } 
        });
    })
    
</script>
@endsection