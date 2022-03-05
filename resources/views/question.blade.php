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

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Question List</h6>
        <button type="button" class="btn btn-primary" data-bs-target="#addQuestion" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Pertanyaan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="anxietyTable">
            </tbody>
        </table>
    </div>
</div>
<!-- Add Question Modal -->
<div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addQuestion">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_tes" value="1" id="add_idTes">
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
<div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
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
<div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteQuestion">
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
<script type="text/javascript">
    $(document).ready(function(){
        const getData = () => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/question",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('.anxietyTable').empty()
                    let table = $('.anxietyTable');
                    res.questionAnxiety.map((item, index) => {
                        table.append('<tr>')
                        table.append(`<th scope="row">${index+1}</th>`)
                        table.append(`<th scope="row">${item.pertanyaan}</th>`)
                        table.append(`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="button" class="btn btn-warning editButton" data-id="${item.id_pertanyaan}"
                                data-bs-target="#editQuestion" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger deleteButton" data-id="${item.id_pertanyaan}"
                                data-bs-target="#deleteQuestion" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>`)
                        table.append('</tr>')
                    })
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        }

        getData();

        $('#addQuestion').on('shown.bs.modal', function(){
            $(this).find('#add_pertanyaan').focus()
        })

        $('#addQuestion').on('submit',function(e){
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
                    $('.toast-title').append(res.status)
                    $('.toast-text').append(res.message)
                    var toast = new bootstrap.Toast($('.toast'))
                    toast.show()
                    getData()
                    $('#addQuestion').modal('toggle')
                    setTimeout(() => {
                        toast.hide()
                        $('.toast-title').text("")
                        $('.toast-text').text("")
                    }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.anxietyTable').on('click','.editButton', function(){
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

        $('#editQuestion').on('shown.bs.modal', function(){
            $(this).find('#edit_pertanyaan').focus()
        })

        $('#editQuestion').on('submit',function(e){
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
                    $('.toast-title').append(res.status)
                    $('.toast-text').append(res.message)
                    var toast = new bootstrap.Toast($('.toast'))
                    toast.show()
                    getData()
                    $('#editQuestion').modal('toggle')
                    setTimeout(() => {
                        toast.hide()
                        $('.toast-title').text("")
                        $('.toast-text').text("")
                    }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.anxietyTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idPertanyaan').attr('value', id);
        })

        $('#deleteQuestion').on('submit',function(e){
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
                    $('.toast-title').append(res.status)
                    $('.toast-text').append(res.message)
                    var toast = new bootstrap.Toast($('.toast'))
                    toast.show()
                    getData()
                    $('#deleteQuestion').modal('toggle')
                    setTimeout(() => {
                        toast.hide()
                        $('.toast-title').text("")
                        $('.toast-text').text("")
                    }, 4000);
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })
    })
</script>
@endsection