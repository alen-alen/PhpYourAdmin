<?php
require 'app/views/parcels/head.php';

use PhpYourAdimn\App\Helpers\Route;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-6 offset-3">
            <h1>Create Database</h1>
            <form action="<?= Route::path('database/store') ?>" method="POST">
                <form>
                    <?php if ($request->session->has('error')) {
                        foreach ($request->session->get('error') as $error) { ?>
                            <div class='alert alert-danger'><?= $error ?></div>
                    <?php }
                    } ?>
                    <div class="form-group">
                        <label for="dbName">Database name</label>
                        <input type="text" name='dbName' class="form-control" id="dbName">
                    </div>

                    <select class="custom-select" name='collationId' id="inputGroupSelect04" aria-label="Example select with button addon">
                        <option hidden>Choose...</option>
                        <?php foreach ($collations as $collate) { ?>
                            <option value=" <?= $collate['Id'] ?>"> <?= $collate['Collation'] ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="<?= Route::path('database/dashboard') ?>">go Back</a>
                </form>
            </form>
        </div>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>