<?php require 'app/views/parcels/head.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 border">
            <div class='dashboard'>
                <?php require 'parcels/dashboard.php' ?>
            </div>
        </div>
        <div class="col-9 border mt-5 ">
            <div class='table '>
                <?php if (isset($columns)) { ?>

                    <table id='myTable' class=''>
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