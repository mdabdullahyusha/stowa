@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Welcome, <strong>{{$logged_user}}</strong><span class="float-end">Total User, ({{ $total_user}})</span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $key => $user)
                    <tr>
                        <td>{{$users->firstitem()+$key}}</td>
                        <td>{{$user-> name}}</td>
                        <td>{{$user-> email}}</td>
                        <td>{{$user-> created_at}}</td>
                        <td><a href="{{route('delete',$user->id)}}" class="btn btn-danger shadow sharp mr-1 btn-xs"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                    </table>
                    {{$users -> links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
