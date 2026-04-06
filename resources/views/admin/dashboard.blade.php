<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Navigation Menu -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-orange-500 mb-6">Admin Dashboard</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-800 hover:bg-gray-700 p-4 rounded-lg border border-gray-600 text-center">
                        <h3 class="text-lg font-semibold text-cyan-400">Recipes</h3>
                        <p class="text-gray-400 text-sm">Manage recipes</p>
                    </a>
                    
                    <a href="{{ route('categories.index') }}" class="bg-gray-800 hover:bg-gray-700 p-4 rounded-lg border border-gray-600 text-center">
                        <h3 class="text-lg font-semibold text-cyan-400">Categories</h3>
                        <p class="text-gray-400 text-sm">Manage categories</p>
                    </a>
                    
                    <a href="{{ route('ingredients.index') }}" class="bg-gray-800 hover:bg-gray-700 p-4 rounded-lg border border-gray-600 text-center">
                        <h3 class="text-lg font-semibold text-cyan-400">Ingredients</h3>
                        <p class="text-gray-400 text-sm">Manage ingredients</p>
                    </a>
                    
                    <a href="{{ route('countries.index') }}" class="bg-gray-800 hover:bg-gray-700 p-4 rounded-lg border border-gray-600 text-center">
                        <h3 class="text-lg font-semibold text-cyan-400">Countries</h3>
                        <p class="text-gray-400 text-sm">Manage countries</p>
                    </a>
                </div>
            </div>

            <!-- Recipes List -->
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                <h2 class="text-2xl font-bold text-orange-500 mb-6">Recent Recipes</h2>
                
                <div>
                    @foreach($recipes as $recipe)
                        <div class="mb-4 p-4 bg-gray-700 rounded-lg flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-white">{{ $recipe->name }}</h3>
                                <p class="text-gray-400">{{ $recipe->description }}</p>
                                <p class="text-cyan-400 text-sm">Category: {{ $recipe->category->name }}</p>
                                @if($recipe->image)
                                    <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->name }}" class="w-20 h-20 object-cover rounded mt-2">
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{route('recipes.edit', $recipe)}}" class="text-cyan-500 hover:text-cyan-400">edit</a>
                                <a href="{{route('recipes.destroy', $recipe)}}" class="text-red-500 hover:text-red-400" onclick="return confirm('Are you sure?')">remove</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
