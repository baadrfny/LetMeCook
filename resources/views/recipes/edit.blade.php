<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <h1 class="text-3xl font-bold text-orange-500 mb-6">Edit Recipe</h1>
                
                <form action="{{ auth()->user()->role === 'admin' ? route('recipes.update', $recipe) : route('my-recipes.update', $recipe) }}" 
          method="POST" 
          enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Recipe Name</label>
                        <input type="text" name="name" value="{{ old('name', $recipe->name) }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                        <textarea name="description" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">{{ old('description', $recipe->description) }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $recipe->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Preparation Steps</label>
                        <textarea name="preparation_steps" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">{{ $recipe->preparation_steps }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Cook Time (minutes)</label>
                        <input type="number" name="cook_time" value="{{ $recipe->cook_time }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Country of Origin</label>
                        <input type="text" name="country_origin" value="{{ $recipe->country_origin }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Recipe Image:</label>
                        <input type="file" name="image" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white">
                        @if($errors->has('image'))
                            <span class="text-red-500 text-sm">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Video URL</label>
                        <input type="url" name="video_url" value="{{ $recipe->video_url }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-black">
                    </div>
                    
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Update Recipe</button>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>