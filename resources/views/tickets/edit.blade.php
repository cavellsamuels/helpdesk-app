<x-app-layout>

    <head>
        <title> Edit Ticket </title>
    </head>

    <div class="pb-6">
        <x-auth-card>
            <x-heading2> Edit Ticket #{{ $ticket->id }} </x-heading2>

            <x-auth-validation-errors class="" :errors="$errors" />

            <form method="POST" action="{{ route('update.ticket', [$ticket->id, $ticket->file]) }}"
                enctype="multipart/form-data">
                @csrf @method('PUT')
                @auth

                    <div class="">
                        <x-label for="title" :value="__('Title')" />

                        <x-input type="text" class="block mt-
                    1 w-full" name="title"
                            placeholder="Name" value="{{ ucwords($ticket->title) }}" />
                    </div>

                    <div class="mt-4">
                        <x-label for="details" :value="__('Details:')" />

                        <x-input type="text" class="block mt-1 w-full" name="details" placeholder="Details"
                            value="{{ ucwords($ticket->details) }}" />
                    </div>

                    <div class="mt-4">
                        <x-label for="urgency" :value="__('Urgency')" />

                        <select name="urgency" id="urgency" class="block mt-1 w-full rounded-xl" required>
                            <option selected hidden value="{{ $ticket->urgency }}">
                                @foreach ($urgencies as $key => $value)
                                    @if ($key == $ticket->urgency)
                                        {{ $value }}
                                    @endif
                                @endforeach
                            </option>
                            @foreach ($urgencies as $key => $value)
                                @if ($key == $ticket->urgency)
                                    {{ $value }}
                                @endif
                                <option value="{{ $key }}"> {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="category" :value="__('Category')" />

                        <select name="category" id="category" class="block mt-1 w-full rounded-xl">
                            <option selected hidden value="{{ $ticket->category }}">
                                @foreach ($categories as $key => $value)
                                    @if ($key == $ticket->category)
                                        {{ $value }}
                                    @endif
                                @endforeach
                            </option>
                            @foreach ($categories as $key => $value)
                                <option value="{{ $key }}"> {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endauth

                <div class="mt-4">
                    <x-label for="open" :value="__('Status')" />

                    <select name="open" id="open" class="block mt-1 w-full rounded-xl"
                        value="{{ ucwords($ticket->open) }}">
                        <option selected hidden value="{{ $ticket->open }}">
                            @if ($ticket->open == true)
                                <div> &#x2705; Open </div>
                            @endif

                            @if ($ticket->open == false)
                                <div> &#x274C; Closed </div>
                            @endif
                        </option>
                        <option value="{{ App\Models\Ticket::OPEN }}">
                            <div> &#x2705; Open </div>
                        </option>
                        <option value="{{ App\Models\Ticket::CLOSED }}">
                            <div> &#x274C; Closed </div>
                        </option>
                    </select>
                </div>

                @auth
                    <div class="mt-4">
                        <x-label for="file" :value="__('File (Optional)')" />

                        @if ($ticket->file)
                            <x-input type="text" class="block mt-1 w-full" name="" placeholder="Name"
                                value="{{ ucwords($ticket->file->name) }}" readonly />
                        @endif
                        <input type="file" id="file" class="mt-6 w-full" name="file" />
                    </div>

                    <div class="mt-4">
                        <x-label for="assignedTo" :value="__('Assigned To')" />

                        <select name="assigned_to" value="" id="assigned_to" class="block mt-1 w-full rounded-xl"
                            name="assigned_to">
                            @if ($ticket->user)
                                <option Selected hidden value="{{ $ticket->assigned_to }}"
                                    {{ $user = App\Models\User::find($ticket->assigned_to) }}>
                                    {{ ucwords($user->value('first_name') . ' ' . $user->value('last_name')) }}</option>
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
                @endauth

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-auth-card>
    </div>
</x-app-layout>
