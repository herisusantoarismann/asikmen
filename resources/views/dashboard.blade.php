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
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary user-title" data-id="{{Auth::user()->id}}">Hasil Tes</h6>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center hasilTable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Mental</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Hasil Test</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<!-- Add Mental Modal -->
<div class="modal fade" id="addUsersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addUser">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="add_nama" placeholder="Nama" nama="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" class="form-control" id="add_email" placeholder="Email" nama="email"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="add_password" placeholder="Password"
                            nama="password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password Confirmation</label>
                        <input type="password" class="form-control" id="add_passwordConfirmation" placeholder="Password"
                            nama="password_confirmation" required>
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
<div class="modal fade" id="editHasilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Hasil</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editHasilForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_hasil" id="edit_idHasil">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Hasil</label>
                        <input type="text" class="form-control" id="edit_hasil" placeholder="Hasil" nama="hasil"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Hasil</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Mental Modal -->
<div class="modal fade" id="deleteHasilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Hasil</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteHasilForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idHasil" name="id_hasil">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        const getData = () => {
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     url: "/mental",
            //     type: 'GET',
            //     dataType: 'json', // added data type
            //     success: function(res) {
            //         $('.mentalTable').empty()
            //         let table = $('.mentalTable');
            //         res.mental.map((item, index) => {
            //             table.append('<tr>')
            //             table.append(`<th scope="row">${index+1}</th>`)
            //             table.append(`<th scope="row">${item.nama}</th>`)
            //             table.append(`<th scope="row" style="width:50%;">${item.description}</th>`)
            //             table.append(`<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
            //                 <button type="button" class="btn btn-warning editButton" data-id="${item.id_mental}"
            //                     data-bs-target="#editMental" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
            //                 <button type="button" class="btn btn-danger deleteButton" data-id="${item.id_mental}"
            //                     data-bs-target="#deleteMental" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
            //             </td>`)
            //             table.append('</tr>')
            //         })
            //     },
            //     error:function(res){
            //         console.log(res.responseJSON.message)
            //     }
            // })

            let id = $('.user-title').data('id');

            var table = $('.hasilTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/hasil" + id,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'userNama', name: 'userNama'},
                    {data: 'mentalNama', name: 'mentalNama'},
                    {data: 'created_at', name: 'created_at', "render":function(data){
                        let date = moment(data).utc().format('DD-MM-YYYY')
                        return date;
                    }},
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

        getData();

        // $('#addMental').on('shown.bs.modal', function(){
        //     $(this).find('#add_nama').focus()
        // })

        // $('#addMental').on('submit',function(e){
        //     e.preventDefault();

        //     let formData = new FormData();
        //     formData.append('nama', $('#add_nama').val())
        //     formData.append('description', $('#add_description').val())

        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: "/mental",
        //         type: 'POST',
        //         data: formData,
        //         dataType: 'json', // added data type
        //         processData: false,
        //         contentType: false,
        //         success: function(res) {
        //             // $('.toast-title').append(res.status)
        //             // $('.toast-text').append(res.message)
        //             // var toast = new bootstrap.Toast($('.toast'))
        //             // toast.show()
        //             getData()
        //             $('#addMentalModal').modal('toggle')
        //             // setTimeout(() => {
        //             //     toast.hide()
        //             //     $('.toast-title').text("")
        //             //     $('.toast-text').text("")
        //             // }, 4000);
        //         },
        //         error:function(res){
        //             console.log(res.responseJSON.message)
        //         }
        //     })
        // })

            $('.hasilTable').on('click','.editButton', function(){
                let id = $(this).data('id');
                $('#edit_idHasil').attr('value', id);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/edithasil"+id,
                    type: 'POST',
                    data: {
                        'id_hasil':id
                    },
                    dataType: 'json', // added data type
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#edit_hasil').val(res.data.hasil)
                    },
                    error:function(res){
                        console.log(res.responseJSON.message)
                    }
                })
            })

            $('#editHasilModal').on('shown.bs.modal', function(){
                $(this).find('#edit_hasil').focus()
            })

            $('#editHasilForm').on('submit',function(e){
                e.preventDefault();

                let formData = new FormData();
                formData.append('id_hasil', $('#edit_idHasil').val())
                formData.append('hasil', $('#edit_hasil').val())

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/updatehasil",
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
                        $('#editHasilModal').modal('toggle')
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

        $('.hasilTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idHasil').attr('value', id);
        })

        $('#deleteHasilForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idHasil').val()
            formData.append('id_hasil', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/hasil"+id,
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
                        // $('.toast-header').addClass('bg-primary')
                        // $('.toast-title').append(res.status)
                        // $('.toast-text').append(res.message)
                        // var toast = new bootstrap.Toast($('.toast'))
                        // toast.show()
                        getData()
                        $('#deleteHasilModal').modal('toggle')
                        // setTimeout(() => {
                        //     toast.hide()
                        //     $('.toast-title').text("")
                        //     $('.toast-text').text("")
                        //     $('.toast-header').removeClass('bg-primary')
                        // }, 4000);
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