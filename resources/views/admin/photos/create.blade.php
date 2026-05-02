@extends('layouts.app')

@section('title', 'Upload Photo')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[900px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="bg-surface border border-surface-variant rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 md:px-8 py-6 border-b border-surface-variant">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-primary text-on-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[28px]">add_a_photo</span>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-on-background">
                                New Gallery Photo
                            </h2>

                            <p class="text-on-surface-variant mt-1">
                                This photo will appear on the public My Photography page.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 border border-red-200">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/admin/photos') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Photo Title
                            </label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Example: Sunset View"
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 focus:outline-none focus:border-primary"
                                required
                            >
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Category
                            </label>
                            <select
                                name="category"
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 focus:outline-none focus:border-primary"
                            >
                                <option value="People" {{ old('category') === 'People' ? 'selected' : '' }}>People</option>
                                <option value="Nature" {{ old('category') === 'Nature' ? 'selected' : '' }}>Nature</option>
                                <option value="Street" {{ old('category') === 'Street' ? 'selected' : '' }}>Street</option>
                                <option value="School" {{ old('category') === 'School' ? 'selected' : '' }}>School</option>
                                <option value="Event" {{ old('category') === 'Event' ? 'selected' : '' }}>Event</option>
                                <option value="Personal" {{ old('category') === 'Personal' ? 'selected' : '' }}>Personal</option>
                                <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Description
                            </label>
                            <textarea
                                name="description"
                                rows="5"
                                placeholder="Write a short story behind this photo..."
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 focus:outline-none focus:border-primary resize-none"
                            >{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Image
                            </label>
                            <input
                                type="file"
                                name="image"
                                accept="image/*"
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-on-primary"
                                required
                            >
                            <p class="text-sm text-on-surface-variant mt-2">
                                Max size: 12MB. Format: JPG, JPEG, PNG, WEBP.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button
                                type="submit"
                                class="inline-flex justify-center items-center gap-2 bg-primary text-on-primary px-8 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200"
                            >
                                <span class="material-symbols-outlined text-[20px]">upload</span>
                                Upload Photo
                            </button>

                            <a
                                href="{{ url('/admin/photos') }}"
                                class="inline-flex justify-center items-center gap-2 border border-surface-variant text-on-surface-variant px-8 py-3 rounded-full font-label-sm text-label-sm hover:border-primary hover:text-primary transition-all duration-200"
                            >
                                Cancel
                            </a>

                            <a
                                href="{{ url('/my-photography') }}"
                                class="inline-flex justify-center items-center gap-2 border border-surface-variant text-on-surface-variant px-8 py-3 rounded-full font-label-sm text-label-sm hover:border-primary hover:text-primary transition-all duration-200"
                            >
                                View Gallery
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</main>

@endsection
