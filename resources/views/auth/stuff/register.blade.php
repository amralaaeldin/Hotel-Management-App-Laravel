<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" style="display: flex;flex-direction: column;align-items: center;">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                <h3>Stuff - Register</h3>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" enctype="multipart/form-data" action="{{ route('stuff.register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- National Id -->
            <div class="mt-4">
                <x-label for="national_id" value="National Id" />

                <x-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" required/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Avatar -->
            <div class="mt-4">
                <x-label for="avatar" value="Upload Image" />
                <input id="avatar" name="avatar" class="block w-full text-sm text-gray-900 bg-white-50 rounded-lg border shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cursor-pointer" type="file">
            </div>

            <!-- Role -->
            <div class="mt-4">
                <x-label for="role" value="Select an option" />
                <select name="role" required id="role" class="bg-white-50 text-gray-900 text-sm rounded-lg shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    <option selected>Choose a Role</option>
                    @foreach ($roles as $role)
                    <option value="$role">{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('stuff.login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
