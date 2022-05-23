<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Aplikasi Cek Mental</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top:150px;"><br>
        <div class="col-md-4 col-md-offset-4 container">
            <h2 class="text-center"><b>ASIKMEN</b><br>Aplikasi Cek Mental</h2>
            @if(session('success'))
            <div class="alert alert-danger">
                {{session('success')}}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form id="postRegister">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required=""
                                id="add_email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                required="" id="add_password">
                        </div>
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Password" required="" id="add_passwordConfirmation">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-4 container mt-4">
            <div class="card">
                <div class="card-body">
                    Sudah punya akun? <a href="/">Login</a> sekarang!
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $('#postRegister').on('submit',function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('level', 0)
            formData.append('name', 'User')
            formData.append('email', $('#add_email').val())
            formData.append('password', $('#add_password').val())
            formData.append('password_confirmation', $('#add_passwordConfirmation').val())
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/postRegister",
                type: 'POST',
                data: formData,
                dataType: 'json', // added data type
                processData: false,
                contentType: false,
                success:function(){
                    window.location ='http://localhost:8000/'
                }
            })
        })
    </script>
</body>

</html>