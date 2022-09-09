<link href="{{ asset('css/assigned-dashboard.css') }}" rel="stylesheet">

@section('search')
    <form action="{{ route('search.ticket') }}" method="POST" role="search">
        @csrf
        @method('GET')

        <div class="input-group mb-4">
            @auth
                <input type="text" class="form-control rounded-lg" name="search" placeholder="Search...">
                <span class="input-group-btn">
                    <button title="Create Ticket" type="submit" class="p-1 text-lg bg-gray-900 rounded-md">
                        <span class="text-md"> &#128269; </span>
                    </button>
                </span>
            @endauth
            <a href="{{ route('create.ticket') }}" class="ml-1 p-2 rounded-md text-md text-white bg-green-900">
                &plus;
                Create a Ticket</a>
        </div>
    </form>
@endsection

@section('tableheaders')
    <tr>
        @if (Route::is('show.global.dashboard'))
            @auth
                <th></th>
            @endauth
        @endif
        <th> Ticket # </th>
        <th> Title </th>
        <th> Urgency </th>
        <th> Category </th>
        <th> Status </th>
        <th> File </th>
        <th> Created At </th>
        <th> Logged By </th>
        @if (Route::is('show.global.dashboard'))
            @auth
                <th> Assigned To </th>
            @endauth
        @endif
        <th> Actions </th>
    </tr>
@endsection

@section('tablevalues')
    <form id="linkedTickets" action="{{ route('show.linked', [$tickets->pluck('id')]) }}">
        @foreach ($tickets as $ticket)
            <tr>
                @if (Route::is('show.global.dashboard'))
                    @auth
                        <td>
                            <input type="checkbox" id="linkedtickets" name="linkedtickets[]"
                                value="{{ $ticket->id }} 'active' => 'true'"></input>
                        </td>
                    @endauth
                @endif
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
                <td>{{ $ticket->created_at_formatted }}</td>
                <td>{{ $ticket->logged_by }}</td>
                @if (Route::is('show.global.dashboard'))
                    @auth
                        <td>
                            @if ($ticket->user)
                                {{ ucwords($ticket->user->first_name) }}
                                {{ ucwords($ticket->user->last_name) }}
                            @endif
                        </td>
                    @endauth
                @endif
                <td class="th-functions">
                    <form id="deleteTicket" class="" action="{{ route('delete.ticket', [$ticket->id]) }}"
                        method="POST">

                        <a href="{{ route('show.ticket', $ticket->id) }}" id="showdetails" title="Ticket Details"
                            class="ticket-details-button mb-1 p-1 bg-blue-900 rounded-md fa fa-info-circle"></a>

                        <a href="{{ route('edit.ticket', $ticket->id) }}" id="editdetails" title="Edit Ticket"
                            class="edit-ticket-button mb-1 p-1 bg-green-900 rounded-md text-xl fa fa-pencil">
                        </a>

                        @csrf
                        @method('DELETE')

                        @auth
                            <button form="deleteTicket" title="Delete Ticket"
                                class="delete-ticket-button bg-red-900 rounded-md p-1 fa fa-trash-o" type="submit">
                            </button>
                        @endauth
                    </form>
                </td>
            </tr>
        @endforeach
        <div class="mb-4">
            @if (Route::is('show.global.dashboard'))
                @auth
                    @method('GET')
                    <x-button form="linkedTickets" title="Show Tickets" class="bg-blue-900 mt-2" name="viewtickets"> &#x1F441; </x-button>

                    <x-button form="linkedTickets" title="Edit Tickets" name="edittickets" class="bg-green-900 mt-2"> &#128393; </x-button>
                @endauth
            @endif
        </div>
    </form>
@endsection
