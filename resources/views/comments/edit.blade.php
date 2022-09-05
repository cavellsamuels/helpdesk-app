<x-app-layout>
    <x-auth-card>
        <h2 class="text-white font-bold text-4xl pb-4 pt-2 underline"> Update Comment </h2>

        @if ($errors->any())
            <div class="text-white alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ ucwords($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div>
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                    role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div>
                            <p class="font-bold">Success</p>
                            <p class="text-sm"> {{ $message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
