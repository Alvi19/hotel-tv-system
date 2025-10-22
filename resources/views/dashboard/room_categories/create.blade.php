@extends('layouts.app')
@section('title', 'Add Room Category')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
            <i class="bi bi-tags text-info"></i> Add New Room Category
        </h3>
        <a href="{{ route('dashboard.room-categories.index') }}" class="btn btn-outline btn-accent">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-error shadow-lg">
            <div>
                <i class="bi bi-exclamation-triangle"></i>
                <span>
                    <strong>There were some problems with your input:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </span>
            </div>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl">
        <div class="card-body space-y-4">
            <form action="{{ route('dashboard.room-categories.store') }}" method="POST">
                @csrf

                {{-- 🏷️ Category Name --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Category Name</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400"
                        placeholder="e.g. Deluxe, Suite, Family Room"
                        required
                    />
                </div>

                {{-- 📝 Description --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Description (optional)</span>
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="textarea textarea-bordered w-full bg-base-200 text-white placeholder-gray-400"
                        placeholder="Enter short description or leave blank"
                    >{{ old('description') }}</textarea>
                </div>

                {{-- ✅ Buttons --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard.room-categories.index') }}" class="btn btn-outline btn-accent">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="bi bi-save"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
