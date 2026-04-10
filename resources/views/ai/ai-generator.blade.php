<div id="recipeDisplay" class="hidden space-y-6 animate-fade-in">
    <h3 id="display_name" class="text-3xl font-bold text-orange-500"></h3>
    <div class="flex gap-4 flex-wrap">
        <span id="display_time" class="bg-gray-800 px-3 py-1 rounded text-cyan-400"></span>
        <span id="display_difficulty" class="bg-gray-800 px-3 py-1 rounded text-orange-400"></span>
        <span id="display_country" class="bg-gray-800 px-3 py-1 rounded text-green-400"></span>
    </div>
    <p id="display_desc" class="text-gray-300 italic"></p>
    <div class="bg-gray-900 p-6 rounded-xl border border-gray-800">
        <h4 class="text-white mb-4 font-bold">Preparation Steps:</h4>
        <p id="display_steps" class="whitespace-pre-line text-gray-400"></p>
    </div>
</div>
<script>
// داخل ملف ai-generator.blade.php في قسم الـ Script

document.getElementById('generateBtn').addEventListener('click', async () => {
    // جلب المكونات المختارة
    const selectedIngredients = Array.from(document.querySelectorAll('input[name="ingredients[]"]:checked'))
                                     .map(el => el.value);

    // إظهار اللودر (Loader)
    document.getElementById('loader').classList.remove('hidden');

    try {
        const response = await fetch('/ai/generate-guest', { // تأكد من هذا المسار
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ingredients: selectedIngredients })
        });

        const data = await response.json();

        // إخفاء اللودر وإظهار قسم النتيجة
        document.getElementById('loader').classList.add('hidden');
        document.getElementById('recipeDisplay').classList.remove('hidden');

        // تعبئة البيانات
        document.getElementById('display_name').innerText = data.name;
        document.getElementById('display_desc').innerText = data.description;
        document.getElementById('display_steps').innerText = data.preparation_steps;
        document.getElementById('display_time').innerText = data.cook_time + " mins";
        
        // Add difficulty and country if available
        const difficultyEl = document.getElementById('display_difficulty');
        const countryEl = document.getElementById('display_country');
        
        if (difficultyEl && data.difficulty) {
            difficultyEl.innerText = data.difficulty;
        }
        
        if (countryEl && data.country_origin) {
            countryEl.innerText = data.country_origin;
        }
        
        // Auto YouTube Link
        const searchQuery = encodeURIComponent(data.name + " recipe");
        document.getElementById('res_video').value = `https://www.youtube.com/results?search_query=${searchQuery}`;
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loader').classList.add('hidden');
    }
});
</script>
