<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'TaskFlow' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-between p-8 lg:p-16 bg-white min-h-screen">
            <div></div>

            <div class="max-w-md w-full mx-auto">
                {{ $slot }}
            </div>

            <div class="max-w-md w-full mx-auto mt-12 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-600 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-600 transition">Terms of Service</a>
                </div>
                <p>&copy; {{ date('Y') }} TaskFlow</p>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-[#DCE8F2] p-16 flex-col justify-between relative overflow-hidden">
            <div class="flex items-center gap-2 text-slate-900 font-semibold text-xl">
                <div class="w-9 h-9 bg-[#2F5F73] text-white rounded-lg flex items-center justify-center text-lg font-bold">T</div>
                <span>TaskFlow</span>
            </div>

            <div class="max-w-lg my-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight mb-6">
                    One workspace for<br>every project you run.
                </h1>
                <p class="text-slate-600 text-base lg:text-lg leading-relaxed">
                    Plan milestones, assign tasks, track hours, and keep your whole team aligned — all in a single project management system built for how teams actually work.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex -space-x-2 overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#DCE8F2]" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="User">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#DCE8F2]" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="User">
                    <div class="h-8 w-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-medium ring-2 ring-[#DCE8F2]">+1k</div>
                </div>
                <span class="text-sm font-medium text-slate-700">Join 1,200+ teams worldwide</span>
            </div>
        </div>

    </div>
</body>
</html>