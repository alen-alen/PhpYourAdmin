<?php

use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\App\Helpers\Session;

require 'app/views/parcels/head.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 border">
            <div class='dashboard'>
                <?php require 'app/views/parcels/dashboard.php' ?>
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
                <div class="col-12">
                    <a href="<?= Route::path('database/users/create') ?>"> Create user <i class="fa fa-plus"></i> </a>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <table class='table '>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>User name</th>
                                <th>Host name</th>
                                <th>Password</th>
                                <th>Global priviliges</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $key => $user) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $user['User'] ?></td>
                                    <td><?= $user['Host'] ?></td>
                                    <td><?= !empty($user['Password']) ? 'Yes' : 'No' ?></td>
                                    <td><?= $user['Grant_priv'] === 'Y' ? 'ALL PRIVILIGES' : 'USAGE' ?></td>
                                    <td><a href="<?= Route::path('database/users/delete', [['id', $key]]) ?>">delete</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require 'app/views/parcels/footer.php'; ?>