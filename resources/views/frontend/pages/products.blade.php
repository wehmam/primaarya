@extends('frontend.layouts')
@section('title', 'Products')    
@section('content')

@include('frontend.component.widget-products')

<div class="amado_product_area section-padding-100">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                    <!-- Total Products -->
                    <div class="total-products">
                        <p>Showing {{ count($products) > 0 ? 1 : 0 }} - {{ count($products) }} Products</p>
                        {{-- <div class="view d-flex">
                            <a href="#"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-bars" aria-hidden="true"></i></a>
                        </div> --}}
                    </div>
                    {{-- <!-- Sorting -->
                    <div class="product-sorting d-flex">
                        <div class="sort-by-date d-flex align-items-center mr-15">
                            <p>Sort by</p>
                            <form action="#" method="get">
                                <select name="select" id="sortBydate">
                                    <option value="value">Date</option>
                                    <option value="value">Newest</option>
                                    <option value="value">Popular</option>
                                </select>
                            </form>
                        </div>
                        <div class="view-product d-flex align-items-center">
                            <p>View</p>
                            <form action="#" method="get">
                                <select name="select" id="viewProduct">
                                    <option value="value">12</option>
                                    <option value="value">24</option>
                                    <option value="value">48</option>
                                    <option value="value">96</option>
                                </select>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($products as $item)
            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="single-product-wrapper">
                    <!-- Product Image -->
                    <div class="product-img">
                        <a href="{{ url("product/detail/" . $item->id) }}">
                            <img src="{{ Storage::url($item->productPhotos[0]->image) }}">
                            <!-- Hover Thumb -->
                            <!-- <img class="hover-img" src="img/product-img/product2.jpg" alt=""> -->
                            {{-- <img class="hover-img" src="{{ Storage::url($item->productPhotos[1]->image) }}" alt=""> --}}
                        </a>
                    </div>

                    <!-- Product Description -->
                    <div class="product-description d-flex align-items-center justify-content-between">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data">
                            <div class="line"></div>
                            <p class="product-price">Rp {{ number_format($item->price, 0) }}</p>
                            <a href="{{ url("product/detail/" . $item->id) }}">
                                <h6>{{ $item->title }}</h6>
                            </a>
                        </div>
                        <!-- Ratings & Cart -->
                        <div class="ratings-cart text-right">
                            <div class="ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                            <div class="cart">
                                <a href="{{ url("product/detail/" . $item->id) }}" data-toggle="tooltip" data-placement="left" title="Add to Cart"><img src="{{ asset("assets/img/core-img/cart.png") }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
          
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Pagination -->
                @php
                    $link_limit = 7;   
                @endphp
                @if($products->lastPage() > 1)
                    <nav aria-label="navigation">
                        <ul class="pagination justify-content-end mt-50">
                            @for($i = 1; $i <= $products->lastPage(); $i++) 
                                @php 
                                    $half_total_links = floor($link_limit / 2);
                                    $from = $products->currentPage() - $half_total_links;
                                    $to = $products->currentPage() + $half_total_links;
                                    if ($products->currentPage() < $half_total_links) {
                                        $to += $half_total_links - $products->currentPage();
                                    }
                                    if ($products->lastPage() - $products->currentPage() < $half_total_links) {
                                        $from -= $half_total_links - ($products->lastPage() - $products->currentPage()) - 1;
                                    }
                                @endphp
                                @if ($from < $i && $i < $to)
                                    @php
                                        $currUrl = $products->url($i);  
                                    @endphp
                                    <li class="page-item {{ $products->currentPage() == $i ? "active" : "" }}"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection