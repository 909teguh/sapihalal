<?php

namespace App\Livewire\Dashboard;

use App\Models\Mitra;
use App\Models\SertifikatVeteriner as SertifikatVeterinerModel;
use Livewire\Component;

class Index extends Component
{
    public int $totalSertifikat;

    public int $totalMitraAktif;

    public int $sertifikatBulanIni;

    public int $totalDokterHewan;

    public float $volumeKarkas;

    public float $volumeJeroanMerah;

    public float $volumeJeroanHijau;

    public float $volumeKulit;

    public array $trenBulanan = [];

    public mixed $topMitra;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->totalSertifikat = SertifikatVeterinerModel::count();
        $this->totalMitraAktif = Mitra::where('status_aktif', true)->count();
        $this->sertifikatBulanIni = SertifikatVeterinerModel::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $this->totalDokterHewan = SertifikatVeterinerModel::distinct('dokter_hewan')->count('dokter_hewan');

        $volume = SertifikatVeterinerModel::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('
                COALESCE(SUM(jeroan_merah), 0) as jm,
                COALESCE(SUM(jeroan_hijau), 0) as jh,
                COALESCE(SUM(karkas), 0) as k,
                COALESCE(SUM(kulit), 0) as ku
            ')->first();

        $this->volumeJeroanMerah = (float) ($volume->jm ?? 0);
        $this->volumeJeroanHijau = (float) ($volume->jh ?? 0);
        $this->volumeKarkas = (float) ($volume->k ?? 0);
        $this->volumeKulit = (float) ($volume->ku ?? 0);

        $this->trenBulanan = $this->hitungTrenBulanan();

        $this->topMitra = SertifikatVeterinerModel::selectRaw('
                mitra_id,
                COALESCE(SUM(jeroan_merah), 0) + COALESCE(SUM(jeroan_hijau), 0) + COALESCE(SUM(karkas), 0) + COALESCE(SUM(kulit), 0) as total_volume
            ')
            ->groupBy('mitra_id')
            ->orderByDesc('total_volume')
            ->limit(5)
            ->with('mitra')
            ->get();
    }

    protected function hitungTrenBulanan(): array
    {
        $result = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = SertifikatVeterinerModel::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->count();

            $result[] = [
                'bulan' => $date->translatedFormat('M'),
                'tahun' => $date->year,
                'jumlah' => $count,
            ];
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}
