<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/gif" href="{{asset('aset/nabawi-mosque.png')}}" />
    <title>{{ config('app.name') }}</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href="{{asset('/css/main.css') }}">
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('assets/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dist/css/skins/_all-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/morris.js/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600">
</head>

<style type="text/css">
    body, h2, h3, h5
    {
        font-family: 'Barlow';
    }

    .btn
    {
        height: 40px;
/*        width: 120px;*/
        background: #B3C8CF;
/*        font-size: 18px;*/
/*        text-transform: uppercase;*/
    }

    .header-right > a 
    {
         font-size: 18px; 
         text-transform: uppercase;
    }

    a, a:hover
    {
        color: black;
    }
</style>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="header-logo col-sm-1">
                    <img src="{{asset('/aset/nabawi-mosque.png')}}" alt="" class="logo" style="width: 80px;">
                </div>
                <div class="col-sm-4" style="margin-top: 20px; margin-left: -25px;">
                    <h2>{{ config('app.name') }}</h2>
                </div>
                <div class="header-right col-sm-offset-3 col-sm-4" style="margin-top: 40px; margin-right: 0px;">
                      <a href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn" style="float: right; margin-left: 10px;"><i class="fa fa-power-off" aria-hidden="true" style="color: red"></i></a>

                      <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                    <a href="{{ url('/admin/laporan/' . date('Y-m-d') . '/' . date('Y-m-d') . '/20') }}" class="btn" style="float: right;  margin-left: 10px;@if(Request::segment(2) == 'laporan') background: #77B0AA; color: white;@endif">LAPORAN</a>
                    <a href="{{ url('/admin') }}" class="btn" style="float: right; @if(Request::segment(2) == '') background: #77B0AA; color: white;@endif">TRANSAKSI</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container" style="margin-top: 30px">
        <div class="row">
            <div class="col-sm-12">
                <!-- <form action="/importMuzakki" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <b>File Excel</b><br/>
                        <input type="file" name="xlsx">
                    </div>

                    <input type="submit" value="Upload" class="btn btn-primary">
                </form> -->
              <div class="col-sm-2">
                Jumlah data<br>
                <select id="show" onchange="advanceSearch()" class="form-control">
                    <option value="10" @if($pagination == "10") selected="selected" @endif>10</option>
                    <option value="20" @if($pagination == "20") selected="selected" @endif>20</option>
                    <option value="all" @if($pagination == "all") selected="selected" @endif>Semua</option>
                </select>
              </div>
              <div class="col-sm-2"> 
                Tanggal awal<br>
                  <div class="input-group date">
                    <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{ $start_date }}" onchange="changeDate()">
                  </div>
              </div>
              <div class="col-sm-4">
                Tanggal akhir<br>
                  <div class="input-group date">
                    <input type="text" class="form-control pull-right" id="datepicker2" name="end_date" value="{{ $end_date }}" onchange="changeDate()">
                  </div>
              </div>
            </div>
            <div class="laporan">
                <div class="col-sm-12">
                    <table class=" table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 20%">Jenis Zakat</th>
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
                    <a href="{{ url('/admin/transaction/export_excel/' . $start_date . '/' . $end_date) }}" class="btn">Download Data Muzakki</a>
                    <a href="{{ url('/admin/export_sumdata/' . $start_date . '/' . $end_date) }}" class="btn">Download Ringkasan Zakat</a>
                    
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
                                            @if($detail->zakat->type == 'Beras')
                                                <li>{{ ucwords($detail->muzakki->name) . ' -> ' . $detail->nominal }} kg</li>
                                            @else
                                                <li>{{ ucwords($detail->muzakki->name) . ' -> Rp' . number_format($detail->nominal,2,'.',',') }}</li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </td>
                                <td><a href="{{ url('/admin/print/' . $transaction->id) }}" class="btn" target="_blank()">Print</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <img src="{{asset('/aset/nabawi-mosque.png')}}" alt="" class="logo-footer" style="display: inline-block; width: 80px;">
                <div style="display: inline-block;">
                    <h3>{{ config('app.name') }}</h3>
                    <h5>Panitia Zakat Fitrah Ramadhan 1455 H</h5>
                </div> 
            </div>
        </div>
    </footer>

    <script src="{{asset('assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('assets/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="{{asset('assets/bower_components/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/bower_components/morris.js/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('assets/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('assets/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script src="{{asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('assets/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    
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
      window.location = window.location.origin + '/admin/laporan/' + $("#datepicker").val() + '/' + $("#datepicker2").val() + '/{{ $pagination }}';
    }

    function advanceSearch()
    {
      var show        = $('#show').val();      
      window.location = window.location.origin + '/admin/laporan/{{ $start_date }}/{{ $end_date }}/' + show;
    }
  </script>
</body>
</html>
