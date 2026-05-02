<x-admin-layout title="Create User">
    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @include('admin.users.form')
    </form>
</x-admin-layout>
