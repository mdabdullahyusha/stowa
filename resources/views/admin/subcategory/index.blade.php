@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Sub Category List</h3>
                </div>
                <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($subcategories as $key=> $subcategory)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{!!($subcategory->rel_to_category->deleted_at == NULL ? $subcategory->rel_to_category->category_name : $subcategory->rel_to_category->category_name . ' <span class="badge bg-secondary text-white">Soft Deleted</span>')!!}</td>
                                    <td>{{$subcategory->subcategory_name}}</td>
                                    <td>{{$subcategory->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{route('subcategory.delete', $subcategory->id)}}" class="btn btn-danger shadow sharp mr-1 btn-xs"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                </div>
            </div>

            {{-- <div class="card mt-5">
                <div class="card-header">
                    <h3>Trash Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/mark/restore')}}" method="POST" >
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

                            @foreach ($subcategories as $key=> $subcategory)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$subcategory->rel_to_category->category_name}}</td>
                                </tr>
                            @endforeach


                        </table>
                            @if ($trash_categories_count != 0)
                        <button class="btn btn-outline-primary" name="del" value="1" type="submit">Restore Checked</button>
                        <button class="btn btn-danger" name="del" value="2" type="submit">Force Delete Checked</button>
                            @endif
                    </form>
                </div>
            </div> --}}

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Sub Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/subcategory/insert')}}" method="POST">
                        @csrf

                        <div class="mt-3">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Option --</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" name="subcategory_name">
                            @error('subcategory_name')
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
