<section class="bg-dark text-light d-flex flex-column vh-100 p-0 text-capitalize position-relative z-1">
    <div class="sticky-top">
        <!-- title -->
        <h4 class="px-3 py-5 text-capitalize bg-darkgray d-md-block">
            admin panel
        </h4>

        <!-- options -->
        @php
        $id = Auth::user()->id;
        $options = [
        ["title" => "change password", "icon" => "fas fa-key", "link" => "admin/security"],
        ["title" => "add product", "icon" => "fas fa-plus", "link" => "products/create"],
        ["title" => "search & edit product", "icon" => "fas fa-search", "link" => "admin/products"],
        ["title" => "categories", "icon" => "fas fa-list", "link" => "categories"],
        ["title" => "advertising", "icon" => "fas fa-ad", "link" => "ads"],
        ["title" => "create fake data", "icon" => "fas fa-vial", "link" => "admin/create_fake_data"],
        ]
        @endphp

        <!-- loop -->
        @foreach($options as $option)
        <a href="{{$option['link']}}" class="d-flex align-items-center hover-bg-darkgray py-3 js-link" title="{{ $option['title'] }}">
            <i class="{{$option['icon']}} col-2"></i>
            <span class="pl-2 d-md-block">{{$option['title']}}</span>
        </a>
        @endforeach

        <!-- logout -->
        <a class="d-flex align-items-center hover-bg-darkgray py-3" title="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt col-2"></i>
            <span class="pl-2 d-md-block">logout</span>
        </a>
    </div>
</section>