@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif

@foreach($mental as $m)
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Pertanyaan {{$m->nama}}</h6>
        <button type="button" class="btn btn-primary addQuestion" id="addQuestion" data-id="{{$m->id_mental}}"
            data-bs-target="#addQuestionModal" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center question{{$m->id_mental}}Table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Pertanyaan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="question{{$m->id_mental}} questionBody">
            </tbody>
        </table>
    </div>
</div>
@endforeach
<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addQuestionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_tes" id="add_idTes">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Pertanyaan</label>
                        <textarea class="form-control" id="add_pertanyaan" rows="3" name="pertanyaan"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editQuestionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_pertanyaan" value="1" id="edit_idPertanyaan">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Pertanyaan</label>
                        <textarea class="form-control" id="edit_pertanyaan" rows="3" name="pertanyaan"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Question</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Question Modal -->
<div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteQuestionForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idPertanyaan" name="id_pertanyaan">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('toast')
<div style="z-index: 50; position: fixed; bottom:0; right:0; padding:10px;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto toast-title"></strong>
        </div>
        <div class="toast-body toast-text">
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        const getData = () => {
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     url: "/question",
            //     type: 'GET',
            //     dataType: 'json', // added data type
            //     success: function(res) {
            //         $('.anxietyTable').empty()
            //         let table = $('.anxietyTable');
            //         res.questionAnxiety.map((item, index) => {
            //             table.append('<tr>')
            //             table.append(`<th scope="row">${index+1}</th>`)
            //             table.append(`<th scope="row">${item.pertanyaan}</th>`)
            //             table.append(`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
            //                 <button type="button" class="btn btn-warning editButton" data-id="${item.id_pertanyaan}"
            //                     data-bs-target="#editQuestion" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
            //                 <button type="button" class="btn btn-danger deleteButton" data-id="${item.id_pertanyaan}"
            //                     data-bs-target="#deleteQuestion" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
            //             </td>`)
            //             table.append('</tr>')
            //         })
            //     },
            //     error:function(res){
            //         console.log(res.responseJSON.message)
            //     }
            // })

            let count = $('tbody[class*="question"');
            
            let table;
            for(let i = 0; i < count.length; i++){ 
                let id=count[i].className.replace(/\D/g, "" ); 
                let className=count[i].className.split(" ")
                table = $('.'+className[0] + 'Table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: " /getquestion" + id, 
                    columns: [ 
                        {data: 'DT_RowIndex' , name: 'DT_RowIndex' },
                        {data: 'pertanyaan' ,name: 'pertanyaan' }, 
                        {data: 'action' , name: 'action' , orderable: true, searchable: true }, 
                    ], 
                    bDestroy: true, 
                    dom:'<"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
                });
            }
        }

        getData();

        $('.addQuestion').click(function(){
            let id = $(this).data('id')
            $('#add_idTes').attr('value', id)
        })

        $('#addQuestionModal').on('shown.bs.modal', function(){
            $(this).find('#add_pertanyaan').focus()
        })

        $('#addQuestionForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_tes', $('#add_idTes').val())
            formData.append('pertanyaan', $('#add_pertanyaan').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/question",
                type: 'POST',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    // $('.toast-title').append(res.status)
                    // $('.toast-text').append(res.message)
                    // var toast = new bootstrap.Toast($('.toast'))
                    // toast.show()
                    getData()
                    $('#addQuestionModal').modal('toggle')
                    // setTimeout(() => {
                    //     toast.hide()
                    //     $('.toast-title').text("")
                    //     $('.toast-text').text("")
                    // }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.questionBody').on('click','.editButton', function(){
            let id = $(this).data('id');
            $('#edit_idPertanyaan').attr('value', id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/editquestion"+id,
                type: 'POST',
                data: {
                    'id_pertanyaan':id
                },
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#edit_pertanyaan').val(res.data.pertanyaan)
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('#editQuestionModal').on('shown.bs.modal', function(){
            $(this).find('#edit_pertanyaan').focus()
        })

        $('#editQuestionForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_pertanyaan', $('#edit_idPertanyaan').val())
            formData.append('pertanyaan', $('#edit_pertanyaan').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/updatequestion",
                type: 'POST',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    // $('.toast-title').append(res.status)
                    // $('.toast-text').append(res.message)
                    // var toast = new bootstrap.Toast($('.toast'))
                    // toast.show()
                    getData()
                    $('#editQuestionModal').modal('toggle')
                    // setTimeout(() => {
                    //     toast.hide()
                    //     $('.toast-title').text("")
                    //     $('.toast-text').text("")
                    // }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.questionBody').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idPertanyaan').attr('value', id);
        })

        $('#deleteQuestionForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idPertanyaan').val()
            formData.append('id_pertanyaan', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/question"+id,
                type: 'DELETE',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    // $('.toast-title').append(res.status)
                    // $('.toast-text').append(res.message)
                    // var toast = new bootstrap.Toast($('.toast'))
                    // toast.show()
                    getData()
                    $('#deleteQuestionModal').modal('toggle')
                    // setTimeout(() => {
                    //     toast.hide()
                    //     $('.toast-title').text("")
                    //     $('.toast-text').text("")
                    // }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })
    })
</script>
@endsection