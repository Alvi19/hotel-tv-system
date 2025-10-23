@extends('layouts.app')
@section('title', 'Hotel Contents')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-card-list text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Hotel Contents</h3>
            </div>

            <a href="{{ route('dashboard.contents.create') }}"
                class="btn btn-primary gap-2 hover:scale-105 transition-transform duration-300">
                <i class="bi bi-plus-circle"></i> Add Content
            </a>
        </div>

        {{-- CONTENT GRID --}}
        @if ($contents->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($contents as $content)
                    <div
                        class="card bg-base-300 border border-base-200 shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">

                        {{-- Image --}}
                        @if ($content->image_url)
                            <figure class="relative">
                                <img src="{{ asset('storage/'.$content->image_url) }}"
                                 alt="Content Image"
                                 class="w-full h-40 object-cover brightness-90 hover:brightness-100 transition-all duration-300">
                            </figure>
                        @else
                            <div class="flex items-center justify-center h-40 bg-base-200 text-gray-400 italic">
                                No Image
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body p-5 space-y-3">
                            <h3 class="text-lg font-semibold text-white">{{ $content->title }}</h3>
                            <p class="text-sm text-gray-400 capitalize">
                                <i class="bi bi-tag text-info mr-1"></i>{{ $content->type }}
                            </p>

                            {{-- Status Badge --}}
                            <span class="badge {{ $content->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $content->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            {{-- Actions --}}
                            <div class="flex justify-between items-center pt-3">
                                <a href="{{ route('dashboard.contents.edit', $content->id) }}"
                                    class="btn btn-sm btn-warning text-white gap-1 hover:scale-105 transition-transform">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('dashboard.contents.destroy', $content->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this content?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-error text-white gap-1 hover:scale-105 transition-transform">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 text-center space-y-3">
                <i class="bi bi-inbox text-5xl text-gray-400"></i>
                <h4 class="text-gray-300 text-lg font-medium">No contents found</h4>
                <a href="{{ route('dashboard.contents.create') }}" class="btn btn-info gap-2 mt-2">
                    <i class="bi bi-plus-circle"></i> Create New Content
                </a>
            </div>
        @endif
    </div>
@endsection
