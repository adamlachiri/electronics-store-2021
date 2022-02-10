<!-- vars -->
@php
$all_categories = \App\Models\Category::all();
$cart_count = isset(Auth::user()->cart_items) ? count(Auth::user()->cart_items) : 0;
@endphp

<section id="nav-container" class="text-light border-bottom border-dark position-absolute top-0 left-0 right-0 z-2">

    <!-- topbar -->
    <nav class="py-1 align-items-center justify-content-between bg-darkgray">
        <!-- logo -->
        <a href="" title="back to home" class="mx-5">
            <img src="framework/img/logo.png" width=50 alt="">
        </a>

        <!-- search -->
        <form action="products" method="get" class="d-md-flex align-items-stretch px-0 mr-3 col text-dark border border-main rounded">
            @csrf
            <!-- btn -->
            <button type="submit" class="bg-main px-3 d-center hover-opacity">
                <i class="fas fa-search fa-lg text-dark"></i>
            </button>

            <!-- type -->
            <select name="category_id" class="hover-opacity text-capitalize bg-light" style="width:5rem">
                <option value="">all</option>

                <!-- categories -->
                @foreach($all_categories as $category)
                @php
                $selected = old('category_id') == $category->id ? "selected" : "";
                @endphp
                <option value="{{$category->id}}" {{ $selected }}>{{$category->name}}</option>
                @endforeach
            </select>

            <!-- input -->
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter a product name" class="col focus-shadow-main">
        </form>

        <!-- right side -->
        <div class="d-flex align-items-center">
            <!-- auth -->
            <div class="text-capitalize mx-1">
                @guest
                <a href="login" class="hover-outline d-center p-2" style="height: 3rem">
                    <i class="fas fa-sign-in-alt pr-1"></i>
                    sign in
                </a>
                @else

                @if(Auth::user()->is_admin())
                <!-- admin pannel -->
                <a href="admin/security" class="d-center flex-column font-weight-bold p-2 hover-outline" style="height: 3rem" title="visit your profile">
                    <span class="d-block">admin panel</span>
                </a>
                @else
                <!-- profile -->
                <a href="profile/edit" class="d-center flex-column font-weight-bold p-2 hover-outline" style="height: 3rem" title="visit your profile">
                    <small class="d-block">visit your profile</small>
                    <span>{{Auth::user()->name}}</span>
                </a>
                @endif

                @endguest


            </div>

            <!-- cart -->
            <a href="cart" class="d-center font-weight-bold p-2 mx-1 hover-outline {{ $cart_count > 0 ? 'text-main' : '' }}" title="your cart" style="height: 3rem">
                <i class="fas fa-cart-plus pr-1"></i>
                <span class="h5">{{ $cart_count }}</span>
            </a>
        </div>
    </nav>

    <!-- newbar -->
    <nav class="d-md-none align-items-center py-2 px-5 bg-dark">
        <!-- search -->
        <form action="products" method="get" class="d-md-none d-flex align-items-stretch px-0 mr-3 col text-dark border border-main rounded">
            @csrf
            <!-- btn -->
            <button type="submit" class="bg-main px-3 d-center hover-opacity">
                <i class="fas fa-search fa-lg text-dark"></i>
            </button>

            <!-- type -->
            <select name="category_id" class="hover-opacity text-capitalize bg-light" style="width:5rem">
                <option value="">all</option>

                <!-- categories -->
                @foreach($all_categories as $category)
                @php
                $selected = old('category_id') == $category->id ? "selected" : "";
                @endphp
                <option value="{{$category->id}}" {{ $selected }}>{{$category->name}}</option>
                @endforeach
            </select>

            <!-- input -->
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter a product name" class="col focus-shadow-main">
        </form>

        <!-- dropdown btn -->
        <i id="dropdown-btn" class="fas fa-bars fa-2x text-light d-md-none">
        </i>
    </nav>

    <!-- navbar links -->
    <nav class="d-md-flex align-items-stretch text-capitalize bg-dark">
        <!-- home -->
        <a href="" class="px-2 py-1 hover-outline">
            home
        </a>

        <!-- all products -->
        <a href="products" class="px-2 py-1 hover-outline">
            all products
        </a>

        <!-- category links -->
        @foreach($all_categories as $category)
        <a href="products?category_id={{$category->id}}" class="px-2 py-1 hover-outline js-link">
            {{$category->name}}
        </a>
        @endforeach
    </nav>

    <!-- nav dropdown -->
    <div class="bg-dark-transparent">
        <div id="nav-dropdown" class="hide-left d-none d-flex ease-out-fast opacity-0 text-light text-capitalize">
            <!-- links -->
            <div class="py-2 bg-dark">
                <a href="" class="d-block px-5 py-2 h5 hover-bg-darkgray">
                    home
                </a>
                <hr>
                @foreach($all_categories as $category)
                <a href="products?category_id={{$category->id}}" class="d-block px-5 py-2 h5 hover-bg-darkgray">
                    {{$category->name}}
                </a>
                @endforeach
            </div>
        </div>
    </div>


    <!-- navbar script -->
    <script>
        // dropdown btn click event
        document.getElementById('dropdown-btn').addEventListener("click", function() {
            if (this.classList.contains("fa-bars")) {
                open_dropdown();
            } else {
                close_dropdown();
            }
        })

        // window resize
        window.addEventListener("resize", function() {
            close_dropdown();
            get_dropdown_height();
        })

        // load event
        window.addEventListener("load", get_dropdown_height);

        // dropdown height function
        function get_dropdown_height() {
            document.getElementById('nav-dropdown').style.height = 'calc(100vh - ' + document.getElementById('nav-container').clientHeight + 'px'
        }

        // close dropdown function
        function close_dropdown() {
            document.getElementById('dropdown-btn').classList.add('fa-bars');
            document.getElementById('dropdown-btn').classList.remove('fa-times');
            document.getElementById('nav-dropdown').classList.add('opacity-0');
            document.getElementById('nav-dropdown').classList.add('hide-left');
            setTimeout(() => {
                document.getElementById('nav-dropdown').classList.add('d-none');
            }, 500);
        }

        // open dropdown function
        function open_dropdown() {
            document.getElementById('dropdown-btn').classList.remove('fa-bars');
            document.getElementById('dropdown-btn').classList.add('fa-times');
            document.getElementById('nav-dropdown').classList.remove('d-none');
            setTimeout(() => {
                document.getElementById('nav-dropdown').classList.remove('opacity-0');
                document.getElementById('nav-dropdown').classList.remove('hide-left');
            }, 200);
        }
    </script>

</section>

<!-- anti nav -->
<div id="anti-nav">
    <script>
        // anti nav function
        function anti_nav() {
            const nav_height = document.getElementById('nav-container').clientHeight;
            document.getElementById('anti-nav').style.height = nav_height + "px";
        }

        window.addEventListener("load", anti_nav);
        window.addEventListener("resize", anti_nav);
    </script>
</div>