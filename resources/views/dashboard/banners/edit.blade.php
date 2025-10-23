@extends('layouts.app')
@section('title', 'Edit Banner')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-pencil-square text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Edit Banner</h3>
            </div>
            <a href="{{ route('dashboard.banners.index') }}" class="btn btn-outline btn-accent gap-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card bg-base-300 border border-base-200 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="card-body space-y-6">

                <form action="{{ route('dashboard.banners.update', $banner->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- TITLE --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Title <span
                                    class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                            placeholder="Enter banner title"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" />
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Description</span>
                        </label>
                        <textarea name="description" rows="3" placeholder="Enter description..."
                            class="textarea textarea-bordered w-full bg-base-200 text-white placeholder-gray-400">{{ old('description', $banner->description) }}</textarea>
                    </div>

                    {{-- IMAGE UPLOAD + PREVIEW --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Banner Image</span>
                        </label>

                        @if ($banner->image_url)
                            <div class="flex flex-col items-start space-y-3 mb-3">
                                <p class="text-sm text-gray-400">Current Image</p>
                                <img src="{{ asset('storage/' . $banner->image_url) }}" alt="Current Banner"
                                    class="rounded-xl shadow-md w-56 h-36 object-cover border border-base-200 hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        <input type="file" name="image_url" accept="image/*" id="imageInput"
                            class="file-input file-input-bordered w-full bg-base-200 text-gray-300" />

                        {{-- PREVIEW --}}
                        <div id="imagePreview" class="hidden mt-4">
                            <div class="border border-base-200 rounded-xl p-2 bg-base-200/40 w-fit">
                                <img id="previewImage"
                                    class="w-56 h-36 object-cover rounded-lg shadow-md hover:scale-105 transition-transform duration-300"
                                    alt="Preview">
                            </div>
                        </div>
                    </div>

                    {{-- 🔹 Assign to Hotel (for Super Admin only) --}}
                    @if (Auth::user()->isSuperAdmin())
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Assign to Hotel</span>
                            </label>
                            <select name="hotel_id" class="select select-bordered w-full bg-base-200 text-white">
                                <option value="">-- Choose Hotel --</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}"
                                        {{ $banner->hotel_id == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- DATES --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Active From</span>
                            </label>
                            <input type="date" name="active_from"
                                value="{{ old('active_from', $banner->active_from ? $banner->active_from->format('Y-m-d') : '') }}"
                                id="active_from" class="input input-bordered bg-base-200 text-white" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Active To</span>
                            </label>
                            <input type="date" name="active_to"
                                value="{{ old('active_to', $banner->active_to ? $banner->active_to->format('Y-m-d') : '') }}"
                                id="active_to" class="input input-bordered bg-base-200 text-white" />
                        </div>
                    </div>

                    {{-- IS ACTIVE CHECKBOX --}}
                    <div class="form-control">
                        <label class="cursor-pointer flex items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-info"
                                {{ old('is_active', $banner->is_active) ? 'checked' : '' }} />
                            <span class="label-text text-gray-300 font-medium">Active</span>
                        </label>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('dashboard.banners.index') }}" class="btn btn-outline btn-accent gap-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="bi bi-check2-circle"></i> Update Banner
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT PREVIEW --}}
    @push('scripts')
        <script>
            // Image preview
            document.getElementById('imageInput').addEventListener('change', (e) => {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('imagePreview');
                const previewImage = document.getElementById('previewImage');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (evt) => {
                        previewImage.src = evt.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });

            // Date validation
            document.addEventListener('DOMContentLoaded', () => {
                const today = new Date().toISOString().split('T')[0];
                const fromInput = document.getElementById('active_from');
                const toInput = document.getElementById('active_to');
                fromInput.setAttribute('min', today);
                toInput.setAttribute('min', today);
                fromInput.addEventListener('change', () => {
                    toInput.setAttribute('min', fromInput.value);
                });
            });
        </script>
    @endpush
@endsection
