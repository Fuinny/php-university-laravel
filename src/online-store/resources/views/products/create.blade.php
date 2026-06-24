@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add New Product</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('products.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                                    @error('title') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category_id" class="col-md-4 col-form-label text-md-end">Category</label>
                                <div class="col-md-6">
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price" class="col-md-4 col-form-label text-md-end">Price</label>
                                <div class="col-md-6">
                                    <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_added" class="col-md-4 col-form-label text-md-end">Date Added</label>
                                <div class="col-md-6">
                                    <input id="date_added" type="date" class="form-control @error('date_added') is-invalid @enderror" name="date_added" value="{{ old('date_added', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required style="resize: none; overflow: scroll;">{{ old('description') }}</textarea>
                                    @error('description') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Save Product</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
