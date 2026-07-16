<?php

namespace App\Livewire\Mitra;

use App\Models\Mitra;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    public $mitras;

    // Form state
    public $mitra_id;
    public $nama;
    public $alamat;
    public $pemilik;
    public $kecamatan_alamat = '';
    public $kelurahan_alamat = '';
    public $koordinat;
    public $link_gmap;
    public $status_aktif = true;
    public $sertifikat;
    public $sertifikat_lama;
    public $foto;
    public $foto_lama;

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
            $this->link_gmap = $mitra->link_gmap;
            $this->status_aktif = $mitra->status_aktif;
            $this->sertifikat_lama = $mitra->sertifikat;
            $this->foto_lama = $mitra->foto;
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
            'link_gmap' => 'nullable|string',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
                    'link_gmap' => $this->link_gmap,
                    'status_aktif' => $this->status_aktif,
                    'sertifikat' => $this->sertifikat 
                        ? $this->sertifikat->store('sertifikat', 'public') 
                        : $this->sertifikat_lama,
                    'foto' => $this->foto 
                        ? $this->foto->store('foto', 'public') 
                        : $this->foto_lama,
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
                'link_gmap' => $this->link_gmap,
                'status_aktif' => $this->status_aktif,
                'sertifikat' => $this->sertifikat 
                    ? $this->sertifikat->store('sertifikat', 'public') 
                    : null,
                'foto' => $this->foto 
                    ? $this->foto->store('foto', 'public') 
                    : null,
            ]);
        }

        $this->loadMitras();
        $this->resetForm();

        $this->js('document.querySelector("[data-close-mitra-modal]")?.click()');
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
        $this->link_gmap = '';
        $this->status_aktif = true;
        $this->sertifikat = null;
        $this->sertifikat_lama = null;
        $this->foto = null;
        $this->foto_lama = null;
        $this->kelurahans = [];
    }

    public function render()
    {
        return view('livewire.mitra.index')->layout('layouts.app');
    }
}
