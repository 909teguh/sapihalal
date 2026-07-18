<?php

namespace App\Livewire\SertifikatVeteriner;

use App\Models\Mitra;
use App\Models\SertifikatVeteriner as SertifikatVeterinerModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $records;

    public $recordId;

    public $tanggal;

    public $mitra_id = '';

    public $mitra_search = '';

    public $mitra_name = '';

    public $filteredMitras = [];

    public $jenis_hewan;

    public $jeroan_merah = 0;

    public $jeroan_hijau = 0;

    public $karkas = 0;

    public $kulit = 0;

    public $asal_produk;

    public $nama_penerima;

    public $alamat_penerima;

    public $keterangan;

    public $dokter_hewan;

    public $scan_sertifikat;

    public $scan_sertifikat_lama;

    public $isEditMode = false;

    public function mount()
    {
        $this->loadRecords();
    }

    public function loadRecords()
    {
        $this->records = SertifikatVeterinerModel::with('mitra')->orderBy('tanggal', 'desc')->get();
    }

    public function updatedMitraSearch($value)
    {
        if (strlen($value) >= 2) {
            $this->filteredMitras = Mitra::where('nama', 'ilike', '%'.$value.'%')
                ->orderBy('nama')
                ->get()
                ->toArray();
        } else {
            $this->filteredMitras = [];
        }
    }

    public function selectMitra($id, $name)
    {
        $this->mitra_id = $id;
        $this->mitra_name = $name;
        $this->mitra_search = '';
        $this->filteredMitras = [];
    }

    public function clearMitra()
    {
        $this->mitra_id = '';
        $this->mitra_name = '';
        $this->mitra_search = '';
        $this->filteredMitras = [];
    }

    public function createRecord()
    {
        $this->resetForm();
        $this->isEditMode = false;
    }

    public function editRecord($id)
    {
        $this->resetForm();
        $this->isEditMode = true;

        $record = SertifikatVeterinerModel::find($id);

        if (! $record) {
            return;
        }

        $this->recordId = $record->id;
        $this->tanggal = $record->tanggal->format('Y-m-d');
        $this->mitra_id = $record->mitra_id;
        $this->mitra_name = $record->mitra?->nama ?? '';
        $this->jenis_hewan = $record->jenis_hewan;
        $this->jeroan_merah = $record->jeroan_merah;
        $this->jeroan_hijau = $record->jeroan_hijau;
        $this->karkas = $record->karkas;
        $this->kulit = $record->kulit;
        $this->asal_produk = $record->asal_produk;
        $this->nama_penerima = $record->nama_penerima;
        $this->alamat_penerima = $record->alamat_penerima;
        $this->keterangan = $record->keterangan;
        $this->dokter_hewan = $record->dokter_hewan;
        $this->scan_sertifikat_lama = $record->scan_sertifikat;
    }

    public function saveRecord()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'mitra_id' => 'required|integer|exists:mitras,id',
            'jenis_hewan' => 'required|string|max:255',
            'jeroan_merah' => 'nullable|numeric|min:0',
            'jeroan_hijau' => 'nullable|numeric|min:0',
            'karkas' => 'nullable|numeric|min:0',
            'kulit' => 'nullable|numeric|min:0',
            'asal_produk' => 'required|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            'keterangan' => 'nullable|string',
            'dokter_hewan' => 'required|string|max:255',
            'scan_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        ]);

        $data = [
            'tanggal' => $this->tanggal,
            'mitra_id' => $this->mitra_id,
            'jenis_hewan' => $this->jenis_hewan,
            'jeroan_merah' => $this->jeroan_merah ?? 0,
            'jeroan_hijau' => $this->jeroan_hijau ?? 0,
            'karkas' => $this->karkas ?? 0,
            'kulit' => $this->kulit ?? 0,
            'asal_produk' => $this->asal_produk,
            'nama_penerima' => $this->nama_penerima,
            'alamat_penerima' => $this->alamat_penerima,
            'keterangan' => $this->keterangan,
            'dokter_hewan' => $this->dokter_hewan,
        ];

        if ($this->isEditMode && $this->recordId) {
            $record = SertifikatVeterinerModel::find($this->recordId);

            if ($record) {
                $data['scan_sertifikat'] = $this->scan_sertifikat
                    ? $this->scan_sertifikat->store('sertifikat-veteriner', 'public')
                    : $this->scan_sertifikat_lama;

                $record->update($data);
            }
        } else {
            $data['scan_sertifikat'] = $this->scan_sertifikat
                ? $this->scan_sertifikat->store('sertifikat-veteriner', 'public')
                : null;

            SertifikatVeterinerModel::create($data);
        }

        $this->loadRecords();
        $this->resetForm();

        $this->js('document.querySelector("[data-close-sv-modal]")?.click()');
    }

    public function deleteRecord($id)
    {
        SertifikatVeterinerModel::destroy($id);
        $this->loadRecords();
    }

    public function resetForm()
    {
        $this->recordId = null;
        $this->tanggal = '';
        $this->mitra_id = '';
        $this->mitra_search = '';
        $this->mitra_name = '';
        $this->filteredMitras = [];
        $this->jenis_hewan = '';
        $this->jeroan_merah = 0;
        $this->jeroan_hijau = 0;
        $this->karkas = 0;
        $this->kulit = 0;
        $this->asal_produk = '';
        $this->nama_penerima = '';
        $this->alamat_penerima = '';
        $this->keterangan = '';
        $this->dokter_hewan = '';
        $this->scan_sertifikat = null;
        $this->scan_sertifikat_lama = null;
    }

    public function render()
    {
        return view('livewire.sertifikat-veteriner.index')->layout('layouts.app');
    }
}
