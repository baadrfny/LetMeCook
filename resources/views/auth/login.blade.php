<x-guest-layout>
    <style>
        html, body { 
            height: 100%; 
            margin: 0; 
            background-color: #050505 !important;
            overflow: hidden; 
        }
    </style>

    <div class="fixed inset-0 w-screen h-screen bg-[#050505] flex items-center justify-center font-['Satoshi'] overflow-hidden">
        
        <div class="absolute -top-[20%] -left-[10%] w-[1000px] h-[1000px] bg-orange-600/10 rounded-full blur-[180px] pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[1000px] h-[1000px] bg-cyan-600/10 rounded-full blur-[180px] pointer-events-none animate-pulse"></div>

        <div class="relative z-10 w-full max-w-[450px] px-8">
            
            <div class="text-center mb-10 space-y-3">
                <div class="inline-block px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-4">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-orange-500">Secure Protocol</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter uppercase text-white leading-none">
                    Studio <span class="text-orange-500 italic font-medium tracking-normal">In</span>
                </h1>
            </div>

            <div class="bg-white/[0.03] border border-white/10 backdrop-blur-3xl rounded-[3rem] p-8 md:p-12 shadow-[0_50px_100px_rgba(0,0,0,0.9)]">
                
                <x-auth-session-status class="mb-6 text-cyan-400 text-[10px] font-black text-center uppercase tracking-widest" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <div class="group space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 ml-2 group-focus-within:text-orange-500 transition-colors">
                            {{ __('Architect Identity') }}
                        </label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full bg-black/50 border-white/10 rounded-2xl py-4 px-6 text-white focus:border-orange-500/50 focus:ring-0 transition-all font-bold text-sm placeholder-gray-800"
                            placeholder="name@studio.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-[9px] font-black uppercase" />
                    </div>

                    <div class="group space-y-3">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-500 group-focus-within:text-cyan-400 transition-colors">
                                {{ __('Pass-Key') }}
                            </label>
                        </div>
                        <input id="password" type="password" name="password" required 
                            class="w-full bg-black/50 border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500/50 focus:ring-0 transition-all font-bold text-sm placeholder-gray-800"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-[9px] font-black uppercase" />
                    </div>

                    <div class="flex items-center justify-between px-2">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="hidden peer">
                            <div class="w-8 h-4 bg-white/5 border border-white/10 rounded-full peer-checked:bg-cyan-500 transition-all relative">
                                <div class="absolute left-1 top-1 w-2 h-2 bg-gray-600 rounded-full peer-checked:translate-x-4 peer-checked:bg-white transition-all"></div>
                            </div>
                            <span class="ms-3 text-[9px] font-black uppercase tracking-widest text-gray-500 group-hover:text-gray-300 transition-colors">Remember</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-[9px] font-black uppercase tracking-widest text-gray-600 hover:text-orange-500 transition-colors" href="{{ route('password.request') }}">
                                {{ __('Forgot?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full group relative py-5 bg-white text-black font-black text-[10px] uppercase tracking-[0.5em] rounded-2xl transition-all duration-500 shadow-2xl overflow-hidden">
                        <span class="relative z-10 group-hover:text-white transition-colors">Login</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </form>
            </div>

            <div class="mt-12 text-center space-y-4">
                <p class="text-gray-600 text-[9px] font-black uppercase tracking-[0.3em]">
                    New here? <a href="{{ route('register') }}" class="text-white hover:text-cyan-400 transition-colors underline decoration-cyan-500/30 underline-offset-4">Register Identity</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>