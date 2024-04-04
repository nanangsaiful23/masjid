<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masjid Nurul huda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ ('/css/main.css') }}">
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
    <div class="input-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">  
                    <div class="isi-data col-sm-7">
                        <div class="tombol">
                            @foreach($zakats as $zakat)
                                <button class="btn" onclick="kirimData('{{ $zakat->name }}', '{{ $zakat->type }}', '{{ $zakat->nominal }}')"> {{ $zakat->name }} </button>
                            @endforeach
                        </div>
                        <div class="form-data">
                            <div class="form-group">
                                <label>Nama Group</label>
                                <div>
                                    <select class="form-control col-sm-6 select2" onchange="changeNameGroup()" id="select-name-group">
                                        <option>Pilih nama group</option>
                                        @for($i = 0; $i < sizeof($names); $i++)
                                            <option value="{{ $names[$i] }}">{{ $names[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <label>Nama Individu</label>
                                <div>
                                    <select class="form-control col-sm-6 select2" onchange="changeName()" id="select-name">
                                        <option>Pilih nama</option>
                                        @foreach($muzakkis as $muzakki)
                                            <option value="{{ $muzakki->name }}">{{ $muzakki->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="tambah-orang">
                                    <div class="form-inline">
                                        <input type="text" class="form-control" id="nama-1" placeholder="fulan" required>
                                        <button class="btn" id="btn-1"
                                            onclick="event.preventDefault(); tambahOrang('2');"><i
                                                class="fa fa-plus-square"></i></button>
                                        <div id="hapusnama-1"></div>
                                    </div>
                                </div>
                                <label>Jenis</label>
                                <input type="text" class="form-control" id="jenis" placeholder="zakat">
                                <label>Jenis Pembayaran</label>
                                <input type="text" class="form-control" id="jenis_pembayaran" placeholder="Beras/Uang">
                                <label>Nominal</label>
                                <input type="text" class="form-control" id="nominal" placeholder="0"
                                    onkeyup="changeFormat()">
                            </div>
                            <input type="submit" class="btn" value="tambah"
                                onclick="event.preventDefault(); tambahDataTable()">
                        </div>
                    </div>
                    <div class="lihat-data col-sm-5">
                        <div class="tabel">
                            <form method="POST" action={{ route('transaksi') }}>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">nama</th>
                                            <th scope="col">jenis</th>
                                            <th scope="col">Jenis Pembayaran</th>
                                            <th scope="col">nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-table">
                                    </tbody>
                                </table>
                                {{ csrf_field() }}
                                <div style="text-align: right">
                                    <span>Total:</span><span id="total">-</span>
                                </div>
                                <button class="btn" type="submit" id="bayar">Bayar </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <img src="{{('/aset/fa-mosque-solid.png')}}" alt="" class="logo-footer">
        <h3>Masjid Nurul Huda Ngablak</h3>
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
    <script>
        $(document).ready (function (){
            $('.select2').select2();
        }); 
        var index_before = 1;
        var idx=1;
        var count=1;
        var totaluang=0;
        var totalberas=0;

        function changeName()
        {
            document.getElementById('nama-' + idx).value = document.getElementById('select-name').value;

          // $.ajax({
          //   url: "{!! url('/getGroup/') !!}/" + $("#select-name").val(),
          //   success: function(result){
          //     var groups = result.groups;

          //     for (var i = 0; i < groups.length; i++) 
          //     {
          //         idx += 1;

          //        $("#tambah-orang").prepend('<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" value="' + groups[i].name + '"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');"><i class="fa fa-plus-square"></i></button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>');
          //       document.getElementById("btn-"+(parseInt(idx)-1)).remove();
          //       document.getElementById("hapusnama-"+(parseInt(idx)-1)).innerHTML='<button class="btn" onclick="event.preventDefault(); hapusOrang('+(parseInt(idx)-1)+');"><i class="fa fa-times-circle"></i></button>';

          //     }
          // },
          //   error: function(){
          //   }
          // });
        }

        function changeNameGroup()
        {
            var names = document.getElementById('select-name-group').value;
            var name = names.split(", ");

            document.getElementById('nama-' + idx).value = name[0];
            for (i = 1; i < name.length - 1; i++) 
            {
                idx += 1;

                 $("#tambah-orang").prepend('<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" value="' + name[i] + '"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');"><i class="fa fa-plus-square"></i></button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>');
                document.getElementById("btn-"+(parseInt(idx)-1)).remove();
                document.getElementById("hapusnama-"+(parseInt(idx)-1)).innerHTML='<button class="btn" onclick="event.preventDefault(); hapusOrang('+(parseInt(idx)-1)+');"><i class="fa fa-times-circle"></i></button>';
            }
        }

        function kirimData(jenis,JenisBayar,nominal) {
            document.getElementById("jenis").value=jenis;
            document.getElementById("jenis_pembayaran").value=JenisBayar;
            document.getElementById("nominal").value=nominal;
        }
        function tambahOrang() {
            idx+=1;
            // ganti button
            document.getElementById("btn-"+(parseInt(idx)-1)).remove();
            document.getElementById("hapusnama-"+(parseInt(idx)-1)).innerHTML='<button class="btn" onclick="event.preventDefault(); hapusOrang('+(parseInt(idx)-1)+');"><i class="fa fa-times-circle"></i></button>';

            $("#tambah-orang").prepend('<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" placeholder="fulan"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');"><i class="fa fa-plus-square"></i></button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>');

        }
        function hapusOrang(idn)
        {
            document.getElementById("hapusnama-"+(parseInt(idn))).remove();
            document.getElementById("nama-"+(parseInt(idn))).remove();
        }
        function changeFormat() {
            document.getElementById("nominal").value=formatNumber(document.getElementById("nominal").value);
        }
        function formatNumber(num)
        {
                num=  num.toString().replace(/,/g,'');
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        function tambahDataTable() {
            var result = "";
            idx+=1;
            index=index_before;
            komplet=true;
            temptcount=count;
            temptotaluang=totaluang;
            temptotalberas=totalberas;
            while (index < idx) {
                if(document.getElementById("nama-"+index)!= null ){
                    if (document.getElementById("nama-"+index).value!="" && document.getElementById("jenis").value!="" && document.getElementById("nominal").value!="") {
                        result += "<tr><th scope='row'>"+count+"</th><td>"+document.getElementById("nama-"+index).value+"</td><td>"+document.getElementById("jenis").value+"</td><td>"+document.getElementById("jenis_pembayaran").value+"</td><td style='text-align:right;'>"+formatNumber(document.getElementById("nominal").value)+"</td><input type='hidden' value='"+document.getElementById("nama-"+index).value+"' name='nama[]'><input type='hidden' value='"+document.getElementById("jenis").value+"' name='jenis[]'><input type='hidden' value='"+document.getElementById("jenis_pembayaran").value+"' name='jenis_pembayaran[]'><input type='hidden' value='"+parseFloat(document.getElementById("nominal").value.replace(/,/g,''))+"' name='nominal[]'></tr>";
                        count++
                        console.log(document.getElementById("jenis_pembayaran"));
                        if(document.getElementById("jenis_pembayaran").value=="Uang"){
                            totaluang+=parseFloat(document.getElementById("nominal").value.replace(/,/g,''))
                        }else if(document.getElementById("jenis_pembayaran").value=="Beras"){
                            console.log("ini masuk")
                            totalberas+=parseFloat(document.getElementById("nominal").value.replace(/,/g,''))
                        }
                    }else{
                        komplet=false;
                        count=temptcount;
                        totaluang=temptotaluang;
                        totalberas=temptotalberas;
                    }
                }
                index++;
            }
            if(komplet){
                $("#data-table").append(result);
                document.getElementById("tambah-orang").innerHTML='<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" placeholder="fulan"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');"><i class="fa fa-plus-square"></i></button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>';
                document.getElementById("jenis").value="";
                document.getElementById("nominal").value="";
                if ((totaluang!=0) && (totalberas!=0)) {
                    document.getElementById("total").innerHTML="<span id='total'>Uang Rp"+formatNumber(totaluang)+" <br>Beras "+formatNumber(totalberas)+"Kg </span><input type='hidden' value='" + totaluang + "' name='total_uang'><input type='hidden' value='" + totalberas + "' name='total_beras'>";
                }else if(totaluang!=0){
                    document.getElementById("total").innerHTML="<span id='total'>Rp"+formatNumber(totaluang)+"</span><input type='hidden' value='" + totaluang + "' name='total_uang'><input type='hidden' value='" + totalberas + "' name='total_beras'>";
                }else if(totalberas!=0){
                    document.getElementById("total").innerHTML="<span id='total'>"+formatNumber(totalberas)+" Kg</span><input type='hidden' value='" + totaluang + "' name='total_uang'><input type='hidden' value='" + totalberas + "' name='total_beras'>";
                }
                index_before=idx;
            }else{
                idx-=1;
                alert("silahkan lengkapi data");
            }
        }

    </script>
</body>

</html>
