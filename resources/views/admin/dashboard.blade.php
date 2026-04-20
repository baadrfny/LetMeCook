<x-app-layout>
    <div class="relative bg-[#050505] min-h-screen overflow-hidden font-['Satoshi'] text-white">
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 py-16 relative z-10">
            
            <div class="mb-12">
                <h1 class="text-5xl font-black tracking-tighter leading-none">
                    Admin <span class="text-orange-500 italic uppercase">Dashboard</span>
                </h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-gradient-to-br from-white/[0.05] to-transparent border border-white/10 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="fas fa-utensils text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-black mb-2">{{ $recipes->count() }}</h3>
                    <p class="text-orange-500 text-xs font-black uppercase tracking-widest">Total Recipes</p>
                </div>

                <div class="bg-gradient-to-br from-white/[0.05] to-transparent border border-white/10 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="fas fa-layer-group text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-black mb-2">{{ App\Models\Categories::count() }}</h3>
                    <p class="text-cyan-400 text-xs font-black uppercase tracking-widest">Live Categories</p>
                </div>

                <div class="bg-gradient-to-br from-white/[0.05] to-transparent border border-white/10 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="fas fa-seedling text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-black mb-2">{{ App\Models\Ingredient::count() }}</h3>
                    <p class="text-green-500 text-xs font-black uppercase tracking-widest">Ingredients</p>
                </div>
            </div>

            <div class="bg-white/[0.02] border border-white/10 rounded-[3rem] overflow-hidden backdrop-blur-3xl shadow-2xl">
                <div class="p-10 border-b border-white/10 flex justify-between items-center bg-white/[0.02]">
                    <h2 class="text-2xl font-black tracking-tight">Recent Masterpieces</h2>
                    <a href="{{ route('recipes.create') }}" class="bg-cyan-500 hover:bg-white text-black px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                        + Add New Recipe
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] bg-white/[0.02]">
                                <th class="px-10 py-6">Visual & Details</th>
                                <th class="px-10 py-6">Category</th>
                                <th class="px-10 py-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($recipes as $recipe)
                            <tr class="group hover:bg-white/[0.04] transition-all duration-300">
                                <td class="px-10 py-8">
                                    <div class="flex items-center space-x-8">
                                        <div class="relative w-24 h-24 shrink-0 rounded-[1.5rem] overflow-hidden border-2 border-white/10 group-hover:border-orange-500 transition-all duration-500 shadow-xl">
                                            @if($recipe->image)
                                                <img src="{{ asset('storage/' . $recipe->image) }}" class="w-full h-full object-cover scale-110 group-hover:scale-100 transition-transform duration-700" alt="{{ $recipe->name }}">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-600 text-xl"></i>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <div class="text-xl font-black text-white leading-none tracking-tight group-hover:text-orange-500 transition-colors">{{ $recipe->name }}</div>
                                            <div class="text-gray-500 text-xs font-medium max-w-sm line-clamp-1 italic">"{{ $recipe->description }}"</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-10 py-8">
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-500/10 text-cyan-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-cyan-500/20 group-hover:bg-cyan-500 group-hover:text-black transition-all">
                                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 group-hover:bg-black"></span>
                                        {{ $recipe->category->name }}
                                    </span>
                                </td>
                                
                                <td class="px-10 py-8">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white/5 hover:bg-cyan-500 text-white hover:text-black rounded-xl border border-white/10 hover:border-cyan-500 transition-all text-[10px] font-black uppercase tracking-widest">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Archive this masterpiece? This action is permanent.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-red-500/10 hover:bg-red-600 text-red-500 hover:text-white rounded-xl border border-red-500/20 hover:border-red-600 transition-all text-[10px] font-black uppercase tracking-widest">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>