<x-app-layout>
    <div class="mt-2">
        <x-auth-card>
            <title> Create Ticket </title>
            <form method="POST" action="{{ route('store.ticket') }}" enctype="multipart/form-data">
                @csrf

                <h2 class="text-white font-bold text-3xl pb-3 pt-2 underline"> Create Ticket </h2>

                <x-auth-validation-errors class="mb-3" :errors="$errors" />

                <!-- Title -->
                <div class="mt-3">
                    <x-label for="title" :value="__('Title:')" />

                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                        required autofocus />
                </div>

                <!-- Details -->
                <div class="mt-3">
                    <x-label for="details" :value="__('Details:')" />

                    <textarea name="details" id="" cols="30" class="block mt-1 min-h-full max-h-32 w-full rounded-xl"
                        rows="10"></textarea>
                </div>

                <!-- Logged By -->
                <div class="mt-3">
                    <x-label for="loggedby" :value="__('Logged By:')" />

                    <x-input id="loggedby" class="block mt-1 w-full" type="text" name="logged_by" :value="old('loggedby')"
                        required autofocus />
                </div>

                <!-- Urgency Level -->
                <div class="mt-3">
                    <x-label for="urgency" :value="__('Urgency Level:')" />

                    <x-select name="urgency" id="urgency" :value="old('urgency')"
                        required>
                        <option disabled selected value></option>
                        @foreach ($urgencies as $key => $value)
                            <option value="{{ $key }}"> {{ $value }}</option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Category-->
                <div class="mt-3">
                    <x-label for="category" :value="__('Category:')" />

                    <x-select name="category" id="category" name="category"
                        :value="old('category')" required>
                        <option disabled selected value></option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $key }}"> {{ $value }}</option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Open -->
                <div class="mt-3">
                    <x-label for="open" :value="__('Open:')" />

                    <x-select name="open" id="open" :value="old('open')"
                        required>
                        <option disabled selected value></option>
                        <option value="{{ App\Models\Ticket::OPEN }}">
                            Yes
                        </option>
                        <option value="{{ App\Models\Ticket::CLOSED }}">
                            No
                        </option>
                    </x-select>
                </div>

                <!-- File -->
                <div class="mt-3">
                    <x-label for="file" :value="__('File (Optional):')" />

                    <input type="file" id="file" class="block mt-1 w-full" name="file" />
                </div>

                <div class="flex items-center justify-end mt-3">
                    <x-button class="ml-3">
                        {{ __('Submit') }}
                    </x-button>
                </div>

                @auth
                    <!-- Assigned To -->
                    <div class="">
                        <x-label for="assignedTo" :value="__('Assigned To:')" />

                        <x-select name="assigned_to" id="assigned_to" name="assigned_to">s
                            <option disabled selected value<</option>
                                @foreach ($itSupportUsers as $user)
                            <option value="{{ $user->id }}">
                                {{ ucwords($user->first_name . ' ' . $user->last_name) }} </option>
                            @endforeach
                        </x-select>
                    </div>
                @endauth
            </form>
        </x-auth-card>
    </div>
    </htm </x-app-layout>
