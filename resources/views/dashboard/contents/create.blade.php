@extends('layouts.app')
@section('title', 'Add Content')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-plus-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Add New Content</h3>
            </div>

            <a href="{{ route('dashboard.contents.index') }}" class="btn btn-outline btn-accent gap-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card bg-base-300 border border-base-200 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="card-body space-y-6">

                <form action="{{ route('dashboard.contents.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- HOTEL SELECTION (Super Admin) --}}
                    @if (Auth::user()->isSuperAdmin())
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Assign to Hotel <span
                                        class="text-error">*</span></span>
                            </label>
                            <select name="hotel_id"
                                class="select select-bordered bg-base-200 text-white w-full focus:ring-2 focus:ring-info"
                                required>
                                <option value="">-- Choose Hotel --</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- TITLE --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Title <span
                                    class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" placeholder="Enter content title"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" required />
                    </div>

                    {{-- TYPE --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Type <span class="text-error">*</span></span>
                        </label>
                        <select name="type"
                            class="select select-bordered bg-base-200 text-white w-full focus:ring-2 focus:ring-info"
                            required>
                            <option disabled selected>-- Select Content Type --</option>
                            <option value="about">About Hotel</option>
                            <option value="room_type">Room Type</option>
                            <option value="nearby_place">Nearby Place</option>
                            <option value="facility">Facility</option>
                            <option value="event">Event</option>
                            <option value="promotion">Promotion</option>
                            <option value="policy">Policy</option>
                        </select>
                    </div>

                    @if ($roomCategories)
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Room Type (Optional)</span>
                            </label>
                            <select name="room_type_id" class="select select-bordered bg-base-200 text-white">
                                <option value="">-- All Room Types --</option>
                                @foreach ($roomCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- IMAGE UPLOAD --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Image</span>
                        </label>
                        <input type="file" name="image_url" accept="image/*"
                            class="file-input file-input-bordered w-full bg-base-200 text-gray-300" />
                    </div>

                    {{-- CONTENT BODY --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Content Body</span>
                        </label>
                        <textarea name="body" rows="5" placeholder="Write the content details..."
                            class="textarea textarea-bordered w-full bg-base-200 text-white placeholder-gray-400"></textarea>
                    </div>

                    {{-- ACTIVE CHECKBOX --}}
                    <div class="form-control">
                        <label class="cursor-pointer flex items-center gap-3">
                            <input type="checkbox" name="is_active" class="checkbox checkbox-success" checked />
                            <span class="label-text text-gray-300 font-medium">Active</span>
                        </label>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('dashboard.contents.index') }}" class="btn btn-outline btn-accent gap-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="bi bi-save"></i> Save Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
