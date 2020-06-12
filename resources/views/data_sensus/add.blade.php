@extends('layouts.app')

@section('content')
    <div class="container" id="add-data-sensus">
        <div class="card">
            <div class="card-header">
                <span style="font-size: 16pt"><button class="btn btn-danger mr-2 py-0" @click="back"><i
                            style="font-size: 18pt" class="icon ion-md-arrow-back"></i></button>Tambah Data</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Kode Akses</label>
                                    <input type="text" v-model="data_sensus.kode_akses" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Nomor Ponsel</label>
                                    <input type="text" v-model="data_sensus.no_hp" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Desa</label>
                                    <div class="form-control dropdown-toggle dropdown-toggle-split"
                                         id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true"
                                         @click="hideCariDesa=true"
                                         aria-expanded="false" data-reference="parent">
                                        <div class="float-left"
                                             style="overflow-x: hidden;overflow-y: hidden;text-overflow: ellipsis; width: 70%"
                                             v-text="data_sensus.alamat.label"></div>
                                        <span class="float-right">
                                            <i class="icon ion-md-arrow-dropdown-circle"
                                               style="font-size: 14pt"></i>
                                        </span>
                                    </div>
                                    <div v-show="hideCariDesa">
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference"
                                             style="width: 90%;display: inline-block !important;">
                                            <div class="px-2 mb-1">
                                                <div class="input-group">
                                                    <input type="text" v-model="cariDesa" class="form-control"
                                                           @keypress="postCariDesa()"
                                                           placeholder="Ketik Nama Desa 5 Huruf ">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                              style="cursor:pointer;" v-show="hideCariDesa"
                                                              @click="()=>{hideCariDesa=false;dataDesa=null;cariDesa=null;}">
                                                            <i class="icon ion-md-close"></i>&nbsp;Tutup
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <div
                                                style="max-height: 250px;overflow-y: scroll;width: 100%;overflow-x: hidden">
                                                <div v-for="(item, index) in dataDesa" class="dropdown-item" href="#"
                                                     @click="selectedDesa(item)">
                                                    <div v-text="item.desa"></div>
                                                    <small v-text="item.label"></small>
                                                </div>
                                                <a v-show="!dataDesa" class="dropdown-item" href="#">Desa Tidak
                                                    Ditemukan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <textarea v-model="data_sensus.alamat.detail" class="form-control"
                                              rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="anggota_keluarga" class="mt-2">
                    <div style="line-height: 0.5">
                        <div class="float-left mr-3" style="height: 50px">
                            <i class="icon ion-md-people text-success" style="font-size: 42px;"></i>
                        </div>
                        <div>
                            <h5>Keluarga</h5>
                            <p class="text-muted">Daftarkan Anggota Keluarga</p>
                        </div>
                    </div>
                    <div v-for="(item, index) in data_sensus.anggota_keluarga" class="row pt-3 pb-2"
                         style="border-top: 1px solid rgba(0, 0, 0, 0.125)">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control"
                                       v-model="data_sensus.anggota_keluarga[index].nama_lengkap">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Nama Panggilan</label>
                                <input type="text" class="form-control"
                                       v-model="data_sensus.anggota_keluarga[index].nama_panggilan">
                            </div>
                        </div>
                        <div class="col-8 col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" v-model="data_sensus.anggota_keluarga[index].status">
                                    @foreach($status as $val)
                                        <option value="{{$val}}">{{ucwords($val)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4 col-md-2 my-auto">
                            <span @click="deleteAnggota(index)" class="btn btn-danger btn-block mt-3">
                                <i class="icon ion-md-trash" style="font-size: 14pt"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-success" @click="addAnggota">
                        <i class="icon ion-md-add" style="font-size: 14pt"></i>
                        Tambah Anggota
                    </button>
                    <button class="btn btn-primary" v-if="validation" @click="postSave">
                        <i class="icon ion-md-save" style="font-size: 14pt"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        button[aria-haspopup="listbox"] {
            border: 1px solid #ccc;
            background-color: #fff !important;
            color: #495057 !important;
        }

        div[id="dropdownMenuReference"]::after {
            display: none;
        }

        .dropdown-menu {
            position: absolute;
            /*top: 100%;*/
            /*left: 0;*/
            z-index: 1000;
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: .25rem;
            transform: translate3d(15px, 70px, 0px);
            top: 0px;
            left: 0px;
            will-change: transform;
        }
    </style>
@endsection
@section('script')
    <script>
        var addDataSensus = new Vue({
            el: '#add-data-sensus',
            data: {
                cariDesa: '',
                hideCariDesa: false,
                dataDesa: null,
                data_sensus: {
                    kode_akses: null,
                    no_hp: null,
                    alamat: {
                        desa: '',
                        detail: null,
                    },
                    anggota_keluarga: [
                        {
                            nama_lengkap: null,
                            nama_panggilan: null,
                            // no_hp: null,
                            status: 'ayah',
                        }
                    ]
                }
            },
            computed: {
                validation: function () {
                    if (this.data_sensus.kode_akses == null ||
                        // this.data_sensus.no_hp == null ||
                        this.data_sensus.alamat.desa == null ||
                        this.data_sensus.alamat.detail == null) {
                        return false
                    }

                    let ak = this.data_sensus.anggota_keluarga;
                    for (let i = 0; i < ak.length; i++) {
                        if (JSON.stringify(ak[i]).includes('null')) {
                            return false
                        }
                    }

                    return true
                }
            },
            methods: {
                selectedDesa: function (item) {
                    const {id_prov, id_kab, id_kec, id_des, label} = item;
                    this.data_sensus.alamat.label = label;
                    this.cariDesa = '';
                    this.dataDesa = null;
                    this.data_sensus.alamat.desa = `${id_prov}${id_kab}${id_kec}${id_des}`;
                    this.hideCariDesa = false
                },
                addAnggota: function () {
                    this.data_sensus.anggota_keluarga.push({
                        nama_lengkap: null,
                        nama_panggilan: null,
                        // no_hp: null,
                        status: null,
                    })
                },
                deleteAnggota: function (id) {
                    let length = this.data_sensus.anggota_keluarga.length;
                    let tmp = [];
                    for (let i = 0; i < length; i++) {
                        if (i !== id) {
                            tmp.push(this.data_sensus.anggota_keluarga[i])
                        }
                    }

                    this.data_sensus.anggota_keluarga = tmp;
                },
                postSave: function () {
                    axios.post('/data-sensus/add', this.data_sensus)
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                postCariDesa: function () {
                    if (this.cariDesa.length > 4) {
                        axios.post('/api/desa/q', {q: this.cariDesa})
                            .then(function (response) {
                                addDataSensus.dataDesa = response.data.value;
                            })
                            .catch(function (error) {
                                console.log(error);
                                addDataSensus.dataDesa = null;
                            });
                    }
                },
                back: function () {
                    history.go(-1);
                }
            }
        })
    </script>
@endsection
