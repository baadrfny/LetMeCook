<x-app-layout>
    <div class="relative bg-[#050505] min-h-screen overflow-hidden font-['Satoshi']">
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-orange-600/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-cyan-600/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-6 py-12 relative z-10">
            
            <div class="flex justify-between items-center mb-12">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-500 hover:text-white transition-all">
                    <i class="fas fa-chevron-left text-[10px] group-hover:-translate-x-1 transition-transform"></i>
                    <span class="text-xs font-black uppercase tracking-widest">Back to Recipes</span>
                </a>

                @if(Auth::id() === $recipe->user_id || Auth::user()->role === 'admin')
                    <a href="{{ route('my-recipes.edit', $recipe->id) }}" class="bg-white/5 border border-white/10 hover:border-cyan-500/50 hover:text-cyan-400 px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        Edit Recipe
                    </a>
                @endif
            </div>

            <div class="relative h-[500px] rounded-[3rem] overflow-hidden mb-12 border border-white/5 shadow-2xl">
                <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1000' }}" 
                     class="w-full h-full object-cover shadow-inner" alt="{{ $recipe->name }}">
                
                @auth
                    @if(auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists())
                        <form action="{{ route('favorites.destroy', auth()->user()->favorites()->where('recipe_id', $recipe->id)->first()->id) }}" method="POST" class="absolute top-6 right-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 rounded-full bg-orange-500/30 backdrop-blur-xl border border-orange-500/40 flex items-center justify-center text-orange-500 hover:bg-orange-500 hover:text-white transition-all shadow-lg shadow-orange-500/30">
                                <i class="fas fa-heart animate-pulse"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorites.store') }}" method="POST" class="absolute top-6 right-20">
                            @csrf
                            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-xl border border-white/10 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white transition-all">
                                <i class="far fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @endauth
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                
                <div class="absolute bottom-12 left-12 right-12">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-4 py-1.5 bg-orange-500 text-black text-[10px] font-black uppercase tracking-[0.2em] rounded-lg">
                            {{ $recipe->category->name }}
                        </span>
                        <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-white/10">
                            <i class="far fa-clock mr-2 text-orange-500"></i> {{ $recipe->cook_time ?? '30' }} Minutes
                        </span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-none">{{ $recipe->name }}</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-2 space-y-12">
                    <section>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-500 mb-6 flex items-center gap-4">
                            The Story <span class="h-px bg-white/5 flex-grow"></span>
                        </h2>
                        <p class="text-gray-400 text-xl font-medium leading-relaxed italic">
                            "{{ $recipe->description }}"
                        </p>
                    </section>

                    <section class="bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-10 backdrop-blur-3xl">
                        <h2 class="text-2xl font-black text-white mb-8 tracking-tight">Preparation Steps</h2>
                        <div class="space-y-8 text-gray-400 font-medium leading-relaxed">
                            {{-- افترضت هنا وجود خطوات، إذا لم توجد يمكنك عرض الوصف الكامل بشكل منسق --}}
                            <div class="flex gap-6">
                                <span class="text-orange-500 font-black text-2xl italic opacity-50 italic">01.</span>
                                <p>Begin by carefully selecting the freshest ingredients. Quality is the soul of this dish.</p>
                            </div>
                            <div class="flex gap-6">
                                <span class="text-orange-500 font-black text-2xl italic opacity-50 italic">02.</span>
                                <p>Follow the traditional method of blending spices to ensure the depth of flavor is captured.</p>
                            </div>
                            <p class="text-sm text-gray-600 mt-6 border-t border-white/5 pt-6 italic">
                                * Detailed instructions for this masterpiece are provided in the chef's notes.
                            </p>
                        </div>
                    </section>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-12 bg-[#0a0a0a] border border-white/5 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-orange-500/10 blur-3xl rounded-full"></div>
                        
                        <h2 class="text-xl font-black text-white mb-8 flex items-center justify-between">
                            Ingredients
                            <i class="fas fa-shopping-basket text-orange-500 text-sm"></i>
                        </h2>

                        <ul class="space-y-4">
                            @forelse($recipe->ingredients as $ingredient)
                                <li class="flex items-center justify-between group py-3 border-b border-white/5 last:border-0">
                                    <span class="text-gray-400 font-bold group-hover:text-white transition-colors">
                                        {{ $ingredient->name }}
                                    </span>
                                    <span class="text-xs font-black text-cyan-500 bg-cyan-500/5 px-3 py-1 rounded-lg border border-cyan-500/20">
                                        {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-600 italic text-sm py-4">The secret is in the air... no ingredients listed.</li>
                            @endforelse
                        </ul>

                        <button class="w-full mt-10 bg-orange-500 hover:bg-white text-black font-black py-4 rounded-2xl transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest text-[10px]">
                            Add to Grocery List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>