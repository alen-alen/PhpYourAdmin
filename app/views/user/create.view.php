<?php

use PhpYourAdmin\App\Helpers\Route;
use PhpYourAdmin\App\Helpers\Session;

require 'app/views/parcels/head.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 ">
            <div class='dashboard'>
                <?php require 'app/views/parcels/dashboard.php' ?>
            </div>
        </div>
        <div class="col-9  pt-3 ">
            <?php if ($this->request->session->has('success')) { ?>
                <div class='alert alert-success'><?= $this->request->session->get('success') ?></div>
            <?php } ?>
            <?php if ($this->request->session->has('error')) { ?>
                <div class='alert alert-danger'><?= $this->request->session->get('error') ?></div>
            <?php
            } ?>
            <div class="row">
                <div class="col-12 ">
                    <h4>Create a new Mysql user</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="<?= Route::path('database/users/store') ?>" method="POST">
                        <div class="form-group row">
                            <label for="user" class="col-sm-2 col-form-label">User name:</label>
                            <div class="col-sm-6">
                                <input type="text" name='username' class="form-control" id="user">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="host" class="col-sm-2 col-form-label">Host name:</label>
                            <div class="col-sm-6">
                                <input type="text" name='host' class="form-control" id="host">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-6">
                                <input type="password" name='password' class="form-control" id="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">User type:</label>
                            <select id='type' name='type' class="form-control col-sm-6">
                                <option value='user'>User</option>
                                <option value='admin'>Administrator</option>
                                <option value='adminGrant'>Administrator-WITH GRANT OPTION</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 d-flex justify-content-end  ">
                                <button type="submit" class="btn btn-primary ">Create</button>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end  ">
                                <a href="<?= Route::path('database/users') ?>"> Go Back </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require 'app/views/parcels/footer.php'; ?>