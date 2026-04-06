<div>
    <h1>Create Recipe</h1>

    <form action="{{ auth()->user()->role === 'admin' ? route('recipes.store') : route('my-recipes.store') }}" 
          method="POST" 
          enctype="multipart/form-data"> @csrf
        
        <input type="text" name="name" placeholder="Recipe Name" required>
        <textarea name="description" placeholder="Recipe Description" required></textarea>
        
        <input type="text" name="preparation_steps" placeholder="Preparation Steps">
        <input type="number" name="cook_time" placeholder="Cook Time (minutes)">
        <input type="text" name="country_origin" placeholder="Country">
        <input type="url" name="video_url" placeholder="Video URL (optional)">

        <label class="text-white">Recipe Image:</label>
        <input type="file" name="image" class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md">
        
        @error('image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <button type="submit">Create Recipe</button>
    </form>
</div>