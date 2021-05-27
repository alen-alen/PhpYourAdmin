<?php

use PhpYourAdimn\App\Helpers\Cookie;
use PhpYourAdimn\App\Helpers\Route;
use PhpYourAdimn\App\Helpers\Session;

require 'app/views/parcels/head.php';
?>

<div class="container">
    <div class="row my-5">
        <?php if (Cookie::has('user')) { ?>
            <div class="col-8 offset-2">
                <div class=' border shadow p-5'>
                    <div class="alert alert-success">You are already logged in!</div>
                    <a href="<?=Route::path('database/dashboard')?>">Go back</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-8 offset-2">
                <div class=' border shadow p-5'>
                    <h1 class='mb-5 text-center'>Login</h1>

                    <?php if ($request->session->get('error')) { ?>

                        <div class='alert alert-danger text-center'><?= $request->session->get('error') ?></div>
                    <?php } ?>

                    <form action='login' method="POST">
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password:</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="host" class="col-sm-2 col-form-label"> Host:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="host" id="host">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1">
                                    <label class="form-check-label" for="gridCheck1">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>