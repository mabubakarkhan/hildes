<x-admin-layout title="Create Application">
    <form method="POST" action="{{ route('admin.applications.store') }}" enctype="multipart/form-data">
        @include('admin.applications.form')
    </form>
</x-admin-layout>
