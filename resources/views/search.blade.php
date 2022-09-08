<x-app-layout>

    @include('layouts.dashboard')

    <title> Tickets Results </title>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14">
            <x-heading1> Ticket Results</x-heading1>

            <x-auth-validation-errors class="" :errors="$errors" />

            <x-table>
                @yield('tableheaders')

                @yield('tablevalues')
            </x-table>
        </div>
    </body>
</x-app-layout>
