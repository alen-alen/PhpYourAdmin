<div class='table'>
    <?php if ($request->getParameter('table')) { ?>
        <table id='databaseDataTable' class=''>
            <thead class='table-dark'>
                <tr>
                    <?php foreach ($columns as $key => $column) {
                        echo "<th>{$column}</th>";
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData as $row) { ?>
                    <tr class='h-25'>
                        <?php foreach ($row as $column => $value) { ?>
                            <td><?= $value === null ? 'NULL' : $value ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>