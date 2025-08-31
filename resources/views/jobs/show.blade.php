<x-layout>
    <x-slot:heading>Job Detail</x-slot:heading>
    <h1>{{  $job['title'] }} </h1>
    <p>{{  $job['description'] }}</p>
    <p>Salary: {{ $job['salary'] }}</p>
    <div class="mt-4">
        {{-- @can('edit-job', $job) --}}
        @can('edit', $job)
            <x-button href="/jobs/{{ $job->id }}/edit">Edit</x-button>
        @endcan
    </div>
</x-layout>