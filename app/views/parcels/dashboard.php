<div class=''>
    <h3>PhpYourAdmin</h3>
    <a href="logout">Logout</a>
</div>
<div class='select'>

    <form action="dashboard" method="GET">
        <div class="input-group">
            <select class="custom-select" name='db' id="inputGroupSelect04" aria-label="Example select with button addon">
                <option selected>Choose...</option>
                <?php foreach ($databases as $db) { ?>
                    <option value="<?= $db['Database'] ?>"><?= $db['Database'] ?></option>
                <?php } ?>
            </select>

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type='submit'>Select Database</button>
            </div>
    </form>
</div>
</div>
<div>
    <div class="tableList bg-light mt-4">
        <h5>Available tables:</h5>
        <div class="list-group">
            <form action="">
                <?php
                if (isset($tables)) {
                    foreach ($tables as $tablename) {
                        if (!isset($_GET['table'])) { ?>
                            <a href="<?php echo trim($_SERVER['REQUEST_URI'], '/') ?>&table=<?= $tablename ?>" class=" list-group-item list-group-item-action"><?= $tablename ?></a>
                        <?php   } else { ?>
                            <a href="<?php echo explode('&', trim($_SERVER['REQUEST_URI'], '/'))[0] ?>&table=<?= $tablename ?>" class="list-group-item list-group-item-action"><?= $tablename ?></a>
                <?php }
                    }
                }
                ?>
            </form>

        </div>
    </div>

</div>