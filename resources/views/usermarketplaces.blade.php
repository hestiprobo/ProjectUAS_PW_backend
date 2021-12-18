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
                <form action="/user/marketplaces/tambah" method="post" enctype="multipart/form-data" class="form-tweet">
                    @csrf
                    <input oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" type="text" name="title" required placeholder="Masukkan Judul....">
                    <input oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" type="number" min="1" name="harga" required placeholder="Masukkan Harga....">
                    <textarea name="deskripsi" required="Ketik Pesan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" class="input-tweet" cols="54" placeholder="Masukkan Deskripsi...."></textarea>
                    <br>
                    <a style="font-size: 10px;" onclick="tambahgambar()">Tambahkan Gambar</a>
                    <br>
                    <input hidden type="file" id="gambar" name="foto" class="file-gambar">
                    <input hidden type="text" name="id_user" value="{{Auth::user()->id}}">
                    <br>
                    <button type="submit" class="btn-posting button">Kirim</button>
                </form>
            </span>
        </div>
    </div>
    @foreach($posting as $row)
    <!-- feeds area -->
    <div class="box">
        <!-- header /box -->
        <div class="header-box">
            <li>
                <!-- profile and name -->
                <span class="profile">
                    <div class="profile-picture">
                        @foreach($User as $datauser)
                        @if($row->id_user == $datauser->id)
                            <img src="{{url($datauser->foto)}}" alt="A">
                        @else
                        @endif
                        @endforeach
                    </div>
                    <span class="identity">
                        @if($row->id_user == Auth::user()->id)
                        <strong><a href="#" class="u">Anda</a></strong>
                        @else
                        @foreach($User as $userdata)
                        @if($userdata->id == $row->id_user)
                        <strong><a href="#" class="u">{{$userdata->name}}</a></strong>
                        @else
                        @endif
                        @endforeach
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
                        <a href="/user/marketplaces/hapus/{{ $row->id }}">Hapus</a>
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
                    <strong>{{$row->title}} Rp. {{ $row->harga }}</strong>
                </span>
                <br>
                <span id="" class="show-opini">
                    {{$row->deskripsi}}
                </span>
                <!-- image post -->
                @if($row->foto == 'kosong')
                @else
                <div id="" class="image-post">
                    <img src="{{url($row->foto)}}" alt="A">
                </div>
                @endif
            </div>
            <div hidden id="form{{$row->id}}" class="box">
                <div class="header-box">
                    <span class="profile">
                        <form action="/user/marketplaces/edit" method="post" class="form-tweet">
                            @csrf
                            <input type="text" required name="title" value="{{$row->title}}">
                            <input type="number" min="0" required name="harga" value="{{$row->harga}}">
                            <textarea name="deskripsi" class="input-tweet" cols="56" placeholder="Apa yang kamu pikirkan ?">{{ $row->deskripsi }}</textarea>
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
                    <a href="/user/marketplaces/komentar/{{$row->id}}">
                        <button class="button btn btn-responses">
                            <i class="icon-comment-alt">
                                @php
                                    foreach($komentar as $komentars){
                                        if($komentars['id_market']== $row['id'] ){
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
    </script>
    @endforeach
</td>
@endsection
@else
@endcan