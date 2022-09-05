<x-app-layout>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/index.css') }}" rel="stylesheet">
        <title> Combined Tickets </title>
    </head>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14">
            <h1 class="font-medium leading-tight text-4xl mt-0 mb-6 text-white font-black underline font-sans"> Combined
                Tickets </h1>
            <x-auth-validation-errors class="" :errors="$errors" />
            <form action="{{ route('show.linked') }}" method="POST">
                @csrf

                <table class="w-full border border-black border-collapse">
                    <tr>
                        <th> Ticket # </th>
                        <th> Title </th>
                        <th> Urgency </th>
                        <th> Category </th>
                        <th> Status </th>
                        <th> File </th>
                        <th> Created At </th>
                        <th> Logged By </th>
                        <th> Assigned To </th>
                        <th> Actions</th>
                    </tr>
                    @if ($tickets == true)
                        @foreach ($tickets as $ticket)
                            <tr>
                                <div>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        @foreach ($urgencies as $key => $value)
                                            @if ($key == $ticket->urgency)
                                                {{ $value }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($categories as $key => $value)
                                            @if ($key == $ticket->category)
                                                {{ $value }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($ticket->open == true)
                                            <div> &#x2705; Open </div>
                                        @endif

                                        @if ($ticket->open == false)
                                            <div> &#x274C; Closed </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ticket->file)
                                            {{ $ticket->file->name }}
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at->format('d.m.Y') }}</td>
                                    <td>{{ $ticket->logged_by }}</td>
                                    <td>
                                        @if ($ticket->user)
                                            {{ ucwords($ticket->user->first_name) }}
                                            {{ ucwords($ticket->user->last_name) }}
                                        @endif
                                    </td>
                                    <td class="th-functions">
                                        <form class="" action="{{ route('delete.ticket', [$ticket->id]) }}"
                                            method="POST">

                                            <a href="{{ route('show.ticket', $ticket->id) }}" title="Ticket Details"
                                                class="ticket-details-button mb-1 p-1 bg-blue-900 rounded-md fa fa-info-circle"></a>

                                            <a href="{{ route('edit.ticket', $ticket->id) }}" title="Edit Ticket"
                                                class="edit-ticket-button mb-1 p-1 bg-green-900 rounded-md text-xl fa fa-pencil">
                                            </a>

                                            @csrf
                                            @method('DELETE')

                                            <button title="Delete Ticket"
                                                class="delete-ticket-button bg-red-900 rounded-md p-1 fa fa-trash-o"
                                                type="submit">
                                            </button>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                @method('GET')
            </form>
        </div>
    </body>

    </html>
</x-app-layout>
