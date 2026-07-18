<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Sertifikat Veteriner</h2>
        </div>

        <flux:modal.trigger name="sv-form-modal">
            <flux:button variant="primary" wire:click="createRecord">Tambah Data</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
        <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
            <thead class="bg-neutral-50 dark:bg-neutral-800 text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                <tr>
                    <th class="px-4 py-3 font-medium">Tanggal</th>
                    <th class="px-4 py-3 font-medium">Mitra</th>
                    <th class="px-4 py-3 font-medium">Jenis Hewan</th>
                    <th class="px-4 py-3 font-medium">Penerima</th>
                    <th class="px-4 py-3 font-medium">Dokter Hewan</th>
                    <th class="px-4 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($records as $record)
                <tr>
                    <td class="px-4 py-3">{{ $record->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $record->mitra?->nama }}</td>
                    <td class="px-4 py-3">{{ $record->jenis_hewan }}</td>
                    <td class="px-4 py-3">{{ $record->nama_penerima }}</td>
                    <td class="px-4 py-3">{{ $record->dokter_hewan }}</td>
                    <td class="px-4 py-3 text-right">
                        <flux:modal.trigger name="sv-form-modal">
                            <flux:button size="sm" variant="ghost" wire:click="editRecord({{ $record->id }})">Edit</flux:button>
                        </flux:modal.trigger>

                        <flux:button size="sm" variant="danger" wire:click="deleteRecord({{ $record->id }})" wire:confirm="Yakin ingin menghapus data ini?">Hapus</flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-neutral-500">Belum ada data sertifikat veteriner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal name="sv-form-modal" class="md:w-[42rem]">
        <div class="space-y-6" wire:key="sv-modal-body-{{ $isEditMode ? $recordId : 'create' }}">
            <div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">
                    {{ $isEditMode ? 'Edit Sertifikat Veteriner' : 'Tambah Sertifikat Veteriner' }}
                </h3>
            </div>

            <form wire:submit="saveRecord" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="tanggal" type="date" label="Tanggal" required />

                    <div class="relative" wire:key="mitra-search">
                        <flux:field>
                            <flux:label>Mitra (Pemilik)</flux:label>

                            @if($mitra_id && $mitra_name)
                                <div class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                                    <span class="flex-1 text-zinc-900 dark:text-white">{{ $mitra_name }}</span>
                                    <button type="button" wire:click="clearMitra" class="text-zinc-400 hover:text-red-500">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @else
                                <flux:input wire:model.live.debounce.300ms="mitra_search" placeholder="Ketik min. 2 karakter..." />

                                @if(strlen($mitra_search) >= 2)
                                    <div class="absolute top-full left-0 right-0 z-50 mt-1 rounded-lg border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-48 overflow-y-auto">
                                        @forelse($filteredMitras as $mitra)
                                            <button
                                                wire:click="selectMitra('{{ $mitra['id'] }}', '{{ $mitra['nama'] }}')"
                                                type="button"
                                                class="w-full px-3 py-2 text-left text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700 first:rounded-t-lg last:rounded-b-lg"
                                            >
                                                {{ $mitra['nama'] }}
                                            </button>
                                        @empty
                                            <div class="px-3 py-2 text-sm text-zinc-500">Tidak ditemukan</div>
                                        @endforelse
                                    </div>
                                @endif
                            @endif
                        </flux:field>
                    </div>
                </div>

                @error('mitra_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                <flux:input wire:model="jenis_hewan" label="Jenis Hewan" placeholder="Sapi, Kambing, dll" required />

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Informasi Berat (kg)</label>
                    <div class="grid grid-cols-4 gap-3">
                        <flux:input wire:model="jeroan_merah" type="number" step="0.01" min="0" label="Jeroan Merah" />
                        <flux:input wire:model="jeroan_hijau" type="number" step="0.01" min="0" label="Jeroan Hijau" />
                        <flux:input wire:model="karkas" type="number" step="0.01" min="0" label="Karkas" />
                        <flux:input wire:model="kulit" type="number" step="0.01" min="0" label="Kulit" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="asal_produk" label="Asal Produk" placeholder="Padang, dll" required />
                    <flux:input wire:model="nama_penerima" label="Nama Penerima" placeholder="Nama penerima" required />
                </div>

                <flux:textarea wire:model="alamat_penerima" label="Alamat Penerima" required></flux:textarea>

                <flux:textarea wire:model="keterangan" label="Keterangan (Opsional)"></flux:textarea>

                <flux:input wire:model="dokter_hewan" label="Dokter Hewan (Petugas Pemeriksaan)" placeholder="Nama dokter hewan" required />

                <div wire:key="scan-sertifikat-field">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Scan Sertifikat (PDF/JPG, Opsional)</label>
                    @if($scan_sertifikat_lama && !$scan_sertifikat)
                        <div class="mb-2 text-xs text-neutral-500">
                            File saat ini: <a href="{{ asset('storage/'.$scan_sertifikat_lama) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                        </div>
                    @endif
                    @if($scan_sertifikat)
                        <div class="mb-2 text-xs text-green-600">
                            File terpilih: {{ $scan_sertifikat->getClientOriginalName() }}
                        </div>
                    @endif
                    <input type="file" wire:model="scan_sertifikat" accept=".pdf,.jpg,.jpeg"
                        class="w-full text-sm text-neutral-700 dark:text-neutral-300
                               file:mr-3 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-medium
                               file:bg-neutral-100 file:text-neutral-700
                               hover:file:bg-neutral-200
                               dark:file:bg-neutral-700 dark:file:text-neutral-200
                               dark:hover:file:bg-neutral-600" />
                    <div wire:loading wire:target="scan_sertifikat" class="text-xs text-neutral-500 mt-1">Mengunggah...</div>
                    @error('scan_sertifikat') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost" data-close-sv-modal>Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
