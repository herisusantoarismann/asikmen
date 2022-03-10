@extends('layouts.home')

@section('title')
Test
@endsection

@section('content')
<ul class="steps py-4 stepper" data-id="{{ $pertanyaan[0]->id_tes }}">
    @foreach($pertanyaan as $key=>$value)
    <li class="step">
        <div class="step-content">
            <span class="step-circle">{{$key+1}}</span>
        </div>
    </li>
    @endforeach
</ul>
<div class="container">
    <h5 data-id-user="{{ Auth::id() }}" class="test-name">Anxiety Test</h5>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p style="flex:1;" class="pertanyaan">

                </p>
                <div style="flex:1;" class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-primary mr-2" id="prevQuestion">Prev</button>
                    <div class="navigationQuestion">
                        <button type="button" class="btn btn-primary" id="nextQuestion">Next</button>
                    </div>
                    <div class="submitQuestion" style="display: none;">
                        <button type="button" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </div>
            <div class="alert alert-danger my-3" role="alert">
                Choose are answer that meet apply to you.
            </div>
            <div class="px-4">
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" id="jawab1" name="jawaban" value="1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Tidak Pernah
                    </label>
                </div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" id="jawab2" name="jawaban" value="2">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Jarang
                    </label>
                </div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" id="jawab3" name="jawaban" value="3">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Kadang-kadang
                    </label>
                </div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" id="jawab4" name="jawaban" value="4">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Cukup sering
                    </label>
                </div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" id="jawab5" name="jawaban" value="5">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Sering
                    </label>
                </div>
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
        let pertanyaan;
        let jawabanPointer = {};
        let jawaban = {}
        let id = $('.stepper').data('id')
        $.ajax({
            url: "/test/"+id,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                pertanyaan = res.pertanyaan;
                for(let i = 0; i < pertanyaan.length; i++){
                    jawaban[i] = null;
                }
                $('.pertanyaan').append(res.pertanyaan[0].pertanyaan)
                $('.pertanyaan').attr('data-id', 0);
                $('.pertanyaan').attr('data-pointer', res.pertanyaan[0].id_pertanyaan);
                $('.test-name').attr('data-id-test', res.pertanyaan[0].id_tes);
            }
        });
        $('#prevQuestion').click(function(){
            let id = $('.pertanyaan').attr('data-id');
            if(jawabanPointer[id-1]){
                $(`#jawab${jawabanPointer[id-1]}`).prop('checked', true);
            }
            else{
                $(':radio').each(function () {
                    $(this).removeAttr('checked');
                    $('input[type="radio"]').prop('checked', false);
                })
            }
            if(id > 0){
                id=--id;
                $('.pertanyaan').text(pertanyaan[id].pertanyaan)
                $('.pertanyaan').attr('data-id', id);
                $('.pertanyaan').attr('data-pointer', pertanyaan[id].id_pertanyaan);
            }
            else{
                $('.pertanyaan').text(pertanyaan[id].pertanyaan)
                $('.pertanyaan').attr('data-id', id);
                $('.pertanyaan').attr('data-pointer', pertanyaan[id].id_pertanyaan);
            }
            $('.stepper li').each(function(index){
                if(index == id){
                    if(jawabanPointer[index]){
                    $(this).removeClass('step-success')
                    }
                    $(this).addClass('step-active')
                }
                else if(jawaban[index]){
                    $(this).addClass('step-success')
                }else{
                    $(this).removeClass('step-active')
                }
            })
        })
        $('#nextQuestion').click(function(){
            let id = $('.pertanyaan').attr('data-id');
            let pointer = $('.pertanyaan').attr('data-pointer');
            if(jawabanPointer[++id]){
                $(`#jawab${jawabanPointer[id]}`).prop('checked', true);
            }
            else{
                $(':radio').each(function () {
                    $(this).removeAttr('checked');
                    $('input[type="radio"]').prop('checked', false);
                })
            }
            if(id < pertanyaan.length - 1){ 
                $('.pertanyaan').text(pertanyaan[id].pertanyaan)
                $('.pertanyaan').attr('data-id', id); 
                $('.pertanyaan').attr('data-pointer', pertanyaan[id].id_pertanyaan); 
            } 
            else{ 
                $('.pertanyaan').text(pertanyaan[id].pertanyaan)
                $('.pertanyaan').attr('data-id', id); 
                $('.pertanyaan').attr('data-pointer', pertanyaan[id].id_pertanyaan); 
                $('.navigationQuestion').css('display', 'none');
                $('.submitQuestion').css('display', 'flex');
            }
            $('.stepper li').each(function(index){
                if(index == id){
                    if(jawabanPointer[index]){
                        $(this).removeClass('step-success')
                    }
                    $(this).addClass('step-active')
                }
                else if(jawabanPointer[index]){
                    $(this).addClass('step-success')
                }else{
                    $(this).removeClass('step-active')
                }
            })
        })
        $('input[name="jawaban"]').change(function(){
            let id = $('.pertanyaan').attr('data-id');
            let pointer = $('.pertanyaan').attr('data-pointer');
            jawabanPointer[id] = $('input[name="jawaban"]:checked').val();
            jawaban[pointer] = $('input[name="jawaban"]:checked').val();
        })

        $('.submitQuestion').click(function(){
            delete jawaban[0]
            if(Object.keys(jawaban).length < pertanyaan.length){
                alert("Belum selesai")
            }else{
                let id_user = $('.test-name').attr('data-id-user');
                let id_tes = $('.test-name').attr('data-id-test');

                let formData = new FormData();
                formData.append('id_user', id_user)
                formData.append('id_mental', id_tes)
                formData.append('jawaban', JSON.stringify(jawaban))

                for (var pair of formData.entries()) {
                    console.log(pair[0]+ ', ' + pair[1]); 
                }

                // $.ajax({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     url: "/test",
                //     type: 'POST',
                //     data: formData,
                //     dataType: 'json', // added data type
                //     processData: false,
                //     contentType: false,
                //     success: function(res) {
                //         console.log(res.jawaban)
                //     },
                //     error:function(res){
                //         console.log(res.responseJSON.message)
                //     }
                // })
            }
        })
    })
    
</script>
@endsection