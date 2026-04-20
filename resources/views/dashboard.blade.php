<x-app-layout>
    <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
        
        <section class="relative pt-10 pb-16 flex flex-col lg:flex-row items-center gap-12 min-h-[75vh]">
            
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-8">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400">Master the Kitchen</span>
                </div>
                
                <h1 class="text-6xl md:text-[5.5rem] font-bold leading-[0.95] tracking-[-0.04em] mb-8">
                    Elevate your <br> 
                    <span class="text-orange-500 italic">everyday</span> <br> 
                    cooking.
                </h1>

                <p class="text-gray-400 text-lg md:text-xl max-w-lg mb-10 font-normal leading-relaxed">
                    A curated collection of professional recipes designed for your home kitchen. 
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                    <a href="#explore" class="bg-orange-500 hover:bg-orange-600 text-black font-bold py-4 px-12 rounded-2xl transition-all shadow-[0_20px_40px_rgba(249,115,22,0.2)] hover:scale-105 active:scale-95">
                        Browse Recipes
                    </a>
                    <a href="{{ route('my-recipes.create') }}" class="group flex items-center gap-3 text-white font-semibold">
                        <span class="border-b-2 border-white/10 group-hover:border-orange-500 transition-all">Add yours</span>
                        <i class="fas fa-plus text-xs text-orange-500"></i>
                    </a>
                </div>
            </div>

            
            <div class="flex-1 relative">
                <div class="absolute inset-0 bg-orange-500/15 rounded-full blur-[100px] animate-pulse"></div>
                <div class="relative z-10 animate-float">
                    <img src="https://pngimg.com/uploads/burger_sandwich/burger_sandwich_PNG4114.png" 
                         class="w-full max-w-[500px] mx-auto drop-shadow-[0_40px_60px_rgba(0,0,0,0.7)]" 
                         alt="Gourmet Burger">
                </div>
            </div>
        </section>

        <section class="py-10 border-y border-white/5 bg-black/20 backdrop-blur-sm sticky top-0 z-40 mb-16">
            <div class="flex items-center justify-between gap-8">
                <h2 class="hidden md:block text-sm font-bold uppercase tracking-widest text-orange-500">Categories</h2>
                <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">
                    <button class="px-8 py-2.5 rounded-xl bg-white text-black text-xs font-black transition-all">All</button>
                    @foreach($categories as $category)
                        <button class="px-8 py-2.5 rounded-xl bg-white/5 border border-white/10 text-xs font-bold hover:bg-white/10 transition-all whitespace-nowrap">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="explore" class="pb-32">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($recipes as $recipe)
                    <div class="group relative flex flex-col bg-[#0d0d0d] border border-white/5 rounded-[2.5rem] overflow-hidden hover:border-orange-500/30 transition-all duration-700">
                        
                        <div class="relative h-80 overflow-hidden">
                            <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://via.placeholder.com/600x800' }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d0d] via-transparent to-black/20"></div>

                            <div class="absolute top-6 left-6">
                                <span class="bg-black/60 backdrop-blur-md text-[10px] font-bold px-4 py-2 rounded-full border border-white/10 uppercase tracking-tighter">
                                    {{ $recipe->category->name ?? 'Premium' }}
                                </span>
                            </div>

                            @auth
                                @if(auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists())
                                    <form action="{{ route('favorites.destroy', auth()->user()->favorites()->where('recipe_id', $recipe->id)->first()->id) }}" method="POST" class="absolute top-6 right-6">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-full bg-orange-500/30 backdrop-blur-xl border border-orange-500/40 flex items-center justify-center text-orange-500 hover:bg-orange-500 hover:text-white transition-all shadow-lg shadow-orange-500/30">
                                            <i class="fas fa-heart animate-pulse"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.store') }}" method="POST" class="absolute top-6 right-6">
                                        @csrf
                                        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                                        <button type="submit" class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-xl border border-white/10 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white transition-all">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <div class="p-10 flex flex-col flex-grow">
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest flex items-center">
                                    <i class="far fa-clock mr-2 text-orange-500"></i> {{ $recipe->cook_time ?? '25' }} MINS
                                </span>
                                <span class="w-1 h-1 rounded-full bg-white/10"></span>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Easy Level</span>
                            </div>

                            <h3 class="text-3xl font-bold mb-4 leading-tight group-hover:text-orange-500 transition-colors">
                                {{ $recipe->name }}
                            </h3>

                            <p class="text-gray-500 text-sm leading-relaxed mb-10 line-clamp-2">
                                {{ $recipe->description }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('my-recipes.show', $recipe->id) }}" class="flex items-center justify-between group/btn">
                                    <span class="text-xs font-bold uppercase tracking-widest">View Recipe</span>
                                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center group-hover/btn:bg-orange-500 group-hover/btn:text-black transition-all group-hover/btn:rotate-[-45deg]">
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white/[0.02] rounded-[3rem] border border-white/5">
                        <p class="text-gray-500 italic">No recipes found. Let's create something new!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-25px) rotate(2deg); }
        }
        .animate-float { animation: float 7s ease-in-out infinite; }
    </style>
</x-app-layout>