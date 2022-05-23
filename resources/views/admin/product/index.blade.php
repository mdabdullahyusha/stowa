@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Product List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>After Discount</th>
                                    <th>Brand</th>
                                    <th>Description</th>
                                    <th>Preview</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $key=>$product)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $product->product_name}}</td>
                                    <td>{{ $product->product_price}}</td>
                                    <td>{{ $product->product_discount}}</td>
                                    <td>{{ $product->after_discount}}</td>
                                    <td>{{ $product->brand}}</td>
                                    <td>{{ substr($product->description, 0, 20)}}</td>
                                    <td>
                                        <img src="{{asset('uploads/product/preview')}}/{{$product->preview}}" width="50" alt="">
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{route('inventory', $product->id)}}" class="btn btn-info shadow btn-xs sharp my-1">
                                            <i class="fa fa-archive"></i>
                                        </a>
                                        <a href="{{url('/product/delete', $product->id)}}" class="btn btn-danger shadow btn-xs sharp my-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-primary px-2">
                        <h3 class=" text-light">Add Product</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/product/insert') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="subcategory_id" class="form-control" id="subcategory_name">
                                    <option value="">-- Select Subategory --</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_price" placeholder="Product Price">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_discount" placeholder="Product Discount %">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="brand" placeholder="Brand Name">
                            </div>
                            <div class="form-group">
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea name="short_description" class="form-control" placeholder="Short Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Product Image</label>
                                <input type="file" class="form-control" name="product_preview">
                            </div>
                            <div class="form-group">
                                <label>Product Thumbnails</label>
                                <input type="file" class="form-control" name="product_thumbnails[]" multiple>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
<script>
    $('#category_id').change(function(){
        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getCategory',
            data: {'category_id':category_id},
            success: function(data){
                $('#subcategory_name').html(data);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#subcategory_name').select2();
        $('#category_id').select2();
    });
</script>
@endsection
