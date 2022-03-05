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
        <h6 class="m-0 font-weight-bold text-primary">Mental Illness List</h6>
        <button type="button" class="btn btn-primary" data-bs-target="#addMental" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Mental</th>
                    <th scope="col" style="width:50%;">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="mentalTable">
            </tbody>
        </table>
    </div>
</div>
<!-- Add Mental Modal -->
<div class="modal fade" id="addMental" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Mental</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addMental">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="add_nama" placeholder="Nama" nama="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="add_description" rows="3" name="description"
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
<!-- Edit Mental Modal -->
<div class="modal fade" id="editMental" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Mental</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_mental" value="1" id="edit_idMental">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" placeholder="Nama" nama="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="edit_description" rows="3" name="description"
                            placeholder="Description" required></textarea>
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
<!-- Delete Mental Modal -->
<div class="modal fade" id="deleteMental" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Mental</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteQuestion">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idMental" name="id_pertanyaan">
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
        <div class="toast-header text-white">
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
                url: "/mental",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('.mentalTable').empty()
                    let table = $('.mentalTable');
                    res.mental.map((item, index) => {
                        table.append('<tr>')
                        table.append(`<th scope="row">${index+1}</th>`)
                        table.append(`<th scope="row">${item.nama}</th>`)
                        table.append(`<th scope="row" style="width:50%;">${item.description}</th>`)
                        table.append(`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <button type="button" class="btn btn-warning editButton" data-id="${item.id_mental}"
                                data-bs-target="#editMental" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger deleteButton" data-id="${item.id_mental}"
                                data-bs-target="#deleteMental" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
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

        $('#addMental').on('shown.bs.modal', function(){
            $(this).find('#add_nama').focus()
        })

        $('#addMental').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('nama', $('#add_nama').val())
            formData.append('description', $('#add_description').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/mental",
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
                    $('#addMental').modal('toggle')
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

        $('.mentalTable').on('click','.editButton', function(){
            let id = $(this).data('id');
            $('#edit_idMental').attr('value', id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/editmental"+id,
                type: 'POST',
                data: {
                    'id_mental':id
                },
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#edit_nama').val(res.data.nama)
                    $('#edit_description').val(res.data.description)
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('#editMental').on('shown.bs.modal', function(){
            $(this).find('#edit_nama').focus()
        })

        $('#editMental').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_mental', $('#edit_idMental').val())
            formData.append('nama', $('#edit_nama').val())
            formData.append('description', $('#edit_description').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/updatemental",
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
                    $('#editMental').modal('toggle')
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

        $('.mentalTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idMental').attr('value', id);
        })

        $('#deleteMental').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idMental').val()
            formData.append('id_mental', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/mental"+id,
                type: 'DELETE',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.status === "Gagal"){
                        $('.toast-header').addClass('bg-danger')
                        setTimeout(() => {
                            $('.toast-title').append(res.status)
                            $('.toast-text').append(res.message)
                            $('.toast-header').removeClass('bg-danger')
                        }, 4000)
                    }else{
                        $('.toast-header').addClass('bg-primary')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        toast.show()
                        getData()
                        $('#deleteMental').modal('toggle')
                        setTimeout(() => {
                            toast.hide()
                            $('.toast-title').text("")
                            $('.toast-text').text("")
                            $('.toast-header').removeClass('bg-primary')
                        }, 4000);
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })
    })
</script>
@endsection