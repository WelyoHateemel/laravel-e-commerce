
@extends('layouts.admin')

@section('title', 'Brands')

@section('page-heading', 'Brands')

@section('content')

<div class="flex-1 overflow-y-auto p-6 bg-gray-100">

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Brands</h1>
            <p class="text-sm text-gray-500">Manage product brands and partners</p>
        </div>

        <a href="{{ route('admin.brands.add') }}"
            class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i>
            Add New Brand
        </a>
    </div>

    <!-- Search and Status Filter -->
    <form action="{{ route('admin.brands') }}" method="GET"
        class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">

        <div class="flex flex-col sm:flex-row items-center gap-3">

            <!-- Search Brand -->
            <div class="relative w-full sm:flex-1">

                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search brand..."
                    class="w-full border border-gray-300 rounded-lg pl-11 pr-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary focus:border-primary">

            </div>

            <!-- Filter Status -->
            <div class="w-full sm:w-48">

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-primary focus:border-primary">

                    <option value="">All Status</option>

                    <option value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ request('status') == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

            <!-- Filter Button -->
            <button
                type="submit"
                class="w-full sm:w-auto bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">

                <i class="fa-solid fa-filter mr-1"></i>
                Filter

            </button>

            <!-- Clear Button -->
            <a href="{{ route('admin.brands') }}"
                class="w-full sm:w-auto text-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition">

                <i class="fa-solid fa-xmark mr-1"></i>
                Clear

            </a>

        </div>

    </form>

    <!-- Brands Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left whitespace-nowrap">

                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">

                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Logo</th>
                        <th class="px-6 py-4">Brand Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($brands as $brand)

                        <tr class="hover:bg-gray-50 transition">

                            <!-- ID -->
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $brand->id }}
                            </td>

                            <!-- Logo -->
                            <td class="px-6 py-4">

                                <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center border overflow-hidden">

                                    @if($brand->image)

                                        <img
                                            src="{{ asset('storage/' . $brand->image) }}"
                                            class="max-w-[30px] max-h-[30px] object-contain"
                                            alt="{{ $brand->name }}">

                                    @else

                                        <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center text-gray-500 font-bold">
                                            B
                                        </div>

                                    @endif

                                </div>

                            </td>

                            <!-- Brand Name -->
                            <td class="px-6 py-4">

                                <span class="font-semibold text-gray-800">
                                    {{ $brand->name }}
                                </span>

                            </td>

                            <!-- Slug -->
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $brand->slug }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">

                                @if($brand->status == 'active')

                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 text-right">

                                <div class="flex items-center justify-end gap-3">

                                    <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                        class="text-blue-500 hover:text-blue-700"
                                        title="Edit Brand">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </a>

                                    <button
                                        type="button"
                                        onclick="deleteBrand(this)"
                                        data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->name }}"
                                        data-url="{{ route('admin.brands.delete', $brand->id) }}"
                                        class="text-red-500 hover:text-red-700"
                                        title="Delete Brand">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">

                                <div class="flex flex-col items-center justify-center gap-3">

                                    <i class="fa-solid fa-boxes-stacked text-4xl text-gray-300"></i>

                                    <h3 class="text-lg font-semibold text-gray-700">
                                        No brands available
                                    </h3>

                                    <p class="text-sm">
                                        No brands found matching your search.
                                    </p>

                                    <a href="{{ route('admin.brands.add') }}"
                                        class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">

                                        <i class="fa-solid fa-plus"></i>
                                        Add New Brand

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">

            {{ $brands->links() }}

        </div>

    </div>

</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" action="">

    @csrf
    @method('DELETE')

</form>

<!-- Delete Confirmation Modal -->
<div id="deleteModal"
    class="fixed inset-0 z-50 hidden"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm"
        onclick="closeModal()">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">

        <div class="flex min-h-full items-center justify-center p-4">

            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl w-full max-w-md">

                <div class="bg-white px-4 pb-4 pt-5 sm:p-6">

                    <div class="sm:flex sm:items-start">

                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">

                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>

                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">

                            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                Delete Brand
                            </h3>

                            <div class="mt-2">

                                <p class="text-sm text-gray-500">

                                    Are you sure you want to delete

                                    <strong id="delete-brand-name" class="text-gray-800">
                                        this brand
                                    </strong>?

                                    This action cannot be undone.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">

                    <button
                        type="submit"
                        form="deleteForm"
                        class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition">

                        Delete

                    </button>

                    <button
                        type="button"
                        id="cancelDeleteBtn"
                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">

                        Cancel

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const brandNameSpan = document.getElementById('delete-brand-name');
        const cancelBtn = document.getElementById('cancelDeleteBtn');

        window.deleteBrand = function (buttonElement) {

            const brandName = buttonElement.dataset.name;
            const deleteUrl = buttonElement.dataset.url;

            brandNameSpan.textContent = brandName;
            deleteForm.action = deleteUrl;

            deleteModal.classList.remove('hidden');

        };

        window.closeModal = function () {

            deleteModal.classList.add('hidden');
            deleteForm.action = '';

        };

        cancelBtn.addEventListener('click', function () {

            window.closeModal();

        });

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {
                window.closeModal();
            }

        });

    });

</script>

@endsection
