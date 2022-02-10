<?php

// flash success message 

use Illuminate\Support\Facades\Session;

function success_msg()
{
    if (Session::get("success")) {
        echo '
    <div id="success" class="fixed-bottom px-5 py-1 bg-success text-white js-success d-flex align-items-center justify-content-between">
        <div>
            <i class="fas fa-check pr-1"></i>
            <span>' . Session::get("success") . '</span>
        </div>
        <button class="border border-light circle hover-opacity d-center js-close" data-id="success" style="width:2rem"
        ">
            <i class="fas fa-times"></i>
        </button>
    </div>
    ';

        // remove key
        Session::forget("success");
    }
}

function error_msg()
{
    if (Session::get("error")) {
        echo '
    <div id="error" class="fixed-bottom px-5 py-1 bg-danger text-white js-error d-flex align-items-center justify-content-between">
        <div>
            <i class="fas fa-exclamation-circle pr-1"></i>
            <span>' . Session::get("error") . '</span>
        </div>
        <button class="border border-light circle hover-opacity d-center js-close" data-id="error" style="width:2rem"
        ">
            <i class="fas fa-times"></i>
        </button>
    </div>
    ';

        // remove key
        Session::forget("error");
    }
}

function stars($rating)

{
    switch (true) {

        case $rating >= 4.7:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star"];
            break;

        case $rating >= 4.5:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star-half-alt"];
            break;

        case $rating >= 4:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star", "far fa-star"];
            break;

        case $rating >= 3.5:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star", "fas fa-star-half-alt", "far fa-star"];
            break;

        case $rating >= 3:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star", "far fa-star", "far fa-star"];
            break;

        case $rating >= 2.5:
            $classes = ["fas fa-star", "fas fa-star", "fas fa-star-half-alt", "far fa-star", "far fa-star"];
            break;

        case $rating >= 2:
            $classes = ["fas fa-star", "fas fa-star", "far fa-star", "far fa-star", "far fa-star"];
            break;

        case $rating >= 1.5:
            $classes = ["fas fa-star", "fas fa-star-half-alt", "far fa-star", "far fa-star", "far fa-star"];
            break;

        case $rating >= 1:
            $classes = ["fas fa-star", "far fa-star", "far fa-star", "far fa-star", "far fa-star"];
            break;

        default:
            $classes = ["far fa-star text-muted", "far fa-star text-muted", "far fa-star text-muted", "far fa-star text-muted", "far fa-star text-muted"];
    }

    foreach ($classes as $class) {
        echo '<i class="' . $class . ' pr-1 text-shadow"></i>';
    }
}

function text_dots($str)
{
    return strlen($str) > 100 ? substr($str, 0, 100) . " . . . " : $str;
}

function stock_situation($stock)
{
    switch (true) {
        case $stock <= 0:
            echo '<span class="text-capitalize text-danger">out of stock</span>';
            break;

        case $stock < 10:
            echo '<span class="text-capitalize text-danger">only ' . $stock . ' left !</span>';
            break;
        default:
            echo    '<span class="text-capitalize text-success">in stock</span>';
    }
}

function carousel($products)
{
    echo '
    <div class="js-carousel ease-out-fast pt-5">

            <!-- slider container -->
            <div class="js-slider-container">

                <!-- prev btn -->
                <div class="js-btn-container position-absolute left-0 top-0 bottom-0 z-2">
                    <i class="fas fa-chevron-left fa-2x js-prev py-5 px-2 bg-white border border-gray hover-opacity"></i>
                </div>

                <!-- items -->
                <div class="js-slider">';
    foreach ($products as $product)
        echo '
                    <a href="products/' . $product->id . '">
                        <img src="storage/' . $product->main_image . '" height=150 width=auto class="mx-3" alt="" title="' . $product->name . '">
                    </a>
                    ';
    echo '</div>

                <!-- next btn -->
                <div class="js-btn-container position-absolute right-0 top-0 bottom-0">
                    <i class="fas fa-chevron-right fa-2x js-next py-5 px-2 bg-white border border-gray hover-opacity"></i>
                </div>
            </div>

            <!-- carousel scrollbar -->
            <div class="js-scrollbar-container mt-3" style="height: 0.7rem;">
                <div class="js-scrollbar bg-gray border border-gray rounded right-0 left-0 "></div>
            </div>
        </div>
    ';
}


function carousel_vertical($products)
{
    echo '
    <div class="js-carousel-vertical ease-out-fast h-100">
            <div class="js-slider d-flex flex-column">
        ';

    // items
    foreach ($products as $product) {
        echo '
            <a href="products/' . $product->id . '">
                <img src="storage/' . $product->main_image . '" alt="" title="' . $product->name . '" class="my-3 img-fluid">
            </a>';
    }
    echo '
            </div>

            <div class="js-btn-container left-0 right-0 top-0">
                <button class="js-prev bg-white hover-opacity border border-gray px-4 py-1">
                    <i class="fas fa-angle-up fa-2x"></i>
                </button>
            </div>

            <div class="js-btn-container left-0 right-0 bottom-0">
                <button class="js-next bg-white hover-opacity border border-gray px-4 py-1">
                    <i class="fas fa-angle-down fa-2x"></i>
                </button>
            </div>

    </div>';
}

// banner ad
function banner_ad($ad)
{
    echo '
    <a href="products/' .  $ad->product_id . '" class="d-block position-relative my-2">
        <img src="storage/' . $ad->image . '" class="w-100" alt="">
        <div class="position-absolute top-0 left-0 text-muted p-1">
            <i class="fas fa-exclamation-circle pr-1"></i>
            <span>Sponsored</span>
        </div>
    </a>
    ';
}

// card ad
function card_ad($ad)
{
    echo '
            <a href="products/' . $ad->id . '" class="card hover-opacity">
                <div class="d-flex justify-content-between">

                    <small class="text-muted p-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Sponsored</span>
                    </small>';

    // if promotion
    if ($ad->promotion) {
        echo '
                        <div class="bg-success text-white py-1 px-3">
                            Save
                            <span>' . $ad->promotion . '</span>
                            %
                        </div>
                        ';
    }

    echo '
                </div>

                <div class="d-center p-2" style="height: 15rem">
                    <img src="storage/' . $ad->main_image . '" class="img-fluid" alt="">
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="text-main pr-1">';
    // stars
    echo stars($ad->rating);

    echo '</span>
                        <span class="text-info">' . $ad->rating . '</span>
                    </div>
                    <div class="pt-1">' . $ad->name . '</div>
                </div>

            </a>
                    ';
}

function input_error($name)
{
    if (Session::has("errors")) {
        $errors = Session::get("errors");
        if ($errors->has($name)) {
            echo '
        <div class="text-danger d-flex align-items-center">
            <i class="fas fa-exclamation-circle pr-2"></i>
            <span>
            ' . $errors->first($name) . '
            </span>
        </div>
        ';
        }
    }
}
