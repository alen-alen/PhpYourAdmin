<?php

use PhpYourAdimn\App\Helpers\Route; ?>
<div class=''>
    <h3>PhpYourAdmin</h3>
    <a href="<?= Route::path('logout') ?>"><i class="fa fa-sign-out"></i></a>
    <a href="<?= Route::path('database/create') ?>"><i class="fa fa-plus">Database</i></a>
</div>
<div class='select'>
    <form action="<?= Route::path('database/dashboard') ?>" method="GET">
        <div class="input-group">
            <select class="custom-select" name='db' id="databaseSelect" aria-label="Example select with button addon">
                <option hidden>Database..</option>
     

            </select>

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type='submit'>Select</button>
            </div>
    </form>
</div>
</div>
<div class='mt-5'>
    <div class="tableList bg-light"id='tableList'>
        <h5>Available tables: </h5>
        <div class="list-group">
            <a href="<?= Route::path('table/create') ?>" class='list-group-item list-group-item-action'>Create table<i class="fa fa-plus ml-2"></i></a>
          
        </div>
    </div>

</div>