<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index()
    {
        $beasiswa = Beasiswa::with('syarat')->get();

        return view('beasiswa.beasiswa', compact('beasiswa'));
    }

    public function daftar()
    {
        $beasiswa = Beasiswa::all();

        return view('beasiswa.daftar', compact('beasiswa'));
    }

    public function hasil()
    {
        $mahasiswa = Mahasiswa::join('beasiswas as b', 'b.id', '=', 'mahasiswas.beasiswa')
            ->select('mahasiswas.*', 'b.nama as nama_beasiswa')
            ->get();

        return view('beasiswa.hasil', compact('mahasiswa'));
    }

    public function storeBeasiswa(Request $request)
    {
        $validatedData = $request->validate([
            'namaBeasiswa' => 'required|string|max:255',
            'jenisBeasiswa' => 'required|in:akademik,non-akademik',
            'sumberDana' => 'required|string|max:255',
            'syarat' => 'required|array',
            'syarat.*' => 'required|string|max:255',
            'jumlahKuota' => 'required|integer|min:1',
        ]);

        $beasiswa = new Beasiswa();
        $beasiswa->nama = $validatedData['namaBeasiswa'];
        $beasiswa->jenis_beasiswa = $validatedData['jenisBeasiswa'];
        $beasiswa->sumber_dana = $validatedData['sumberDana'];
        $beasiswa->jumlah_kuota = $validatedData['jumlahKuota'];
        $beasiswa->save();

        foreach ($validatedData['syarat'] as $syarat) {
            if (!empty($syarat)) {
                $beasiswa->syarat()->create(['syarat' => $syarat]);
            }
        }

        return response()->json(['message' => 'Data beasiswa berhasil disimpan!'], 201);
    }

    public function storeMahasiswa(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'semester' => 'required|integer|min:1|max:8',
                'ipk' => 'required|numeric|min:3',
                'beasiswa' => 'required|string|max:255',
                'berkas' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($request->hasFile('berkas')) {
                $file = $request->file('berkas');
                $filePath = $file->store('berkas_mahasiswa', 'public');
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File berkas tidak ditemukan.',
                ], 400);
            }

            $mahasiswa = Mahasiswa::create([
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'semester' => $validatedData['semester'],
                'ipk' => $validatedData['ipk'],
                'beasiswa' => $validatedData['beasiswa'],
                'berkas' => $filePath,
                'status' => 'unverified'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data mahasiswa berhasil disimpan.',
                'data' => $mahasiswa,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessages = array_shift($errors);

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. ',
                'errors' => $errorMessages[0],
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
