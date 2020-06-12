@extends('layouts.app')

@section('content')
    <div class="container" id="view-data-sensus">
        <div class="row" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <a class="float-right" :href="`/data-sensus/edit/${data_sensus.id}`"><i
                                class="icon ion-md-create"></i> Ubah</a>
                        <div class="clabel">Kode Akses</div>
                        <span v-text="data_sensus.kode_akses"></span>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <div class="clabel">Nomor Ponsel</div>
                        <span v-text="data_sensus.no_hp"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <div class="clabel">Desa</div>
                        <div v-text="data_sensus.alamat.label">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <div class="clabel">Alamat</div>
                        <span v-text="data_sensus.alamat.detail"></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="anggota_keluarga" class="mt-3">
            <p class="text-muted" style="font-weight: bold">Daftar Anggota Keluarga</p>
            <div class="d-none d-md-block">
                <div class="row pt-2 pb-2"
                     style="border-top: 1px solid rgba(0, 0, 0, 0.125);font-weight: bold;background-color: #f5f5f5">
                    <div class="col-md-4">Nama Lengkap</div>
                    <div class="col-md-4">Nama Panggilan</div>
                    <div class="col-md-4">Status Keluarga</div>
                </div>
            </div>
            <div v-for="(item, index) in data_sensus.anggota_keluarga" class="row pt-2 pb-2"
                 style="border-top: 1px solid rgba(0, 0, 0, 0.125)">
                <div class="col-1 col-md-1 d-block d-md-none">
                    <span v-text="index+1"></span>
                </div>
                <div class="col-11 col-md-12">
                    <div class="row">
                        <div class="col-8 col-md-8">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <span class="clabel"
                                          v-text="data_sensus.anggota_keluarga[index].nama_lengkap"></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <span v-text="data_sensus.anggota_keluarga[index].nama_panggilan"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4 text-right text-md-left text-success">
                            <span v-text="data_sensus.anggota_keluarga[index].status.toString().toUpperCase()"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .clabel {
            font-weight: bold;
        }
    </style>
@endsection
@section('script')
    <script>
        var viewDataSensus = new Vue({
            el: '#view-data-sensus',
            data: {
                cariDesa: '',
                hideCariDesa: false,
                dataDesa: null,
                data_sensus: @json($dataSensus)
            }
        })
    </script>
@endsection
