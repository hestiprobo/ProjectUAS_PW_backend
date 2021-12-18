@extends('layouts.screen')
@can('admin')
@section('content')
<td>
    @foreach($data as $row)
    <!-- feeds area -->
    <div class="box">
        <!-- header /box -->
        <div class="header-box">
            <li>
                <!-- profile and name -->
                <span class="profile">
                    <div class="profile-picture">
                        <img src="{{url($row->foto)}}" alt="A">
                    </div>

                    @if($row->id_user == Auth::user()->id)
                    <strong><a href="#" class="u">Anda</a></strong>
                    @else
                    @foreach($user as $userdata)
                    @if($userdata->id == $row->id_user)
                    <strong><a href="#" class="u">{{$userdata->name}}</a></strong>
                    @else
                    @endif
                    @endforeach
                    @endif

                </span>
            </li>
            <li></li>
        </div>
        <!-- show the post -->
        <div class="show-post">
            <!-- for text only -->
            <span class="show-opini">
                {{$row->caption}}
            </span>
            <!-- image post -->
            <div class="image-post">
                <img src="{{url($row->foto)}}" alt="A">
            </div>
        </div>
        <!-- public responses -->
        <div class="reactions">
            <!-- reaction -->
            <span class="post-date">{{$row->created_at}}</span>
        </div>
    </div>

    @endforeach
</td>
<td>
    <!-- For follow -->
    <div class="recoms">
        <form name="form1" action="/admin/marketplaces/komentar/tambah" method="post">
            @csrf
            <textarea name="komentar" required="Ketik Pesan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" class="input-tweet" cols="45" placeholder="Tulis Komentar....."></textarea>
            <input hidden type="text" name="id_market" value="{{ $id_market }}">
            <input hidden type="text" name="id_user" value="{{ Auth::user()->id }}">
            <br>
            <button type="submit" class="btn-posting button">Kirim</button>
        </form>
        <h5>Komentar</h5>
        <!-- list if didn't follow -->
        <li>
            <div style="border: 1px solid #eee;padding: 10px 10px;overflow: hidden;margin-bottom: 10px;background-color: #fff;width: 400px;">
                <!-- start -->
                <div style="margin-bottom: 22px;" class="header-box">
                    @foreach($komentar as $datakomentar)
                    <span class="profile">
                        <span class="identity">
                            @foreach($user as $datauser)
                            @if($datakomentar->id_user == $datauser->id)
                            <strong><a href="#" class="u">{{$datauser->name}}</a></strong>
                            <a style="font-size: 10px;" onclick="fungsiSaya('target{{ $datakomentar->id}}')"><i>Edit</i></a>
                            &nbsp;
                            <a style="font-size: 10px;" href="/admin/marketplaces/komentar/hapus/{{ $datakomentar->id }}"><i>Hapus</i></a>
                            
                            @endif
                            @endforeach
                            <div class="show-post">
                                <span id="komentartarget{{ $datakomentar->id }}" class="show-opini">
                                    {{$datakomentar->komentar}}
                                    <i>
                                        <p style="font-size: 10px;">{{ $datakomentar->created_at }}</p>
                                    </i>
                                </span>
                                <div hidden id="target{{ $datakomentar->id }}">
                                    <form action="/admin/marketplaces/komentar/edit" method="post">
                                        @csrf
                                        <input type="text" name="id" value="{{ $datakomentar->id }}" hidden>
                                        <input type="text" name="id_market" value="{{ $id_market }}" hidden>
                                        <textarea name="komentar" required="Ketik Pesan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" class="input-tweet" cols="45" placeholder="Tulis Komentar.....">{{$datakomentar->komentar}}</textarea>
                                        <button type="submit">Edit</button>
                                    </form>
                                </div>
                            </div>
                        </span>
                    </span>
                </div>
                @endforeach
                <!-- end -->
                <script>
                    function fungsiSaya(data) {
                        var x = document.getElementById(data);
                        var y = document.getElementById('komentar' + data);
                        if (x.style.display == "block") {
                            x.style.display = "none";
                            y.style.display = "block";
                        } else {
                            x.style.display = "block";
                            y.style.display = "none";
                        }
                    }
                </script>
            </div>
        </li>
    </div>
</td>
@endsection
@else
<meta content="0; url=/home" http-equiv="refresh">
@endcan