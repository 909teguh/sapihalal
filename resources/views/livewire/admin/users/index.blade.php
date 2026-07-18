<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Manajemen User</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Kelola role untuk setiap pengguna.</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
        <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium">Role</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @forelse($user->roles as $role)
                                <flux:badge size="sm" color="indigo">{{ $role->name }}</flux:badge>
                            @empty
                                <span class="text-neutral-400">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <flux:modal.trigger name="user-role-modal">
                            <flux:button size="sm" variant="ghost" wire:click="editUserRoles({{ $user->id }})">Edit Role</flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-neutral-500">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal name="user-role-modal" class="md:w-96">
        <div class="space-y-6" wire:key="user-modal-body-{{ $userId }}">
            <div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Edit Role Pengguna</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">{{ $userName }} ({{ $userEmail }})</p>
            </div>

            <form wire:submit="saveUserRoles" class="space-y-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Role</label>
                    @foreach($allRoles as $role)
                        <label class="flex items-center gap-2 cursor-pointer" wire:key="role-{{ $role['id'] }}">
                            <input type="checkbox" value="{{ $role['name'] }}" wire:model="selectedRoles"
                                class="rounded border-neutral-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-800" />
                            <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $role['name'] }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost" data-close-user-modal>Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
