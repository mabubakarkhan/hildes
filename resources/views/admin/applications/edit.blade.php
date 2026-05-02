<x-admin-layout title="Edit Application">
    <form method="POST" action="{{ route('admin.applications.update', $application) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.applications.form', ['application' => $application])
    </form>
</x-admin-layout>
