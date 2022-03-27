@extends('frontend.layouts')
@section('title', 'Home')    
@section('content')
<!-- Product Catagories Area Start -->
    <div class="products-catagories-area clearfix">
        <div class="amado-pro-catagory clearfix">

            <!-- Single Catagory -->
            @foreach($categorys as $category)
                <div class="single-products-catagory clearfix">
                    <a href="{{ url("products/" . $category->slug) }}">
                        {{-- <img src="{{ asset("assets/img/bg-img/1.jpg") }}" alt=""> --}}
                        <img src="{{ env("PRODUCTION_URL") . Storage::url($category->main_image) }}" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line"></div>
                            {{-- <p>From $180</p> --}}
                            <h4>{{ $category->name }}</h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
<!-- Product Catagories Area End -->
@endsection