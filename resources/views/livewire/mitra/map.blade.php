<div class="w-full h-full overflow-y-auto snap-y snap-mandatory bg-white dark:bg-zinc-900">
    <section class="relative snap-start shrink-0 h-full flex flex-col items-center justify-center text-center px-4 bg-cover bg-center" style="background-image: url('{{ asset('images/image1.png') }}');">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-4xl lg:text-5xl font-bold tracking-tight text-black">
                Peta Mitra <span class="text-green-700">{{ config('app.name', 'SapiHalal') }}</span>
            </h1>
            <p class="mt-4 text-lg text-zinc-700">
                Temukan mitra penyedia sapi halal di Kota Padang. Gunakan filter untuk mencari berdasarkan kecamatan dan kelurahan.
            </p>
            <div class="mt-8 flex items-center justify-center gap-8 text-sm">
                <div class="text-center">
                    <div class="text-2xl font-bold text-black">{{ count($markers) }}</div>
                    <div class="text-zinc-600">Mitra di Peta</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-black">Kota Padang</div>
                    <div class="text-zinc-600">Wilayah</div>
                </div>
            </div>
            <div class="mt-10">
                <a href="#map-section" class="inline-flex items-center gap-2 text-sm text-zinc-600 hover:text-black transition-colors">
                    Jelajahi Peta
                    <svg class="size-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <section id="map-section" class="snap-start shrink-0 h-full flex flex-col overflow-hidden">
        <div class="flex-1 flex overflow-hidden">
            <aside class="w-80 shrink-0 flex flex-col border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
                <div class="shrink-0 p-4 space-y-3 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Filter &amp; Daftar Mitra</h2>

                    <flux:select wire:model.live="kecamatan_filter" label="Kecamatan" placeholder="Semua Kecamatan" searchable>
                        <flux:select.option value="">Semua Kecamatan</flux:select.option>
                        @foreach($kecamatans as $kec)
                            <flux:select.option wire:key="kec-{{ $kec->code }}" value="{{ $kec->code }}">{{ $kec->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="relative" wire:key="kelurahan-sidebar-{{ $kecamatan_filter }}">
                        <flux:field>
                            <flux:label>Kelurahan</flux:label>
                            <flux:input wire:model.live.debounce.300ms="kelurahan_search" placeholder="Ketik min. 2 karakter..." />

                            @if(strlen($kelurahan_search) >= 2)
                                <div class="absolute top-full left-0 right-0 z-50 mt-1 rounded-lg border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800 max-h-60 overflow-y-auto">
                                    @forelse($filteredKelurahans as $kel)
                                        <button
                                            wire:click="selectKelurahan('{{ $kel['code'] }}')"
                                            type="button"
                                            class="w-full px-3 py-2 text-left text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700 first:rounded-t-lg last:rounded-b-lg"
                                        >
                                            {{ $kel['name'] }}
                                        </button>
                                    @empty
                                        <div class="px-3 py-2 text-sm text-zinc-500">Tidak ditemukan</div>
                                    @endforelse
                                </div>
                            @endif
                        </flux:field>
                    </div>

                    @if($this->selectedKelurahanName)
                        <div class="flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <span class="text-zinc-500">Kelurahan:</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $this->selectedKelurahanName }}</span>
                            <button wire:click="resetKelurahanFilter" type="button" class="ml-auto text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="shrink-0 px-4 py-2 text-xs text-zinc-500 border-b border-zinc-200 dark:border-zinc-700">
                    {{ count($mitraList) }} mitra ditemukan
                </div>

                <div class="flex-1 overflow-y-auto" x-data="{ detailId: null }">
                    @forelse($mitraList as $mitra)
                        <div
                            class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer transition-colors"
                            :class="{ 'bg-zinc-100 dark:bg-zinc-800': detailId === {{ $mitra['id'] }} }"
                            x-on:click="
                                detailId = (detailId === {{ $mitra['id'] }} ? null : {{ $mitra['id'] }});
                                window.dispatchEvent(new CustomEvent('fly-to-mitra', {
                                    detail: { id: {{ $mitra['id'] }}, lat: {{ $mitra['lat'] ?? 'null' }}, lng: {{ $mitra['lng'] ?? 'null' }} }
                                }))
                            ">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $mitra['nama'] }}</div>
                                    <div class="text-xs text-zinc-500">{{ $mitra['kecamatan'] ?? '-' }}</div>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    @if($mitra['sertifikat'])
                                        <a href="{{ asset('storage/'.$mitra['sertifikat']) }}" download
                                            class="rounded p-1 text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 dark:hover:text-zinc-300 dark:hover:bg-zinc-700"
                                            x-on:click.stop=""
                                            title="Download Sertifikat">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($mitra['link_gmap'])
                                        <a href="{{ $mitra['link_gmap'] }}" target="_blank" rel="noopener"
                                            class="rounded p-1 text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 dark:hover:text-zinc-300 dark:hover:bg-zinc-700"
                                            x-on:click.stop=""
                                            title="Buka di Google Maps">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div
                                x-show="detailId === {{ $mitra['id'] }}"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="mt-2 pt-2 border-t border-zinc-100 dark:border-zinc-800 text-xs text-zinc-600 dark:text-zinc-400 space-y-1"
                            >
                                <p><span class="font-medium text-zinc-700 dark:text-zinc-300">Alamat:</span> {{ $mitra['alamat'] }}</p>
                                <p><span class="font-medium text-zinc-700 dark:text-zinc-300">Pemilik:</span> {{ $mitra['pemilik'] }}</p>
                                <p><span class="font-medium text-zinc-700 dark:text-zinc-300">Kelurahan:</span> {{ $mitra['kelurahan'] ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center text-sm text-zinc-500">Tidak ada mitra ditemukan</div>
                    @endforelse
                </div>
            </aside>

            <div class="flex-1 relative">
                <div
                    wire:ignore
                    id="map"
                    class="absolute inset-0"
                    x-data="{
                        map: null,
                        markersLayer: null,
                        markersMap: {},

                        init() {
                            if (this.map) return;
                            const container = document.getElementById('map');
                            if (!container || container._leaflet_id) return;
                            const padang = [-0.947083, 100.417181];

                            this.map = L.map('map').setView(padang, 13);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '&copy; <a href=&quot;https://www.openstreetmap.org/copyright&quot;>OpenStreetMap</a>'
                            }).addTo(this.map);

                            this.map.whenReady(() => this.map.invalidateSize());

                            this.markersLayer = L.layerGroup().addTo(this.map);

                            this.updateMarkers(@js($markers));

                            $wire.on('markers-updated', (payload) => {
                                const markers = Array.isArray(payload) ? payload[0]?.markers : payload?.markers;
                                if (markers) this.updateMarkers(markers);
                            });

                            window.addEventListener('fly-to-mitra', (e) => {
                                const { id, lat, lng } = e.detail;
                                if (lat && lng) {
                                    this.map.flyTo([lat, lng], 16);
                                    const marker = this.markersMap[id];
                                    if (marker) marker.openPopup();
                                }
                            });
                        },

                        updateMarkers(markers) {
                            this.markersLayer.clearLayers();
                            this.markersMap = {};

                            if (!markers || !markers.length) {
                                this.map.setView([-0.947083, 100.417181], 13);
                                this.map.invalidateSize();
                                return;
                            }

                            const bounds = [];

                            markers.forEach(m => {
                                if (m.lat && m.lng) {
                                    bounds.push([m.lat, m.lng]);

                                    const statusColor = m.status_aktif ? '#22c55e' : '#ef4444';
                                    const statusText = m.status_aktif ? 'Aktif' : 'Tidak Aktif';
                                    const kecName = m.kecamatan ?? '-';
                                    const kelName = m.kelurahan ?? '-';

                                    const popupContent = '<div style=\'min-width:200px\'>'
                                            + (m.foto ? '<img src=\'' + m.foto + '\' style=\'width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:6px\'>' : '')
                                            + '<b>' + m.nama + '</b><br>'
                                            + '<span style=\'color:#666\'>' + m.alamat + '</span><br>'
                                            + 'Pemilik: ' + m.pemilik + '<br>'
                                            + kecName + ', ' + kelName + '<br>'
                                            + '<span style=\'color:' + statusColor + ';font-weight:600\'>' + statusText + '</span>'
                                            + '</div>';

                                    const marker = L.marker([m.lat, m.lng])
                                        .bindPopup(popupContent)
                                        .addTo(this.markersLayer);

                                    this.markersMap[m.id] = marker;
                                }
                            });

                            if (bounds.length === 1) {
                                this.map.setView(bounds[0], 15);
                            } else if (bounds.length > 1) {
                                this.map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
                            }

                            this.map.invalidateSize();
                        }
                    }"
                    x-init="init()"
                ></div>
            </div>
        </div>
    </section>
</div>
