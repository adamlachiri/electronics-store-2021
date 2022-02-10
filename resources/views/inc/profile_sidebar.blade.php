<div class="bg-dark text-light d-flex flex-column vh-100 p-0 text-capitalize">

    <!-- title -->
    <h4 class="px-3 py-5 text-capitalize bg-darkgray d-md-block">
        {{Auth::user()->name}}
    </h4>

    <!-- options -->
    @php
    $id = Auth::user()->id;
    $options = [
    ["title" => "edit profile", "icon" => "fas fa-edit", "link" => "profile/edit"],
    ["title" => "change password", "icon" => "fas fa-key", "link" => "profile/security"],
    ["title" => "your orders", "icon" => "fas fa-boxes", "link" => "profile/".$id."/orders"],
    ["title" => "favourites", "icon" => "fas fa-heart", "link" => "favourites"],
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