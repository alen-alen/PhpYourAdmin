$(document).ready(function() {

    let urlParams = new URLSearchParams(window.location.search);

    $.ajax({
        type: 'GET',
        url: '/api/dashboard',
        dataType: 'json',
        success: function(data) {
            printDatabaseOptions(data, urlParams.get('db'))

            if (urlParams.get('db')) {
                $.ajax({
                    type: 'GET',
                    url: "/api/getTables?db=" + urlParams.get('db'),
                    dataType: 'json',
                    success: function(data) {
                        printAvailableTables(data, urlParams.get('db'), urlParams.get('table'))
                    }
                })
            }
        }
    })

});

function printAvailableTables(data, dbName, tableName) {
    data.forEach(table => {
        if (tableName === table) {
            $('#tableList').append(`
            <a href="/database/table?db=${dbName}&table=${table}" class="list-group-item list-group-item-action active">${table}</a>`)
        } else {
            $('#tableList').append(`
            <a href="/database/table?db=${dbName}&table=${table}" class="list-group-item list-group-item-action ">${table}</a>`)
        }
    });
}

function printDatabaseOptions(data, dbName) {
    data.forEach(database => {
        if (dbName === database) {
            $('#databaseSelect').append(`<option selected  value='${database}'>${database}</option>`);
        } else {
            $('#databaseSelect').append(`<option  value='${database}'>${database}</option>`);
        }
    });
}