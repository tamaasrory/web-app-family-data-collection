@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <v-container>
            <div class="title">
                Sensus Keluarga
            </div>
            <div class="row">
                <div class="col-6">
                    <v-text-field
                        label="Masukkan Kode Unik"
                        single-line
                    ></v-text-field>
                </div>
            </div>
        </v-container>
    </div>
@endsection

@section('style')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 54px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
        })
    </script>
@endsection
