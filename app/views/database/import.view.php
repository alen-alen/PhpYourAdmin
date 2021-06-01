<?php
require 'app/views/parcels/head.php';

use PhpYourAdmin\App\Helpers\Route;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 offset-3 mt-5 p-5 shadow">
            <h1>Import Database</h1>
            <?php if (!empty($message)) { ?>
                <div class='alert alert-danger'><?= $message ?></div>
            <?php } ?>
            <?php if ($request->session->has('error')) { ?>
                <div class='alert alert-danger'><?= $request->session->get('error') ?></div>
            <?php } ?>
            <form action="<?= Route::path('database/import') ?>" method="POST" enctype="multipart/form-data">
                <input type="text" hidden name='db' value="<?= $request->parameter('db') ?>">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Chose your database: ('must be a sql file')</label>
                    <input type="file" name='database' class="form-control-file" id="exampleFormControlFile1">
                </div>
                <button>Import</button>
                <a href="<?= Route::path('database/dashboard') ?>">Go Back</a>
            </form>
        </div>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>