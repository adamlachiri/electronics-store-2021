@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$edit_container_class = Session::get("show_edit_container") ? "" : "d-none";
$edit_action = Session::get("edit_id") ? "ads/".Session::get("edit_id") : "";
@endphp

<!-- navbar -->
@include('inc/navbar')

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/admin_sidebar")

        <!-- page -->
        <section class="col p-5">

            <!-- add new ad -->
            <section>
                <div class="p-5 border border-gray bg-white">
                    <!-- title -->
                    <h4 class="text-capitalize">
                        add new ad
                    </h4>

                    <!-- form -->
                    <form action="ads" method="post" enctype="multipart/form-data" class="pt-3">
                        @csrf

                        <!-- type -->
                        <div class="form-group">
                            <label class="font-weight-bold required text-capitalize">type</label>
                            <select name="type" class="form-control">
                                <option disabled selected class="text-muted">choose the type ...</option>
                                <option value="banner">banner</option>
                                <option value="card">card</option>
                            </select>
                            <!-- error -->
                            @error("type")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <!-- image -->
                        <div class="form-group">
                            <label class="font-weight-bold required text-capitalize">image</label>
                            <input type="file" name="image" class="form-control active-shadow-main">
                            <!-- error -->
                            @error("image")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <!-- products id -->
                        <div class="form-group">
                            <label class="font-weight-bold required text-capitalize">product_id</label>
                            <input type="text" name="product_id" value="{{ $product_id }}" class="form-control active-shadow-main" placeholder="Enter the advertised product id">
                            <!-- error -->
                            @error("product_id")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <!-- submit -->
                        <button type="submit" class="btn btn-main text-dark">
                            <i class="fas fa-plus pr-1"></i>
                            <span>add</span>
                        </button>
                    </form>
                </div>
            </section>

            <!-- manage ads -->
            <section class="pt-5">
                <div class="p-5 border border-gray bg-white">
                    <!-- title -->
                    <h4 class="text-capitalize">
                        manage ads
                    </h4>

                    <!-- ads -->
                    <div class="pt-3 text-capitalize">

                        @if(count($ads) === 0)
                        <p class="text-muted">no ads found ...</p>

                        @else
                        <section class="table-responsive" style="overflow-x: auto">
                            <table class="table table-bordered">
                                <!-- table head -->
                                <thead class="font-weight-bold">
                                    <tr>
                                        <th scope="col">image</th>
                                        <th scope="col">product name</th>
                                        <th scope="col">edit</th>
                                        <th scope="col">delete</th>
                                    </tr>
                                </thead>

                                <!-- table data -->
                                <tbody>
                                    @foreach($ads as $key => $ad)
                                    <tr class="{{ $key % 2 == 0 ? '' : 'bg-light' }}">
                                        <!-- image -->
                                        <td class="bg-center bg-no-repeat bg-cover" style="background-image: url('storage/{{ $ad->image }}')">
                                        </td>

                                        <!-- product name -->
                                        <td>
                                            {{ $ad->product->name }}
                                        </td>

                                        <!-- edit btn -->
                                        <td class="text-center">
                                            <button class="text-main-dark hover-opacity mr-3" data-id="{{$ad->id}}" title="edit ad" onclick="
                        document.getElementById('edit-form').action = 'ads/' + this.dataset.id;
                        document.getElementById('edit-container').classList.remove('d-none');
                        ">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                        <!-- delete btn -->
                                        <td class="text-danger text-center">
                                            <button class="text-danger hover-opacity" data-id="{{$ad->id}}" title="delete ad" onclick="
                        document.getElementById('delete-container').classList.remove('d-none');
                        document.getElementById('delete-form').action = 'ads/' + this.dataset.id;
                        ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>

                        @endif
                    </div>

                </div>
            </section>

        </section>
    </div>

    <!-- edit form -->
    <section id="edit-container" class="fixed-full bg-light-transparent {{ $edit_container_class }} d-center z-9999">
        <form id="edit-form" method="post" enctype="multipart/form-data" action="{{ $edit_action }}" class="col0 col-sm-8 col-md-6 col-lg-4 bg-white p-5 border border-gray">
            @csrf
            @method('put')
            <!-- title -->
            <h4 class="text-capitalize">edit ad</h4>

            <!-- new type -->
            <div class="form-group">
                <label class="font-weight-bold optional text-capitalize">new type</label>
                <select id="new-type" name="new_type" class="form-control">
                    <option disabled selected class="text-muted">choose the type ...</option>
                    <option value="banner">banner</option>
                    <option value="card">card</option>
                </select>
                @error('new_type')
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>

            <!-- new image -->
            <div class="form-group">
                <label class="font-weight-bold optional text-capitalize">new image</label>
                <input type="file" name="new_image" class="form-control @error('new_image') is-invalid @enderror" placeholder="Enter a new name">
                @error('new_image')
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>

            <!-- new products id -->
            <div class="form-group">
                <label class="font-weight-bold optional text-capitalize">new product id</label>
                <input type="text" name="new_product_id" class="form-control active-shadow-main" placeholder="Enter a new product id">
                <!-- error -->
                @error("new_product_id")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>

            <!-- btn -->
            <div class="d-flex align-items-center justify-content-between text-capitalize">
                <!-- edit btn -->
                <button type="submit" class="btn btn-main text-dark">edit</button>

                <!-- close btn -->
                <div class="btn btn-gray border-dark" onclick="
                document.getElementById('edit-container').classList.add('d-none');
                ">close</div>
            </div>
        </form>
    </section>

    <!-- delete form -->
    <section id="delete-container" class="fixed-full bg-light-transparent d-none d-center z-9999">
        <form id="delete-form" method="post" action="" class="col0 col-sm-8 col-md-6 col-lg-4 bg-white p-5 border border-gray">
            @csrf
            @method('delete')
            <!-- title -->
            <div class="text-center">
                <h4 class="text-center text-capitalize">are you sure you want to delete this ad ?</h4>
                <small class="text-muted">the products in this ad won't be deleted, but they won't belong to a ad anymore</small>
            </div>


            <!-- options -->
            <div class="d-flex align-items-center justify-content-between pt-5">
                <!-- delete btn -->
                <button type="submit" class="btn btn-danger">yes delete the ad !!</button>

                <!-- cancel btn -->
                <div class="btn btn-gray border-dark" onclick="
                document.getElementById('delete-container').classList.add('d-none');
                ">cancel</div>
            </div>
        </form>
    </section>
</section>
@endsection