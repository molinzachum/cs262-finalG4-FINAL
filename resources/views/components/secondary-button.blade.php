<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center rounded-lg border border-[#D6E5EC] bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-[#EEF6FA] focus:outline-none focus:ring-2 focus:ring-[#2F5F73] focus:ring-offset-2 disabled:opacity-40']) }}>
    {{ $slot }}
</button>