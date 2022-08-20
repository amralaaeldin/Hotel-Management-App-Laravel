<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" style="display: flex;flex-direction: column;align-items: center;">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                <h3>Client - Edit</h3>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="mb-3">
            <img class="mx-auto" style="width:85px; object-fit:cover; height:85px; border-radius:50%" alt="avatar"
                src="{{ asset($client->avatar) }}" />
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('clients.update', $client->id) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input required id="name" class="block mt-1 w-full" type="text" name="name"
                    value="{{ $client->name ?? '' }}" autofocus />
            </div>

            <!-- Mobile Phone -->
            <div class="mt-4">
                <x-label for="mobile" value="Mobile Phone" />

                <x-input required id="mobile" class="block mt-1 w-full" type="text" name="mobile"
                    value="{{ $client->mobile ?? '' }}" />
            </div>

            <!-- Country -->
            <div class="mt-4">
                <x-label for="country" value="Select an option" />
                <select required name="country" id="country"
                    class="bg-white-50 text-gray-900 text-sm rounded-lg shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    <option selected>Choose a Country</option>
                    @foreach ($countries as $country)
                        <option {{ $client->country === array_keys($countries)[$loop->index] ? 'selected' : '' }}
                            value="{{ array_keys($countries)[$loop->index] }}">{{ $country['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Avatar -->
            <div class="mt-4">
                <x-label for="avatar" value="Upload Image" />
                <input id="avatar" name="avatar"
                    class="block w-full text-sm text-gray-900 bg-white-50 rounded-lg border shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cursor-pointer"
                    type="file">
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <x-label for="gender" value="Select an option" />
                <select required name="gender" id="gender"
                    class="bg-white-50 text-gray-900 text-sm rounded-lg shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full p-2.5">
                    <option {{ $client->gender === 'M' ? 'selected' : '' }} value="M">Male</option>
                    <option {{ $client->gender === 'F' ? 'selected' : '' }} value="F">Female</option>
                </select>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input required id="email" class="block mt-1 w-full" type="email" name="email"
                    value="{{ $client->email ?? '' }}" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Edit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
