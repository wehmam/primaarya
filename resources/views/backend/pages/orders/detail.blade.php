@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Product Detail")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")
     <!-- Begin Page Content -->
     <div class="container-fluid">

        <!-- Page Heading -->
        <p class="mb-4">Order Invoice : ({{ $order->invoice_no }}) <span><a href="{{ url("/backend/orders") }}" class="btn btn-sm btn-info float-right"><i class="fa fa-backward"></i> Back</a></span> </p>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-7 col-lg-10">
                <!-- Product Detail -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Details</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                User Email : {{ $order->user ? $order->user->email : "" }}
                            </li>
                            <li class="list-group-item">
                                User Name : {{ $order->user ? $order->user->name : "" }}
                            </li>
                            <li class="list-group-item">
                                User Phone : {{ $order->phone }}
                            </li>
                            <li class="list-group-item">
                                Product : {{ $order->product ? $order->product->title : "" }}
                            </li>
                            <li class="list-group-item">
                                Quantity : {{ $order->quantity }}
                            </li>
                            <li class="list-group-item">
                                Price Per Product :  Rp . {{ number_format($order->price_per_product, 0) }}
                            </li>
                            <li class="list-group-item">
                                Total Price : Rp . {{ number_format($order->price_total, 0) }}
                            </li>
                            <li class="list-group-item">
                                Address : {{ $order->address }}
                            </li>
                          </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-10">

                <!-- Product Detail -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Invoice Details</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                Bill Pembayaran : BP{{ $order->invoice_details ? $order->invoice_details->invoice_id : ""  }}
                            </li>
                            <li class="list-group-item">
                                Bill Title : {{ $order->invoice_details ? $order->invoice_details->title : ""  }}
                            </li>
                            <li class="list-group-item">
                                Bill Total : Rp . {{ $order->invoice_details ? number_format($order->invoice_details->amount, 0) : 0 }}
                            </li>
                            <li class="list-group-item">
                                Status Payment : <a class="badge badge-{{ !is_null($order->invoice_details->invoice->paid_at) ? "success" : "danger" }}">{{ !is_null($order->invoice_details->invoice->paid_at) ? "Paid" : "Not Paid" }}</a>
                            </li>
                          </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                 <!-- Bar Chart -->
                 <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Photos</h6>
                    </div>
                    <div class="card-body">
                        @if($order->product->productPhotos) 
                            <div class="card-columns">
                                @foreach ($order->product->productPhotos as $item)
                                    <div class="card">
                                        <img class="card-img"  src="{{ env("PRODUCTION_URL") . Storage::url($item->image) }}" alt="Card image">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection