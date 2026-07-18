<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Manajemen Role</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Kelola role dan permission yang dimilikinya.</p>
        </div>

        <flux:modal.trigger name="role-form-modal">
            <flux:button variant="primary" wire:click="createRole">Tambah Role</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
        <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama Role</th>
                    <th class="px-4 py-3 font-medium">Permissions</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($roles as $role)
                <tr>
                    <td class="px-4 py-3">
                        <flux:badge size="sm" color="indigo">{{ $role->name }}</flux:badge>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @forelse($role->permissions as $perm)
                                <flux:badge size="sm">{{ $perm->name }}</flux:badge>
                            @empty
                                <span class="text-neutral-400">-</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <flux:modal.trigger name="role-form-modal">
                            <flux:button size="sm" variant="ghost" wire:click="editRole({{ $role->id }})">Edit</flux:button>
                        </flux:modal.trigger>

                        @if($role->name !== 'Superadmin')
                            <flux:button size="sm" variant="danger" wire:click="deleteRole({{ $role->id }})" wire:confirm="Yakin ingin menghapus role ini?">Hapus</flux:button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-neutral-500">Belum ada data role.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal name="role-form-modal" class="md:w-96">
        <div class="space-y-6" wire:key="role-modal-body-{{ $roleId ?? 'create' }}">
            <div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">
                    {{ $roleId ? 'Edit Role' : 'Tambah Role Baru' }}
                </h3>
            </div>

            <form wire:submit="saveRole" class="space-y-4">
                <flux:input wire:model="roleName" label="Nama Role" placeholder="Masukkan nama role" required />

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Permissions</label>
                    @foreach($allPermissions as $perm)
                        <label class="flex items-center gap-2 cursor-pointer" wire:key="perm-{{ $perm['id'] }}">
                            <input type="checkbox" value="{{ $perm['name'] }}" wire:model="selectedPermissions"
                                class="rounded border-neutral-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-800" />
                            <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $perm['name'] }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost" data-close-role-modal>Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
