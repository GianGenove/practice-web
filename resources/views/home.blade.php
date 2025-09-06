<x-layout>
    <x-slot:heading>Home Page</x-slot:heading>
    <h1>This is the Home Page!</h1>
    @if (session('message'))
        <x-success-message>
            {{ session('message') }}
        </x-success-message>
    @endif
</x-layout>