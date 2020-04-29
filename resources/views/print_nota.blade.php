<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Masjid Nurul huda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='print,screen' href="{{ ('/css/print.css') }}">
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
                        <td>{{number_format($transaction->nominal,0,',','.')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <span>Total :</span><span id="totalbayar">Rp{{$totalbayar}}</span>
        <br>
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
            // setTimeout(function () { window.close(); }, 100);
            window.location.href = "http://localhost:8000/";
            // window.location = ;
        })
    </script>
</body>

</html>
