<?php require 'app/views/parcels/head.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-3 border">
            <?php require 'parcels/dashboard.php' ?>
        </div>
        <div class="col-9 border ">
            <div class='table'>
                <?php if (isset($columns)) { ?>

                    <table id='myTable'class='table-responsive' style="width:100%" >
                        <thead class='table-dark'>
                            <tr>
                            <?php foreach ($columns as $key => $columns) {
                                echo "<th>{$columns['Field']}</th>";
                            } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) { ?>
                                <tr class='h-25'>
                                    <?php foreach ($row as $column => $value) { ?>
                                        <td><?= $value ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require 'app/views/parcels/footer.php'; ?>