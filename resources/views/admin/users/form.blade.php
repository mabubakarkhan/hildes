@csrf
<div class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
    <input name="name" required value="{{ old('name', $user->name ?? '') }}" placeholder="Full name">
    <input name="username" required value="{{ old('username', $user->username ?? '') }}" placeholder="Username">
    <input name="email" required type="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Email">
    <input name="password" type="password" placeholder="{{ isset($user) ? 'New password (optional)' : 'Password' }}">
    <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin ?? false))>
        Admin access
    </label>
    <input name="profile_image" type="file">
    <button class="md:col-span-2 btn btn-primary form-submit">Save User</button>
</div>
