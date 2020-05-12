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
            <div class="header-right offset-6 col-sm-3">
                <a href="{{ url('') }}" class="btn active">Transaksi</a>
                <a href="{{route('laporan')}}" class="btn btn-header">Laporan</a>
            </div>
        </div>
    </header>
    <div class="input-data">
        <div class="container">
            <div class="row">
                <div class="isi-data col-sm-7 col-7">
                    <div class="tombol">
                        <button class="btn" onclick="kirimData('Zakat Fitrah','Uang','25,000')"> Zakat Fitrah
                            Uang</button>
                        <button class="btn" onclick="kirimData('Zakat Fitrah','Beras','2.5')"> Zakat Fitrah
                            Beras</button>
                        <button class="btn" onclick="kirimData('Zakat Mal','Uang','')"> Zakat Mal</button>
                        <button class="btn" onclick="kirimData('Fidyah','Uang','')"> Fidyah</button>
                        <button class="btn" onclick="kirimData('Infaq','Uang','')"> infaq</button>
                        <button class="btn"> lain</button>
                    </div>
                    <div class="form-data">
                        <div class="form-group">
                            <label>Nama</label>
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
                <div class="lihat-data col-sm-5 col-5">
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
                                    {{-- @for ($j = 1; $j < 11; $j++) <tr>
                                        <th scope="row">{{$j}}</th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>
                                    @endfor --}}
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
    <footer>
        <img src="{{('/aset/fa-mosque-solid.png')}}" alt="" class="logo-footer">
        <h3>Masjid Nurul Huda Ngablak</h3>
    </footer>
    <script src="{{('/jquery-3.4.1.min.js')}}"></script>
    <script>
        var index_before = 1;
        var idx=1;
        var count=1;
        var totaluang=0;
        var totalberas=0;
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
                document.getElementById("tambah-orang").innerHTML='<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" placeholder="fulan"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');">+</button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>';
                document.getElementById("jenis").value="";
                document.getElementById("nominal").value="";
                if ((totaluang!=0) && (totalberas!=0)) {
                    document.getElementById("total").innerHTML="<span id='total'>Uang Rp"+formatNumber(totaluang)+" <br>Beras "+formatNumber(totalberas)+"Kg </span>";
                }else if(totaluang!=0){
                    document.getElementById("total").innerHTML="<span id='total'>Rp"+formatNumber(totaluang)+"</span>";
                }else if(totalberas!=0){
                    document.getElementById("total").innerHTML="<span id='total'>"+formatNumber(totalberas)+" Kg</span>";
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
