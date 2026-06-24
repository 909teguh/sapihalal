<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Data Mitra</h2>
        
        <flux:modal.trigger name="mitra-form-modal">
            <flux:button variant="primary" wire:click="createMitra">Tambah Mitra Baru</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
        <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Pemilik</th>
                    <th class="px-4 py-3 font-medium">Kecamatan</th>
                    <th class="px-4 py-3 font-medium">Kelurahan</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($mitras as $mitra)
                <tr>
                    <td class="px-4 py-3">{{ $mitra->nama }}</td>
                    <td class="px-4 py-3">{{ $mitra->pemilik }}</td>
                    <td class="px-4 py-3">{{ $mitra->kecamatan_alamat }}</td>
                    <td class="px-4 py-3">{{ $mitra->kelurahan_alamat }}</td>
                    <td class="px-4 py-3">
                        @if($mitra->status_aktif)
                            <flux:badge color="green" size="sm">Aktif</flux:badge>
                        @else
                            <flux:badge color="red" size="sm">Tidak Aktif</flux:badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <flux:modal.trigger name="mitra-form-modal">
                            <flux:button size="sm" variant="ghost" wire:click="editMitra({{ $mitra->id }})">Edit</flux:button>
                        </flux:modal.trigger>
                        
                        <flux:button size="sm" variant="danger" wire:click="deleteMitra({{ $mitra->id }})" wire:confirm="Yakin ingin menghapus mitra ini?">Hapus</flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-neutral-500">Belum ada data mitra.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <flux:modal name="mitra-form-modal" class="md:w-96" x-on:modal-close.window="if ($event.detail.name === 'mitra-form-modal') $el.close()">
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">
                    {{ $isEditMode ? 'Edit Mitra' : 'Tambah Mitra Baru' }}
                </h3>
            </div>

            <form wire:submit="saveMitra" class="space-y-4">
                <flux:select wire:model.live="kecamatan_alamat" label="Kecamatan" placeholder="Pilih Kecamatan..." searchable>
                    <flux:select.option value="">Pilih Kecamatan...</flux:select.option>
                    @foreach($kecamatans as $kecamatan)
                        <flux:select.option wire:key="kecamatan-{{ $kecamatan->code }}" value="{{ $kecamatan->code }}">{{ $kecamatan->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                
                <flux:select wire:key="kelurahan-select-{{ $kecamatan_alamat }}" wire:model="kelurahan_alamat" label="Kelurahan" placeholder="Pilih Kelurahan..." searchable>
                    <flux:select.option value="">Pilih Kelurahan...</flux:select.option>
                    @foreach($kelurahans as $kelurahan)
                        <flux:select.option wire:key="kelurahan-{{ $kelurahan->code }}" value="{{ $kelurahan->code }}">{{ $kelurahan->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="nama" label="Nama Mitra" placeholder="Masukkan nama mitra" required />
                
                <flux:input wire:model="pemilik" label="Pemilik" placeholder="Nama pemilik" required />
                
                <flux:textarea wire:model="alamat" label="Alamat Lengkap" required></flux:textarea>
                
                

                <flux:input wire:model="koordinat" label="Koordinat (Opsional)" placeholder="-6.200000, 106.816666" />
                
                <flux:checkbox wire:model="status_aktif" label="Status Aktif Mitra" />

                <div class="flex justify-end gap-2 pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
