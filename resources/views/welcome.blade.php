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
                <div class="isi-data col-sm-8 col-8">
                    <div class="tombol">
                        <button class="btn" onclick="kirimData('Zakat Fitrah','30000')"> Zakat Fitrah</button>
                        <button class="btn" onclick="kirimData('Zakat Mal','')"> Zakat Mal</button>
                        <button class="btn" onclick="kirimData('Fidyah','')"> Fidyah</button>
                        <button class="btn" onclick="kirimData('Infaq','')"> infaq</button>
                        <button class="btn"> Lain-lain</button>
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
                            <label>Nominal</label>
                            <input type="text" class="form-control" id="nominal" placeholder="0" onkeyup="changeFormat()">
                        </div>
                        <input type="submit" class="btn" value="tambah"
                            onclick="event.preventDefault(); tambahDataTable()">
                    </div>
                </div>
                <div class="lihat-data col-sm-4 col-4">
                    <div class="tabel">
                        <form method="POST" action={{ route('transaksi') }}>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">nama</th>
                                        <th scope="col">jenis</th>
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
                            <span>Total :</span><span id="totalbayar">Rp.0</span>
                            <br>
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
        var total_before = 1;
        var idx=1;
        var count=1;
        var totalbayar=0;
        function kirimData(jenis,nominal) {
            document.getElementById("jenis").value=jenis;
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
                console.log("ini number");
                console.log(num);
                num=  num.toString().replace(/,/g,'');
                console.log(num);
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

        function tambahDataTable() {
            var result = "";
            idx+=1;
            index=total_before;
            komplet=true;
            temptcount=count;
            temptotalbayar=totalbayar;
            while (index < idx) {
                if(document.getElementById("nama-"+index)!= null ){
                    if (document.getElementById("nama-"+index).value!="" && document.getElementById("jenis").value!="" && document.getElementById("nominal").value!="") {
                        result += "<tr><th scope='row'>"+count+"</th><td>"+document.getElementById("nama-"+index).value+"</td><td>"+document.getElementById("jenis").value+"</td><td>"+formatNumber(document.getElementById("nominal").value)+"</td><input type='hidden' value='"+document.getElementById("nama-"+index).value+"' name='nama[]'><input type='hidden' value='"+document.getElementById("jenis").value+"' name='jenis[]'><input type='hidden' value='"+parseInt(document.getElementById("nominal").value.replace(/,/g,''))+"' name='nominal[]'></tr>";
                        count++
                        totalbayar+=parseInt(document.getElementById("nominal").value.replace(/,/g,''))
                    }else{
                        komplet=false;
                        count=temptcount;
                        totalbayar=temptotalbayar;
                    }
                }
                index++;
            }
            if(komplet){

                $("#data-table").append(result);
                document.getElementById("tambah-orang").innerHTML='<div class="form-inline"> <input type="text" class="form-control" id="nama-'+idx+'" placeholder="fulan"><button class="btn" id="btn-'+(parseInt(idx))+'" onclick="event.preventDefault(); tambahOrang('+(parseInt(idx)+1)+');">+</button><div id="hapusnama-'+(parseInt(idx))+'"></div></div>';
                document.getElementById("jenis").value="";
                document.getElementById("nominal").value="";
                document.getElementById("totalbayar").innerHTML="<span id='totalbayar'>Rp"+formatNumber(totalbayar)+"</span>";
                total_before=idx;
            }else{
                idx-=1;
                alert("silahkan lengkapi data");
            }
        }

    </script>
</body>

</html>
