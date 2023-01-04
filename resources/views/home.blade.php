@extends('layouts.app')

@section('content')
<?php
//mengambil
$data = file_get_contents("https://ftisunpar.github.io/data/prasyarat.json");


// parse / uraikan data
$parsedata = json_decode($data);

?>
<div class="container p-3">
    <?php
    for ($j = 1; $j <= 8; $j++) {

    ?>


        <div class="container bg-white mb-3 rounded">

            <h2>Semester <?php echo $j ?></h2>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Kode Mata Kuliah</th>
                        <th scope="col">Nama Mata Kuliah</th>
                        <th scope="col">Jumlah SKS</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($i = 0; $i < count($parsedata); $i++) {

                    ?>
                        <?php
                        if ($parsedata[$i]->semester === $j) {
                        ?>
                            <tr>
                                <!-- modal -->
                                <td class="tempuh" style="display:none;">
                                    ~
                                    <?php
                                    foreach ($parsedata[$i]->prasyarat->tempuh as $syarat) {
                                        for ($k = 0; $k < count($parsedata); $k++) {
                                            if ($parsedata[$k]->kode === $syarat) {
                                                echo $parsedata[$k]->nama;
                                            }
                                        }
                                    ?> ~ <?php
                                            ?>

                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="lulus" style="display:none;">
                                    ~
                                    <?php
                                    foreach ($parsedata[$i]->prasyarat->lulus as $syarat) {
                                        for ($k = 0; $k < count($parsedata); $k++) {
                                            if ($parsedata[$k]->kode === $syarat) {
                                                echo $parsedata[$k]->nama;
                                            }
                                        }
                                    ?> ~ <?php
                                            ?>

                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="bersamaan" style="display:none;">
                                    ~
                                    <?php
                                    foreach ($parsedata[$i]->prasyarat->bersamaan as $syarat) {
                                        for ($k = 0; $k < count($parsedata); $k++) {
                                            if ($parsedata[$k]->kode === $syarat) {
                                                echo $parsedata[$k]->nama;
                                            }
                                        }
                                    ?> ~ <?php
                                            ?>

                                    <?php
                                    }
                                    ?>
                                </td>

                                <!-- end modal -->


                                <td class=" kode"><?php echo $parsedata[$i]->kode; ?></td>

                                <td class="nama"> <?php echo $parsedata[$i]->nama; ?></td>
                                <td> <?php echo $parsedata[$i]->sks; ?></td>
                                <td class="wajib"> <?php
                                                    if ($parsedata[$i]->wajib === true) {
                                                        echo "wajib";
                                                    } else {
                                                        echo "Pilihan";
                                                    }

                                                    ?>
                                </td>
                                <td>

                                    <button class="btn btn-primary " data-toggle="modal" data-target="#gfgmodal">
                                        Detail</button>




                                    <!-- modal -->
                                    <script>
                                        $(function() {
                                            // ON SELECTING ROW
                                            $(".btn").click(function() {
                                                //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
                                                var a =
                                                    $(this).parents("tr").find(".kode").text();
                                                var c =
                                                    $(this).parents("tr").find(".nama").text();
                                                var d =
                                                    $(this).parents("tr").find(".wajib").text();
                                                var e =
                                                    $(this).parents("tr").find(".tempuh").text();
                                                var f =
                                                    $(this).parents("tr").find(".lulus").text();
                                                var g =
                                                    $(this).parents("tr").find(".bersamaan").text();

                                                //CLEARING THE PREFILLED DATA
                                                $("#kodeM").empty();
                                                //WRITING THE DATA ON MODEL
                                                $("#kodeM").append(a);

                                                $("#namaM").empty();
                                                $("#namaM").append(c);
                                                $("#wajibM").empty();
                                                $("#wajibM").append(d);


                                                $("#tempuhM").empty();
                                                $("#tempuhM").append(e);
                                                $("#lulusM").empty();
                                                $("#lulusM").append(f);
                                                $("#bersamaanM").empty();
                                                $("#bersamaanM").append(g);
                                            });
                                        });
                                    </script>
                                    <!-- CREATING BOOTSTRAP MODEL -->
                                    <div class="modal fade" id="gfgmodal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!-- MODEL TITLE -->
                                                    <h2 class="modal-title" id="gfgmodallabel">
                                                        Detail Mata Kuliah</h2>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">
                                                            ×</span>
                                                    </button>
                                                </div>
                                                <!-- MODEL BODY -->
                                                <div class="modal-body">
                                                    <!-- <div class="GFGclass" id="divGFG"></div> -->




                                                    <div class="modal-body">
                                                        <div class="w3-container" id="container1">
                                                            <h2 style="text-align: center;">Nama Mata kuliah</h2>
                                                            <div class="GFGclass" id="namaM" style="text-align: center;"></div>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex mb-3" id="container1">
                                                            <div class="p-2">
                                                                <h3 style="text-align: center;">Kode Mata kuliah</h3>
                                                                <div style="text-align: center;" class="GFGclass" id="kodeM"></div>



                                                            </div>

                                                            <div class="ms-auto p-2" style="text-align: center;">
                                                                <h3>wajib/pilihan</h3>
                                                                <div class="GFGclass" id="wajibM"></div>

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="container" id="container1">
                                                            <h4 style="text-align: center;">Prasayrat Mata Kuliah</h4>
                                                            <br>
                                                            <p>Tempuh:</p>
                                                            <div class="GFGclass" id="tempuhM"></div>
                                                            <br>
                                                            <p>Bersamaan:</p>
                                                            <div class="GFGclass" id="bersamaanM"></div>
                                                            <br>
                                                            <p>Lulus:</p>
                                                            <div class="GFGclass" id="lulusM"></div>

                                                        </div>
                                                    </div>



                                                    <div class="modal-footer">
                                                        <!-- The close button in the bottom of the modal -->
                                                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                Close</button> -->
                                                        <p>Detail Mata Kuliah Kurikulum Jurusan Informatika 2018 </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- end modal  -->

                                </td>
                            </tr>

                        <?php
                        }

                        ?>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }

    ?>

</div>

@endsection