@extends('layouts.dashboard')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/mark/delete')}}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <tr>
                                <th><label for=""><input type="checkbox" id="chkSelectAll"> Check All</label></th>
                                <th>SL</th>
                                <th>Coupon Code</th>
                                <th>Discount</th>
                                <th>Validity</th>
                                <th>Created At</th>
                            </tr>

                            @foreach ($coupons as $key=> $coupon)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$coupon->coupon_code}}</td>
                                <td>{{$coupon->discount}}</td>
                                <td>{{$coupon->validity}}</td>
                                <td>{{$coupon->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{url('/coupon/delete', $coupon->id)}}" class="btn btn-danger shadow sharp mr-1 btn-xs"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Coupon</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/coupon/insert')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" name="coupon_code">
                            @error('coupon_code')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Discount %</label>
                            <input type="number" class="form-control" name="discount">
                            @error('discount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Validity</label>
                            <input type="date" class="form-control" name="validity">
                            @error('validity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Coupon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
