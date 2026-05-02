<x-admin-layout title="My Profile">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
        @csrf
        @method('PUT')
        <input name="name" required value="{{ old('name', $user->name) }}" placeholder="Full name">
        <input name="username" required value="{{ old('username', $user->username) }}" placeholder="Username">
        <input name="email" required type="email" value="{{ old('email', $user->email) }}" placeholder="Email">
        <input name="password" type="password" placeholder="New password (optional)">
        <input name="profile_image" type="file" class="md:col-span-2">
        <button class="md:col-span-2 btn btn-primary form-submit">Update Profile</button>
    </form>
</x-admin-layout>
