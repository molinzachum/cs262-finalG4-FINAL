<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Workspace</p>
                <h1 class="text-2xl font-bold text-slate-950">Account Settings</h1>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm sm:p-6">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm sm:p-6">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm sm:p-6">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </section>
    </div>
</x-app-layout>