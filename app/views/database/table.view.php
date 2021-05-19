<?php

use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Session;

require 'app/views/parcels/head.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 border">
            <div class='dashboard'>
                <?php require 'app/views/parcels/dashboard.php' ?>
            </div>
        </div>
        <div class="col-9 border mt-5 ">
            <?php if (Session::get('success')) { ?>
                <div class='alert alert-success'><?= Session::get('success') ?></div>
            <?php } ?>
            <div class="row">
                <div class="col-12">
                    <form action="<?=Route::path('database/query') ?>" method='GET'>
                    <input type="text" hidden name='db' value="<?=$_GET['db']?>">
                    <input type="text" hidden name='table' value="<?=$_GET['table']?>">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Enter your query</label>
                            <textarea class="form-control" name='sql' id="exampleFormControlTextarea1" rows="3"></textarea>

                        </div>
                        <button type="submit" class="btn btn-primary">Go</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php require 'app/views/parcels/databaseTable.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>