<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sosial Media</title>
    <link rel="stylesheet" type="text/css" href="{{('/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/css/icon/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/css/w3.css')}}">
    <script src="{{url ('/css/script/jquery.js')}}" type="text/javascript"></script>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>Sosial Media</th>
                <th>

                </th>
                <th>
                    <div class="menu">
                        <div class="menu-top">
                            <span class="identity">
                                <strong><a href="/user/profil/{{Auth::user()->id}}">{{Auth::user()->name}}</a></strong>
                            </span>
                            <div class="profile">
                                <div class="profile-picture">
                                    <img src="{{url(Auth::user()->foto)}}" alt="A">
                                </div>
                            </div>
                        </div>
                        </li>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @can('admin')
                    <li><a href="/admin/beranda"><strong>Beranda Admin</strong></a></li>
                    <li><a href="/admin/marketplaces"><strong>Marketplaces Admin</strong></a></li>
                    <li><a href="/admin/manajemenuser"><strong>Manajemen User</strong></a></li>
                    @elsecan('user')
                    <li><strong><a href="/home">Beranda</a></strong></li>
                    <li><a href="/user/marketplaces"><strong>Marketplace</strong></a></li>
                    @endcan
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </li>
                </td>
                @yield('content')
                <td>
                    <!-- For follow -->
                    
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>