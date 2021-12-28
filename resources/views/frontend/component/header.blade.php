 <!-- Header Area Start -->
 <header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    
    <!-- Logo main -->
    <div class="logo">
        {{-- <a href="index.html"><img src="{{ asset("assets/img/core-img/logo.png") }}" alt=""></a> --}}
        <a href="#">
            <img src="https://laravel.com/img/logomark.min.svg" alt="">
        </a>
    </div>

    <!-- Side Menu Nav -->
    <nav class="amado-nav">
        <ul>
            <li class="{{ Request::segment(1) == "" ? "active" : "" }}"><a href="{{ url("") }}">Home</a></li>
            <li class="{{ Request::segment(1) == "products" ? "active" : "" }}"><a href="{{ url('/products') }}" >Products</a></li>
            {{-- <li class="{{ Request::segment(1) == "cart" ? "active" : "" }}"><a href="{{ url('cart') }}">Cart</a></li> --}}
            {{-- <li class="{{ Request::segment(1) == "checkout" ? "active" : "" }}"><a href="{{ url('checkout') }}">Checkout</a></li> --}}
        </ul>
    </nav>

    {{-- <!-- Button Group -->
    <div class="amado-btn-group mt-30 mb-100">
        <a href="#" class="btn amado-btn mb-15">%Discount%</a>
        <a href="#" class="btn amado-btn active">New this week</a>
    </div> --}}

    <!-- Cart Menu -->
    <div class="cart-fav-search mb-100">
        <a href="{{ url("cart") }}" class="cart-nav"><img src="{{ asset("assets/img/core-img/cart.png") }}" alt=""> Cart <span>(0)</span></a>
        <a href="#" class="search-nav"><img src="{{ asset("assets/img/core-img/search.png") }}" alt=""> Search</a>
        {{-- <a href="#" class="fav-nav"><img src="{{ asset("assets/img/core-img/favorites.png") }}" alt=""> Favourite</a> --}}
    </div>

    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    </div>
    
</header>
<!-- Header Area End -->