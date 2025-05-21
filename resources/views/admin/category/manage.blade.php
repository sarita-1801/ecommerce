    @extends('layouts.app')

    @section('content')
    <head>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="{{ asset('css/manageCategory.css') }}">
    </head>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-md-10">
                            <div class="card-header">{{ __('Manage Category') }}</div>
                        </div>
                        <div class="col-md-2">
                           
                             <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                               Add
                            </button>
                
                                <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form id="addCategoryForm" action="{{route('postAddCategory')}}" method="POST" enctype="multipart/form-data">
                                            @csrf()
                                        
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="details" class="form-label">Details</label>
                                                <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-secondary">Add</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="card-body">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Create date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->title }}</td>
                                    <td>{{$category->details}}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                    <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                        Edit
                                    </button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editCategoryForm{{ $category->id }}" action="{{ route('updateCategory', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" name="title" value="{{ $category->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Details</label>
                                                            <textarea class="form-control" name="details" rows="3" required>{{ $category->details }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                        Delete
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this category?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('deleteCategory', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
