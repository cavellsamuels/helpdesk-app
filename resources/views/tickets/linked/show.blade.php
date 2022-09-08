<x-app-layout>
    <html lang="en">

    <head>
        @include('layouts.dashboard')
        <title> Combined Tickets </title>
    </head>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14">
            <x-heading1> Combined Tickets </x-heading1>

            <x-auth-validation-errors class="" :errors="$errors" />

            <form action="{{ route('show.linked', $tickets->pluck('id')) }}" method="POST">
                @csrf

                <table class="w-full border border-black border-collapse">
                    @yield('tableheaders')
                    {{-- @if ($tickets == true) --}}
                    @yield('tablevalues')
                    {{-- @endif --}}
                </table>

                @method('GET')
            </form>
        </div>
    </body>

    </html>
</x-app-layout>
