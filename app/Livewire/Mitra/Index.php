<?php

namespace App\Livewire\Mitra;

use App\Models\Mitra;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Livewire\Component;

class Index extends Component
{
    public $mitras;

    // Form state
    public $mitra_id;
    public $nama;
    public $alamat;
    public $pemilik;
    public $kecamatan_alamat = '';
    public $kelurahan_alamat = '';
    public $koordinat;
    public $status_aktif = true;

    // Dependent Dropdown state
    public $kecamatans = [];
    public $kelurahans = [];

    // Modal state
    public $isEditMode = false;

    public function mount()
    {
        $this->loadMitras();
        $this->kecamatans = Kecamatan::all();
    }

    public function loadMitras()
    {
        $this->mitras = Mitra::all();
    }

    public function updatedKecamatanAlamat($value)
    {
        if ($value) {
            $this->kelurahans = Kelurahan::where('kecamatan_code', $value)->get();
        } else {
            $this->kelurahans = [];
        }
        $this->kelurahan_alamat = ''; // Reset kelurahan when kecamatan changes
    }

    public function createMitra()
    {
        $this->resetForm();
        $this->isEditMode = false;
    }

    public function editMitra($id)
    {
        $this->resetForm();
        $this->isEditMode = true;

        $mitra = Mitra::find($id);
        if ($mitra) {
            $this->mitra_id = $mitra->id;
            $this->nama = $mitra->nama;
            $this->alamat = $mitra->alamat;
            $this->pemilik = $mitra->pemilik;
            $this->kecamatan_alamat = $mitra->kecamatan_alamat;
            
            if ($this->kecamatan_alamat) {
                $this->kelurahans = Kelurahan::where('kecamatan_code', $this->kecamatan_alamat)->get();
            }

            $this->kelurahan_alamat = $mitra->kelurahan_alamat;
            $this->koordinat = $mitra->koordinat;
            $this->status_aktif = $mitra->status_aktif;
        }
    }

    public function saveMitra()
    {
        $this->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'pemilik' => 'required|string',
            'kecamatan_alamat' => 'nullable|string',
            'kelurahan_alamat' => 'nullable|string',
            'koordinat' => 'nullable|string',
            'status_aktif' => 'boolean',
        ]);

        if ($this->isEditMode && $this->mitra_id) {
            $mitra = Mitra::find($this->mitra_id);
            if ($mitra) {
                $mitra->update([
                    'nama' => $this->nama,
                    'alamat' => $this->alamat,
                    'pemilik' => $this->pemilik,
                    'kecamatan_alamat' => $this->kecamatan_alamat,
                    'kelurahan_alamat' => $this->kelurahan_alamat,
                    'koordinat' => $this->koordinat,
                    'status_aktif' => $this->status_aktif,
                ]);
            }
        } else {
            Mitra::create([
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'pemilik' => $this->pemilik,
                'kecamatan_alamat' => $this->kecamatan_alamat,
                'kelurahan_alamat' => $this->kelurahan_alamat,
                'koordinat' => $this->koordinat,
                'status_aktif' => $this->status_aktif,
            ]);
        }

        $this->loadMitras();
        
        // Attempt to close modal via JS
        $this->js('document.querySelector("[data-modal=\"mitra-form-modal\"]")?.close()');
        $this->js('window.dispatchEvent(new CustomEvent("modal-close", {detail: {name: "mitra-form-modal"}}))');
    }

    public function deleteMitra($id)
    {
        Mitra::destroy($id);
        $this->loadMitras();
    }

    public function resetForm()
    {
        $this->mitra_id = null;
        $this->nama = '';
        $this->alamat = '';
        $this->pemilik = '';
        $this->kecamatan_alamat = '';
        $this->kelurahan_alamat = '';
        $this->koordinat = '';
        $this->status_aktif = true;
        $this->kelurahans = [];
    }

    public function render()
    {
        return view('livewire.mitra.index')->layout('layouts.app');
    }
}
