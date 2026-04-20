<x-app-layout>


    <div class="relative bg-black min-h-screen overflow-hidden text-white">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-orange-600/10 rounded-full blur-[150px] z-0"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[150px] z-0"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 py-16">
            <div class="mb-12">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="px-4 py-1.5 bg-cyan-500/10 text-cyan-400 text-xs font-black rounded-lg uppercase tracking-widest border border-cyan-500/20">
                        {{ $recipe->category->name ?? 'General' }}
                    </span>
                    <span class="px-4 py-1.5 bg-orange-500/10 text-orange-500 text-xs font-black rounded-lg uppercase tracking-widest border border-orange-500/20">
                        {{ $recipe->country_origin }}
                    </span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black tracking-tighter mb-4 uppercase leading-[0.9]">
                    {{ $recipe->name }}
                </h1>
                <div class="h-1.5 w-32 bg-orange-500 rounded-full shadow-[0_0_20px_rgba(249,115,22,0.4)]"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-12">
                    @if($videoId)
                        <div class="relative group">
                            <div class="absolute inset-0 bg-cyan-500/20 rounded-[2.5rem] blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            <div class="relative bg-gray-950 border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-md">
                                <div class="aspect-video w-full">
                                    <iframe 
                                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                                        class="w-full h-full"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    @elseif($recipe->image)
                        <div class="rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl">
                            <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->name }}" class="w-full h-auto object-cover">
                        </div>
                    @endif

                    <div class="bg-gray-900/40 border border-white/5 p-8 rounded-[2rem] backdrop-blur-sm">
                        <h2 class="text-2xl font-bold mb-4 text-orange-500 uppercase tracking-tight">The Story</h2>
                        <p class="text-gray-400 leading-relaxed text-lg italic">
                            "{{ $recipe->description }}"
                        </p>
                    </div>

                    <div class="bg-gray-900/40 border border-white/5 p-8 rounded-[2rem] backdrop-blur-sm">
                        <h2 class="text-2xl font-bold mb-6 text-cyan-400 uppercase tracking-tight italic">How to Prepare</h2>
                        <div class="text-gray-300 leading-loose whitespace-pre-line text-lg">
                            {{ $recipe->preparation_steps }}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-gray-950/80 border border-white/10 p-10 rounded-[2.5rem] shadow-2xl backdrop-blur-xl sticky top-24">
                        <h2 class="text-2xl font-black mb-8 tracking-tight uppercase">Quick Info</h2>
                        <div class="space-y-6 mb-10">
                            <div class="flex justify-between items-center border-b border-white/5 pb-4">
                                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">Cook Time</span>
                                <span class="text-white font-black text-xl">{{ $recipe->cook_time }} Min</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/5 pb-4">
                                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">Origin</span>
                                <span class="text-orange-500 font-black text-lg">{{ $recipe->country_origin }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-white/5 pb-4">
                                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">Author</span>
                                <span class="text-cyan-400 font-black">{{ $recipe->user->name ?? 'Chef' }}</span>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold mb-6 text-white uppercase tracking-tighter">Ingredients</h3>
                        <ul class="space-y-4 mb-10">
                            @forelse($recipe->ingredients ?? [] as $ingredient)
                                <li class="flex items-start text-gray-400 text-sm group">
                                    <div class="w-1.5 h-1.5 bg-orange-500 rounded-full mt-1.5 mr-3 group-hover:scale-150 transition-transform"></div>
                                    <span>
                                        {{ $ingredient->name }} - 
                                        <span class="text-white font-bold">
                                            {{ optional($ingredient->pivot)->quantity }} {{ optional($ingredient->pivot)->unit }}
                                        </span>
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-600 italic">No ingredients found.</li>
                            @endforelse
                        </ul>

                        <div class="pt-8 border-t border-white/5 space-y-4">
                            @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::id() === $recipe->user_id))
                                <a href="{{ route('recipes.edit', $recipe) }}" 
                                   class="block w-full text-center bg-cyan-500 hover:bg-cyan-600 text-black font-black py-4 rounded-2xl transition-all shadow-[0_10px_30px_rgba(6,182,212,0.2)]">
                                    Edit Recipe
                                </a>
                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Confirm deletion?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-center text-red-500 hover:text-red-400 font-bold transition py-2 text-sm uppercase tracking-widest">
                                        Delete
                                    </button>
                                </form>
                            @endif
                            <a href="{{ url()->previous() }}" class="block w-full text-center text-gray-500 hover:text-white font-bold transition text-sm">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

