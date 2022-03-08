@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">

    <div class="col-lg-4 order-lg-2">

        <div class="card shadow mb-4">
            <div class="card-profile-image mt-4">
                <figure class="rounded-circle avatar avatar font-weight-bold"
                    style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}">
                </figure>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h5 class="font-weight-bold">{{ Auth::user()->name }}</h5>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-8 order-lg-1">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="" autocomplete="off" id="editProfile">

                    <h6 class="heading-small text-muted mb-4 title-profile" data-id="{{ Auth::id() }}">User information
                    </h6>

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Name<span
                                            class="small text-danger">*</span></label>
                                    <input type="hidden" name="id_user" id="id_user">
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Nama">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email address<span
                                            class="small text-danger">*</span></label>
                                    <input type="email" id="email" class="form-control" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="current_password">Current password</label>
                                    <input type="password" id="current_password" class="form-control"
                                        name="current_password" placeholder="Current password">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">New password</label>
                                    <input type="password" id="new_password" class="form-control" name="new_password"
                                        placeholder="New password">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="confirm_password">Confirm password</label>
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

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
            let id = $('.title-profile').data('id')

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/profile" + id,
                type: 'POST',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#id_user').attr('value', res.data.id)
                    $('#name').attr('value', res.data.name)
                    $('#email').attr('value', res.data.email)
                },
                error:function(res){
                    console.log(res.responseJSON.message)
                }
            })
        }

        getData();

        $('#editProfile').submit(function(e) {
            e.preventDefault()

            let formData = new FormData();
            formData.append('id_user', $('#id_user').val())
            formData.append('name', $('#name').val())
            formData.append('email', $('#email').val())
            formData.append('old_password', $('#current_password').val())
            formData.append('new_password', $('#new_password').val())
            formData.append('password_confirmation', $('#password_confirmation').val())

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/profile",
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
                        toast.show()
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
                        toast.show()
                        getData()
                        setTimeout(() => {
                            toast.hide()
                            $('.toast-title').text("")
                            $('.toast-text').text("")
                            $('.toast-header').removeClass('bg-primary')
                        }, 4000);
                    }
                },
                error:function(res){
                    $('.toast-title').append("Error")
                    $('.toast-text').append(res.responseJSON.message)
                    $('.toast-header').addClass('bg-danger')
                    var toast = new bootstrap.Toast($('.toast'))
                    toast.show()
                    setTimeout(() => {
                        toast.hide()
                        $('.toast-title').append("")
                        $('.toast-text').append("")
                        $('.toast-header').removeClass('bg-danger')
                    }, 4000)
                }
            })
        })
    })
</script>
@endsection