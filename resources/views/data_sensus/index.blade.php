@extends('layouts.app')

@section('content')
    <div class="container" id="index-data-sensus">
        <div class="card">
            <div class="card-header">
                <span class="align-middle">Data Akses</span>
            </div>
            <div class="card-body">
                <a href="/data-sensus/add" class="btn btn-success mb-3">Tambah</a>
                <div v-show="!data_sensus.length">Data masih kosong belum ada keluarga yang terdaftar</div>
                <table class="table table-hover" v-show="data_sensus.length">
                    <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Kode Akses</th>
                        <th>Nomor Ponsel</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in data_sensus">
                        <td v-text="index + 1"></td>
                        <td v-text="item.kode_akses"></td>
                        <td v-text="item.no_hp"></td>
                        <td>
                            <div class="float-right">
                                <a class="btn btn-danger" href="#" @click="postDelete(item.id)">
                                    Hapus
                                </a>
                                <a :href="`/data-sensus/edit/${item.id}`" class="btn btn-primary"
                                   target="_blank">
                                    Edit
                                </a>
                                <a :href="`/data-sensus/view/${item.id}`" class="btn btn-info"
                                   target="_blank">
                                    Lihat
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var indexDataSensus = new Vue({
            el: '#index-data-sensus',
            data: {
                data_sensus: @json($data)
            },
            methods: {
                postDelete: function (id) {
                    const ck = confirm('Anda yakin akan menghapus data ini ?');
                    if(ck) {
                        axios.post('/data-sensus/delete', {id: id})
                            .then(function (response) {
                                let length = indexDataSensus.data_sensus.length;
                                let tmp = [];
                                for (let i = 0; i < length; i++) {
                                    if (indexDataSensus.data_sensus[i].id !== id) {
                                        tmp.push(indexDataSensus.data_sensus[i])
                                    }
                                }

                                indexDataSensus.data_sensus = tmp;
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                }
            }
        })
    </script>
@endsection

