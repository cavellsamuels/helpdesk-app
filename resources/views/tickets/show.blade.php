<x-app-layout>

    <title> Ticket Details </title>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 mx-0 mt-10 ">
            <x-auth-card>
                <x-heading2> Ticket #{{ $ticket->id }} Details </x-heading2>

                <div class="">
                    <x-label for="title" :value="__('Title:')" />
                    <x-input type="text" class="block mt-1 w-full" name="title" placeholder="Name"
                        value="{{ ucwords($ticket->title) }}" readonly />
                </div>

                <div class="mt-4">
                    <x-label for="details" :value="__('Details:')" />
                    <x-textarea type="text" name="details" readonly>{{ ucwords($ticket->details) }}</x-textarea>
                </div>

                <div class="mt-4">
                    <x-label for="urgency" :value="__('Urgency:')" />

                    <select name="urgency" id="urgency" class="block mt-1 w-full rounded-xl display:none" disabled>
                        <option selected readonly hidden value="{{ $ticket->urgency }}">
                            @foreach ($urgencies as $key => $value)
                                @if ($key == $ticket->urgency)
                                    {{ $value }}
                                @endif
                            @endforeach
                        </option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="category" :value="__('Category:')" />

                    <select disabled name="category" id="category" class="block mt-1 w-full rounded-xl">
                        <option selected hidden value="{{ $ticket->category }}">
                            @foreach ($categories as $key => $value)
                                @if ($key == $ticket->category)
                                    {{ $value }}
                                @endif
                            @endforeach
                        </option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="open" :value="__('Status:')" />
                    <select disabled name="open" id="open" class="block mt-1 w-full rounded-xl"
                        value="{{ ucwords($ticket->open) }}" required>
                        <option selected hidden value="{{ $ticket->open }}">
                            @if ($ticket->open == true)
                                <div> &#x2705; Open </div>
                            @endif

                            @if ($ticket->open == false)
                                <div> &#x274C; Closed </div>
                            @endif
                        </option>
                    </select>
                </div>

                <div class="mt-4 mb-0">
                    <x-label for="file" :value="__('File:')" />
                    @if ($ticket->file)
                        <span>
                            <div class="flex">
                                <x-input type="text" class="w-full" name="file"
                                    value="{{ ucwords($ticket->file->name) }}" placeholder="File" readonly />
                                <form action="{{ route('file.download', [$ticket->id, $ticket->file]) }}">
                                    <button class="bg-gray-800 text-white p-1 w-10 rounded-xl text-md"> <u> ↓ </u>
                                    </button>
                                </form>
                            </div>
                        </span>
                    @else
                        <x-input type="text" class="block mt-1 w-full" name="file" value="No File Attached"
                            readonly />
                    @endif
                </div>

                <div class="mt-4 mb-0">
                    <x-label for="createdat" :value="__('Created At:')" class="mt-4" />

                    <x-input type="text" class="block mt-1 w-full" name="createdat"
                        value="{{ $ticket->created_at->format('d/m/Y | h:m A ') }}" readonly />
                </div>

                <div class="mt-4 mb-4">
                    <x-label for="loggedby" :value="__('Logged By:')" />
                    <x-input type="text" class="block mt-1 w-full" name="loggedby" placeholder="Name"
                        value="{{ ucwords($ticket->logged_by) }}" readonly />
                </div>
                @auth
                    <div class="mt-4">
                        <x-label for="assignedTo" :value="__('Assigned To:')" />

                        <select name="assigned_to" value="" id="assigned_to" class="block mt-1 w-full rounded-xl mb-4"
                            name="assigned_to">
                            @if ($ticket->user)
                                <option Selected hidden value="{{ $ticket->assigned_to }}"
                                    {{ $user = App\Models\User::find($ticket->assigned_to) }}>
                                    {{ ucwords($user->value('first_name') . ' ' . $user->value('last_name')) }}</option>
                                <option value="" name="unassigned"> Unassign </option>
                            @else
                                <option selected hidden value="">N/A</option>
                            @endif
                            @foreach ($itSupportUsers as $user)
                                <option value="{{ $user->id }}">
                                    {{ ucwords($user->first_name . ' ' . $user->last_name) }} </option>
                            @endforeach
                        </select>
                    </div>
                @endauth
            </x-auth-card>

            {{-- Comment --}}
            <div class="pb-6 mb-3">
                <x-auth-card>
                    <h2 class="text-white font-bold text-4xl pb-4 pt-2 underline"> Comments </h2>

                    <x-auth-validation-errors class="" :errors="$errors" />

                    <form action="{{ route('create.comment', ['ticket' => $ticket]) }}" method="POST">
                        @csrf

                        <x-textarea name="details" placeholder="Leave a Comment...">{{ null }}</x-textarea>

                        <x-button type="submit"> Post </x-button>

                    </form>
                    @foreach ($comments as $comment)
                        <div class="mt-4">
                            @if ($comment->user)
                                <x-label class="underline text-lg"
                                    value=" {{ ucwords($comment->user->first_name) }} {{ ucwords($comment->user->last_name) }}">
                                </x-label>
                            @endif

                            <x-textarea name="details" readonly>{{ ucwords($comment->details) }}</x-textarea>
                        </div>

                        <form class="" action="{{ route('delete.comment', [$ticket->id, $comment->id]) }}"
                            method="post">

                            <a href="{{ route('edit.comment', [$ticket->id, $comment->id]) }}" title="Edit Comment"
                                class="mt-4 text-white bg-green-900 rounded-md p-2 text-lg">
                                &#128393;</a>

                            @csrf
                            @method('delete')

                            <button title="Delete Comment" class=" mt-4 bg-red-900 rounded-md p-2" type="submit">
                                &#128465;
                            </button>
                        </form>
                    @endforeach
                </x-auth-card>
            </div>
        </div>
    </div>

</x-app-layout>
