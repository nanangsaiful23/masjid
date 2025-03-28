<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Masjid Nurul huda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='print,screen' href="{{ asset('/css/print.css') }}">
    <meta http-equiv="refresh" content="10;url={{ url('/admin') }}" />
    <!-- <link rel="stylesheet" href="bootstrap-4.0.0/dist/css/bootstrap.min.css"> -->
    <!-- <script src='main.js'></script> -->
</head>

<body>
    <header>
        <div class="header-logo">
            <img src="{{ asset('/aset/logo.png')}}" alt="" class="logo">
        </div>
    </header>
    <div class="print-data ">
        <div class="tabel">
            <table>
                <tbody id="data-table">
                    @php
                        $j=1
                    @endphp
                    @foreach ($transaction->TransactionDetail as $detail)
                    <tr>
                        <td style="font-size: 12px" scope="row">{{ $j++ }}.</td>
                        <td style="font-size: 12px">{{ strtoupper($detail->muzakki->name) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{$detail->zakat->name}}</td>
                        @if ($detail->zakat->type=="Uang")
                        <td style="text-align: right;">Rp {{number_format($detail->nominal,0,',','.')}}</td>
                        @elseif($detail->zakat->type=="Beras")
                        <td style="text-align: right;">{{number_format($detail->nominal,1,',','.')}} kg</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="totalnota" >
            <span>Total :<br></span><span id="totalbayar">
                @if($totaluang!=0 && $totalberas!=0)
                    Uang Rp{{$totaluang}} <br> Beras {{$totalberas}} Kg
                @elseif($totaluang!=0)
                    Uang Rp{{$totaluang}}
                @else
                    Beras {{$totalberas}} Kg
                @endif
                </span>
                <br><br>
                {{ date('d F Y H:i:s', strtotime($transaction->created_at)) }} - ID: {{ $transaction->id }}
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
            <img src="{{ asset('/aset/logo.png')}}" alt="" class="logo">
        </div>
    </header>
    <div class="print-data ">
        <div class="tabel">
            <table>
                <tbody id="data-table">
                    @php
                    $j=1
                    @endphp
                    @foreach ($transaction->TransactionDetail as $detail)
                    <tr>
                        <td style="font-size: 12px" scope="row">{{ $j++ }}.</td>
                        <td style="font-size: 12px">{{ strtoupper($detail->muzakki->name) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{$detail->zakat->name}}</td>
                        @if ($detail->zakat->type=="Uang")
                        <td style="text-align: right;">Rp {{number_format($detail->nominal,0,',','.')}}</td>
                        @elseif($detail->zakat->type=="Beras")
                        <td style="text-align: right;">{{number_format($detail->nominal,1,',','.')}} kg</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="totalnota" >
            <span>Total :<br></span><span id="totalbayar">
                @if($totaluang!=0 && $totalberas!=0)
                    Uang  Rp{{$totaluang}} <br> Beras {{$totalberas}} Kg
                @elseif($totaluang!=0)
                    Uang  Rp{{$totaluang}}
                @else
                    Beras {{$totalberas}} Kg
                @endif
                </span>
                <br><br>
                {{ date('d F Y H:i:s', strtotime($transaction->created_at)) }} - ID: {{ $transaction->id }}
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
    <script src="{{ asset('/jquery-3.4.1.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            window.print();
        })
    </script>
</body>

</html>
