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
        <h6 class="m-0 font-weight-bold text-primary">Faktor {{$m->nama}}</h6>
        <button type="button" class="btn btn-primary addFaktor" id="addFaktor" data-id="{{$m->id_mental}}"
            data-bs-target="#addFaktorModal" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Faktor</th>
                    <th scope="col" width="30%">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="faktorTable{{$m->id_mental}} faktorTable">
            </tbody>
        </table>
    </div>
</div>
@endforeach
<!-- Add Faktor Modal -->
<div class="modal fade" id="addFaktorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Faktor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addFaktorForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_mental" id="add_idMental">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="add_nama" placeholder="Nama" nama="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="add_description" rows="3" name="description"
                            placeholder="Description" required></textarea>
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
<div class="modal fade" id="editFaktorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Faktor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editFaktorForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_faktor" value="1" id="edit_idFaktor">
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
                    <button type="submit" class="btn btn-primary">Edit Faktor</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Mental Modal -->
<div class="modal fade" id="deleteFaktorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Question</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteFaktorForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idFaktor" name="id_pertanyaan">
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
                url: "/factor",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    let dataList = []
                    for(let i = 0; i < res.faktor.length; i++){
                        let data = res.faktor.filter((item) => {
                            return item.id_mental == i;
                        })
                        if(data.length){
                            dataList.push(data)
                        }
                    }
                    let tableRow;
                    let table;
                    dataList.map((item1, index1) => {
                        $(`.faktorTable${item1[0].id_mental}`).empty()
                        table = $(`.faktorTable${item1[0].id_mental}`);
                        dataList[index1].map((item2, index2) => {
                            tableRow = ''
                            tableRow+='<tr>'
                                tableRow+=`<th scope="row">${index2+1}</th>`
                                tableRow+=`<th scope="row">${item2.nama}</th>`
                                tableRow+=`<th scope="row" width="30%">${item2.description}</th>`
                                tableRow+=`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    <button type="button" class="btn btn-warning editButton" data-id="${item2.id_faktor}"
                                        data-bs-target="#editFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger deleteButton" data-id="${item2.id_faktor}"
                                        data-bs-target="#deleteFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                                </td>`
                                tableRow+='</tr>'
                            table.append(tableRow)
                        })
                        table = ""
                    })
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        }

        getData();

        $('.addFaktor').click(function(){
            let id = $(this).data('id')
            $('#add_idMental').attr('value', id)
        })

        $('#addFaktorModal').on('shown.bs.modal', function(){
            $(this).find('#add_nama').focus()
        })

        $('#addFaktorForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_mental', $('#add_idMental').val())
            formData.append('nama', $('#add_nama').val())
            formData.append('description', $('#add_description').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('postFaktor')}}",
                type: 'POST',
                data: formData,
                dataType: 'json',
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
                        $('#addFaktorModal').modal('toggle')
                        setTimeout(() => {
                            toast.hide()
                        }, 4000);
                        if(toast.hide()){
                            $('.toast-title').text("")
                            $('.toast-text').text("")
                            $('.toast-header').removeClass('bg-primary')
                            $('#add_nama').atrr('value', '')
                        }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.faktorTable').on('click','.editButton', function(){
            let id = $(this).data('id');
            $('#edit_idFaktor').attr('value', id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/editfaktor"+id,
                type: 'POST',
                data: {
                    'id_faktor':id
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

        $('#editFaktorModal').on('shown.bs.modal', function(){
            $(this).find('#edit_nama').focus()
        })

        $('#editFaktorForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_faktor', $('#edit_idFaktor').val())
            formData.append('nama', $('#edit_nama').val())
            formData.append('description', $('#edit_description').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/updatefaktor",
                type: 'POST',
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
                        $('#editFaktorModal').modal('toggle')
                        setTimeout(() => {
                            toast.hide()
                        }, 4000);
                        if(toast.hide()){
                            $('.toast-title').text("")
                            $('.toast-text').text("")
                            $('.toast-header').removeClass('bg-primary')
                        }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.faktorTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idFaktor').attr('value', id);
        })

        $('#deleteFaktorForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idFaktor').val()
            formData.append('id_faktor', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/factor"+id,
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
                        $('#deleteFaktorModal').modal('toggle')
                        setTimeout(() => {
                            toast.hide()
                        }, 4000);
                        if(toast.hide()){
                            $('.toast-title').text("")
                            $('.toast-text').text("")
                            $('.toast-header').removeClass('bg-primary')
                        }
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