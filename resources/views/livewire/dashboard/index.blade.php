<div class="p-6 space-y-6">
    <div>
        <flux:heading size="xl" class="mb-1">Dashboard</flux:heading>
        <flux:subheading>Ringkasan data sertifikat veteriner</flux:subheading>
    </div>

    {{-- Widget 1: Statistik Ringkasan --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Total Sertifikat</p>
                    <p class="mt-1 text-3xl font-semibold text-neutral-900 dark:text-white">{{ number_format($totalSertifikat) }}</p>
                </div>
                <div class="rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                    <flux:icon.document-check class="size-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Mitra Aktif</p>
                    <p class="mt-1 text-3xl font-semibold text-neutral-900 dark:text-white">{{ number_format($totalMitraAktif) }}</p>
                </div>
                <div class="rounded-lg bg-emerald-50 p-3 dark:bg-emerald-900/20">
                    <flux:icon.building-office-2 class="size-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Sertifikat Bulan Ini</p>
                    <p class="mt-1 text-3xl font-semibold text-neutral-900 dark:text-white">{{ number_format($sertifikatBulanIni) }}</p>
                </div>
                <div class="rounded-lg bg-amber-50 p-3 dark:bg-amber-900/20">
                    <flux:icon.calendar-days class="size-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Dokter Hewan</p>
                    <p class="mt-1 text-3xl font-semibold text-neutral-900 dark:text-white">{{ number_format($totalDokterHewan) }}</p>
                </div>
                <div class="rounded-lg bg-violet-50 p-3 dark:bg-violet-900/20">
                    <flux:icon.user-circle class="size-6 text-violet-600 dark:text-violet-400" />
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Widget 2: Rekap Volume Produk --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5 lg:col-span-1">
            <flux:heading size="lg" class="mb-4">Volume Produk {{ now()->translatedFormat('F Y') }}</flux:heading>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/20">
                            <flux:icon.fire class="size-4 text-red-600 dark:text-red-400" />
                        </div>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Jeroan Merah</span>
                    </div>
                    <span class="text-sm font-semibold text-neutral-900 dark:text-white">{{ number_format($volumeJeroanMerah, 2) }} kg</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-green-50 dark:bg-green-900/20">
                            <flux:icon.beaker class="size-4 text-green-600 dark:text-green-400" />
                        </div>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Jeroan Hijau</span>
                    </div>
                    <span class="text-sm font-semibold text-neutral-900 dark:text-white">{{ number_format($volumeJeroanHijau, 2) }} kg</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/20">
                            <flux:icon.scissors class="size-4 text-blue-600 dark:text-blue-400" />
                        </div>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Karkas</span>
                    </div>
                    <span class="text-sm font-semibold text-neutral-900 dark:text-white">{{ number_format($volumeKarkas, 2) }} kg</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/20">
                            <flux:icon.tag class="size-4 text-amber-600 dark:text-amber-400" />
                        </div>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Kulit</span>
                    </div>
                    <span class="text-sm font-semibold text-neutral-900 dark:text-white">{{ number_format($volumeKulit, 2) }} kg</span>
                </div>
            </div>

            <flux:separator class="my-4" />

            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Volume</span>
                <span class="text-sm font-bold text-neutral-900 dark:text-white">
                    {{ number_format($volumeJeroanMerah + $volumeJeroanHijau + $volumeKarkas + $volumeKulit, 2) }} kg
                </span>
            </div>
        </div>

        {{-- Widget 6: Top 5 Mitra --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5 lg:col-span-2">
            <flux:heading size="lg" class="mb-4">Top 5 Mitra Berdasarkan Volume</flux:heading>

            @if($topMitra->isEmpty())
                <p class="py-8 text-center text-sm text-neutral-500">Belum ada data sertifikat.</p>
            @else
                <div class="overflow-hidden">
                    <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
                        <thead class="text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-700">
                            <tr>
                                <th class="px-3 py-2 font-medium">#</th>
                                <th class="px-3 py-2 font-medium">Mitra</th>
                                <th class="px-3 py-2 font-medium text-right">Total Volume</th>
                                <th class="px-3 py-2 font-medium text-right">Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @php $totalKeseluruhan = $topMitra->sum('total_volume'); @endphp
                            @foreach($topMitra as $index => $item)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-neutral-900 dark:text-white">{{ $index + 1 }}</td>
                                    <td class="px-3 py-3">{{ $item->mitra?->nama ?? '—' }}</td>
                                    <td class="px-3 py-3 text-right font-medium">{{ number_format($item->total_volume, 2) }} kg</td>
                                    <td class="px-3 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <div class="h-1.5 w-24 overflow-hidden rounded-full bg-neutral-100 dark:bg-neutral-700">
                                                <div class="h-full rounded-full bg-blue-500"
                                                    style="width: {{ $totalKeseluruhan > 0 ? round(($item->total_volume / $totalKeseluruhan) * 100) : 0 }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs text-neutral-500 w-10 text-right">
                                                {{ $totalKeseluruhan > 0 ? round(($item->total_volume / $totalKeseluruhan) * 100) : 0 }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Widget 3: Grafik Tren Sertifikat Per Bulan --}}
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
        <flux:heading size="lg" class="mb-4">Tren Sertifikat — 12 Bulan Terakhir</flux:heading>

        @php $maxJumlah = max(array_column($trenBulanan, 'jumlah')) ?: 1; @endphp

        <div class="flex items-end gap-1.5 h-48">
            @foreach($trenBulanan as $data)
                <div class="group relative flex flex-1 flex-col items-center justify-end">
                    <div class="relative w-full rounded-t bg-blue-500 transition-all hover:bg-blue-600 dark:bg-blue-400 dark:hover:bg-blue-300"
                        style="height: {{ $maxJumlah > 0 ? round(($data['jumlah'] / $maxJumlah) * 100) : 0 }}%">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-neutral-800 px-2 py-0.5 text-xs text-white opacity-0 group-hover:opacity-100 dark:bg-neutral-200 dark:text-neutral-900">
                            {{ $data['jumlah'] }}
                        </div>
                    </div>
                    <span class="mt-2 text-[10px] text-neutral-500 dark:text-neutral-400">{{ $data['bulan'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid grid-cols-12 gap-1.5">
            @foreach($trenBulanan as $data)
                <div class="text-center">
                    <span class="text-xs font-medium text-neutral-900 dark:text-white">{{ $data['jumlah'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
