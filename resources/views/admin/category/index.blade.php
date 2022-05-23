@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/mark/delete')}}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <tr>
                                <th><label for=""><input type="checkbox" id="chkSelectAll"> Check All</label></th>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($categories as $key=> $category)
                            <tr>
                                <td><input type="checkbox" name="mark[]" class="chkDel" value="{{$category->id}}"></td>
                                <td>{{$key+1}}</td>
                                <td>{{$category->category_name}}</td>
                                <td>{{App\Models\User::find($category->added_by)->name}}</td>
                                <td><img width="100" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                                <td>{{$category->created_at < now()->subDays(30)? $category->created_at : $category->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('category.edit', $category->id)}}" class="btn btn-info shadow sharp mr-1 btn-xs"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('category.delete', $category->id)}}" class="btn btn-danger shadow sharp mr-1 btn-xs"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @if ($categories_count != 0)
                        <button class="btn btn-outline-danger" type="submit">Delete Checked</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/category/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-3">
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name">
                            @error('category_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="category_image">
                            @error('category_image')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">

            <div class="card">
                <div class="card-header">
                    <h3>Trash Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/mark/restore')}}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <tr>
                                <th><input type="checkbox" id="chktSelectAll"> Check All</th>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>

                            @forelse ($trash_categories as $key=> $category)
                            <tr>
                                <td><input type="checkbox" name="markt[]" class="chktDel" value="{{$category->id}}"></td>
                                <td>{{$key+1}}</td>
                                <td>{{$category->category_name}}</td>
                                <td>{{App\Models\User::find($category->added_by)->name}}</td>
                                <td><img width="100" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                                <td>{{$category->created_at < now()->subDays(30)? $category->created_at : $category->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('category.restore', $category->id)}}" class="btn btn-info shadow sharp mr-1 btn-xs"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('category.force_delete', $category->id)}}" class="btn btn-danger shadow sharp mr-1 btn-xs"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No Data Found</td>
                            </tr>
                            @endforelse
                        </table>
                            @if ($trash_categories_count != 0)
                        <button class="btn btn-outline-primary" name="del" value="1" type="submit">Restore Checked</button>
                        <button class="btn btn-danger" name="del" value="2" type="submit">Force Delete Checked</button>
                            @endif
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
    @if (session('delete'))
        <script>
            Swal.fire(
            'Good job!',
            "{{session('delete')}}",
            'success'
            )
        </script>
    @endif

    <script>
        $(function(){
            $("#chkSelectAll").on('click', function(){
                this.checked ? $(".chkDel").prop("checked", true) : $(".chkDel").prop("checked", false);
            });

            $("#chktSelectAll").on('click', function(){
                this.checked ? $(".chktDel").prop("checked", true) : $(".chktDel").prop("checked", false);
            });
        })
    </script>
@endsection
