@extends('layouts.app')

@section('title', 'Add New Banner')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-megaphone text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Add New Banner</h3>
            </div>
            <a href="{{ route('dashboard.banners.index') }}" class="btn btn-outline btn-accent gap-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card bg-base-300 border border-base-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="card-body space-y-6">

                <form action="{{ route('dashboard.banners.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- TITLE --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Title <span
                                    class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" placeholder="Enter banner title"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" required />
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Description</span>
                        </label>
                        <textarea name="description" rows="3" placeholder="Short description..."
                            class="textarea textarea-bordered w-full bg-base-200 text-white placeholder-gray-400"></textarea>
                    </div>

                    {{-- IMAGE UPLOAD + PREVIEW --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Banner Image <span
                                    class="text-error">*</span></span>
                        </label>
                        <input type="file" name="image_url" id="imageInput" accept="image/*"
                            class="file-input file-input-bordered w-full bg-base-200 text-gray-300" required />

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
                                <span class="label-text text-gray-300 font-medium">Assign to Hotel <span
                                        class="text-error">*</span></span>
                            </label>
                            <select name="hotel_id" class="select select-bordered w-full bg-base-200 text-white" required>
                                <option value="">-- Choose Hotel --</option>
                                @foreach (\App\Models\Hotel::orderBy('name')->get() as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
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
                            <input type="date" name="active_from" id="active_from"
                                class="input input-bordered bg-base-200 text-white" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Active To</span>
                            </label>
                            <input type="date" name="active_to" id="active_to"
                                class="input input-bordered bg-base-200 text-white" required />
                        </div>
                    </div>

                    {{-- IS ACTIVE CHECKBOX --}}
                    <div class="form-control">
                        <label class="cursor-pointer flex items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-info" checked />
                            <span class="label-text text-gray-300 font-medium">Active</span>
                        </label>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('dashboard.banners.index') }}" class="btn btn-outline btn-accent gap-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="bi bi-save"></i> Save Banner
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- IMAGE PREVIEW & DATE VALIDATION --}}
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
