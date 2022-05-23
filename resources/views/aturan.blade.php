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
        <h6 class="m-0 font-weight-bold text-primary">Aturan {{$m->nama}}</h6>
        <button type="button" class="btn btn-primary addAturan" id="addAturan" data-id="{{$m->id_mental}}"
            data-bs-target="#addAturanModal" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center aturan{{$m->id_mental}}Table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Aturan</th>
                    <th scope="col">Hasil</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="aturan{{$m->id_mental}} aturanBody">
            </tbody>
        </table>
    </div>
</div>
@endforeach
<!-- Add Faktor Modal -->
<div class="modal fade" id="addAturanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Aturan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addAturanForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_mental" id="add_idMental">
                    <div class="form-group">
                        <label for="namaFaktor">Kategori </label>
                        <div class="addKategoriParent row">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Hasil</label>
                        <input type="text" class="form-control" id="add_hasil" placeholder="Hasil" nama="hasil"
                            required>
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
<div class="modal fade" id="editAturanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Aturan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editAturanForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_mental" value="1" id="edit_idMental">
                    <input type="hidden" name="id_aturan" value="1" id="edit_idAturan">
                    <div class="form-group">
                        <label for="namaFaktor">Kategori </label>
                        <div class="editKategoriParent row">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Hasil</label>
                        <input type="text" class="form-control" id="edit_hasil" placeholder="Hasil" nama="hasil"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Aturan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Mental Modal -->
<div class="modal fade" id="deleteAturanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Aturan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteAturanForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idAturan" name="id_aturan">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    function ganti(e){
        $(`#${e.target.name}`).val(e.target.value)
    }
    $(document).ready(function(){
        const getData = () => {
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     url: "/factor",
            //     type: 'GET',
            //     dataType: 'json', // added data type
            //     success: function(res) {
            //         let dataList = []
            //         for(let i = 0; i < res.faktor.length; i++){
            //             let data = res.faktor.filter((item) => {
            //                 return item.id_mental == i;
            //             })
            //             if(data.length){
            //                 dataList.push(data)
            //             }
            //         }
            //         let tableRow;
            //         let table;
            //         dataList.map((item1, index1) => {
            //             $(`.faktorTable${item1[0].id_mental}`).empty()
            //             table = $(`.faktorTable${item1[0].id_mental}`);
            //             dataList[index1].map((item2, index2) => {
            //                 tableRow = ''
            //                 tableRow+='<tr>'
            //                     tableRow+=`<th scope="row">${index2+1}</th>`
            //                     tableRow+=`<th scope="row">${item2.nama}</th>`
            //                     tableRow+=`<th scope="row" width="30%">${item2.description}</th>`
            //                     tableRow+=`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
            //                         <button type="button" class="btn btn-warning editButton" data-id="${item2.id_faktor}"
            //                             data-bs-target="#editFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
            //                         <button type="button" class="btn btn-danger deleteButton" data-id="${item2.id_faktor}"
            //                             data-bs-target="#deleteFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
            //                     </td>`
            //                     tableRow+='</tr>'
            //                 table.append(tableRow)
            //             })
            //             table = ""
            //         })
            //     },
            //     error:function(res){
            //         console.log(res.responseJSON.message)
            //     }
            // })

            let count = $('tbody[class*="aturan"');

            let table;
            for(let i = 0; i < count.length; i++){
                let id = count[i].className.replace(/\D/g, "");
                let className = count[i].className.split(" ")
                table = $('.'+className[0] + 'Table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/getaturan" + id,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'rule', name: 'rule'},
                        {data: 'hasil', name: 'hasil'},
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },
                    ],
                    bDestroy: true,
                    dom:'<"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>', 
                });
            }
        }

        let kategori = {};
        const getKategori = (id) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/aturan"+id,
                    type: 'POST',
                    data: {
                        'id_mental':id
                    },
                    dataType: 'json', // added data type
                    success: function(res) {
                        resolve(res.kategori)
                    },
                    error:function(res){
                        console.log(res.responseJSON.message)
                        reject(res)
                    }
                })
            })
            
        }

        getData();

        $('.addAturan').click(function() {
            let id = $(this).data('id')
            $('#add_idMental').attr('value', id)

            getKategori(id)
                .then((res) => {
                    for(let f in res){
                        let select = $('.addKategoriParent');
                        let option = "";
                        let el = "";
                        for(let k in f){
                            // option+= `<option value="${k.id_kategori}">${k.nama}</option>`
                            // select.append(option)
                            // option = ''
                            el = "";
                            el += '<select class="form-select form-control mx-3 col add_idKategori" id="add_idKategori" aria-label="Default select example" name="add_idKategori">'
                            for(let i = 0; i < res[f].length; i++){
                                option+= `<option value="${res[f][i].id_kategori}">${res[f][i].nama}</option>`
                                el += option;
                                option = "";
                            }
                            el += '</select>'
                            select.append(el)
                        }
                    }
                })
                .catch(err => console.log(err));
        })

        $('#addAturanModal').on('shown.bs.modal', function(){
            // $(this).find('#add_nama').focus()
        })

        $('#addAturanForm').on('submit',function(e){
            e.preventDefault();

            let k = $('.add_idKategori').get()
            let j = k.map(element => {
                return element.value
            });
            let formData = new FormData();
            formData.append('id_mental', $('#add_idMental').val())
            formData.append('aturan', j.join(','))
            formData.append('hasil', $('#add_hasil').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('postAturan')}}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.status === "Gagal"){
                        // $('.toast-header').addClass('bg-danger')
                        // setTimeout(() => {
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // $('.toast-header').removeClass('bg-danger')
                        // }, 4000)
                    }else{
                        // $('.toast-header').addClass('bg-primary')
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // var toast = new bootstrap.Toast($('.toast'))
                        // toast.show()
                        getData()
                        $('#addAturanModal').modal('toggle')
                        // setTimeout(() => {
                        //     toast.hide()
                        // }, 4000);
                        // if(toast.hide()){
                        //     $('.toast-title').text("")
                        //     $('.toast-text').text("")
                        //     $('.toast-header').removeClass('bg-primary')
                        //     $('#add_nama').atrr('value', '')
                        // }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.aturanBody').on('click','.editButton', function(){
            let id = $(this).data('id');
            let idMental = $(this).attr('data-id-mental');
            $('#edit_idAturan').attr('value', id);

            getKategori(idMental)
                .then((res) => {
                    let editData = $.parseJSON($.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "/editaturan"+id,
                            type: 'POST',
                            data: {
                                'id_aturan':id
                            },
                            dataType: 'json', // added data type
                            async: false
                        }).responseText)
                    $('#edit_hasil').val(editData.aturan.hasil)
                    editData = editData.aturan.aturan.split(',')
                    editData = editData.map(item => parseInt(item))
                    for(let f in res){
                        let select = $('.editKategoriParent');
                        let option = "";
                        let el = "";
                        for(let k in f){
                            el = "";
                            el += '<select class="form-select form-control mx-3 col edit_idKategori" id="edit_idKategori" aria-label="Default select example" name="edit_idKategori">'
                            for(let i = 0; i < res[f].length; i++){ 
                                option+=`<option value="${res[f][i].id_kategori}" ${editData.includes(res[f][i].id_kategori) ? 'selected' : ''}>${res[f][i].nama}</option>`
                                el += option;
                                option = "";
                            }
                            el += '</select>'
                            select.append(el)
                        }
                    }
                })
                .catch(err => console.log(err));
        })

        // $('#editAturanModal').on('shown.bs.modal', function(){
        //     $(this).find('#edit_nama').focus()
        // })

        $('#editAturanForm').on('submit',function(e){
            e.preventDefault();

            let k = $('.edit_idKategori').get()
            let j = k.map(element => {
                return element.value
            });
            let formData = new FormData();
            formData.append('id_aturan', $('#edit_idAturan').val())
            formData.append('aturan', j.join(','))
            formData.append('hasil', $('#edit_hasil').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updateAturan')}}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.status === "Gagal"){
                        // $('.toast-header').addClass('bg-danger')
                        // setTimeout(() => {
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // $('.toast-header').removeClass('bg-danger')
                        // }, 4000)
                    }else{
                        // $('.toast-header').addClass('bg-primary')
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // var toast = new bootstrap.Toast($('.toast'))
                        // toast.show()
                        getData()
                        $('#editAturanModal').modal('toggle')
                        // setTimeout(() => {
                        // toast.hide()
                        // }, 4000);
                        // if(toast.hide()){
                        // $('.toast-title').text("")
                        // $('.toast-text').text("")
                        // $('.toast-header').removeClass('bg-primary')
                        // $('#add_nama').atrr('value', '')
                        // }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('.aturanBody').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idAturan').attr('value', id);
        })

        $('#deleteAturanForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idAturan').val()
            formData.append('id_aturan', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/aturan"+id,
                type: 'DELETE',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.status === "Gagal"){
                    // $('.toast-header').addClass('bg-danger')
                    // setTimeout(() => {
                    // $('.toast-title').append(res.status)
                    // $('.toast-text').append(res.message)
                    // $('.toast-header').removeClass('bg-danger')
                    // }, 4000)
                    }else{
                    // $('.toast-header').addClass('bg-primary')
                    // $('.toast-title').append(res.status)
                    // $('.toast-text').append(res.message)
                    // var toast = new bootstrap.Toast($('.toast'))
                    // toast.show()
                    $('#deleteAturanModal').modal('toggle')
                    // setTimeout(() => {
                    // toast.hide()
                    // }, 4000);
                    // if(toast.hide()){
                    // $('.toast-title').text("")
                    // $('.toast-text').text("")
                    // $('.toast-header').removeClass('bg-primary')
                    // }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON)
                }
            })
        })
    })
</script>
@endsection