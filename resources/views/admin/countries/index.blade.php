<x-app-layout>
    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-orange-500">Countries Management</h1>
                </div>

                <!-- Add New Country Form -->
                <div class="mb-8 p-4 bg-gray-700 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-300 mb-4">Add New Country</h2>
                    <form action="{{ route('countries.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Country name" required
                               class="flex-1 px-3 py-2 bg-gray-600 border border-gray-500 rounded-md text-black">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded">
                            Add Country
                        </button>
                    </form>
                </div>

                <!-- Countries List -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-300 mb-4">Existing Countries</h2>
                    
                    @if($countries->count() > 0)
                        @foreach($countries as $country)
                        <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-black">{{ $country->name }}</h3>
                                <p class="text-gray-400 text-sm">ID: {{ $country->id }}</p>
                            </div>
                            
                            <div class="flex gap-2">
                                <!-- Edit Form -->
                                <form action="{{ route('countries.update', $country) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $country->name }}" required
                                           class="px-2 py-1 bg-gray-600 border border-gray-500 rounded text-black text-sm">
                                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 px-3 py-1 rounded text-sm">
                                        Update
                                    </button>
                                </form>
                                
                                <!-- Delete Form -->
                                <form action="{{ route('countries.destroy', $country) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <p>No countries found. Add your first country above!</p>
                        </div>
                    @endif
                </div>

                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-600 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
