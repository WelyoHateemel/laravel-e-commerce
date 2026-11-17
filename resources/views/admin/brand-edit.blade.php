@extends('layouts.admin')

@section('title', 'Edit Brand')

@section('page-heading', 'Edit Brand')

@section('content')

@if (session('trigger_error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('trigger_error') }}
    </div>
@endif

    <div class="flex-1 overflow-y-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Brand</h1>

            <a href="{{ route('admin.brands') }}"
                class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Brands
            </a>
        </div>

        <div class="max-w-3xl mx-auto">

            <form action="{{ route('admin.brands.update', $brand->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 space-y-6">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Brand Name *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $brand->name) }}"
                            placeholder="e.g. Samsung"
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg outline-none focus:ring-1 focus:ring-primary"
                            required>

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Brand Slug
                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $brand->slug) }}"
                            placeholder="samsung"
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg bg-gray-50 outline-none focus:ring-1 focus:ring-primary">

                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Current Logo
                        </label>

                        <div class="w-full h-24 border border-gray-200 rounded-lg bg-gray-50 flex items-center justify-center p-3">

                            @if($brand->image)
                                <img
                                    src="{{ asset('storage/' . $brand->image) }}"
                                    alt="{{ $brand->name }}"
                                    class="max-w-full max-h-full object-contain">
                            @else
                                <span class="text-sm text-gray-400">
                                    No logo available
                                </span>
                            @endif

                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Change Brand Logo
                        </label>

                        <div class="relative w-full h-24">

                            <label for="brand-image"
                                class="relative flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition overflow-hidden">

                                <div id="upload-content"
                                    class="flex flex-col items-center justify-center">

                                    <i class="fa-solid fa-image text-2xl text-gray-400 mb-1"></i>

                                    <p class="text-xs text-gray-500">
                                        Upload new brand logo
                                    </p>
                                </div>

                                <img
                                    id="image-preview"
                                    class="hidden absolute inset-0 w-full h-full object-contain p-2 z-20 bg-white"
                                    src=""
                                    alt="Logo Preview">

                                <input
                                    id="brand-image"
                                    name="image"
                                    type="file"
                                    class="hidden"
                                    accept="image/png, image/jpeg, image/webp">

                            </label>

                            <button
                                type="button"
                                id="remove-logo-btn"
                                class="hidden absolute -top-2 -right-2 z-30 bg-white text-red-500 hover:text-white hover:bg-red-500 rounded-full w-7 h-7 flex items-center justify-center shadow-md border border-gray-200 transition-colors">

                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        </div>

                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        id="status"
                        name="status"
                        value="1"
                        {{ old('status', $brand->status) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">

                    <label for="status" class="text-sm text-gray-700">
                        Set as Active Brand
                    </label>

                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">

                    <a href="{{ route('admin.brands') }}"
                        class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition text-sm">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition text-sm font-medium shadow-sm">
                        Save Brand
                    </button>

                </div>

            </form>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('brand-image');
        const imagePreview = document.getElementById('image-preview');
        const uploadContent = document.getElementById('upload-content');
        const removeButton = document.getElementById('remove-logo-btn');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image.');
                    this.value = '';
                    return;
                }

                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('hidden');
                uploadContent.classList.add('hidden');
                removeButton.classList.remove('hidden');
            }
        });

        removeButton.addEventListener('click', function () {
            imageInput.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadContent.classList.remove('hidden');
            removeButton.classList.add('hidden');
        });
    </script>
@endsection
