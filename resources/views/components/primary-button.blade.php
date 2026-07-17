<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg bg-[#2F5F73] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#274F60] focus:outline-none focus:ring-2 focus:ring-[#2F5F73] focus:ring-offset-2 active:bg-[#1F3F4D] disabled:opacity-50']) }}>
    {{ $slot }}
</button>