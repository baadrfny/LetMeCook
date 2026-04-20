<x-app-layout>
    <div class="relative bg-[#050505] min-h-screen overflow-hidden font-['Satoshi'] text-white py-20 px-6">
        
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-4xl mx-auto">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="space-y-4">
                    <a href="{{ route('my-recipes.index') }}" class="group inline-flex items-center gap-2 text-gray-500 hover:text-white transition-colors mb-4">
                        <i class="fas fa-chevron-left text-[10px] group-hover:-translate-x-1 transition-transform"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Return to Studio</span>
                    </a>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-none">
                        Refine your <span class="text-cyan-400 italic font-medium">Vision.</span>
                    </h1>
                    <p class="text-gray-500 text-lg font-medium tracking-tight">Updating: <span class="text-white">{{ $recipe->name }}</span></p>
                </div>
                
                @if($recipe->image)
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-orange-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="relative w-24 h-24 object-cover rounded-2xl border border-white/10" alt="Current image">
                </div>
                @endif
            </div>

            <div class="bg-white/[0.02] border border-white/10 backdrop-blur-3xl rounded-[3.5rem] p-8 md:p-16 shadow-[0_40px_100px_rgba(0,0,0,0.5)]">
                <form action="{{ auth()->user()->role === 'admin' ? route('recipes.update', $recipe) : route('my-recipes.update', $recipe) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Recipe Name</label>
                            <input type="text" name="name" value="{{ old('name', $recipe->name) }}" required
                                class="w-full bg-black/40 border-white/10 rounded-2xl py-5 px-8 text-white focus:border-orange-500/50 focus:ring-0 transition-all text-lg font-bold shadow-inner">
                        </div>

                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">Category</label>
                            <div class="relative">
                                <select name="category_id" required
                                    class="w-full bg-black/40 border-white/10 rounded-2xl py-5 px-8 text-white focus:border-cyan-500/50 focus:ring-0 appearance-none transition-all cursor-pointer text-lg font-bold shadow-inner">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $recipe->category_id ? 'selected' : '' }} class="bg-gray-900">
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-8 top-1/2 -translate-y-1/2 text-cyan-500 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div class="group space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Description</label>
                        <textarea name="description" required rows="2"
                            class="w-full bg-black/40 border-white/10 rounded-2xl py-5 px-8 text-white focus:border-orange-500/50 focus:ring-0 transition-all text-lg font-medium shadow-inner italic">{{ old('description', $recipe->description) }}</textarea>
                    </div>

                    <div class="group space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">Preparation Steps</label>
                        <textarea name="preparation_steps" required rows="6"
                            class="w-full bg-black/40 border-white/10 rounded-[2rem] py-8 px-8 text-white focus:border-cyan-500/50 focus:ring-0 transition-all text-lg font-medium shadow-inner leading-relaxed">{{ old('preparation_steps', $recipe->preparation_steps) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Cook Time (Min)</label>
                            <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" required
                                class="w-full bg-black/40 border-white/10 rounded-2xl py-5 px-8 text-white focus:border-orange-500/50 font-black text-xl shadow-inner">
                        </div>
                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">Country Origin</label>
                            <input type="text" name="country_origin" value="{{ old('country_origin', $recipe->country_origin) }}" required
                                class="w-full bg-black/40 border-white/10 rounded-2xl py-5 px-8 text-white focus:border-cyan-500/50 font-black text-xl shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Recipe Image Update</label>
                            <label class="relative flex flex-col items-center justify-center w-full h-36 bg-black/40 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:border-orange-500/50 transition-all group overflow-hidden">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                    <i class="fas fa-image text-orange-500 mb-2 text-xl group-hover:scale-110 transition-transform"></i>
                                    <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest group-hover:text-orange-400">Replace Media Asset</p>
                                </div>
                                <input type="file" name="image" class="hidden" />
                            </label>
                        </div>
                        <div class="group space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">YouTube Video URL</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $recipe->video_url) }}" placeholder="https://youtube.com/..."
                                class="w-full bg-black/40 border-white/10 rounded-2xl py-12 px-8 text-white focus:border-cyan-500/50 font-medium text-sm shadow-inner transition-all">
                        </div>
                    </div>

                    <button type="submit" class="w-full group relative py-6 bg-cyan-500 hover:bg-white text-black font-black text-[11px] uppercase tracking-[0.4em] rounded-2xl transition-all duration-500 shadow-2xl shadow-cyan-500/20 overflow-hidden mt-12">
                        <span class="relative z-10">Update Masterpiece</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>