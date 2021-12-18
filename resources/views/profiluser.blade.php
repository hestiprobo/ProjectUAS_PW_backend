@extends('layouts.screen')

@can('semiuser')
<meta content="0; url=/home" http-equiv="refresh">
@elsecan('user')
@section('content')
<td>
    <div class="box">
        <div class="header-box">
            <span class="profile">
                <div class="profile-picture">
                    <img src="{{url(Auth::user()->foto)}}" alt="A">
                </div>

                <p style="margin-left: 20px">
                <div id="data{{ $User->id }}">
                    <strong>Nama : {{ $User->name }}</strong>
                    </br>
                    <strong>Email : {{ $User->email }}</strong>
                    </br>
                    <strong>No.hp : {{ $User->nomor }}</strong>
                </div>
                <div hidden id="form{{ $User->id }}">
                    <form action="/user/profil/edit" method="post">
                        @csrf
                        <strong>Nama : <input required type="text" name="name" value="{{ $User->name }}"></strong>
                        <input hidden required type="text" name="id" value="{{ $User->id }}">
                        </br>
                        <strong>Email : <input required type="email" name="email" value="{{ $User->email }}"></strong>
                        </br>
                        <strong>No.hp : <input type="number" min="0" name="nomor" value="{{ $User->nomor }}" require></strong>
                        </br>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
                <div hidden id="formfoto{{ $User->id }}">
                    <form action="/user/profil/upload" enctype="multipart/form-data" method="post">
                        @csrf
                        <input required type="file" name="foto">
                        <input hidden required type="text" name="id" value="{{ $User->id }}">
                        </br>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
                </br>
                <script>
                    function fungsiSaya(data) {
                        var x = document.getElementById('show' + data);
                        var y = document.getElementById('form' + data);
                        if (x.style.display == "none") {
                            x.style.display = "block";
                            y.style.display = "none";
                        } else {
                            x.style.display = "none";
                            y.style.display = "block";
                        }
                    }

                    function tambahgambar() {
                        var x = document.getElementById('gambar');
                        if (x.style.display == "block") {
                            x.style.display = "none";
                        } else {
                            x.style.display = "block";
                        }
                    }
                    function editdataprofil(id) {
                        var x = document.getElementById('data' + id);
                        var y = document.getElementById('form' + id);
                        if (x.style.display == "none") {
                            x.style.display = "block";
                            y.style.display = "none";
                        } else {
                            x.style.display = "none";
                            y.style.display = "block";
                        }
                    }

                    function fotoupload(id) {
                        var x = document.getElementById('data' + id);
                        var y = document.getElementById('formfoto' + id);
                        if (x.style.display == "none") {
                            x.style.display = "block";
                            y.style.display = "none";
                        } else {
                            x.style.display = "none";
                            y.style.display = "block";
                        }
                    }
                </script>
                <div style="margin-left: 120px;">
                    @if($User->id == Auth::user()->id)
                    <a onclick="fotoupload('{{ $User->id }}')">Ubah Foto</a> &nbsp;&nbsp;&nbsp; <a onclick="editdataprofil('{{ $User->id }}')">Edit Data</a>
                    @endif
                </div>
                </p>
            </span>
        </div>
    </div>
    @if($User->id == Auth::user()->id)
    <div class="box">
        <div class="header-box">
            <span class="profile">
                <form action="/user/posting/tambah" method="post" enctype="multipart/form-data" class="form-tweet">
                    @csrf
                    <textarea name="caption" required="Ketik Pesan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" class="input-tweet" cols="56" placeholder="Apa yang kamu pikirkan ?"></textarea>
                    <br>
                    <a style="font-size: 10px;" onclick="tambahgambar()">Tambahkan Gambar</a>
                    <br>
                    <input hidden type="file" id="gambar" name="gambar" class="file-gambar">
                    <input hidden type="text" name="id_user" value="{{Auth::user()->id}}">
                    <br>
                    <button type="submit" class="btn-posting button">Kirim</button>
                </form>
            </span>
        </div>
    </div>
    @else
    @endif
    @foreach($posting as $row)
    <!-- feeds area -->
    <div class="box">
        <!-- header /box -->
        <div class="header-box">
            <li>
                <span class="profile">
                    <div class="profile-picture">
                        <img src="{{url($User->foto)}}" alt="A">
                    </div>
                    <span class="identity">
                        @if($row->id_user == Auth::user()->id)
                        <strong><a href="#" class="u">Anda</a></strong>
                        @else
                        @if($User->id == $row->id_user)
                        <strong><a href="#" class="u">{{$User->name}}</a></strong>
                        @else
                        @endif
                        @endif
                     
                    </span>
                    @if($row->id_user == Auth::user()->id)
                    <div style="font-size: 15px;margin-left: -90px;">
                        <a onclick="fungsiSaya('{{$row->id}}')">Edit</a>
                    </div>
                    &nbsp;
                    &nbsp;
                    <div style="font-size: 15px;">
                        <a href="/user/posting/hapus/{{ $row->id }}">Hapus</a>
                    </div>
                    @else
                    @endif

                </span>
            </li>
            <li></li>
        </div>
        <!-- show the post -->
        <div class="show-post">
            <!-- for text only -->
            <div id="show{{$row->id}}">
                <span id="" class="show-opini">
                    {{$row->caption}}
                </span>
                <!-- image post -->
                @if($row->gambar == 'kosong')
                @else
                <div id="" class="image-post">
                    <img src="{{url($row->gambar)}}" alt="A">
                </div>
                @endif
            </div>

            <div hidden id="form{{$row->id}}" class="box">
                <div class="header-box">
                    <span class="profile">
                        <form action="/user/posting/edit" method="post" class="form-tweet">
                            @csrf
                            <textarea name="caption" class="input-tweet" cols="56" placeholder="Apa yang kamu pikirkan ?">{{ $row->caption }}</textarea>
                            <br>
                            <input type="text" name="id" value="{{ $row->id }}" hidden>
                            <br>
                            <button type="submit" class="btn-posting button">Kirim</button>
                        </form>
                    </span>
                </div>
            </div>
        </div>
        <!-- public responses -->
        <div class="reactions">
            <!-- reaction -->
            <div class="gv-react">
                <li>

                    <a href="/user/komentar/{{$row->id}}">
                        <button class="button btn btn-responses">
                            <i class="icon-comment-alt">
                                @php

                                foreach($komentar as $komentars){
                                if($komentars['id_post']== $row['id'] ){
                                $nilai = $nilai + 1;
                                }
                                }
                                @endphp

                                {{ $nilai }} Komentar
                                @php
                                $nilai = 0;
                                @endphp
                            </i>
                        </button>
                    </a>
                </li>
            </div>
            <span class="post-date">{{$row->created_at}}</span>
        </div>
    </div>

    @endforeach

</td>
@endsection
@elsecan('admin')
@section('content')
<td>
    <div class="box">
        <div class="header-box">
            <span class="profile">
                <div class="profile-picture">
                    <img src="{{url(Auth::user()->foto)}}" alt="A">
                </div>

                <p style="margin-left: 20px">
                <div id="data{{ $User->id }}">
                    <strong>Nama : {{ $User->name }}</strong>
                    </br>
                    <strong>Email : {{ $User->email }}</strong>
                    </br>
                    <strong>No.hp : {{ $User->nomor }}</strong>
                </div>
                <div hidden id="form{{ $User->id }}">
                    <form action="/user/profil/edit" method="post">
                        @csrf
                        <strong>Nama : <input required type="text" name="name" value="{{ $User->name }}"></strong>
                        <input hidden required type="text" name="id" value="{{ $User->id }}">
                        </br>
                        <strong>Email : <input required type="email" name="email" value="{{ $User->email }}"></strong>
                        </br>
                        <strong>No.hp : <input type="number" min="0" name="nomor" value="{{ $User->nomor }}" require></strong>
                        </br>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
                <div hidden id="formfoto{{ $User->id }}">
                    <form action="/user/profil/upload" enctype="multipart/form-data" method="post">
                        @csrf
                        <input required type="file" name="foto">
                        <input hidden required type="text" name="id" value="{{ $User->id }}">
                        </br>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
                </br>
                <div style="margin-left: 120px;">
                    @if($User->id == Auth::user()->id)
                    <a onclick="fotoupload('{{ $User->id }}')">Ubah Foto</a> &nbsp;&nbsp;&nbsp; <a onclick="editdataprofil('{{ $User->id }}')">Edit Data</a>
                    @endif
                </div>
                </p>
            </span>

        </div>
    </div>
    <script>
        function fungsiSaya(data) {
            var x = document.getElementById('show' + data);
            var y = document.getElementById('form' + data);
            if (x.style.display == "none") {
                x.style.display = "block";
                y.style.display = "none";


            } else {
                x.style.display = "none";
                y.style.display = "block";

            }
        }

        function tambahgambar() {
            var x = document.getElementById('gambar');
            if (x.style.display == "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }

        }

        function editdataprofil(id) {
            var x = document.getElementById('data' + id);
            var y = document.getElementById('form' + id);
            if (x.style.display == "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }

        function fotoupload(id) {
            var x = document.getElementById('data' + id);
            var y = document.getElementById('formfoto' + id);
            if (x.style.display == "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }
    </script>
    @if($User->id == Auth::user()->id)
    <div class="box">
        <div class="header-box">
            <span class="profile">
                <form action="/user/posting/tambah" method="post" enctype="multipart/form-data" class="form-tweet">
                    @csrf
                    <textarea name="caption" required="Ketik Pesan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" class="input-tweet" cols="56" placeholder="Apa yang kamu pikirkan ?"></textarea>
                    <br>
                    <a style="font-size: 10px;" onclick="tambahgambar()">Tambahkan Gambar</a>
                    <br>
                    <input hidden type="file" id="gambar" name="gambar" class="file-gambar">
                    <input hidden type="text" name="id_user" value="{{Auth::user()->id}}">
                    <br>
                    <button type="submit" class="btn-posting button">Kirim</button>
                </form>
            </span>
        </div>
    </div>
    @else
    @endif
    @foreach($posting as $row)
    <!-- feeds area -->
    <div class="box">
        <!-- header /box -->
        <div class="header-box">
            <li>
                <span class="profile">
                    <div class="profile-picture">
                        <img src="{{url($User->foto)}}" alt="A">
                    </div>
                    <span class="identity">
                        @if($row->id_user == Auth::user()->id)
                        <strong><a href="#" class="u">Anda</a></strong>
                        @else
                        @if($User->id == $row->id_user)
                        <strong><a href="#" class="u">{{$User->name}}</a></strong>
                        @else
                        @endif
                        @endif
                        <!-- user (@) -->
                    </span>
                    @if($row->id_user == Auth::user()->id)
                    <div style="font-size: 15px;margin-left: -90px;">
                        <a onclick="fungsiSaya('{{$row->id}}')">Edit</a>
                    </div>
                    &nbsp;
                    &nbsp;
                    <div style="font-size: 15px;">
                        <a href="/user/posting/hapus/{{ $row->id }}">Hapus</a>
                    </div>
                    @else
                    @endif
                </span>
            </li>
            <li></li>
        </div>
        <!-- show the post -->
        <div class="show-post">
            <!-- for text only -->
            <div id="show{{$row->id}}">
                <span id="" class="show-opini">
                    {{$row->caption}}
                </span>
                <!-- image post -->
                @if($row->gambar == 'kosong')
                @else
                <div id="" class="image-post">
                    <img src="{{url($row->gambar)}}" alt="A">
                </div>
                @endif
            </div>

            <div hidden id="form{{$row->id}}" class="box">
                <div class="header-box">
                    <span class="profile">
                        <form action="/user/posting/edit" method="post" class="form-tweet">
                            @csrf
                            <textarea name="caption" class="input-tweet" cols="56" placeholder="Apa yang kamu pikirkan ?">{{ $row->caption }}</textarea>
                            <br>
                            <input type="text" name="id" value="{{ $row->id }}" hidden>
                            <br>
                            <button type="submit" class="btn-posting button">Kirim</button>
                        </form>
                    </span>
                </div>
            </div>
        </div>
        <!-- public responses -->
        <div class="reactions">
            <!-- reaction -->
            <div class="gv-react">
                <li>

                    <a href="/user/komentar/{{$row->id}}">
                        <button class="button btn btn-responses">
                            <i class="icon-comment-alt">
                                @php
                                foreach($komentar as $komentars){
                                if($komentars['id_post']== $row['id'] ){
                                $nilai = $nilai + 1;
                                }
                                }
                                @endphp

                                {{ $nilai }} Komentar
                                @php
                                $nilai = 0;
                                @endphp
                            </i>
                        </button>
                    </a>
                </li>
            </div>
            <span class="post-date">{{$row->created_at}}</span>
        </div>
    </div>
    @endforeach

</td>
@endsection
@else
@endcan