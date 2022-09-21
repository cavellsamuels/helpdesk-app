@section('deleteform')
    <form id="deleteTicket" class="" action="{{ route('delete.ticket', [$ticket->id]) }}" method="POST">

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
@endsection
