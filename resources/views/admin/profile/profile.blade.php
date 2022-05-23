@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-header">
                        <h3>Change Name</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/name/change')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{Auth::user()->name}}" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-header">
                        <h3>Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/password/change')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="password" class="form-control" name="old_password" placeholder="Enter Old Password">
                                @error('old_password')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="New Password">
                                @error('password')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-header">
                        <h3>Change Photo</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/photo/change')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="profile_photo">
                                    <label class="custom-file-label"></label>
                                </div>
                                @error('profile_photo')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Photo Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')
    @if (session('success'))
        <script>
            Swal.fire(
            'Good job!',
            "{{session('success')}}",
            'success'
            )
        </script>
    @endif
    @if (session('wrong_pass'))
        <script>
            Swal.fire(
            'Bad job!',
            "{{session('wrong_pass')}}",
            'error'
            )
        </script>
    @endif
@endsection
