<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masjid Nurul huda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ ('/css/main.css') }}">
    <link rel="stylesheet" href="{{('/bootstrap-4.0.0/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{('/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!-- <link rel="stylesheet" href="bootstrap-4.0.0/dist/css/bootstrap.min.css"> -->
    <!-- <script src='main.js'></script> -->
</head>

<body>
    <header>
        <div class="row">
            <div class="header-logo col-sm-3">
                <img src="{{('/aset/logo.png')}}" alt="" class="logo">
            </div>
            <div class="header-right offset-6 col-sm-3 ">
                <a href="{{ url('') }}" class="btn btn-header">Transaksi</a>
                <a href="{{route('laporan')}}" class="btn active">Laporan</a>
            </div>
        </div>
    </header>
    <div class="laporan">
        <div class="row col-sm-12">
            <table class=" table table-bordered">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Jenis</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>

                    @php
                    $i=1;
                    $totalpemasukan=0;
                    @endphp
                    @foreach ($ringkasan as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->jenis}} </td>
                        <td>{{number_format( $item->total,0,",",".")}}</td>
                        @php
                            $totalpemasukan+=$item->total
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">Total Pemasukan</td>
                        <td>{{number_format( $totalpemasukan,0,",",".")}}</td>
                    </tr>
                </tbody>

            </table>
            <a href="/transaction/export_excel" class="btn btn-primary">Export data muzakki</a>
        </div>

    </div>
    <footer>
        <img src="{{('/aset/fa-mosque-solid.png')}}" alt="" class="logo-footer">
        <h3>Masjid Nurul Huda Ngablak</h3>
    </footer>
    <script src="{{('/jquery-3.4.1.min.js')}}"></script>
    <script>
    </script>
</body>

</html>
