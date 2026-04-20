<x-guest-layout>
    <style>
        html, body { 
            height: 100%; 
            margin: 0; 
            background-color: #050505 !important;
            overflow: hidden; 
        }
    </style>

    <div class="fixed inset-0 w-screen h-screen bg-[#050505] flex items-center justify-center font-['Satoshi'] overflow-hidden px-6">
        
        <div class="absolute -top-[15%] -right-[10%] w-[900px] h-[900px] bg-cyan-600/10 rounded-full blur-[180px] pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-[15%] -left-[10%] w-[900px] h-[900px] bg-orange-600/10 rounded-full blur-[180px] pointer-events-none animate-pulse"></div>

        <div class="relative z-10 w-full max-w-[500px]">
            
            <div class="text-center mb-8 space-y-2">
                <div class="inline-block px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-2">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-cyan-400">Identity Formation</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase text-white leading-none">
                    Join the <span class="text-cyan-400 italic font-medium tracking-normal">Studio</span>
                </h1>
            </div>

            <div class="bg-white/[0.03] border border-white/10 backdrop-blur-3xl rounded-[3rem] p-8 md:p-10 shadow-[0_50px_100px_rgba(0,0,0,0.9)]">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="group space-y-2">
                        <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Architect Name</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus
                            class="w-full bg-black/50 border-white/10 rounded-2xl py-3.5 px-6 text-white focus:border-orange-500/50 focus:ring-0 transition-all font-bold text-sm shadow-inner"
                            placeholder="Ex: Leonardo">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-[9px] font-black uppercase" />
                    </div>

                    <div class="group space-y-2">
                        <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">Digital Mail</label>
                        <input id="email" type="email" name="email" :value="old('email')" required
                            class="w-full bg-black/50 border-white/10 rounded-2xl py-3.5 px-6 text-white focus:border-cyan-500/50 focus:ring-0 transition-all font-bold text-sm shadow-inner"
                            placeholder="name@studio.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-[9px] font-black uppercase" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group space-y-2">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">Security Key</label>
                            <input id="password" type="password" name="password" required
                                class="w-full bg-black/50 border-white/10 rounded-xl py-3.5 px-6 text-white focus:border-orange-500/50 focus:ring-0 transition-all font-bold text-sm shadow-inner"
                                placeholder="••••••••">
                        </div>

                        <div class="group space-y-2">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-cyan-400 transition-colors">Verify Key</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full bg-black/50 border-white/10 rounded-xl py-3.5 px-6 text-white focus:border-cyan-500/50 focus:ring-0 transition-all font-bold text-sm shadow-inner"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 text-[9px] font-black uppercase" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-[9px] font-black uppercase" />

                    <div class="pt-4 space-y-4">
                        <button type="submit" class="w-full group relative py-5 bg-white text-black font-black text-[10px] uppercase tracking-[0.5em] rounded-2xl transition-all duration-500 shadow-2xl overflow-hidden">
                            <span class="relative z-10 group-hover:text-white transition-colors">Construct Identity</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-cyan-700 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        </button>

                        <div class="text-center">
                            <a class="text-[9px] font-black uppercase tracking-widest text-gray-600 hover:text-orange-500 transition-colors" href="{{ route('login') }}">
                                {{ __('Already have an identity? Login') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>