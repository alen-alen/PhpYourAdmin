<?php
require 'app/views/parcels/head.php';

use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Session;
use PhpYourAdimn\Core\Request;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 offset-3">
            <h1>Import Database</h1>

            <form action="<?= Route::path('database/import') ?>" method="POST" enctype="multipart/form-data">
            <input type="text"hidden name='db'value="<?=Request::getParameter('db')?>">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Example file input</label>
                    <input type="file" name='database' class="form-control-file" id="exampleFormControlFile1">
                </div>
                <button>Import</button>
            </form>

        </div>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>