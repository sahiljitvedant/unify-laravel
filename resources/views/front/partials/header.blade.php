<ul class="nav-links">
    <li><a href="{{ route('home') }}">Home</a></li>

    <li class="dropdown">
        <a href="javascript:void(0)">Products</a>
        <ul class="dropdown-menu">
            @foreach($products as $product)
                <li>
                    <a href="{{ route('product.page', $product->slug) }}">
                        {{ $product->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>

    <li><a href="#classes">Blogs</a></li>
    <li><a href="{{ route('login_get') }}" target="_blank">Login</a></li>
</ul>
<style>
    .dropdown {
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background: #fff;
    min-width: 200px;
    top: 100%;
    left: 0;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    z-index: 999;
}

.dropdown-menu li {
    list-style: none;
}

.dropdown-menu li a {
    display: block;
    padding: 10px 15px;
    color: #000;
    text-decoration: none;
}

.dropdown-menu li a:hover {
    background: #f2f2f2;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

</style>