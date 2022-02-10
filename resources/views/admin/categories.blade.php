@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$edit_container_class = Session::get("show_edit_container") ? "" : "d-none";
$edit_action = Session::get("edit_id") ? "categories/".Session::get("edit_id") : "";
@endphp

<!-- navbar -->
@include('inc/navbar')

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/admin_sidebar")

        <!-- page -->
        <section class="col p-5">

            <!-- add new category -->
            <section>
                <div class="p-5 border border-gray bg-white">
                    <!-- title -->
                    <h4 class="text-capitalize">
                        add new category
                    </h4>

                    <!-- form -->
                    <form action="categories" method="post" enctype="multipart/form-data" class="pt-3">
                        @csrf

                        <!-- name -->
                        <div class="form-group">
                            <label class="font-weight-bold required">Name</label>
                            <input type="text" name="name" class="form-control active-shadow-main" placeholder="Enter a unique name">
                            <!-- error -->
                            @error("name")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <!-- image -->
                        <div class="form-group">
                            <label class="font-weight-bold required">image</label>
                            <input type="file" name="image" class="form-control active-shadow-main">
                            <!-- error -->
                            @error("image")
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

            <!-- manage categories -->
            <section class="pt-5">
                <div class="p-5 border border-gray bg-white">
                    <!-- title -->
                    <h4 class="text-capitalize">
                        manage categories
                    </h4>

                    <!-- categories -->
                    <div class="pt-3 text-capitalize">

                        @if(count($categories) === 0)
                        <p class="text-muted">no categories found ...</p>

                        @else
                        @foreach($categories as $category)
                        <div class="d-flex py-1 px-2 border border-gray">
                            <!-- name -->
                            <span class="text-capitalize col">{{ $category->name }}</span>

                            <!-- edit btn -->
                            <button class="text-main-dark hover-opacity mr-3" data-id="{{$category->id}}" data-name="{{ $category->name }}" title="edit category" onclick="
                        const edit_container = document.getElementById('edit-container');
                        const edit_form = document.getElementById('edit-form');
                        const input = document.getElementById('new-name');

                        edit_form.action = 'categories/' + this.dataset.id;
                        input.value = this.dataset.name;
                        edit_container.classList.remove('d-none');
                        ">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- delete btn -->
                            <button class="text-danger hover-opacity" data-id="{{$category->id}}" title="delete category" onclick="
                        document.getElementById('delete-container').classList.remove('d-none');
                        document.getElementById('delete-form').action = 'categories/' + this.dataset.id;;
                        ">
                                <i class="fas fa-trash"></i>
                            </button>

                        </div>
                        @endforeach


                        <table class="table-bordered w-100 d-none">
                            <!-- table head -->
                            <thead class="font-weight-bold">
                                <tr>
                                    <th class="p-1" scope="col">name</th>
                                    <th class="p-1 text-center" scope="col">edit</th>
                                    <th class="p-1 text-center" scope="col">delete</th>
                                </tr>
                            </thead>

                            <!-- table data -->
                            <tbody>
                                @foreach($categories as $key => $category)
                                <tr class="{{ $key % 2 == 0 ? '' : 'bg-light' }}">
                                    <!-- name -->
                                    <td class="p-1" scope="row">{{ $category->name }}</td>
                                    <!-- edit btn -->
                                    <td class="p-1 text-center">

                                    </td>
                                    <!-- delete btn -->
                                    <td class="p-1 text-center">

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                </div>
            </section>

        </section>
    </div>

    <!-- edit form -->
    <section id="edit-container" class="fixed-full bg-light-transparent {{ $edit_container_class }} d-center z-9999">
        <form id="edit-form" method="post" enctype="multipart/form-data" action="{{ $edit_action }}" class="col-10 col-sm-8 col-md-6 col-lg-4 bg-white p-5 border border-gray">
            @csrf
            @method('put')
            <!-- title -->
            <h4 class="text-capitalize">edit category</h4>

            <!-- new name -->
            <div class="form-group">
                <label class="font-weight-bold optional text-capitalize">new name</label>
                <input id="new-name" type="text" name="new_name" class="form-control @error('new_name') is-invalid @enderror" placeholder="Enter a new name">
                @error('new_name')
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
        <form id="delete-form" method="post" action="" class="col-10 col-sm-8 col-md-6 col-lg-4 bg-white p-5 border border-gray">
            @csrf
            @method('delete')
            <!-- title -->
            <div class="text-center">
                <h4 class="text-center text-capitalize">are you sure you want to delete this category ?</h4>
                <small class="text-muted">the products in this category won't be deleted, but they won't belong to a category anymore</small>
            </div>


            <!-- options -->
            <div class="d-flex align-items-center justify-content-between pt-5">
                <!-- delete btn -->
                <button type="submit" class="btn btn-danger">yes delete the category !!</button>

                <!-- cancel btn -->
                <div class="btn btn-gray border-dark" onclick="
                document.getElementById('delete-container').classList.add('d-none');
                ">cancel</div>
            </div>
        </form>
    </section>
</section>
@endsection