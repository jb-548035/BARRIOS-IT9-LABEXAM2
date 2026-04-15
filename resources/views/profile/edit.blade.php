<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-brand-dark">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="container-lg py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="card shadow-sm mb-4">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="card shadow-sm">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
