@extends('layouts.app1')

@section('content')
<?php
$data = file_get_contents("https://ftisunpar.github.io/data/prasyarat.json");


// parse / uraikan data
$parsedata = json_decode($data);

?>
<div class="container p-3">
    <div class="container bg-white mb-3 rounded p-3">
        <div class="d-flex">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Masukan Data
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar Mata Kuliah</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('rekomendasi.store')}}" method="POST">
                                @csrf
                                <div class="d-flex">
                                    <div class="form-floating">
                                        <select class="form-control" id="fkMata" name="fkMata">
                                            @foreach ($listsMata as $mata)
                                            <option value="{{ $mata->idMata }}">{{ $mata->namaMataKuliah }}</option>
                                            @endforeach

                                        </select>
                                        <label for="fkMata">Nama Mata Kuliah</label>
                                    </div>
                                </div>
                                <div class="form-floating" style="margin-top: 20px;">
                                    <select id="status" name="status">
                                        <option value="lulus">Lulus</option>
                                        <option value="tidak">Tidak Lulus</option>
                                    </select>
                                </div>
                                <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Tambah </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        for ($row = 0; $row < count($listt); $row++) {
            echo "<tr>";
            for ($col = 0; $col < 4; $col++) {
                echo "<td>" . $listt[$row][$col] . " " . "</td>";
            }
            echo "<br>";

            echo "</tr>";
            echo "<br>";
        }
        ?>
        <div class="container bg-white mb-3 rounded">

            <h2>Daftar Mata Kuliah Rekomendasi Untuk Semester {{$semester}}</h2>

            <table class="table">

                <tr>
                    <th scope="col">Nomor</th>

                    <th scope="col">Kode Mata Kuliah</th>
                    <th scope="col">Nama Mata Kuliah</th>
                    <th scope="col">Jumlah SKS</th>
                    <th scope="col">Keterangan</th>
                </tr>
                <?php $no = 1 ?>

                @foreach ($listsRekomendasi as $rekomendasi)
                <tr style="border: 1px solid #ddd;padding: 70px;">
                    <td><?php echo $no ?></td>
                    <td>{{$rekomendasi->kode}}</td>
                    <td>{{$rekomendasi->namaMataKuliah}}</td>
                    <td>{{$rekomendasi->sks}}</td>
                    <td>{{$rekomendasi->status}}</td>
                </tr>
                <?php $no = $no + 1 ?>
                @endforeach

            </table>

        </div>



        <div class="container bg-white mb-3 rounded">

            <h2>Daftar Mata Kuliah Rekomendasi Untuk Semester {{$semester}}</h2>

            <table class="table">

                <tr>
                    <th scope="col">Nomor</th>

                    <th scope="col">Kode Mata Kuliah</th>
                    <th scope="col">Nama Mata Kuliah</th>
                    <th scope="col">Jumlah SKS</th>
                    <th scope="col">Keterangan</th>
                </tr>
                <?php $no = 1 ?>

                @foreach ($listsRekomendasi as $rekomendasi)
                <tr style="border: 1px solid #ddd;padding: 70px;">
                    <td><?php echo $no ?></td>
                    <td>{{$rekomendasi->kode}}</td>
                    <td>{{$rekomendasi->namaMataKuliah}}</td>
                    <td>{{$rekomendasi->sks}}</td>
                    <td>{{$rekomendasi->status}}</td>
                </tr>
                <?php $no = $no + 1 ?>
                @endforeach

            </table>

        </div>
    </div>
    @endsection