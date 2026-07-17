@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border-[#D6E5EC] text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-[#2F5F73] focus:ring-[#2F5F73] disabled:opacity-60']) }}>