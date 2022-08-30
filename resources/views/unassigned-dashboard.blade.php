<x-app-layout>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href="{{ asset('css/assigned-dashboard.css') }}" rel="stylesheet">

        <title> Unassigned Tickets </title>
    </head>


    <body>
        {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white mt-5">
            <a href="{{ route('show.global.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Global Tickets </a>
            <a href="{{ route('show.unassigned.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Unassigned Tickets </a>
        </div> --}}


        {{-- <form action="{{ route('search.ticket') }}" method="POST" role="search">
            @csrf
                <div class="input-group mb-4">
                    <input type="text" class="form-control" name="search" placeholder="Search..."> <span
                    class="input-group-btn">
                    <x-button type="submit" class="btn btn-default">
                        <span class=""> Submit </span>
                    </x-button>
                </span>
                <a href="{{ route('create.ticket') }}"
                class="mb-4 inline-flex items-center px-4 py-2 bg-green-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Add
                Ticket</a>
            </div>
        </form> --}}

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14 ">
            <div class="mb-6">
                <h1 class="font-medium leading-tight text-4xl mt-0 mb-6 text-white font-black underline font-sans">
                    Unassigned Tickets </h1>

                <x-auth-validation-errors :errors="$errors" />

                <table class="w-full border border-black border-collapse">
                    <tr>
                        {{-- <th> Assigned To </th> --}}
                        <th> Ticket # </th>
                        <th> Title </th>
                        {{-- <th> Details </th> --}}
                        <th> Urgency </th>
                        <th> Category </th>
                        <th> Status </th>
                        <th> File </th>
                        <th> Logged By </th>
                        <th> Actions </th>
                    </tr>

                    @foreach ($tickets as $ticket)
                        <tr>
                            {{-- <td>
                            @if ($ticket->user)
                                {{ ucwords($ticket->user->first_name) }} {{ ucwords($ticket->user->last_name) }}
                            @endif
                        </td> --}}
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            {{-- <td>{{ $ticket->details }}</td> --}}
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
                            <td>{{ $ticket->logged_by }}</td>
                            <td class="th-functions">
                                <form class="" action="{{ route('delete.ticket', [$ticket->id]) }}"
                                    method="post">

                                    <a href="{{ route('show.ticket', $ticket->id) }}" title="Ticket Details"
                                        class="bg-blue-900 p-1 ticket-details-button rounded-md fa fa-info-circle"></a>
                                    @auth

                                        <a href="{{ route('edit.ticket', $ticket->id) }}" title="Edit Ticket"
                                            class="bg-green-900 p-1 edit-ticket-button rounded-md fa fa-pencil"></a>
                                    @endauth


                                    @csrf
                                    @method('delete')

                                    <button title="Delete Meeting"
                                        class="bg-red-900 p-1 delete-ticket-button rounded-md fa fa-trash-o"
                                        type="submit"></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
    </body>

    </html>
</x-app-layout>
