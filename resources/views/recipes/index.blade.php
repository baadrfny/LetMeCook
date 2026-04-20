<x-app-layout>
    <div class="relative bg-[#050505] min-h-screen overflow-hidden font-['Satoshi']">
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 py-16 relative z-10">
            
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Creator Studio</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-none">
                        Kitchen <span class="text-orange-500 italic">Command</span> Center.
                    </h1>
                    <p class="text-gray-500 text-lg max-w-xl font-medium">
                        Everything you've shared with the world, organized and ready for refinement.
                    </p>
                </div>
                
                <a href="{{ route('my-recipes.create') }}" class="group relative inline-flex items-center gap-3 bg-cyan-500 hover:bg-white text-black font-black py-5 px-10 rounded-2xl transition-all duration-500 overflow-hidden shadow-2xl shadow-cyan-500/20">
                    <span class="relative z-10 uppercase tracking-widest text-xs">Post New Recipe</span>
                    <i class="fas fa-plus relative z-10 group-hover:rotate-90 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white/[0.02] border border-white/5 p-10 rounded-[2.5rem] backdrop-blur-3xl group hover:border-cyan-500/30 transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 text-xl">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="text-[10px] font-black text-cyan-500 uppercase tracking-widest">Total</span>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em] mb-1">Recipes Shared</p>
                    <p class="text-5xl font-black text-white group-hover:scale-110 origin-left transition-transform">{{ $recipes->count() }}</p>
                </div>

                <div class="bg-white/[0.02] border border-white/5 p-10 rounded-[2.5rem] backdrop-blur-3xl group hover:border-orange-500/30 transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-xl">
                            <i class="fas fa-globe"></i>
                        </div>
                        <span class="text-[10px] font-black text-orange-500 uppercase tracking-widest">Live</span>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em] mb-1">Visibility Status</p>
                    <p class="text-5xl font-black text-white">Public</p>
                </div>

                <div class="bg-white/[0.02] border border-white/5 p-10 rounded-[2.5rem] backdrop-blur-3xl group hover:border-white/20 transition-all duration-500">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-white text-xl">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Avg</span>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em] mb-1">Avg Cook Time</p>
                    <p class="text-5xl font-black text-white">~25<span class="text-xl ml-2 font-medium text-gray-600 tracking-normal italic">min</span></p>
                </div>
            </div>

            <div class="bg-white/[0.01] border border-white/5 rounded-[3rem] overflow-hidden backdrop-blur-xl shadow-[0_40px_100px_rgba(0,0,0,0.5)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02]">
                                <th class="px-10 py-8 text-gray-400 font-black uppercase text-[10px] tracking-[0.2em]">The Recipe</th>
                                <th class="px-10 py-8 text-gray-400 font-black uppercase text-[10px] tracking-[0.2em]">Category</th>
                                <th class="px-10 py-8 text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] text-center">Time</th>
                                <th class="px-10 py-8 text-gray-400 font-black uppercase text-[10px] tracking-[0.2em] text-right">Management</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 font-medium">
                            @forelse($recipes as $recipe)
                                <tr class="group hover:bg-white/[0.03] transition-all duration-500">
                                    <td class="px-10 py-8">
                                        <div class="flex items-center space-x-6">
                                            <div class="relative w-20 h-20 shrink-0">
                                                <div class="absolute inset-0 bg-cyan-500/20 blur-xl group-hover:opacity-100 opacity-0 transition-opacity"></div>
                                                <div class="relative w-full h-full rounded-2xl overflow-hidden border border-white/10 group-hover:border-cyan-500/50 transition-colors">
                                                    <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://via.placeholder.com/150' }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $recipe->name }}">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-white font-black text-xl mb-1 group-hover:text-cyan-400 transition-colors leading-none tracking-tight">{{ $recipe->name }}</p>
                                                <p class="text-gray-500 text-xs font-medium tracking-wide italic">Published on {{ $recipe->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="px-5 py-2 bg-white/5 text-gray-300 text-[10px] font-black rounded-xl border border-white/10 uppercase tracking-widest group-hover:border-orange-500/30 transition-colors">
                                            {{ $recipe->category->name ?? 'Gourmet' }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <span class="text-white text-lg font-black tracking-tighter">{{ $recipe->cook_time }} <span class="text-[10px] text-gray-600 font-bold uppercase ml-1">min</span></span>
                                    </td>
                                    <td class="px-10 py-8">
                                        <div class="flex items-center justify-end space-x-4">
                                            <a href="{{ route('my-recipes.edit', $recipe->id) }}" 
                                               class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-cyan-500 hover:text-black transition-all group/edit">
                                                <i class="fas fa-pencil-alt text-sm group-hover/edit:rotate-12 transition-transform"></i>
                                            </a>
                                            <form action="{{ route('my-recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Delete this creation permanently?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all group/del">
                                                    <i class="fas fa-trash-alt text-sm group-hover/del:animate-shake transition-transform"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-32 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center text-gray-700 mb-8">
                                                <i class="fas fa-utensils text-4xl"></i>
                                            </div>
                                            <p class="text-gray-500 font-bold text-xl mb-6">Your gallery is waiting for its first masterpiece.</p>
                                            <a href="{{ route('my-recipes.create') }}" class="text-cyan-400 font-black uppercase tracking-widest text-xs border-b-2 border-cyan-400/30 pb-1 hover:border-cyan-400 transition-all">
                                                Start Creating
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
        }
        .group-hover\/del\:animate-shake { animation: shake 0.3s ease-in-out infinite; }
    </style>
</x-app-layout>