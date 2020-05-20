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
                        <th>#</th>
                        <th>Jenis</th>
                        <th>Jeni Pembayaran</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                    $i=1;
                    $totaluang=0;
                    $totalberas=0;
                    @endphp
                    @foreach ($ringkasan as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->jenis}} </td>
                        <td>{{$item->jenis_pembayaran}}</td>
                        @if ($item->jenis_pembayaran=="Uang")
                        <td style="text-align: right">{{number_format( $item->total,0,",",".")}}</td>
                        @php
                        $totaluang+=$item->total;
                        @endphp
                        @elseif($item->jenis_pembayaran=="Beras")
                        <td style="text-align: right">{{number_format( $item->total,1,",",".")}}</td>
                        @php
                        $totalberas+=$item->total;
                        @endphp
                        @endif
                        {{-- @php
                            if ($item->jenis_pembayaran=="Uang") {

                                $totaluang+=$item->total;
                            }else if($item->jenis_pembayaran=="Beras"){
                                $totalberas+=$item->total;
                            }
                        @endphp --}}
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Total Pemasukan Uang</td>
                        <td style="text-align: right">Rp{{number_format( $totaluang,0,",",".")}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Total Pemasukan Beras</td>
                        <td style="text-align: right">{{number_format( $totalberas,1,",",".")}} Kg</td>
                    </tr>
                </tbody>

            </table>
            <a href="/transaction/export_excel" class="btn">Download data muzakki</a>
            <a href="/export_sumdata" class="btn">Download ringkasan data muzakki</a>
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
