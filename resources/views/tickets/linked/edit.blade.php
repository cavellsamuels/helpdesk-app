<x-app-layout>

    <head>
        <title> Edit Ticket </title>
    </head>

    <div class="text-center mt-10 mb-0">
        <h1 class="font-medium leading-tight text-4xl mt-0 mb-4 text-white font-black underline font-sans"> Edit
            Tickets </h1>
    </div>

    <div class="max-w-fit mx-auto px-4 lg:px-8 mt-14">
        <div class="pb-6 grid grid-cols-3">
        @if ($tickets == true)
            @foreach ($tickets as $ticket)
                <x-auth-card>
                    <h2 class="text-white font-bold text-4xl pb-4 pt-2 underline"> Ticket #{{ $ticket->id }} </h2>

                    <x-auth-validation-errors />

                    <form method="POST" action="{{ route('update.ticket', [$ticket->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Assigned To -->
                        <div class="">
                            <x-label for="assignedTo" :value="__('Assigned To')" />

                            <select name="assigned_to" value="" id="assigned_to"
                                class="block mt-1 w-full rounded-xl" name="assigned_to">
                                @if ($ticket->user)
                                    <option Selected hidden value="{{ $ticket->assigned_to }}"
                                        {{ $user = App\Models\User::find($ticket->assigned_to) }}>
                                        {{ ucwords($user->value('first_name') . ' ' . $user->value('last_name')) }}
                                    </option>
                                    <option value="" name="unassigned"> Unassign </option>
                                @else
                                    <option selected hidden value="">-- Select a User --</option>
                                @endif
                                @foreach ($itSupportUsers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ ucwords($user->first_name . ' ' . $user->last_name) }} </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="mt-4">
                            <x-label for="title" :value="__('Title')" />

                            <x-input type="text" class="block mt-1 w-full" name="title" placeholder="Name"
                                value="{{ ucwords($ticket->title) }}" />
                        </div>

                        <!-- Details -->
                        <div class="mt-4">
                            <x-label for="details" :value="__('Details')" />

                            <x-input type="text" class="block mt-1 w-full" name="details" placeholder="Details"
                                value="{{ ucwords($ticket->details) }}" />
                        </div>

                        <!-- Logged By -->
                        <div class="mt-4">
                            <x-label for="loggedby" :value="__('Logged By')" />

                            <x-input type="text" class="block mt-1 w-full" name="logged_by" placeholder="Name"
                                value="{{ ucwords($ticket->logged_by) }}" />
                        </div>

                        <!-- Urgency Level -->
                        <div class="mt-4">
                            <x-label for="urgency" :value="__('Urgency Level')" />

                            <select name="urgency" id="urgency" class="block mt-1 w-full rounded-xl"
                                value="{{ old('urgency') }}" required>
                                @foreach ($urgencies as $key => $value)
                                    @if ($key == $ticket->urgency)
                                        {{ $value }}
                                    @endif
                                    <option value="{{ $key }}"> {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category-->
                        <div class="mt-4">
                            <x-label for="category" :value="__('Category')" />

                            <select name="category" id="category" class="block mt-1 w-full rounded-xl"
                                value="{{ $ticket->category }}" required>
                                @foreach ($categories as $key => $value)
                                    <option value="{{ $key }}"> {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Open -->
                        <div class="mt-4">
                            <x-label for="open" :value="__('Open Level')" />

                            <select name="open" id="open" class="block mt-1 w-full rounded-xl"
                                value="{{ ucwords($ticket->open) }}" required>
                                <option value="{{ true }}">
                                    Yes
                                </option>
                                <option value="{{ false }}">
                                    No
                                </option>
                            </select>
                        </div>

                        <!-- File -->
                        <div class="mt-4 mb-6">
                            <x-label for="file" :value="__('File (Optional)')" />

                            @if ($ticket->file)
                                <x-input type="text" class="block mt-1 w-full mb-4" name="" placeholder="Name"
                                    value="{{ ucwords($ticket->file->name) }}" readonly />
                            @else
                                <x-input type="text" class="block mt-1 w-full mb-4" name="" placeholder="Name"
                                    value="No File Set" readonly />
                            @endif

                            <input type="file" id="file" class="block mt-1 w-full" name="file" />
                    </form>
                </x-auth-card>
            @endforeach
        @endif
    </div>

    <div class="text-center">
        <form action="{{ route('update.linked', $tickets->pluck('id')) }}" method="POST">
            @csrf
            @method('PUT')

            <x-button class="mt-2 text-xl">
                {{ __('Update') }}
            </x-button>
        </form>
    </div>
    </div>
</x-app-layout>
