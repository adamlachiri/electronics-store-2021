<section class="text-capitalize bg-white d-sm-block">
    <div class="sticky-top">
        <!-- filter -->
        <div class="p-3 ease-out-fast">
            <!-- categories -->
            <section>
                <h6 class="font-weight-bold">categories</h6>
                <ul class="p-2">
                    <li>
                        <label class="d-flex align-items-center js-submit-onclick" data-id="products-form">
                            <input form="products-form" type="radio" name="category_id" class="mr-2" value="">
                            <span class="hover-text-main-dark">all</span>
                        </label>
                    </li>
                    @foreach(App\Models\Category::all() as $category)
                    @php
                    $checked = old("category_id") == $category->id ? "checked" : "";
                    $class = old("category_id") == $category->id ? "font-weight-bold" : "";
                    @endphp
                    <li>
                        <label class="d-flex align-items-center js-submit-onclick" data-id="products-form">
                            <input form="products-form" type="radio" name="category_id" class="mr-2" value="{{ $category->id }}" {{ $checked }}>
                            <span class="hover-text-main-dark {{ $class }}">{{ $category->name }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </section>
            <hr>

            <!-- rating -->
            <section>
                @php
                $ratings = [
                ["value" => "4", "span" => "& up"],
                ["value" => "3", "span" => "& up"],
                ["value" => "2", "span" => "& up"],
                ["value" => "1", "span" => "& up"],
                ]
                @endphp
                <h6 class="font-weight-bold">ratings</h6>
                <ul class="p-2">
                    @foreach($ratings as $rating)
                    @php
                    $checked = old("rating") == $rating["value"] ? "checked" : "";
                    $class = old("rating") == $rating["value"] ? "font-weight-bold" : "";
                    @endphp
                    <li>
                        <label class="d-flex align-items-center hover-text-main-dark {{ $class }}  js-submit-onclick" data-id="products-form">
                            <input form="products-form" type="radio" name="rating" class="mr-2" value="{{ $rating['value'] }}" {{ $checked }}>
                            <span class="text-main">
                                {{ stars($rating["value"]) }}
                            </span>
                            <span>{{ $rating["span"]}}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </section>
            <hr>

            <!-- price -->
            <section>
                @php
                $prices = [
                ["value" => "3000", "span" => "under 3000 DH"],
                ["value" => "1000", "span" => "under 1000 DH"],
                ["value" => "500", "span" => "under 500 DH"],
                ["value" => "100", "span" => "under 100 DH"],
                ]
                @endphp
                <h6 class="font-weight-bold">price</h6>
                <ul class="p-2">
                    @foreach($prices as $price)
                    @php
                    $checked = old("max_price") == $price["value"] ? "checked" : "";
                    $class = old("max_price") == $price["value"] ? "font-weight-bold" : "";
                    @endphp
                    <li>
                        <label class="d-flex align-items-center hover-text-main-dark {{ $class }} js-submit-onclick" data-id="products-form">
                            <input form="products-form" type="radio" name="max_price" class="mr-2" value="{{ $price['value'] }}" {{ $checked }}>
                            <span>{{ $price["span"]}}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</section>