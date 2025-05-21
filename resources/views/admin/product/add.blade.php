@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="card-header">{{ __('Manage Products') }}</h5>
                        </div>
                        <div class="col-md-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                Add
                            </button>

                            <!-- Add Product Modal -->
                            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addProductForm" method="POST" action="{{ route('postAddProduct') }}" enctype="multipart/form-data">
                                                @csrf()

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="detail" class="form-label">{{ __('Detail') }}</label>
                                                    <textarea id="detail" class="form-control @error('detail') is-invalid @enderror" name="detail" rows="3" required>{{ old('detail') }}</textarea>
                                                    @error('detail')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="cost" class="form-label">{{ __('Cost') }}</label>
                                                    <input id="cost" type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost') }}" required>
                                                    @error('cost')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="category" class="form-label">{{ __('Category') }}</label>
                                                    <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                                                        <option value="" disabled selected>Select a Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="photo" class="form-label">{{ __('Photo') }}</label>
                                                    <input id="photo" type="file" class="form-control-file @error('photo') is-invalid @enderror" name="photo" required>
                                                    @error('photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-success">{{ __('Add Product') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Example Product Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Detail</th>
                                <th>Cost</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product )
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" style="width: 50px; height: 50px;">
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->detail}}</td>
                                <td>{{$product->cost}}</td> 
                                <td>{{ $product->category ? $product->category->title : $product->cat_id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $product->id }}">
                                            Edit
                                        </button>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editProductForm{{ $product->id }}" action="{{ route('updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="detail" class="form-label">Detail</label>
                                                                <textarea class="form-control" name="detail" rows="3" required>{{ $product->detail }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="cost" class="form-label">Cost</label>
                                                                <input type="number" step="0.01" class="form-control" name="cost" value="{{ $product->cost }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="category" class="form-label">Category</label>
                                                                <select class="form-control" name="category" required>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : '' }}>
                                                                            {{ $category->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="photo" class="form-label">Photo</label>
                                                                <input type="file" class="form-control" name="photo">
                                                            </div>
                                                            <button type="submit" class="btn btn-secondary">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this product?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('deleteProduct', $product->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
