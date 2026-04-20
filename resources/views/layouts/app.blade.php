<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LetMeCook | Premium Recipes</title>

    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            font-family: 'Satoshi', sans-serif;
            background-color: #050505;
            color: #ffffff;
            -webkit-font-smoothing: antialiased;
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="antialiased selection:bg-orange-500/30">
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-white/[0.02] rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10">
        @include('layouts.navigation')
        <main>{{ $slot }}</main>
    </div>
</body>
</html>