<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Masjid Nurul huda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='print,screen' href="{{ ('/css/print.css') }}">
    <meta http-equiv="refresh" content="10;url={{ url('/') }}" />
    <!-- <link rel="stylesheet" href="bootstrap-4.0.0/dist/css/bootstrap.min.css"> -->
    <!-- <script src='main.js'></script> -->
</head>

<body>
    <header>
        <div class="header-logo">
            <img src="{{('/aset/logo.png')}}" alt="" class="logo">
        </div>
    </header>
    <div class="print-data ">
        <div class="tabel">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nama</th>
                        <th scope="col">jenis</th>
                        <th scope="col">jenis pembayaran</th>
                        <th scope="col">nominal</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    @php
                    $j=1
                    @endphp
                    @foreach ($transactions as $transaction)
                    <tr>
                        <th scope="row">{{$j++}}</th>
                        <td>{{$transaction->nama}}</td>
                        <td>{{$transaction->jenis}}</td>
                        <td style="text-align: center">{{$transaction->jenis_pembayaran}}</td>
                        @if ($transaction->jenis_pembayaran=="Uang")
                        <td style="text-align: right;">{{number_format($transaction->nominal,0,',','.')}}</td>
                        @elseif($transaction->jenis_pembayaran=="Beras")
                        <td style="text-align: right;">{{number_format($transaction->nominal,1,',','.')}}</td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="totalnota" >
            <span>Total :</span><span id="totalbayar">
                @if ($totaluang!=0 && $totalberas!=0)
                    Uang  Rp{{$totaluang}} <br> Beras {{$totalberas}} Kg
                @elseif($totaluang!=0)
                    Uang  Rp{{$totaluang}}
                @else
                Beras {{$totalberas}} Kg
                @endif
                </span>
                <br>
                <br>
                <br>
        </div>
    </div>
    <footer>
        <br>
        <span>Masjid Nurul Huda Ngablak</span>
        <br>
        <span>Keberkahan di setiap transaksi</span>
    </footer>
    <div>
        <span><br><br></span>
    </div>
    <header>
        <div class="header-logo">
            <img src="{{('/aset/logo.png')}}" alt="" class="logo">
        </div>
    </header>
    <div class="print-data ">
        <div class="tabel">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nama</th>
                        <th scope="col">jenis</th>
                        <th scope="col">jenis pembayaran</th>
                        <th scope="col">nominal</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    @php
                    $j=1
                    @endphp
                    @foreach ($transactions as $transaction)
                    <tr>
                        <th scope="row">{{$j++}}</th>
                        <td>{{$transaction->nama}}</td>
                        <td>{{$transaction->jenis}}</td>
                        <td style="text-align: center">{{$transaction->jenis_pembayaran}}</td>
                        @if ($transaction->jenis_pembayaran=="Uang")
                        <td style="text-align: right;">{{number_format($transaction->nominal,0,',','.')}}</td>
                        @elseif($transaction->jenis_pembayaran=="Beras")
                        <td style="text-align: right;">{{number_format($transaction->nominal,1,',','.')}}</td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="totalnota" >
            <span>Total :</span><span id="totalbayar">
                @if ($totaluang!=0 && $totalberas!=0)
                    Uang  Rp{{$totaluang}} <br> Beras {{$totalberas}} Kg
                @elseif($totaluang!=0)
                    Uang  Rp{{$totaluang}}
                @else
                Beras {{$totalberas}} Kg
                @endif
                </span>
                <br>
                <br>
                <br>
        </div>
    </div>
    <footer>
        <br>
        <span>Masjid Nurul Huda Ngablak</span>
        <br>
        <span>Keberkahan di setiap transaksi</span>
    </footer>
    <script src="{{('/jquery-3.4.1.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            window.print();
        })
    </script>
</body>

</html>
