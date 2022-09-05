<head>
    <title> Register </title>
</head>

<x-app-layout>
    <div class="mt-20">
        <x-auth-card>
            <x-slot name="logo">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </x-slot>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h2 class="text-white font-bold text-4xl pb-4 pt-2 underline"> Register </h2>

                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <!-- First Name -->
                <div>
                    <x-label for="firstname" :value="__('First Name')" />

                    <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('firstname')"
                        required autofocus />
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <x-label for="lastname" :value="__('Last Name')" />

                    <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('lastname')"
                        required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required />
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <x-label for="roleid" :value="__('Role')" />

                    <select id="role_id" class="block mt-1 w-full" name="role_id" required>
                        <option value="{{ App\Models\User::ITSUPPORT }}"> IT Support </option>
                        <option value="{{ App\Models\User::ADMIN }}"> Admin </option>
                    </select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-white hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="ml-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </x-auth-card>
    </div>
</x-app-layout>   
