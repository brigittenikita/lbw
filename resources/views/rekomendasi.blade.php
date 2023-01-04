@extends('layouts.app1')

@section('content')
<div class="container p-3">
    <div class="container bg-white mb-3 rounded p-3">
        <h6>Nama :{{$nama}}</h6>
        <h6>Semester :{{$semester-1}}</h6>
        <h4 style="text-align: center;">Input Status Mata Kuliah</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" style="position: absolute;left: 45%;" data-target="#exampleModal">
            Tambah Data
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar Mata Kuliah</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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

    <!--  -->




    <!-- <div class="container bg-white mb-3 rounded">

        <h2>Daftar Mata Kuliah Lulus</h2>

        <table class="table">

            <tr>
                <th scope="col">Nomor</th>

                <th scope="col">Kode Mata Kuliah</th>
                <th scope="col">Nama Mata Kuliah</th>
                <th scope="col">Jumlah SKS</th>
                <th scope="col">Keterangan</th>
            </tr>
            <?php $no = 1 ?>

            @foreach($listsTempuh as $listLulus)
            <tr style="border: 1px solid #ddd;padding: 70px;">
                <td>1</td>
                <td>{{$listLulus->namaMataKuliah}} </td>
                <td> {{$listLulus->kode}}</td>
                <td> {{$listLulus->semester}} </td>
                <td> {{$listLulus->namaMataKuliah}} </td>
            </tr>
            @endforeach


        </table>

    </div> -->

    <?php if (!$record->exists()) {
    ?>
        <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

            <h2>Daftar Mata Kuliah Awal Semester</h2>

            <table class="table">

                <tr>
                    <th scope="col">Nomor</th>

                    <th scope="col">Kode Mata Kuliah</th>
                    <th scope="col">Nama Mata Kuliah</th>
                    <th scope="col">Jumlah SKS</th>
                    <th scope="col">Keterangan</th>
                </tr>
                <?php $no = 1 ?>

                @foreach($listsRekomendasi as $listLulus)
                <tr style="border: 1px solid #ddd;padding: 70px;">
                    <td>1</td>
                    <td>{{$listLulus->namaMataKuliah}} </td>
                    <td> {{$listLulus->kode}}</td>
                    <td> {{$listLulus->semester}} </td>
                    <td> {{$listLulus->keterangan}} </td>
                </tr>
                @endforeach

            </table>

        </div>


        <?php
    } else {

        if (!$record1->exists()) {
        ?>
            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($listFilter); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $listFilter[$row][0]  ?></td>
                            <td><?php echo $listFilter[$row][1]  ?></td>
                            <td><?php echo $listFilter[$row][2]  ?></td>
                            <td><?php echo $listFilter[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>


            <!-- <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($list); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $list[$row][0]  ?></td>
                            <td><?php echo $list[$row][1]  ?></td>
                            <td><?php echo $list[$row][2]  ?></td>
                            <td><?php echo $list[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>




            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($list1); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $list1[$row][0]  ?></td>
                            <td><?php echo $list1[$row][1]  ?></td>
                            <td><?php echo $list1[$row][2]  ?></td>
                            <td><?php echo $list1[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>


            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($listt); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $listt[$row][0]  ?></td>
                            <td><?php echo $listt[$row][1]  ?></td>
                            <td><?php echo $listt[$row][2]  ?></td>
                            <td><?php echo $listt[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div> -->



            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Sudah Lulus </h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    @foreach($listsLulus as $list)
                    <tr style="border: 1px solid #ddd;padding: 70px;">
                        <td>{{$no}}</td>
                        <td>{{$list->namaMataKuliah}}</td>
                        <td>{{$list->semester}}</td>
                        <td>{{$list->sks}}</td>
                        <td>{{$list->keterangan}}</td>
                    </tr>
                    <?php $no = $no + 1 ?>
                    @endforeach
                </table>

            </div>





            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Pernah Tidak Lulus </h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    @foreach($listsKosong as $list)
                    <tr style="border: 1px solid #ddd;padding: 70px;">
                        <td>{{$no}}</td>
                        <td>{{$list->namaMataKuliah}}</td>
                        <td>{{$list->semester}}</td>
                        <td>{{$list->sks}}</td>
                        <td>{{$list->keterangan}}</td>
                    </tr>
                    <?php $no = $no + 1 ?>
                    @endforeach
                </table>

            </div>





        <?php } else {
        ?>
            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Rekomendasi Untuk Semester {{$semester}}</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($listFilter); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $listFilter[$row][0]  ?></td>
                            <td><?php echo $listFilter[$row][1]  ?></td>
                            <td><?php echo $listFilter[$row][2]  ?></td>
                            <td><?php echo $listFilter[$row][3]  ?></td>
                        </tr>
                    <?php $no = $no + 1;
                    } ?>

                </table>

            </div>


            <!--  -->

            <!-- 
            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($list); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $list[$row][0]  ?></td>
                            <td><?php echo $list[$row][1]  ?></td>
                            <td><?php echo $list[$row][2]  ?></td>
                            <td><?php echo $list[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>




            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($list1); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $list1[$row][0]  ?></td>
                            <td><?php echo $list1[$row][1]  ?></td>
                            <td><?php echo $list1[$row][2]  ?></td>
                            <td><?php echo $list1[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>


            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Belum Lulus Dan Belum Diambil</h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    <?php for ($row = 0; $row < count($listt); $row++) { ?>
                        <tr style="border: 1px solid #ddd;padding: 70px;">
                            <td><?php echo $row + 1 ?></td>
                            <td><?php echo $listt[$row][0]  ?></td>
                            <td><?php echo $listt[$row][1]  ?></td>
                            <td><?php echo $listt[$row][2]  ?></td>
                            <td><?php echo $listt[$row][3]  ?></td>
                        </tr>
                    <?php        } ?>

                </table>

            </div>
 -->

            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Sudah Lulus </h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    @foreach($listsLulus as $list)
                    <tr style="border: 1px solid #ddd;padding: 70px;">
                        <td>{{$no}}</td>
                        <td>{{$list->namaMataKuliah}}</td>
                        <td>{{$list->semester}}</td>
                        <td>{{$list->sks}}</td>
                        <td>{{$list->keterangan}}</td>
                    </tr>
                    <?php $no = $no + 1 ?>
                    @endforeach
                </table>

            </div>



            <div style="margin-top: 25px;" class="container bg-white mb-3 rounded">

                <h2>Daftar Mata Kuliah Yang Pernah Tidak Lulus </h2>

                <table class="table">

                    <tr>
                        <th scope="col">Nomor</th>

                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                    <?php $no = 1 ?>

                    @foreach($listsKosong as $list)
                    <tr style="border: 1px solid #ddd;padding: 70px;">
                        <td>{{$no}}</td>
                        <td>{{$list->namaMataKuliah}}</td>
                        <td>{{$list->semester}}</td>
                        <td>{{$list->sks}}</td>
                        <td>{{$list->keterangan}}</td>
                    </tr>
                    <?php $no = $no + 1 ?>
                    @endforeach
                </table>

            </div>


        <?php } ?>
    <?php } ?>





</div>
@endsection