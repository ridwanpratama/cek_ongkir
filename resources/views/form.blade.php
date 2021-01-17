<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cek Ongkir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

    <div class="container">

        <br>
        <div class="card">
            <div class="card-body">
                <form action="{{url('/')}}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Nama Anda</h6>
                            <div class="form-group">
                                <input name="name" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Kirim Dari</h6>
                            <div class="form-group">
                                <select name="province_origin" id="province" class="form-control">
                                    <option value="" holder>Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->province}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="origin" id="origin" class="form-control" required>
                                    <option value="" holder>Pilih Kota</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h6>Kirim Ke</h6>
                            <div class="form-group">
                                <select name="province_destination" id="province" class="form-control">
                                    <option value="" holder>Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->province}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="destination" id="destination" class="form-control" required>
                                    <option value="" holder>Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Berat Paket</h6>
                            <div class="form-group">
                                <input name="weight" type="number" class="form-control" required>
                                <small>Dalam gram contoh: 1700 = 1,7kg</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h6>Pilih Kurir</h6>
                            <select name="courier" required class="form-control">
                                <option value="" holder>Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-info btn-block">Cek Ongkir</button>
                        </div>
                    </div>

                    @if($result_cost)
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <table>
                                <tr>
                                    <td width="30%">Nama</td>
                                    <td>: {{$name}}</td>
                                </tr>
                                <tr>
                                    <td>Kirim Dari</td>
                                    <td>: {{$origin_name->type}} {{$origin_name->city_name}}</td>
                                </tr>
                                <tr>
                                    <td>Kirim Ke</td>
                                    <td>: {{$origin_name->type}} {{$destination_name->city_name}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table>
                                <tr>
                                    <td width="30%">Berat</td>
                                    <td>: {{$data_weight}} Gram</td>
                                </tr>
                                <tr>
                                    <td>Kurir</td>
                                    <td>: {{ ucwords($data_courier) }}</td>
                                </tr>                                     
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Service</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Estimasi Pengiriman</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($result_cost as $result)
                                    <tr>
                                        <td>{{$result['service']}}</td>
                                        <td>{{$result['description']}}</td>
                                        <td>{{$result['cost'][0]['value']}}</td>
                                        <td>{{$result['cost'][0]['etd']}} Hari</td>
                                        <td>{{$result['cost'][0]['note']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                    @else

                    @endif



                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="province_origin"]').on('change', function () {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: 'getCity/ajax/' + cityId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="origin"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="origin"]').append(
                                    '<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="origin"]').empty();
                }
            });
            $('select[name="province_destination"]').on('change', function () {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: 'getCity/ajax/' + cityId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="destination"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="destination"]').append(
                                    '<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="destination"]').empty();
                }
            });
        });
    </script>
</body>

</html>