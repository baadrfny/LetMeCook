<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <h1 class="text-3xl font-bold text-orange-500 mb-2">{{ $recipe->name }}</h1>
                <p class="text-cyan-400 mb-4 italic">Category: {{ $recipe->category->name }}</p>
                
                <hr class="border-gray-700 mb-6">

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Description:</h2>
                    <p class="text-gray-400 leading-relaxed">{{ $recipe->description }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">Ingredients:</h2>
                    <ul class="list-disc list-inside text-gray-400">
                        @forelse($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient->name }} - <span class="text-orange-400">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span></li>
                        @empty
                            <li class="text-gray-500 italic">No ingredients listed for this recipe.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-8 flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition underline">← Back to Recipes</a>
                    
                    @if(Auth::id() === $recipe->user_id || Auth::user()->role === 'admin')
                        <a href="{{ route('recipes.edit', $recipe) }}" class="text-cyan-500 hover:underline">Edit Recipe</a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>