@extends('layouts.dashboard')

@section('title', 'Edit Blog - Admin')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.blogs.index') }}" class="text-indigo-600 hover:underline">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Blogs
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mt-4">Edit Blog: {{ $blog->title }}</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 max-w-4xl">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title', $blog->title) }}" required class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category', $blog->category) }}" required class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Marketing, Development">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description (Brief Summary)</label>
                <textarea name="description" rows="2" required class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500">{{ old('description', $blog->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                <textarea name="content" rows="10" required class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500" placeholder="Write your blog content here...">{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags (Comma separated)</label>
                    <input type="text" name="tags" value="{{ old('tags', $blog->tags) }}" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500" placeholder="tag1, tag2, tag3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                    @if($blog->image)
                    <div class="mb-2">
                        <img src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}" class="w-32 h-20 object-cover rounded shadow">
                    </div>
                    @endif
                    <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep existing image</p>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Update Blog
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
