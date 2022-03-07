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
        <h6 class="m-0 font-weight-bold text-primary">Gejala {{$m->nama}}</h6>
        <button type="button" class="btn btn-primary addGejala" id="addGejala" data-id="{{$m->id_mental}}"
            data-bs-target="#addGejalaModal" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Faktor</th>
                    <th scope="col" width="30%">Gejala</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="gejalaTable{{$m->id_mental}} gejalaTable">
            </tbody>
        </table>
    </div>
</div>
@endforeach
<!-- Add Faktor Modal -->
<div class="modal fade" id="addGejalaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Gejala</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addGejalaForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_mental" id="add_idMental">
                    <div class="form-group">
                        <label for="namaFaktor">Faktor</label>
                        <select class="form-select form-control add_idFaktor" id="add_idFaktor"
                            aria-label="Default select example" name="add_idFaktor">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="add_nama" placeholder="Nama" nama="nama" required>
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
<div class="modal fade" id="editGejalaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Gejala</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editGejalaForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_gejala" value="1" id="edit_idGejala">
                    <div class="form-group">
                        <label for="namaFaktor">Faktor</label>
                        <select class="form-select form-control edit_idFaktor" id="edit_idFaktor"
                            aria-label="Default select example" name="edit_idFaktor">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" placeholder="Nama" nama="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Gejala</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Mental Modal -->
<div class="modal fade" id="deleteGejalaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Gejala</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteGejalaForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idGejala" name="id_gejala">
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
        let faktor;
        const getData = () => {
            let dataList = []
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/gejala",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    faktor = res.faktor;
                    for(let i = 1; i <= res.gejala.length; i++){ 
                        let data = res.gejala.filter((item)=> {
                            return item.id_mental == i;
                        })
                        if(data.length){
                            dataList.push(data)
                        }
                    }
                    let tableRow;
                    let table;
                    dataList.map((item1, index1) => {
                        $(`.gejalaTable${item1[0].id_mental}`).empty()
                        table = $(`.gejalaTable${item1[0].id_mental}`);
                        dataList[index1].map((item2, index2) => {
                            tableRow = ''
                            tableRow+='<tr>'
                            tableRow+=`<th scope="row">${index2+1}</th>`
                            tableRow+=`<th scope="row">${item2.namaFaktor}</th>`
                            tableRow+=`<th scope="row" width="30%">${item2.nama}</th>`
                            tableRow+=`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <button type="button" class="btn btn-warning editButton" data-id="${item2.id_gejala}" data-faktor="${item2.id_mental}"
                                    data-bs-target="#editGejalaModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger deleteButton" data-id="${item2.id_gejala}" data-faktor="${item2.id_mental}"
                                    data-bs-target="#deleteGejalaModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
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

        $('.addGejala').click(function(){
            let id = $(this).data('id')
            let faktorList = faktor.filter((item) => {
                return item.id_mental == id
            })
            let option;
            let select = $('.add_idFaktor');
            select.empty()
            faktorList.map((item) => {
                option+= `<option value="${item.id_faktor}">${item.nama}</option>`
                select.append(option)
                option = ''
            })
        })

        $('#addGejala').on('shown.bs.modal', function(){
            $(this).find('#add_nama').focus()
        })

        $('#addGejalaForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_faktor', $('#add_idFaktor').val())
            formData.append('nama', $('#add_nama').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/gejala",
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
                        $('#addGejalaModal').modal('toggle')
                        $('#add_idFaktor').val('')
                        $('#add_nama').val('')
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

        $('.gejalaTable').on('click','.editButton', function(){
            let id = $(this).data('id');
            let idMental = $(this).data('faktor')
            $('#edit_idGejala').attr('value', id);

            let faktorList = faktor.filter((item) => {
                return item.id_mental == idMental
            })
            let option;
            let select = $('.edit_idFaktor');
            select.empty()
            faktorList.map((item) => {
                option+= `<option value="${item.id_faktor}">${item.nama}</option>`
                select.append(option)
                option = ''
            })

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/editgejala"+id,
                type: 'POST',
                data: {
                    'id_gejala':id
                },
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#edit_nama').val(res.data.nama)
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('#editGejalaModal').on('shown.bs.modal', function(){
            $(this).find('#edit_nama').focus()
        })

        $('#editGejalaForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id_gejala', $('#edit_idGejala').val())
            formData.append('id_faktor', $('#edit_idFaktor').val())
            formData.append('nama', $('#edit_nama').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/updategejala",
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
                        $('#editGejalaModal').modal('toggle')
                        $('#add_idFaktor').val('')
                        $('#add_nama').val('')
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

        $('.gejalaTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idGejala').attr('value', id);
        })

        $('#deleteGejalaForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idGejala').val()
            formData.append('id_gejala', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/gejala"+id,
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
                        $('#deleteGejalaModal').modal('toggle')
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