<x-admin-layout title="Edit User">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.users.form', ['user' => $user])
    </form>
</x-admin-layout>
