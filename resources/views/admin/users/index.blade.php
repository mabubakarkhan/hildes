<x-admin-layout title="Users">
    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary inline-block">Add User</a>
    </div>
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
            <tr><th class="p-3 text-left">Name</th><th class="p-3 text-left">Username</th><th class="p-3 text-left">Email</th><th class="p-3 text-center">Role</th><th class="p-3 text-center">Actions</th></tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->username }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3 text-center">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">@csrf @method('DELETE')
                            <button class="btn btn-secondary ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
