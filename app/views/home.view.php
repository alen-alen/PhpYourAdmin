<?php

use PhpYourAdimn\App\Helpers\Route;

require 'app/views/parcels/head.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 border">
            <div class='dashboard'>
                <?php require 'parcels/dashboard.php' ?>
            </div>
        </div>
        <div class="col-9 border pt-3 ">
            <?php if ($request->session->has('success')) { ?>
                <div class='alert alert-success'><?= $request->session->get('success') ?></div>
            <?php } ?>
            <?php if ($request->session->has('error')) { ?>
                <div class='alert alert-danger'><?= $request->session->get('error') ?></div>
            <?php } ?>

            <div class="row">
                <div class="col-12 mb-2">
                    <a href="<?= Route::path('database/import', [['db', $request->parameter('db')]]) ?>" class='btn btn-secondary'>Import</a>
                    <a href="<?= Route::path('database/export', [['db', $request->parameter('db')]]) ?>" class='btn btn-secondary'>Export</a>
                    <a href="<?= Route::path('database/users') ?>" class='btn btn-secondary'>User Accounts</a>
                </div>
                <div class="col-12 border-top pt-3">
                    <?php if (!empty($message)) { ?>
                        <div class='alert alert-danger'><?= $message ?></div>
                    <?php } ?>

                    <form action="<?= Route::path('database/query') ?>" method='GET'>
                        <input type="text" hidden name='db' value="<?= $request->parameter('db') ?>">
                        <input type="text" hidden name='table' value="<?= $request->parameter('table') ?>">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Enter your query:</label>
                            <textarea class="form-control" name='sql' id="exampleFormControlTextarea1" rows="3"><?= $request->has('sql') ? $request->parameter('sql') : "SELECT * FROM " ?></textarea>

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