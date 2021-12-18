@extends('layouts.screen')

@can('admin')
@section('content')
<td>
    <div class="w3-container">
        <h2>Data User</h2>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-light-grey">
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Option</th>
                </tr>
            </thead>
            @foreach($user as $row)
            <tr>
                <td style="text-align: center ;">{{$row->id}}</td>
                <td style="text-align: center;">{{$row->name}}</td>
                <td style="text-align: center;">{{$row->email}}</td>
                <td style="text-align: center;">
                   
                    <a href="/admin/manajemenuser/hapus/{{$row->id}}"> <button class="w3-button w3-tiny w3-ripple w3-red">Hapus</button></a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</td>
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

    function tambah() {
        var x = document.getElementById('tambah');
        if (x.style.display == "block") {
            x.style.display = "none";


        } else {
            x.style.display = "block";

        }
    }
</script>
@endsection
@elsecan('semiuser')
<meta content="0; url=/home" http-equiv="refresh">
@elsecan('user')
<meta content="0; url=/home" http-equiv="refresh">
@else
@endcan