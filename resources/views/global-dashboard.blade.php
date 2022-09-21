<x-app-layout>

    <head>
        @include('layouts.dashboard')
        <title> All Tickets </title>
    </head>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14">

            <x-heading1> All Tickets </x-heading1>

            <x-auth-validation-errors class="" :errors="$errors" />

            @yield('search')

            <table>
                @yield('tableheaders')

                @yield('tablevalues')
            </table>
        </div>
    </body>
</x-app-layout>
