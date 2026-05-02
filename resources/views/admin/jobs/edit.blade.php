<x-admin-layout title="Edit Job">
    <form method="POST" action="{{ route('admin.jobs.update', $job) }}">
        @method('PUT')
        @include('admin.jobs.form', ['job' => $job])
    </form>
</x-admin-layout>
