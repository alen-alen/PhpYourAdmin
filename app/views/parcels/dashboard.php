<?php

use PhpYourAdimn\App\Helpers\Route; ?>
<div class=''>
    <h3>PhpYourAdmin</h3>
    <a href="logout"><i class="fa fa-sign-out"></i></a>
</div>
<div class='select'>
    <form action="<?= Route::path('dashboard') ?>" method="GET">
        <div class="input-group">
            <select class="custom-select" name='db' id="inputGroupSelect04" aria-label="Example select with button addon">
                <option selected>Choose...</option>
                <?php foreach ($databases as $db) { ?>
                    <option <?= isset($_GET['db']) && $db['Database'] === $_GET['db'] ? 'selected' : '' ?> value="<?= $db['Database'] ?>"><?= $db['Database'] ?></option>
                <?php } ?>
            </select>

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type='submit'>Select</button>
            </div>
    </form>
</div>
</div>
<div class='mt-5'>
    <div class="tableList bg-light ">
        <h5>Available tables:</h5>
        <div class="list-group">
            <?php
            if (isset($tables)) {
                foreach ($tables as $tablename) { ?>
                    <a href="
                    <?= Route::path('', [['db', $_GET['db']], ['table', $tablename]]) ?>" class="list-group-item list-group-item-action <?= isset($_GET['table']) && $tablename === $_GET['table'] ? 'active' : '' ?>">
                        <small><?= $tablename ?></small></a>
            <?php
                }
            }
            ?>
        </div>
    </div>

</div>