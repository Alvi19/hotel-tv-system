@extends('layouts.app')
@section('title', 'Edit Content')

@section('content')
<div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-gradient-to-r from-warning to-amber-400 rounded-xl">
                <i class="bi bi-pencil-square text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-semibold text-white">Edit Content</h3>
        </div>

        <a href="{{ route('dashboard.contents.index') }}"
           class="btn btn-outline btn-accent gap-2 hover:scale-105 transition-transform duration-300">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl hover:shadow-2xl transition-all duration-300">
        <div class="card-body space-y-6">

            <form action="{{ route('dashboard.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $content->title) }}"
                           placeholder="Enter content title"
                           class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 focus:ring-2 focus:ring-info" required>
                </div>

                {{-- TYPE --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Type <span class="text-error">*</span></span>
                    </label>
                    <select name="type" class="select select-bordered bg-base-200 text-white w-full focus:ring-2 focus:ring-info" required>
                        @foreach(['about', 'room_type', 'facility', 'event', 'promotion', 'policy'] as $type)
                            <option value="{{ $type }}" {{ $content->type === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- IMAGE PREVIEW + UPLOAD --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Image</span>
                    </label>

                    @if($content->image_url)
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-3">
                            <img src="{{ asset('storage/'.$content->image_url) }}"
                                 alt="Content Image"
                                 class="w-40 h-28 object-cover rounded-xl border border-base-200 shadow-md">
                            <p class="text-sm text-gray-400 italic">Current Image Preview</p>
                        </div>
                    @endif

                    <input type="file" name="image_url" accept="image/*"
                           class="file-input file-input-bordered w-full bg-base-200 text-gray-300" />
                </div>

                {{-- BODY --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Content Body</span>
                    </label>
                    <textarea name="body" rows="5" placeholder="Write your content details..."
                              class="textarea textarea-bordered w-full bg-base-200 text-white placeholder-gray-400 focus:ring-2 focus:ring-info">{{ old('body', $content->body) }}</textarea>
                </div>

                {{-- ACTIVE CHECKBOX --}}
                <div class="form-control">
                    <label class="cursor-pointer flex items-center gap-3">
                        <input type="checkbox" name="is_active" class="checkbox checkbox-success"
                               {{ $content->is_active ? 'checked' : '' }} />
                        <span class="label-text text-gray-300 font-medium">Active</span>
                    </label>
                </div>

                {{-- BUTTONS --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard.contents.index') }}"
                       class="btn btn-outline btn-accent gap-2 hover:scale-105 transition-transform duration-300">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-warning text-white gap-2 hover:scale-105 transition-transform duration-300">
                        <i class="bi bi-check2-circle"></i> Update Content
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
