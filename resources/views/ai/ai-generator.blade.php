<x-app-layout>
    <div class="relative bg-[#050505] min-h-screen overflow-hidden font-['Satoshi']">
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-6 py-20 relative z-10">
            
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Powered by Neural Chef</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-none">
                    What's in your <span class="text-orange-500 italic text-4xl md:text-6xl uppercase">Kitchen?</span>
                </h1>
                <p class="text-gray-500 text-lg font-medium max-w-2xl mx-auto">
                    Enter your available ingredients and let our AI architect a gourmet masterpiece for you.
                </p>
            </div>

            <div class="bg-white/[0.02] border border-white/5 p-8 md:p-12 rounded-[3rem] backdrop-blur-3xl shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 blur-3xl rounded-full transition-all group-hover:bg-cyan-500/10"></div>
                
                <div class="relative z-10 space-y-8">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-4 ml-2">Available Ingredients</label>
                        <input type="text" id="ingredientsInput" 
                               placeholder="e.g. Salmon, Asparagus, Lemon, Thyme..." 
                               class="w-full p-6 bg-black/40 border border-white/10 rounded-2xl focus:border-cyan-500/50 focus:ring-0 outline-none transition-all text-white placeholder:text-gray-700 text-lg font-medium shadow-inner">
                    </div>

                    <button id="generateBtn" class="group relative w-full py-6 bg-cyan-500 hover:bg-white text-black font-black text-xs uppercase tracking-[0.3em] rounded-2xl transition-all duration-500 shadow-xl shadow-cyan-500/10 overflow-hidden">
                        <span class="relative z-10">✨ Generate Culinary Design</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                </div>
            </div>

            <div id="loader" class="hidden text-center py-20 animate-pulse">
                <div class="relative inline-block">
                    <div class="w-16 h-16 border-2 border-cyan-500/20 border-t-cyan-500 rounded-full animate-spin"></div>
                    <i class="fas fa-robot absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-cyan-500"></i>
                </div>
                <p class="text-cyan-400 font-black uppercase tracking-[0.3em] text-[10px] mt-6">Chef AI is architecting your recipe...</p>
            </div>

            <div id="recipeDisplay" class="hidden mt-12 bg-white/[0.01] border border-white/5 p-10 md:p-16 rounded-[3.5rem] backdrop-blur-3xl shadow-[0_40px_100px_rgba(0,0,0,0.5)] animate-in fade-in slide-in-from-bottom-10 duration-1000">
                
                <div class="flex flex-wrap gap-3 mb-10">
                    <span id="display_difficulty" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-orange-500/10 text-orange-500 border border-orange-500/20"></span>
                    <span id="display_country" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-cyan-500/10 text-cyan-400 border border-cyan-500/20"></span>
                    <span id="display_time" class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-white/5 text-gray-400 border border-white/10"></span>
                </div>
        
                <h2 id="display_name" class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-6 leading-none"></h2>
                
                <div class="relative mb-12">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-orange-500 to-transparent opacity-50"></div>
                    <p id="display_desc" class="text-gray-400 text-xl font-medium leading-relaxed italic pl-8"></p>
                </div>
                
                <div class="space-y-8">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 flex items-center gap-4">
                        Execution Steps <span class="h-px bg-white/5 flex-grow"></span>
                    </h3>
                    <div id="display_steps" class="text-gray-300 text-lg font-medium leading-relaxed whitespace-pre-line bg-white/[0.02] p-8 md:p-12 rounded-[2.5rem] border border-white/5 shadow-inner"></div>
                </div>

                <div class="mt-12 pt-12 border-t border-white/5 flex justify-center">
                    <button onclick="window.print()" class="text-gray-500 hover:text-white transition-colors text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-print"></i> Save as PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generateBtn').addEventListener('click', async () => {
            const input = document.getElementById('ingredientsInput').value;
            
            if (input.trim().length < 3) {
                alert('Please reveal your ingredients first.');
                return;
            }

            const loader = document.getElementById('loader');
            const display = document.getElementById('recipeDisplay');
            const btn = document.getElementById('generateBtn');

            loader.classList.remove('hidden');
            display.classList.add('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                const response = await fetch('/ai/generate-guest', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ingredients: input })
                });

                const data = await response.json();
                
                document.getElementById('display_name').innerText = data.name;
                document.getElementById('display_desc').innerText = `"${data.description}"`;
                document.getElementById('display_steps').innerText = data.preparation_steps;
                document.getElementById('display_time').innerText = "⏱️ " + data.cook_time + " MIN";
                document.getElementById('display_difficulty').innerText = "🔥 " + data.difficulty;
                document.getElementById('display_country').innerText = "📍 " + data.country_origin;

                loader.classList.add('hidden');
                display.classList.remove('hidden');
            } catch (e) {
                alert('Connection to Neural Chef lost. Please try again.');
                loader.classList.add('hidden');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
</x-app-layout>