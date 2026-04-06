<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-orange-500">Categories Management</h1>
                </div>

                <!-- Add New Category Form -->
                <div class="mb-8 p-4 bg-gray-700 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-300 mb-4">Add New Category</h2>
                    <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Category name" required
                               class="flex-1 px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-black">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded">
                            Add Category
                        </button>
                    </form>
                </div>

                <!-- Categories List -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-300 mb-4">Existing Categories</h2>
                    
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-black">{{ $category->name }}</h3>
                                <p class="text-gray-400 text-sm">ID: {{ $category->id }}</p>
                            </div>
                            
                            <div class="flex gap-2">
                                <!-- Edit Form -->
                                <form action="{{ route('categories.update', $category) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}" required
                                           class="px-2 py-1 bg-gray-600 border border-gray-500 rounded text-black text-sm">
                                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 px-3 py-1 rounded text-sm">
                                        Update
                                    </button>
                                </form>
                                
                                <!-- Delete Form -->
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <p>No categories found. Add your first category above!</p>
                        </div>
                    @endif
                </div>

                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-600 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
