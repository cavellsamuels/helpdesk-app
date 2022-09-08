<x-app-layout>
    <title> Update Comment </title>
    <x-auth-card>
        <x-heading2> Update Comment</x-heading2>

        <x-auth-validation-errors class="" :errors="$errors" />

        <form action="{{ route('update.comment', [$ticket->id, $comment->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="">
                <x-label for="title" :value="__('Details')" />

                <textarea type="text" class="block mt-1 w-full rounded-xl" name="details" placeholder="Update Comment..."
                value="{{ ucwords($comment->details, $ticket->id) }}">{{ ucwords($comment->details) }}</textarea>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
