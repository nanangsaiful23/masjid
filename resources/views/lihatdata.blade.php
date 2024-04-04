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
    <link rel="stylesheet" href="{{('/bootstrap-4.0.0/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{('/bootstrap-4.0.0/bootstrap-daterangepicker/daterangepicker.css')}}">
</head>

<body>
    <header>
        <div class="row">
            <div class="header-logo col-sm-3">
                <img src="{{('/aset/logo.png')}}" alt="" class="logo">
            </div>
            <div class="header-right offset-6 col-sm-3">
                <a href="{{ url('') }}" class="btn active">Transaksi</a>
                <a href="{{url('laporan/' . date('Y-m-d') . '/' . date('Y-m-d') . '/20') }}" class="btn active">Laporan</a>
            </div>
        </div>
    </header>
    <div class="col-sm-12 row">
        <!-- <form action="/importMuzakki" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <b>File Excel</b><br/>
                <input type="file" name="xlsx">
            </div>

            <input type="submit" value="Upload" class="btn btn-primary">
        </form> -->
      <div class="col-sm-4">
        Jumlah data<br>
        <select id="show" onchange="advanceSearch()" class="form-control col-sm-4">
            <option value="10" @if($pagination == "10") selected="selected" @endif>10</option>
            <option value="20" @if($pagination == "20") selected="selected" @endif>20</option>
            <option value="all" @if($pagination == "all") selected="selected" @endif>Semua</option>
        </select>
      </div>
      <div class="col-sm-4"> 
        Tanggal awal
        <div class="col-md-6">
          <div class="input-group date">
            <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{ $start_date }}" onchange="changeDate()">
          </div>
      </div>
      </div>
      <div class="col-sm-4">
        Tanggal akhir
        <div class="col-md-6">
          <div class="input-group date">
            <input type="text" class="form-control pull-right" id="datepicker2" name="end_date" value="{{ $end_date }}" onchange="changeDate()">
          </div>
        </div>
      </div>
    </div>
    <div class="laporan">
        <div class="row col-sm-12">
            <table class=" table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Zakat</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                        $totaluang=0;
                        $totalberas=0;
                    @endphp
                    @foreach($zakats as $zakat)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $zakat->name }}</td>
                        <td>@if($zakat->type == 'Uang') 
                                Rp{{ number_format($zakat->nominal,0,",",".") }}
                            @else
                                {{ number_format($zakat->nominal,1,",",".") }} kg
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="/transaction/export_excel/{{$start_date}}/{{$end_date}}" class="btn">Download data muzakki</a>
            <a href="/export_sumdata/{{$start_date}}/{{$end_date}}" class="btn">Download ringkasan zakat</a>
            <table class=" table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Total Pembayaran Beras</th>
                        <th>Total Pembayaran Uang</th>
                        <th>Detail</th>
                        <th>Print</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ date('d F Y H:i:s', strtotime($transaction->created_at)) }}</td>
                        <td>{{ number_format($transaction->total_rice,1,",",".") }} kg</td>
                        <td>Rp{{ number_format($transaction->total_money,0,",",".") }}</td>
                        <td>
                            <ol>                        
                                @foreach($transaction->TransactionDetail as $detail)
                                    <li>{{ $detail->muzakki->name . '->' . $detail->nominal }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td><a href="/print/{{ $transaction->id }}">Print</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <img src="{{('/aset/fa-mosque-solid.png')}}" alt="" class="logo-footer">
        <h3>Masjid Nurul Huda Ngablak</h3>
    </footer>
    <script src="{{('/jquery-3.4.1.min.js')}}"></script>
    <script src="{{('/bootstrap-4.0.0/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script src="{{('/bootstrap-4.0.0/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    
  <script type="text/javascript">
    $(document).ready(function(){
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })

      $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })
    });

    function changeDate()
    {
      window.location = window.location.origin + '/laporan/' + $("#datepicker").val() + '/' + $("#datepicker2").val() + '/{{ $pagination }}';
    }

    function advanceSearch()
    {
      var show        = $('#show').val();      
      window.location = window.location.origin + '/laporan/{{ $start_date }}/{{ $end_date }}/' + show;
    }
  </script>
</body>
</html>
