<?php

namespace App\Livewire\Mitra;

use App\Models\Mitra;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Livewire\Component;

class Map extends Component
{
    public $kecamatan_filter = '';
    public $kelurahan_filter = '';
    public $kelurahan_search = '';

    public $kecamatans = [];
    public $filteredKelurahans = [];
    public $mitraList = [];
    public $markers = [];

    public function mount()
    {
        $this->kecamatans = Kecamatan::all();
        $this->filteredKelurahans = Kelurahan::all()->toArray();
        $this->loadData();
    }

    public function updatedKecamatanFilter($value)
    {
        $this->kelurahan_filter = '';
        $this->kelurahan_search = '';

        if ($value) {
            $this->filteredKelurahans = Kelurahan::where('kecamatan_code', $value)->get()->toArray();
        } else {
            $this->filteredKelurahans = Kelurahan::all()->toArray();
        }

        $this->loadData();
    }

    public function updatedKelurahanFilter()
    {
        $this->loadData();
    }

    public function updatedKelurahanSearch($value)
    {
        if (strlen($value) >= 2) {
            $query = Kelurahan::query();

            if ($this->kecamatan_filter) {
                $query->where('kecamatan_code', $this->kecamatan_filter);
            }

            $query->where('name', 'like', '%' . $value . '%');
            $this->filteredKelurahans = $query->get()->toArray();
        } else {
            if ($this->kecamatan_filter) {
                $this->filteredKelurahans = Kelurahan::where('kecamatan_code', $this->kecamatan_filter)->get()->toArray();
            } else {
                $this->filteredKelurahans = Kelurahan::all()->toArray();
            }
        }
    }

    public function selectKelurahan($code)
    {
        $this->kelurahan_filter = $code;
        $this->kelurahan_search = '';

        if ($this->kecamatan_filter) {
            $this->filteredKelurahans = Kelurahan::where('kecamatan_code', $this->kecamatan_filter)->get()->toArray();
        } else {
            $this->filteredKelurahans = Kelurahan::all()->toArray();
        }

        $this->loadData();
    }

    public function resetKelurahanFilter()
    {
        $this->kelurahan_filter = '';
        $this->kelurahan_search = '';

        if ($this->kecamatan_filter) {
            $this->filteredKelurahans = Kelurahan::where('kecamatan_code', $this->kecamatan_filter)->get()->toArray();
        } else {
            $this->filteredKelurahans = Kelurahan::all()->toArray();
        }

        $this->loadData();
    }

    public function loadData()
    {
        $query = Mitra::with(['kecamatan', 'kelurahan'])->orderBy('nama');

        if ($this->kecamatan_filter) {
            $query->where('kecamatan_alamat', $this->kecamatan_filter);
        }

        if ($this->kelurahan_filter) {
            $query->where('kelurahan_alamat', $this->kelurahan_filter);
        }

        $this->mitraList = $query->get()->map(function ($mitra) {
            $coords = explode(',', $mitra->koordinat);
            $lat = trim($coords[0] ?? '');
            $lng = trim($coords[1] ?? '');

            return [
                'id' => $mitra->id,
                'nama' => $mitra->nama,
                'alamat' => $mitra->alamat,
                'pemilik' => $mitra->pemilik,
                'kecamatan' => $mitra->kecamatan?->name,
                'kelurahan' => $mitra->kelurahan?->name,
                'koordinat' => $mitra->koordinat,
                'lat' => is_numeric($lat) ? (float) $lat : null,
                'lng' => is_numeric($lng) ? (float) $lng : null,
                'status_aktif' => $mitra->status_aktif,
            ];
        })->toArray();

        $this->markers = array_values(array_filter($this->mitraList, fn($m) => $m['lat'] && $m['lng']));

        $this->dispatch('markers-updated', markers: $this->markers);
    }

    public function getSelectedKelurahanNameProperty()
    {
        if (!$this->kelurahan_filter) {
            return null;
        }

        $kel = Kelurahan::find($this->kelurahan_filter);

        return $kel?->name;
    }

    public function render()
    {
        return view('livewire.mitra.map')->layout('layouts.guest');
    }
}
