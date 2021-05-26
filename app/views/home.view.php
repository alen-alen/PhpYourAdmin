<?php

use PhpYourAdimn\Core\Request;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Session;

require 'app/views/parcels/head.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 border">
            <div class='dashboard'>
                <?php require 'parcels/dashboard.php' ?>
            </div>
        </div>
        <div class="col-9 border pt-3 ">
            <?php if (Session::has('success')) { ?>
                <div class='alert alert-success'><?= Session::get('success') ?></div>
            <?php } ?>
            <?php if (Session::has('error')) { ?>
                <div class='alert alert-danger'><?= Session::get('error') ?></div>
            <?php } ?>

            <div class="row">
                <div class="col-12 mb-2">
                <a href="<?=Route::path('database/import',[['db',$request->getParameter('db')]])?>" class='btn btn-secondary'>Import</a>
                <a href="<?=Route::path('database/export',[['db',$request->getParameter('db')]])?>" class='btn btn-secondary'>Export</a>
                </div>
                <div class="col-12 border-top pt-3">
                    <?php if (!empty($message)) { ?>
                        <div class='alert alert-danger'><?= $message ?></div>
                    <?php } ?>

                    <form action="<?= Route::path('database/query') ?>" method='GET'>
                        <input type="text" hidden name='db' value="<?= $request->getParameter('db') ?>">
                        <input type="text" hidden name='table' value="<?=$request->getParameter('table') ?>">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Enter your query:</label>
                            <textarea class="form-control" name='sql' id="exampleFormControlTextarea1" rows="3"><?=$request->getParameter('sql') ? $request->getParameter('sql') : "SELECT * FROM " . $request->getParameter('table') ?></textarea>

                        </div>
                        <button type="submit" class="btn btn-primary">Go</button>
                    </form>
                </div>
                <div class="col-12">
                    <?php require 'parcels/databaseTable.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>