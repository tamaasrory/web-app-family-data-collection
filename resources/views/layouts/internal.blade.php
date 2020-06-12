<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>Sensus Keluarga</title>
    <style>
        .v-list-item__subtitle, .v-list-item__title {
            white-space: unset !important;
        }
    </style>
</head>
<body>
<div id="app">
    <v-app>
        <v-app-bar
            color="primary"
            elevation="3"
            dark
            fixed
        >
            <v-scroll-x-transition>
                <v-btn
                    v-if="enableBackBtn"
                    icon
                    @click="clickBack"
                >
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
            </v-scroll-x-transition>

            <v-toolbar-title v-text="appBarTitle"></v-toolbar-title>

            <v-spacer></v-spacer>

            <v-scroll-x-reverse-transition>
                <v-btn v-if="openMenu=='index'" icon @click="showAdd()">
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </v-scroll-x-reverse-transition>
            <v-scroll-x-reverse-transition>
                <v-btn v-if="(openMenu=='add') && savingNewValidation" icon>
                    <v-icon>mdi-check</v-icon>
                </v-btn>
            </v-scroll-x-reverse-transition>
            <v-scroll-x-reverse-transition>
                <v-btn v-if="openMenu=='detail'" icon :to="`/edit/${$route.params.id}`">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </v-scroll-x-reverse-transition>
            <v-scroll-x-reverse-transition>
                <v-btn v-if="(openMenu=='edit') && savingValidation" icon>
                    <v-icon>mdi-check</v-icon>
                </v-btn>
            </v-scroll-x-reverse-transition>
            <v-scroll-x-reverse-transition>
                <v-btn icon>
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </v-scroll-x-reverse-transition>
        </v-app-bar>
        <v-content>
            <v-card
                class="mx-auto"
                flat
                max-width="600"
            >
                <transition>
                    <router-view></router-view>
                </transition>
            </v-card>

            <v-dialog v-model="showDialogAnggota" width="450" persistent>
                <v-card>
                    <v-card-title
                        v-text="dialogTitle"
                    >
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-list>
                        <v-list-item>
                            <v-list-item-content>
                                <v-text-field
                                    v-model="nama_lengkap"
                                    label="Nama Lengkap"
                                    hide-details>
                                </v-text-field>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-text-field
                                    v-model="nama_panggilan"
                                    label="Panggilan"
                                    hide-details>
                                </v-text-field>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-select
                                    v-model="status"
                                    label="Status Keluarga"
                                    :items="data_status"
                                    hide-details>
                                </v-select>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            v-if="dialogLBTN"
                            :color="dialogLBTN.color"
                            @click="dialogLBTN.click"
                            text
                            v-text="dialogLBTN.text">
                        </v-btn>
                        <v-btn
                            v-if="dialogRBTN"
                            :color="dialogRBTN.color"
                            @click="dialogRBTN.click"
                            text
                            v-text="dialogRBTN.text">
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogConfirm.show" width="450" persistent>
                <v-card>
                    <v-card-title
                        v-text="dialogConfirm.title"
                    >
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-text v-html="dialogConfirm.message"></v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            v-if="dialogConfirm.dialogLBTN"
                            :color="dialogConfirm.dialogLBTN.color"
                            @click="dialogConfirm.dialogLBTN.click"
                            text
                            v-text="dialogConfirm.dialogLBTN.text">
                        </v-btn>
                        <v-btn
                            v-if="dialogConfirm.dialogRBTN"
                            :color="dialogConfirm.dialogRBTN.color"
                            @click="dialogConfirm.dialogRBTN.click"
                            text
                            v-text="dialogConfirm.dialogRBTN.text">
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-bottom-navigation
                color="primary"
                :value="activeMenu"
                grow
                fixed
            >
                <v-btn v-if="showMenu[0]" @click="showIndex()">
                    <span>Data</span>
                    <v-icon>mdi-format-list-text</v-icon>
                </v-btn>

                <v-btn v-if="showMenu[1]">
                    <span>Data Baru</span>
                    <v-icon>mdi-account-plus</v-icon>
                </v-btn>

                <v-btn v-if="showMenu[2]">
                    <span>Detail</span>
                    <v-icon>mdi-account-details</v-icon>
                </v-btn>

                <v-btn v-if="showMenu[3]">
                    <span>Edit</span>
                    <v-icon>mdi-account-edit</v-icon>
                </v-btn>

                <v-btn v-if="showMenu[4]" @click="showEbook()">
                    <span>Ebook</span>
                    <v-icon>mdi-file-document</v-icon>
                </v-btn>
            </v-bottom-navigation>
        </v-content>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-router@3.3.2/dist/vue-router.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    const IndexData = {
        template: `<v-container fluid style="padding: 0px;margin-top: 60px;margin-bottom: 60px">
                        <v-list two-line>
                            <v-list-item
                                v-for="(item, index) in data_sensus"
                                :key="item.id"
                                @click="()=>{}"
                            >
                                <v-list-item-action>
                                    <v-btn :color="item.anggota_keluarga.length ? 'success':'grey lighten-1'" fab small>
                                        <span v-text="item.anggota_keluarga.length" style="font-size: 12pt"></span>
                                    </v-btn>
                                </v-list-item-action>

                                <v-list-item-content @click="showDetail(item)">
                                    <v-list-item-title v-text="item.kode_akses"></v-list-item-title>
                                    <v-list-item-subtitle v-text="item.no_hp"></v-list-item-subtitle>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-btn icon @click="showEdit(item)">
                                        <v-icon color="primary">mdi-pencil</v-icon>
                                    </v-btn>
                                </v-list-item-action>

                                <v-list-item-action>
                                    <v-btn icon @click="deleteDataSensus(item)">
                                        <v-icon color="pink">mdi-delete</v-icon>
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>
                            <v-divider/>
                        </v-list>
                    </v-container>`,
        data() {
            return {
                data_sensus: []
            }
        },
        mounted() {
            console.log('Index Data');
            this.loadingDataSensus();
        },
        methods: {
            loadingDataSensus() {
                axios.get('/data-sensus/')
                    .then(response => {
                        this.data_sensus = response.data.value;
                    })
                    .catch(error => {
                        console.log(error);
                        this.data_sensus = [];
                    });
            },
            showDetail(item) {
                this.$root.routeTo(`/view/${item.id}`);
            },
            showEdit(item) {
                this.$root.routeTo(`/edit/${item.id}`);
            },
            deleteDataSensus(item) {
                let length = this.data_sensus.length;
                // TODO push server
                let tmp = [];
                for (let i = 0; i < length; i++) {
                    if (this.data_sensus[i].id !== item.id) {
                        tmp.push(this.data_sensus[i])
                    }
                }

                this.data_sensus = tmp;
            },
        }
    };

    const ViewData = {
        template: `<v-container fluid style="padding: 0px;margin-top: 60px;margin-bottom: 60px">
                        <v-list v-if="data_detail">
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Kode Akses</v-list-item-title>
                                    <v-list-item-subtitle v-text="data_detail.kode_akses"></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Nomor Ponsel</v-list-item-title>
                                    <v-list-item-subtitle v-text="data_detail.no_hp"></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Desa</v-list-item-title>
                                    <v-list-item-subtitle v-text="data_detail.alamat.label"></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Alamat</v-list-item-title>
                                    <v-list-item-subtitle v-text="data_detail.alamat.detail"></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-subheader>Daftar Anggota Keluarga</v-subheader>
                            <v-list-item
                                v-for="(item, index) in data_detail.anggota_keluarga"
                                :key="index"
                                style="border-top: 1px solid rgba(0, 0, 0, 0.125)"
                            >
                                <v-list-item-avatar color="primary">
                                    <span style="color: white" v-text="index+1"></span>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="data_detail.anggota_keluarga[index].nama_lengkap"></v-list-item-title>
                                    <v-list-item-subtitle
                                        v-text="data_detail.anggota_keluarga[index].nama_panggilan"></v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-list-item-action-text
                                        v-text="data_detail.anggota_keluarga[index].status.toString().toUpperCase()"></v-list-item-action-text>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </v-container>`,
        data() {
            return {
                data_detail: null
            }
        },
        mounted() {
            console.log('View Data');
            this.loadingDetail();
            this.$root.setDetailAttr();
        },
        methods: {
            loadingDetail() {
                axios.get(`/data-sensus/view/${this.$route.params.id}`)
                    .then(response => {
                        this.data_detail = response.data.value;
                    })
                    .catch(error => {
                        console.log(error);
                        this.data_detail = null;
                    });
            },
        }
    };

    const EditData = {
        template: `<v-container fluid style="padding: 0px;margin-top: 60px;margin-bottom: 60px">
                        <v-list v-if="data_edit">
                            <v-list-item>
                                <v-list-item-content>
                                    <v-text-field
                                        v-model="data_edit.kode_akses"
                                        label="Kode Akses"
                                        disabled
                                        hide-details>
                                    </v-text-field>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-text-field
                                        v-model="data_edit.no_hp"
                                        label="Nomor Ponsel"
                                        hide-details>
                                    </v-text-field>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-autocomplete
                                        v-model="data_edit.alamat.desa"
                                        :loading="loading_village"
                                        :items="data_village"
                                        ref="village_value"
                                        flat
                                        hide-details
                                        clearable
                                        label="Apa Nama Desa Kamu"
                                        placeholder="Ketik Nama Desa Kamu 5 huruf"
                                        @keypress="searchVillage"
                                    ></v-autocomplete>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-textarea
                                        v-model="data_edit.alamat.detail"
                                        label="Alamat"
                                        rows="1"
                                        auto-grow
                                        hide-details>
                                    </v-textarea>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Daftar Anggota Keluarga</v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-btn
                                        icon
                                        style="background-color: rgba(0, 0, 0, 0.07)"
                                        @click="showAddAnggota(data_edit)"
                                    >
                                        <v-icon color="green">mdi-plus</v-icon>
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>

                            <v-list-item
                                v-for="(item, index) in data_edit.anggota_keluarga"
                                :key="index"
                                style="border-top: 1px solid rgba(0, 0, 0, 0.125)"
                            >
                                <v-list-item-content @click="showEditAnggota(data_edit,index)">
                                    <v-list-item-title
                                        v-text="data_edit.anggota_keluarga[index].nama_lengkap"></v-list-item-title>
                                    <v-list-item-subtitle
                                        v-text="data_edit.anggota_keluarga[index].nama_panggilan"></v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-list-item-action-text
                                        v-text="data_edit.anggota_keluarga[index].status.toString().toUpperCase()"></v-list-item-action-text>
                                </v-list-item-action>
                                <v-list-item-avatar>
                                    <v-btn icon style="background-color: rgba(0,0,0,0.07)"
                                           @click="deleteAnggota(data_edit,index)">
                                        <v-icon color="pink">mdi-delete</v-icon>
                                    </v-btn>
                                </v-list-item-avatar>
                            </v-list-item>
                        </v-list>
                    </v-container>`,
        data() {
            return {
                data_edit: null,
                loading_village: false,
                selectVillage: '',
                data_village: null
            }
        },
        mounted() {
            console.log('Edit Data');
            this.loadingDetail();
        },
        methods: {
            loadingDetail() {
                axios.get(`/data-sensus/view/${this.$route.params.id}`)
                    .then(response => {
                        let temp = JSON.stringify(response.data.value);
                        this.data_edit = JSON.parse(temp);
                        this.$root.data_edit = this.data_edit;
                        this.$root.setEditAttr(temp, this.data_edit);
                    })
                    .catch(error => {
                        console.log(error);
                        this.data_edit = null;
                    });
            },
            postUpdate() {
                axios.post('/data-sensus/edit', this.data_edit)
                    .then(response => {
                        console.log(response);
                        this.$root.routeTo(this.data_edit.id);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            searchVillage() {
                let search = this.$refs.village_value.$refs.input.value;
                console.log(search);
                if (search.length > 4) {
                    this.loading_village = true;
                    axios.post('/api/desa/q', {q: search})
                        .then(response => {
                            this.data_village = response.data.value.map(data => {
                                return {text: data.label, value: data};
                            });
                            this.loading_village = false;
                        })
                        .catch(error => {
                            this.loading_village = false;
                            this.data_village = null;
                        });
                } else {
                    this.data_village = null;
                }
            },
            showAddAnggota(data_edit) {
                this.$root.showAddAnggota(data_edit);
            },
            showEditAnggota(data_edit, index) {
                this.$root.showEditAnggota(data_edit, index);
            },
            deleteAnggota(data_edit, index) {
                this.$root.deleteAnggota(data_edit, index);
            }
        }
    };

    const AddData = {
        template: `<v-container fluid style="padding: 0px;margin-top: 60px;margin-bottom: 60px">
                        <v-list>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-text-field
                                        v-model="data_baru.kode_akses"
                                        label="Kode Akses"
                                        hide-details>
                                    </v-text-field>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-text-field
                                        v-model="data_baru.no_hp"
                                        label="Nomor Ponsel"
                                        hide-details>
                                    </v-text-field>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-autocomplete
                                        v-model="data_baru.alamat.desa"
                                        :loading="loading_village"
                                        :items="data_village"
                                        ref="village_value"
                                        flat
                                        hide-details
                                        clearable
                                        label="Apa Nama Desa Kamu"
                                        placeholder="Ketik Nama Desa Kamu 5 huruf"
                                        @keypress="searchVillage"
                                    ></v-autocomplete>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-textarea
                                        v-model="data_baru.alamat.detail"
                                        label="Alamat"
                                        rows="1"
                                        auto-grow
                                        hide-details>
                                    </v-textarea>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>Daftar Anggota Keluarga</v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-btn
                                        icon
                                        style="background-color: rgba(0, 0, 0, 0.07)"
                                        @click="showAddAnggota(data_baru)"
                                    >
                                        <v-icon color="green">mdi-plus</v-icon>
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>

                            <v-list-item
                                v-for="(item, index) in data_baru.anggota_keluarga"
                                :key="index"
                                style="border-top: 1px solid rgba(0, 0, 0, 0.125)"
                            >
                                <v-list-item-content @click="showEditAnggota(data_baru,index)">
                                    <v-list-item-title
                                        v-text="data_baru.anggota_keluarga[index].nama_lengkap"></v-list-item-title>
                                    <v-list-item-subtitle
                                        v-text="data_baru.anggota_keluarga[index].nama_panggilan"></v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-list-item-action-text
                                        v-text="data_baru.anggota_keluarga[index].status.toString().toUpperCase()"></v-list-item-action-text>
                                </v-list-item-action>
                                <v-list-item-avatar>
                                    <v-btn icon style="background-color: rgba(0,0,0,0.07)"
                                           @click="deleteAnggota(data_baru,index)">
                                        <v-icon color="pink">mdi-delete</v-icon>
                                    </v-btn>
                                </v-list-item-avatar>
                            </v-list-item>
                        </v-list>
                    </v-container>`,
        data() {
            return {
                loading_village: false,
                selectVillage: '',
                data_village: null
            }
        },
        computed: {
            data_baru() {
                return this.$root.data_baru;
            }
        },
        methods: {
            searchVillage() {
                let search = this.$refs.village_value.$refs.input.value;
                console.log(search);
                if (search.length > 4) {
                    this.loading_village = true;
                    axios.post('/api/desa/q', {q: search})
                        .then(response => {
                            this.data_village = response.data.value.map(data => {
                                return {text: data.label, value: data};
                            });
                            this.loading_village = false;
                        })
                        .catch(error => {
                            this.loading_village = false;
                            this.data_village = null;
                        });
                } else {
                    this.data_village = null;
                }
            },
            showAddAnggota(data_edit) {
                this.$root.showAddAnggota(data_edit);
            },
            showEditAnggota(data_edit, index) {
                this.$root.showEditAnggota(data_edit, index);
            },
            deleteAnggota(data_edit, index) {
                this.$root.deleteAnggota(data_edit, index);
            }
        }
    };
    const Ebook = {
        template: `<v-container fluid style="padding: 0px;margin-top: 60px;margin-bottom: 60px">
                        <v-list>
                            <v-list-item @click="downloadEbookBaru">
                                <v-list-item-content>
                                    <v-list-item-title>Buat Ebook Baru</v-list-item-title>
                                    <v-list-item-subtitle v-text="msgProgressEbookBaru">
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-progress-circular
                                        v-show="loading_ebookbaru"
                                        indeterminate
                                        color="success"
                                    ></v-progress-circular>
                                </v-list-item-action>
                            </v-list-item>
                            <v-list-item @click="downloadEbookLama">
                                <v-list-item-content>
                                    <v-list-item-title>Ebook Lama</v-list-item-title>
                                    <v-list-item-subtitle v-text="msgProgressEbookLama">
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-progress-circular
                                        v-show="loading_ebook"
                                        indeterminate
                                        color="primary"
                                    ></v-progress-circular>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </v-container>`,
        mounted() {
            this.$root.appBarTitle = 'Ebook Keluarga';
            this.$root.activeMenu = 1;
        },
        data() {
            return {
                loading_ebookbaru: false,
                loading_ebook: false,
                msgProgressEbookBaru: 'klik disini untuk membuat dan download ebook terbaru',
                msgProgressEbookLama: 'klik disini untuk download ebook lama',
            }
        },
        methods: {
            downloadEbookBaru() {
                this.loading_ebookbaru = true;
                this.msgProgressEbookBaru = 'Sedang Membuat Ebook...';
                axios.get(`/data-sensus/ebook/baru`, {responseType: 'blob'})
                    .then(response => {
                        if (response.status === 200) {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', `Ebook Keluarga.pdf`);
                            document.body.appendChild(link);
                            link.click();
                        }
                        this.loading_ebookbaru = false;
                        this.msgProgressEbookBaru = 'klik disini untuk membuat dan download ebook terbaru';
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading_ebookbaru = false;
                        this.msgProgressEbookBaru = 'klik disini untuk membuat dan download ebook terbaru';
                    })
            },
            downloadEbookLama() {
                this.loading_ebook = true;
                this.msgProgressEbookLama = 'Sedang Download Ebook...';
                axios.get(`/data-sensus/ebook/lama`, {responseType: 'blob'})
                    .then(response => {
                        if (response.status === 200) {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', `Ebook Keluarga.pdf`);
                            document.body.appendChild(link);
                            link.click();
                        }
                        this.loading_ebook = false;
                        this.msgProgressEbookLama = 'klik disini untuk download ebook lama';
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading_ebook = false;
                        this.msgProgressEbookLama = 'klik disini untuk download ebook lama';
                    })
            },
        }
    };

    const routes = [
        {path: '/', component: IndexData},
        {path: '/view/:id', component: ViewData},
        {path: '/edit/:id', component: EditData},
        {path: '/add', component: AddData},
        {path: '/ebook', component: Ebook}
    ];

    const router = new VueRouter({routes});

    var vms = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        router,
        data: {
            appBarTitle: 'Data Sensus',
            openMenu: 'index',
            enableBackBtn: false,
            clickBack: () => {
            },
            data_edit: null,
            data_baru: {
                kode_akses: '',
                no_hp: '',
                alamat: {
                    desa: '',
                    detail: '',
                },
                anggota_keluarga: []
            },
            showMenu: [1, 0, 0, 0, 1],
            activeMenu: 0,
            nama_lengkap: null,
            nama_panggilan: null,
            status: null,
            data_status: [
                'ayah', 'ibu', 'kakek', 'nenek', 'anak', 'paman',
                'bibi', 'keponakan', 'cicit', 'mertua', 'menantu'
            ],
            showDialogAnggota: false,
            dialogTitle: 'Title',
            dialogLBTN: null,
            dialogRBTN: null,
            dialogConfirm: {
                show: false,
                message: '',
                title: 'No Title',
            }
        },
        computed: {
            savingValidation() {
                return this.validation(this.data_edit);
            },
            savingNewValidation() {
                return this.validation(this.data_baru);
            }
        },
        methods: {
            validation(data) {
                if (data) {
                    if (data.kode_akses == null || data.alamat.desa == null || data.alamat.detail == null) {
                        return false
                    }

                    let ak = data.anggota_keluarga;
                    if (ak.length > 0) {
                        for (let i = 0; i < ak.length; i++) {
                            if (JSON.stringify(ak[i]).includes('null')) {
                                return false
                            }
                        }
                    } else {
                        return false
                    }

                    return true
                }
                return false
            },
            chooseMenu(title) {
                this.appBarTitle = title
            },
            routeTo(to) {
                if (this.$router.history.current.path !== to) {
                    this.$router.push(to)
                }
            },
            showIndex() {
                this.openMenu = 'index';
                this.appBarTitle = 'Data Sensus';
                this.enableBackBtn = false;
                this.showMenu = [1, 0, 0, 0, 1];
                this.activeMenu = 0;
                this.routeTo('/')
            },
            setEditAttr(temp, item) {
                this.openMenu = 'edit';
                this.appBarTitle = 'Edit';
                this.enableBackBtn = true;
                this.showMenu = [0, 0, 0, 1, 1];
                this.activeMenu = 0;
                this.clickBack = () => {
                    console.log(item, ' === ', temp);
                    if (JSON.stringify(item) === temp) {
                        this.routeTo(`/view/${item.id}`);
                    } else {
                        this.dialogConfirm.title = 'Info';
                        this.dialogConfirm.message = `<p style='font-size: 14pt' class='my-4'>Simpan Perubahan Data?</p>`;
                        this.dialogConfirm.dialogLBTN = {
                            text: 'Tidak',
                            color: 'pink',
                            click: () => {
                                this.routeTo(`/view/${item.id}`);
                                this.dialogConfirm.show = false;
                            }
                        };
                        this.dialogConfirm.dialogRBTN = {
                            text: 'Simpan',
                            color: 'primary',
                            click: () => {
                                // TODO simpan ke server
                                this.routeTo(`/view/${item.id}`);
                                this.dialogConfirm.show = false;
                            }
                        };
                        this.dialogConfirm.show = true;
                    }
                };
            },
            showEdit(item) {
                let temp = JSON.stringify(item);
                this.data_edit = JSON.parse(temp);
                this.routeTo(`/edit/${item.id}`);
            },
            setDetailAttr() {
                this.openMenu = 'detail';
                this.appBarTitle = 'Detail';
                this.enableBackBtn = true;
                this.showMenu = [0, 0, 1, 0, 1];
                this.activeMenu = 0;
                this.clickBack = () => this.showIndex();
            },
            showDetail(item) {
                this.data_detail = item;
                this.routeTo(`/view/${item.id}`);
            },
            showAdd() {
                this.openMenu = 'add';
                this.appBarTitle = 'Data Baru';
                this.enableBackBtn = true;
                this.showMenu = [0, 1, 0, 0, 1];
                this.activeMenu = 0;
                this.clickBack = () => this.showIndex();
                this.routeTo('/add');
            },
            showEbook() {
                this.openMenu = 'ebook';
                this.appBarTitle = 'Ebook Keluarga';
                this.enableBackBtn = false;
                this.activeMenu = 1;
                this.clickBack = () => this.showIndex();
                this.routeTo('/ebook');
            },
            addAnggota(data) {
                data.anggota_keluarga.push({
                    nama_lengkap: this.nama_lengkap,
                    nama_panggilan: this.nama_panggilan,
                    status: this.status,
                });
                this.nama_lengkap = null;
                this.nama_panggilan = null;
                this.status = null;
            },
            editAnggota(data, index) {
                data.anggota_keluarga[index].nama_lengkap = this.nama_lengkap;
                data.anggota_keluarga[index].nama_panggilan = this.nama_panggilan;
                data.anggota_keluarga[index].status = this.status;
                this.nama_lengkap = null;
                this.nama_panggilan = null;
                this.status = null;
            },
            deleteAnggota(data, id) {
                let length = data.anggota_keluarga.length;
                let tmp = [];
                for (let i = 0; i < length; i++) {
                    if (i !== id) {
                        tmp.push(data.anggota_keluarga[i])
                    }
                }

                data.anggota_keluarga = tmp;
            },
            showAddAnggota(data) {
                this.dialogTitle = 'Tambah Anggota';
                this.dialogRBTN = {
                    text: 'Simpan',
                    color: 'primary',
                    click: () => {
                        if(data) {
                            this.addAnggota(data);
                        }
                        this.showDialogAnggota = false;
                    }
                };

                this.dialogLBTN = {
                    text: 'Batal',
                    color: 'pink',
                    click: () => {
                        this.showDialogAnggota = false;
                        this.nama_lengkap = null;
                        this.nama_panggilan = null;
                        this.status = null;
                    }
                };

                this.showDialogAnggota = true;
            },
            showEditAnggota(data, index) {
                this.dialogTitle = 'Edit Anggota';
                this.dialogRBTN = {
                    text: 'Perbarui',
                    color: 'primary',
                    click: () => {
                        if(data) {
                            this.editAnggota(data, index);
                        }
                        this.showDialogAnggota = false;
                    }
                };

                this.dialogLBTN = {
                    text: 'Batal',
                    color: 'pink',
                    click: () => {
                        this.showDialogAnggota = false;
                        this.nama_lengkap = null;
                        this.nama_panggilan = null;
                        this.status = null;
                    }
                };

                this.nama_lengkap = data.anggota_keluarga[index].nama_lengkap;
                this.nama_panggilan = data.anggota_keluarga[index].nama_panggilan;
                this.status = data.anggota_keluarga[index].status;
                this.showDialogAnggota = true;
            },
            postSave() {
                axios.post('/data-sensus/add', this.data_baru)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            postDelete(id) {
                const ck = confirm('Anda yakin akan menghapus data ini ?');
                if (ck) {
                    axios.post('/data-sensus/delete', {id: id})
                        .then(response => {
                            let length = vms.data_sensus.length;
                            let tmp = [];
                            for (let i = 0; i < length; i++) {
                                if (vms.data_sensus[i].id !== id) {
                                    tmp.push(vms.data_sensus[i])
                                }
                            }

                            vms.data_sensus = tmp;
                            console.log(response);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            }
        }
    })
</script>
</body>
</html>
