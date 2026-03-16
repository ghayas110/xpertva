@extends('layouts.dashboard')

@section('title', 'Manage Blogs - Admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Blogs</h1>
        <a href="{{ route('admin.blogs.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="fa-solid fa-plus mr-2"></i> Create New Blog
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-sm uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Created At</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                @forelse($blogs as $blog)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-6 py-4 font-medium">{{ $blog->title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded text-xs">
                            {{ $blog->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $blog->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 space-x-3 text-right">
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="text-gray-400 hover:text-indigo-500 transition" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-gray-400 hover:text-blue-500 transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this blog?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        No blogs found. Start by creating one!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
