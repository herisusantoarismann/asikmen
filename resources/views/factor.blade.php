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
        <table class="table table-hover text-center faktor{{$m->id_mental}}Table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Faktor</th>
                    <th scope="col" width="30%">Description</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="faktor{{$m->id_mental}} faktorBody">
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
                    <div class="form-group kategoriField">
                        <div class="d-flex justify-content-between mb-3">
                            <label for="exampleFormControlTextarea1">Kategori</label>
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group btn-group-sm me-3" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-primary minKategori">-</button>
                                </div>
                                <div class="btn-group btn-group-sm me-3" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-light countKategori">2</button>
                                </div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-primary plusKategori">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mx-4 row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Nama Kategori" id="add_kategori1">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Nilai" id="add_nilai1">
                            </div>
                        </div>
                        <div class="mb-3 mx-4 row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Nama Kategori" id="add_kategori2">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Nilai" id="add_nilai2">
                            </div>
                        </div>
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
                    <input type="hidden" name="id_mental" value="1" id="edit_idMental">
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
                    <div class="form-group editKategoriField">
                        <div class="d-flex justify-content-between mb-3">
                            <label for="exampleFormControlTextarea1">Kategori</label>
                            <span id="edit_count" class="d-hidden"></span>
                        </div>
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

            let count = $('tbody[class*="faktor"');

            let table;
            for(let i = 0; i < count.length; i++){
                let id = count[i].className.replace(/\D/g, "");
                let className = count[i].className.split(" ")
                table = $('.'+className[0] + 'Table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/getfactor" + id,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'description', name: 'description'},
                        {data: 'kategori', name:'kategori'},
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

        getData();

        $('.minKategori').click(function(){
            let parent = $('.kategoriField').children();
            if(parent.length <= 3){ 
                alert('Minimal Harus 2 Kategori') 
            }else{ 
                $('.countKategori').text((parent.length - 1) - 1);
                parent.last().remove(); 
            } 
        })

        $('.plusKategori').click(function(){
            let count = ($('.kategoriField').children().length + 1) - 1;
            $('.countKategori').text(count)
            $('.kategoriField').append('<div class="mb-3 mx-4 row"><div class="col-sm-6"><input type="text" class="form-control" placeholder="Nama Kategori" id="add_kategori'+ count +'"></div><div class="col-sm-6"><input type="text" class="form-control" placeholder="Nilai" id="add_nilai' + count + '"></div></div>')
        })

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
                    if(res.status == "Gagal"){
                        $('.toast-header').addClass('bg-danger')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        setTimeout(() => {
                            $('.toast-title').append("")
                            $('.toast-text').append("")
                            $('.toast-header').removeClass('bg-danger')
                        }, 4000)
                    }else{
                        $('.toast-header').addClass('bg-primary')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        getData()
                        for(let i = 1; i <= $('.countKategori').text(); i++){
                            let formData = new FormData();
                            formData.append('id_mental', $('#add_idMental').val())
                            formData.append('id_faktor', res.faktor.id_faktor)
                            formData.append('nama', $('#add_kategori'+i).val())
                            formData.append('nilai', $('#add_nilai'+i).val())

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{route('postKategori')}}",
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
                                        // getData()
                                        // $('#add_idFaktor').val(res.faktor.id_faktor)
                                        // $('#addFaktorModal').modal('toggle')
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
                                    console.log(res)
                                }
                            })
                        }
                        $('#addFaktorModal').modal('toggle')
                        setTimeout(() => {
                            $('.toast').toast('hide')
                            $('.toast-title').empty()
                            $('.toast-text').empty()
                            $('.toast-header').removeClass('bg-primary')
                        }, 4000);
                    }
                },
                error:function(res){
                    $('.toast-title').append("Error")
                    $('.toast-text').append("Mohon masukkan data dengan benar!")
                    $('.toast-header').addClass('bg-danger')
                    var toast = new bootstrap.Toast($('.toast'))
                    $('.toast').toast('show')
                    setTimeout(() => {
                        $('.toast').toast('hide')
                        $('.toast-title').empty()
                        $('.toast-text').empty()
                        $('.toast-header').removeClass('bg-danger')
                    }, 4000)
                }
            })
        })

        $('.faktorBody').on('click','.editButton', function(){
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
                    $('#edit_idMental').val(res.data.id_mental)
                    $('#edit_nama').val(res.data.nama)
                    $('#edit_description').val(res.data.description)
                    $('#edit_count').text(res.kategori.length)
                    $('.editKategoriField').children().not(':first-child').remove()
                    for(let i = 0; i < res.kategori.length; i++){
                        $('.editKategoriField').append('<div class="mb-3 mx-4 row"><div class="col-sm-6"><input type="text" class="form-control" onchange="ganti(event)" name="edit_kategori' + (i+1) + '" data-id="' + res.kategori[i].id_kategori + '" id="edit_kategori'+ (i+1) +'" value="' + res.kategori[i].nama + '"></div><div class="col-sm-6"><input type="text" class="form-control" onchange="ganti(event)" name="edit_nilai' + (i+1) + '" id="edit_nilai' + (i+1) + '" value="' + res.kategori[i].nilai.toString() + '"></div></div>')
                    }
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('#editFaktorModal').on('shown.bs.modal', function(){
            $(this).find('#edit_nama').focus()
            console.log($('#edit_kategori1').val("HEri"))
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
                    if(res.status == "Gagal"){
                        $('.toast-header').addClass('bg-danger')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        setTimeout(() => {
                            $('.toast-title').append("")
                            $('.toast-text').append("")
                            $('.toast-header').removeClass('bg-danger')
                        }, 4000)
                    }else{
                        $('.toast-header').addClass('bg-primary')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        getData()
                        for(let i = 1; i <= $('#edit_count').text(); i++){ 
                            let formData=new FormData(); 
                            formData.append('id_kategori', $('#edit_kategori'+i).data('id')) 
                            formData.append('id_mental', $('#edit_idMental').val()) 
                            formData.append('id_faktor', res.faktor) 
                            formData.append('nama', $('#edit_kategori'+i).val()) 
                            formData.append('nilai', $('#edit_nilai'+i).val()) 
                            
                            $.ajax({ 
                                headers: { 
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') 
                                }, 
                                url: "{{route('updateKategori')}}" , 
                                type: 'POST' , 
                                data: formData, 
                                dataType: 'json' ,
                                processData: false, 
                                contentType: false, 
                                success: function(res) { 
                                    if(res.status==="Gagal" ){ 
                                    //$('.toast-header').addClass('bg-danger') // setTimeout(()=> {
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
                                    // getData()
                                    // $('#add_idFaktor').val(res.faktor.id_faktor)
                                    // $('#addFaktorModal').modal('toggle')
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
                                    console.log(res)
                                }
                            })
                        }
                        $('#editFaktorModal').modal('toggle')
                        setTimeout(() => {
                            $('.toast').toast('hide')
                            $('.toast-title').empty()
                            $('.toast-text').empty()
                            $('.toast-header').removeClass('bg-primary')
                        }, 4000);
                    }
                },
                error:function(res){
                    $('.toast-title').append("Error")
                    $('.toast-text').append("Mohon masukkan data dengan benar!")
                    $('.toast-header').addClass('bg-danger')
                    var toast = new bootstrap.Toast($('.toast'))
                    $('.toast').toast('show')
                    setTimeout(() => {
                        $('.toast').toast('hide')
                        $('.toast-title').empty()
                        $('.toast-text').empty()
                        $('.toast-header').removeClass('bg-danger')
                    }, 4000)
                }
            })
        })

        $('.faktorBody').on('click', '.deleteButton', function(){
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
                        // $('.toast-header').addClass('bg-danger')
                        // setTimeout(() => {
                        //     $('.toast-title').append(res.status)
                        //     $('.toast-text').append(res.message)
                        //     $('.toast-header').removeClass('bg-danger')
                        // }, 4000)
                    }else{
                        // $('.toast-header').addClass('bg-primary')
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // var toast = new bootstrap.Toast($('.toast'))
                        // toast.show()
                        getData()
                        $('#deleteFaktorModal').modal('toggle')
                        // setTimeout(() => {
                        //     toast.hide()
                        // }, 4000);
                        // if(toast.hide()){
                        //     $('.toast-title').text("")
                        //     $('.toast-text').text("")
                        //     $('.toast-header').removeClass('bg-primary')
                        // }
                    }
                },
                error:function(res){
                    console.log(res.responseJSON)
                }
            })

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/kategori"+id,
                type: 'DELETE',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    if(res.status == "Gagal"){
                        $('.toast-header').addClass('bg-danger')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        setTimeout(() => {
                            $('.toast-title').append("")
                            $('.toast-text').append("")
                            $('.toast-header').removeClass('bg-danger')
                        }, 4000)
                    }else{
                        $('.toast-header').addClass('bg-primary')
                        $('.toast-title').append(res.status)
                        $('.toast-text').append(res.message)
                        var toast = new bootstrap.Toast($('.toast'))
                        $('.toast').toast('show')
                        getData()
                        $('#deleteFaktorModal').modal('toggle')
                        setTimeout(() => {
                            $('.toast').toast('hide')
                            $('.toast-title').empty()
                            $('.toast-text').empty()
                            $('.toast-header').removeClass('bg-primary')
                        }, 4000);
                    }
                },
                error:function(res){
                    $('.toast-title').append("Error")
                    $('.toast-text').append("Error!")
                    $('.toast-header').addClass('bg-danger')
                    var toast = new bootstrap.Toast($('.toast'))
                    $('.toast').toast('show')
                    setTimeout(() => {
                        $('.toast').toast('hide')
                        $('.toast-title').empty()
                        $('.toast-text').empty()
                        $('.toast-header').removeClass('bg-danger')
                    }, 4000)
                }
            })
        })
    })
</script>
@endsection