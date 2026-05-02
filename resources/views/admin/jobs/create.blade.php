<x-admin-layout title="Create Job">
    <form method="POST" action="{{ route('admin.jobs.store') }}">
        @include('admin.jobs.form')
    </form>
</x-admin-layout>
