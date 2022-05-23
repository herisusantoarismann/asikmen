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
        <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
        <button type="button" class="btn btn-primary" data-bs-target="#addUsersModal" data-bs-toggle="modal">Add
            New</button>
    </div>
    <div class="card-body">
        <table class="table table-hover usersTable">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
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
                        <label for="namaFaktor">Level</label>
                        <select class="form-select form-control" aria-label="Default select example" id="add_level">
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
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
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="editUserForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="edit_idUser">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" placeholder="Nama" nama="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" class="form-control" id="edit_email" placeholder="Email" nama="email"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="namaFaktor">Level</label>
                        <select class="form-select form-control" aria-label="Default select example" id="edit_level">
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
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
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="deleteUserForm">
                @csrf
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <input type="hidden" id="delete_idUser" name="id_user">
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

            var table = $('.usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/users",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'level', name: 'level', "render":function(data){
                        if(data == 0){
                            return 'User'
                        }else{
                            return 'Admin'
                        }
                    }},
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
                bDestroy: true,
                dom:'<"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
            });
        }

        getData();

        $('#addUser').on('shown.bs.modal', function(){
            $(this).find('#add_nama').focus()
        })

        $('#addUser').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('name', $('#add_nama').val())
            formData.append('level', $('#add_level').val())
            formData.append('email', $('#add_email').val())
            formData.append('password', $('#add_password').val())
            formData.append('password_confirmation', $('#add_passwordConfirmation').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/users",
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
                    $('#addUsersModal').modal('toggle')
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

        $('.usersTable').on('click','.editButton', function(){
            let id = $(this).data('id');
            $('#edit_idUser').attr('value', id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/edituser"+id,
                type: 'POST',
                data: {
                    'id':id
                },
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#edit_nama').val(res.data.name)
                    $('#edit_email').val(res.data.email)
                    $('#edit_level').val(res.data.level).change()
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        })

        $('#editUserModal').on('shown.bs.modal', function(){
            $(this).find('#edit_nama').focus()
        })

        $('#editUserForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('id', $('#edit_idUser').val())
            formData.append('name', $('#edit_nama').val())
            formData.append('email', $('#edit_email').val())
            formData.append('level', $('#edit_level').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/updateuser",
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
                    $('#editUserModal').modal('toggle')
                    // setTimeout(() => {
                    //     toast.hide()
                    //     $('.toast-title').text("")
                    //     $('.toast-text').text("")
                    // }, 4000);
                },
                error:function(res){
                    console.log(res)
                }
            })
        })

        $('.usersTable').on('click', '.deleteButton', function(){
            let id = $(this).data('id');
            $('#delete_idUser').attr('value', id);
        })

        $('#deleteUserForm').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            let id = $('#delete_idUser').val()
            formData.append('id', id)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/user"+id,
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
                        $('#deleteUserModal').modal('toggle')
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