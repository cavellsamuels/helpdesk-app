<x-app-layout>
    <html lang="en">

    <head>
        <link href="{{ asset('css/assigned-dashboard.css') }}" rel="stylesheet">

        <title> Unassigned Tickets </title>
    </head>


    <body>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-14 ">
            <div class="mb-6">
                <h1 class="font-medium leading-tight text-4xl mt-0 mb-6 text-white font-black underline font-sans">
                    Unassigned Tickets </h1>

                <x-auth-validation-errors :errors="$errors" />

                <x-table class="">
                    <tr>
                        <th> Ticket # </th>
                        <th> Title </th>
                        <th> Urgency </th>
                        <th> Category </th>
                        <th> Status </th>
                        <th> File </th>
                        <th> Logged By </th>
                        <th> Actions </th>
                    </tr>

                    @foreach ($tickets as $ticket)
                        <tr>
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
                </x-table>
            </div>
    </body>

    </html>
</x-app-layout>
