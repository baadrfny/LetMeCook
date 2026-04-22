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
                @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-2xl mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="recipe-form" action="{{ auth()->user()->role === 'admin' ? route('recipes.update', $recipe) : route('my-recipes.update', $recipe) }}" 
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
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $recipe->category_id) === (string) $category->id ? 'selected' : '' }} class="bg-gray-900">
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

                    <div class="space-y-4">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 italic">Culinary Components</label>
                        <button type="button" id="open-ingredients"
                            class="w-full group flex items-center justify-between bg-white/5 border border-white/10 hover:border-cyan-500/40 rounded-2xl p-6 transition-all duration-500 hover:bg-cyan-500/5 shadow-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span class="text-sm font-black uppercase tracking-widest text-gray-400 group-hover:text-cyan-400 transition-colors">Define Ingredients & Quantities</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-700 group-hover:text-cyan-500 transition-all group-hover:translate-x-1"></i>
                        </button>
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

    <div id="ingredients-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" id="close-modal-overlay"></div>
        <div class="relative bg-[#0a0a0a] border border-white/10 w-full max-w-3xl max-h-[85vh] overflow-hidden rounded-[3rem] shadow-2xl flex flex-col">
            
            <div class="p-10 border-b border-white/5 flex justify-between items-center">
                <h3 class="text-2xl font-black uppercase tracking-tighter text-white">The <span class="text-orange-500">Pantry</span></h3>
                <button type="button" id="close-modal-btn" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-500 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @isset($ingredients)
                    @foreach($ingredients as $ingredient)
                    <div class="group flex items-center gap-4 bg-white/[0.02] p-5 rounded-2xl border border-white/5 hover:border-cyan-500/30 transition-all">
                        <input type="checkbox" form="recipe-form" name="ingredients[]" value="{{ $ingredient->id }}" 
                            {{ in_array($ingredient->id, old('ingredients', $recipeIngredients ?? [])) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-white/10 bg-black text-orange-500 focus:ring-0 focus:ring-offset-0">

                        <div class="flex-1">
                            <span class="text-sm font-black uppercase tracking-widest text-gray-300 group-hover:text-white transition-colors">{{ $ingredient->name }}</span>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            <input type="text" form="recipe-form" name="quantities[{{ $ingredient->id }}]" 
                                value="{{ old('quantities.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->quantity ?? '') }}"
                                placeholder="Qty"
                                class="w-16 bg-black/60 border border-white/10 rounded-xl text-xs p-3 text-white focus:border-cyan-500 outline-none font-bold">

                            <select form="recipe-form" name="units[{{ $ingredient->id }}]"
                                class="bg-black/60 border border-white/10 rounded-xl text-[10px] p-3 text-gray-400 focus:text-cyan-400 focus:border-cyan-500 outline-none uppercase font-black">
                                <option value="g" {{ old('units.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->unit ?? 'pcs') === 'g' ? 'selected' : '' }}>g</option>
                                <option value="kg" {{ old('units.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->unit ?? 'pcs') === 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="ml" {{ old('units.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->unit ?? 'pcs') === 'ml' ? 'selected' : '' }}>ml</option>
                                <option value="pcs" {{ old('units.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->unit ?? 'pcs') === 'pcs' ? 'selected' : '' }}>pcs</option>
                                <option value="tbsp" {{ old('units.' . $ingredient->id, $recipe->ingredients->where('id', $ingredient->id)->first()?->pivot->unit ?? 'pcs') === 'tbsp' ? 'selected' : '' }}>tbsp</option>
                            </select>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                </div>
            </div>

            <div class="p-10 bg-white/[0.02] border-t border-white/5">
                <button type="button" id="confirm-ingredients" class="w-full bg-cyan-500 hover:bg-white text-black font-black py-5 rounded-2xl transition-all uppercase tracking-widest text-[10px]">
                    Lock In Selection
                </button>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(6, 182, 212, 0.2); border-radius: 10px; }
    </style>

    <script>
        const modal = document.getElementById('ingredients-modal');
        const openBtn = document.getElementById('open-ingredients');
        const closeBtn = document.getElementById('close-modal-btn');
        const confirmBtn = document.getElementById('confirm-ingredients');
        const overlay = document.getElementById('close-modal-overlay');

        openBtn.onclick = (e) => {
            e.preventDefault();
            modal.classList.remove('hidden');
            modal.querySelector('.relative').classList.add('animate-in', 'fade-in', 'zoom-in-95');
            document.body.style.overflow = 'hidden';
        }

        const close = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        closeBtn.onclick = close;
        confirmBtn.onclick = close;
        overlay.onclick = close;

        document.querySelectorAll('input[name^="quantities"]').forEach(input => {
            input.addEventListener('input', function() {
                const id = this.name.match(/\[(\d+)\]/)[1];
                const checkbox = document.querySelector(`input[name="ingredients[]"][value="${id}"]`);

                if (this.value.trim() !== '') {
                    checkbox.checked = true;
                }
            });
        });
    </script>
</x-app-layout>
