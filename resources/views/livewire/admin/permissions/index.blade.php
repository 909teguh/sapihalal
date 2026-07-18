<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Manajemen Permission</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Kelola daftar permission yang tersedia.</p>
        </div>

        <flux:modal.trigger name="permission-form-modal">
            <flux:button variant="primary" wire:click="createPermission">Tambah Permission</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
        <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama Permission</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($permissions as $perm)
                <tr>
                    <td class="px-4 py-3">
                        <flux:badge size="sm">{{ $perm->name }}</flux:badge>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <flux:modal.trigger name="permission-form-modal">
                            <flux:button size="sm" variant="ghost" wire:click="editPermission({{ $perm->id }})">Edit</flux:button>
                        </flux:modal.trigger>

                        <flux:button size="sm" variant="danger" wire:click="deletePermission({{ $perm->id }})" wire:confirm="Yakin ingin menghapus permission ini?">Hapus</flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-4 py-8 text-center text-neutral-500">Belum ada data permission.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal name="permission-form-modal" class="md:w-96">
        <div class="space-y-6" wire:key="permission-modal-body-{{ $permissionId ?? 'create' }}">
            <div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">
                    {{ $permissionId ? 'Edit Permission' : 'Tambah Permission Baru' }}
                </h3>
            </div>

            <form wire:submit="savePermission" class="space-y-4">
                <flux:input wire:model="permissionName" label="Nama Permission" placeholder="Masukkan nama permission" required />

                <div class="flex justify-end gap-2 pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost" data-close-permission-modal>Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
