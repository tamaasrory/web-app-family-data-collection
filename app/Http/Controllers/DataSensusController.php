<?php

namespace App\Http\Controllers;

use App\DataSensus;
use Illuminate\Http\Request;

class DataSensusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $data = DataSensus::all(['*']);
        if ($data->count()) {
            return ['value' => $data, 'msg' => 'data sensus'];
        }
        return ['value' => [], 'msg' => 'data sensus'];
    }

    public function add(Request $request)
    {
        if ($request->isMethod('GET')) {

            $status = [
                'ayah', 'ibu', 'kakek', 'nenek', 'anak', 'paman',
                'bibi', 'keponakan', 'cicit', 'mertua', 'menantu'
            ];

            return view('data_sensus.add', compact('status'));

        } elseif ($request->isMethod('POST')) {

            $result = DataSensus::create($request->all([
                'kode_akses',
                'no_hp',
                'alamat',
                'anggota_keluarga',
            ]));

            if ($this->isAjax()) {
                return [
                    'value' => $result,
                    'msg' => $result ? 'Berhasil Menyimpan Data' : 'Gagal Menyimpan Data'
                ];
            }
        }

        return redirect('/data-sensus/');
    }

    public function view($id)
    {
        /** @var DataSensus $dataSensus */
        $dataSensus = DataSensus::findOrFail($id);

        if ($dataSensus) {
            return ['value' => $dataSensus, 'msg' => 'data detail'];
        }
        return ['value' => null, 'msg' => 'data detail not found'];
    }

    public function edit(Request $request, $id = null)
    {
        if ($request->isMethod('GET')) {

            /** @var DataSensus $dataSensus */
            $dataSensus = DataSensus::findOrFail($id);

            if ($dataSensus) {
                $status = [
                    'ayah', 'ibu', 'kakek', 'nenek', 'anak', 'paman',
                    'bibi', 'keponakan', 'cicit', 'mertua', 'menantu'
                ];

                return view('data_sensus.edit', compact('status', 'dataSensus'));
            }

        } elseif ($request->isMethod('POST')) {

            /** @var DataSensus $dataSensus */
            $dataSensus = DataSensus::findOrFail($request->input('id'));
            if ($dataSensus) {
                $result = $dataSensus->update($request->all([
                    'kode_akses',
                    'no_hp',
                    'alamat',
                    'anggota_keluarga',
                ]));

                if ($this->isAjax()) {
                    return [
                        'value' => $result,
                        'msg' => $result ? 'Berhasil Menyimpan Data' : 'Gagal Menyimpan Data'
                    ];
                }
            }
        }

        return redirect('/data-sensus/');
    }

    public function delete(Request $request)
    {
        /** @var DataSensus $dataSensus */
        $dataSensus = DataSensus::findOrFail($request->input('id'));
        if ($dataSensus) {
            $result = $dataSensus->delete();

            if ($this->isAjax()) {
                return [
                    'value' => $result,
                    'msg' => $result ? 'Berhasil Menyimpan Data' : 'Gagal Menyimpan Data'
                ];
            }
        }

        return redirect('/data-sensus/');
    }
}
