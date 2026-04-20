<x-app-layout>
    <x-slot name="header">
        <span class="text-orange-500 font-black tracking-widest uppercase text-xs">Collection</span>
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('My Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-600/5 rounded-full blur-[120px] -z-10"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <div class="mb-12">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tighter">
                    Saved <span class="text-orange-500 italic">Flavors</span>
                </h1>
                <p class="text-gray-500 text-lg font-medium">Your personal collection of culinary inspiration.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl backdrop-blur-md flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif


            
            @auth
                @if(auth()->user()->favorites->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        @foreach(auth()->user()->favorites as $favorite)
                            <div class="group relative bg-[#0d0d0d] border border-white/5 rounded-[2.5rem] overflow-hidden hover:border-orange-500/30 transition-all duration-700 shadow-2xl">
                                
                                <div class="relative h-64 overflow-hidden">
                                    @if($favorite->recipe->image)
                                        <img src="{{ asset('storage/' . $favorite->recipe->image) }}" 
                                             alt="{{ $favorite->recipe->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                    @else
                                        <div class="w-full h-full bg-white/5 flex items-center justify-center">
                                            <i class="fas fa-utensils text-4xl text-white/10"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d0d] via-transparent to-transparent"></div>

                                    <div class="absolute top-6 right-6 flex gap-2">
                                        <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('Remove this masterpiece?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 backdrop-blur-md text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="p-8">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-orange-500 bg-orange-500/10 px-3 py-1 rounded-lg">
                                            {{ $favorite->recipe->category->name }}
                                        </span>
                                        <span class="text-gray-600 text-[10px] font-bold">
                                            <i class="far fa-clock mr-1"></i> {{ $favorite->recipe->cook_time ?? '25' }} MIN
                                        </span>
                                    </div>

                                    <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-orange-500 transition-colors">
                                        {{ $favorite->recipe->name }}
                                    </h3>
                                    
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-8 font-medium leading-relaxed">
                                        {{ $favorite->recipe->description }}
                                    </p>

                                    <div class="pt-6 border-t border-white/5">
                                        <a href="{{ route('my-recipes.show', $favorite->recipe->id) }}" 
                                           class="flex items-center justify-between group/btn">
                                            <span class="text-xs font-black uppercase tracking-widest text-white group-hover/btn:text-orange-500 transition-colors">Cook Now</span>
                                            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover/btn:bg-orange-500 group-hover/btn:text-black transition-all">
                                                <i class="fas fa-chevron-right text-[10px]"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-32 text-center glass rounded-[3rem] border-dashed border-white/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-orange-500/20 blur-3xl rounded-full"></div>
                            <div class="relative w-24 h-24 bg-white/5 border border-white/10 rounded-full flex items-center justify-center">
                                <i class="far fa-heart text-3xl text-gray-600"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Your collection is empty</h3>
                        <p class="text-gray-500 max-w-sm mb-10 font-medium leading-relaxed">
                            Every great chef needs a library of secrets. Start exploring and save your first recipe.
                        </p>
                        <a href="{{ route('welcome') }}" 
                           class="bg-white text-black font-black py-4 px-10 rounded-2xl hover:bg-orange-500 hover:text-white transition-all shadow-xl">
                            Browse Recipes
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-20 glass rounded-[3rem]">
                    <i class="fas fa-lock text-4xl text-orange-500/20 mb-6"></i>
                    <h3 class="text-xl font-bold text-white mb-6">Login to see your favorites</h3>
                    <a href="{{ route('login') }}" class="bg-orange-500 text-black font-black py-3 px-8 rounded-xl">Login</a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>