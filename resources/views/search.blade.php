<x-app-layout>

    <head>
        @include('layouts.dashboard')

        <title> Tickets Results </title>
    </head>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14">
            <x-heading1> Ticket Results </x-heading1>

            <x-auth-validation-errors class="" :errors="$errors" />
            
            <table class="w-full border border-black border-collapse">
                @yield('tableheaders')

                @yield('tablevalues')
            </table>
        </div>
    </body>

    </html>
</x-app-layout>
