$(document).ready(function() {
    let urlParams = new URLSearchParams(window.location.search);

    $.ajax({
        type: 'GET',
        url: '/api/databases',
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

function printAvailableTables(data, urlDbName, urlTableName) {
    data.forEach(table => {
        if (urlTableName === table) {
            $('#tableList').append(`
            <a href="/database/table?db=${urlDbName}&table=${table}" class="list-group-item list-group-item-action active">${table}</a>`)
        } else {
            $('#tableList').append(`
            <a href="/database/table?db=${urlDbName}&table=${table}" class="list-group-item list-group-item-action ">${table}</a>`)
        }
    });
}

function printDatabaseOptions(data, urlDbName) {
    data.forEach(database => {
        if (urlDbName === database) {
            $('#databaseSelect').append(`<option selected  value='${database}'>${database}</option>`);
        } else {
            $('#databaseSelect').append(`<option  value='${database}'>${database}</option>`);
        }
    });
}