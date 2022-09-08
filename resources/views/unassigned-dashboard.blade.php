<x-app-layout>
    <html lang="en">

    <head>
        @include('layouts.dashboard')
        <title> Unassigned Tickets </title>
    </head>

    <body>
        <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8 mt-14 mb-6">
            <x-heading1> Unassigned Tickets </x-heading1>

            <x-auth-validation-errors :errors="$errors" />

            <x-table>
                @yield('tableheaders')

                @yield('tablevalues')
            </x-table>
        </div>
    </body>

    </html>
</x-app-layout>
