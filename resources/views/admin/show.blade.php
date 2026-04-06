<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <h1 class="text-3xl font-bold text-orange-500 mb-4">{{ $recipe->name }}</h1>
                <p class="text-cyan-400 mb-6">Category: {{ $recipe->category->name }}</p>
                
                <hr class="border-gray-700 mb-6">

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Description</h2>
                    <p class="text-gray-400">{{ $recipe->description }}</p>
                </div>

                @if($recipe->image)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Recipe Image</h2>
                    <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->name }}" class="w-full h-64 object-cover rounded-lg">
                </div>
                @endif

                @if($videoId)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Video Guide</h2>
                    <iframe width="560" height="315" 
                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                        frameborder="0" 
                        allowfullscreen
                        class="w-full rounded-lg">
                    </iframe>
                </div>
                @endif

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Preparation Steps</h2>
                    <p class="text-gray-400">{{ $recipe->preparation_steps }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Cook Time</h2>
                    <p class="text-gray-400">{{ $recipe->cook_time }} minutes</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Country of Origin</h2>
                    <p class="text-gray-400">{{ $recipe->country_origin }}</p>
                </div>

                <div class="mt-8 flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white">← Back</a>
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('recipes.edit', $recipe) }}" class="text-cyan-500 hover:text-cyan-400">Edit</a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
