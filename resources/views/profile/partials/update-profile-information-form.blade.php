<section>
    <header>
        <h2 class="text-lg font-semibold text-slate-950">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />

            <div class="mt-2 flex items-center gap-4">
                @if ($user->profile_picture)
                    <img
                        src="{{ asset('storage/' . $user->profile_picture) }}"
                        alt="{{ $user->name }}"
                        class="h-16 w-16 rounded-lg border border-[#D6E5EC] object-cover"
                    >
                @else
                    <span class="flex h-16 w-16 items-center justify-center rounded-lg bg-[#2F5F73] text-xl font-semibold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @endif
                <input id="profile_picture" name="profile_picture" type="file" accept="image/png, image/jpeg, image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-[#EEF6FA] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#2F5F73] hover:file:bg-[#E5F0F5]" />
            </div>
            <p class="mt-1 text-xs text-slate-500">{{ __('JPG, PNG or WEBP, up to 2MB.') }}</p>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-700">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="rounded-md text-sm font-medium text-[#2F5F73] underline hover:text-[#1F3F4D] focus:outline-none focus:ring-2 focus:ring-[#2F5F73] focus:ring-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>