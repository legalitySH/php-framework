$(document).ready(function () {
    $('#cookie-form').submit(function (event) {
        event.preventDefault();
        addCookie();
    });

    $(document).on('submit', '.cookie-remove-form', function (event) {
        event.preventDefault();
        removeCookie($(this));
    });

    $(window).on('load', function () {
        fetchCookies();
    })


});


setInterval(fetchCookies, 1000);


function removeCookie(form) {

    $.ajax({
        url: '/remove-cookie',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (data) {
            fetchCookies();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });
}

function addCookie() {
    $.ajax({
        url: '/add-cookie',
        type: 'POST',
        data: $('#cookie-form').serialize(),
        dataType: 'json',
        success: function (data) {
            let newRow = '<tr>' +
                '<td>' + data.cookieKey + '</td>' +
                '<td>' + data.cookieValue + '</td>' +
                '<td>' +
                '<form method="post" class=\'cookie-remove-form\'>' +
                '<input type="hidden" name="delete-cookie" value="' + data.cookieKey + '">' +
                '<button type="submit" class="btn kill">Kill</button>' +
                '</form>' +
                '</td>' +
                '</tr>';
            $('#cookie-table tbody').append(newRow);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies: ', textStatus, errorThrown);
        }
    });
}

function fetchCookies() {
    $.ajax({
        url: '/fetch-cookies',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#cookie-table tbody').empty();
            for (const cookieKey in data) {
                let newRow = '<tr>' +
                    '<td>' + cookieKey + '</td>' +
                    '<td>' + data[cookieKey] + '</td>' +
                    '<td>' +
                    '<form method="post" class=\'cookie-remove-form\'>' +
                    '<input type="hidden" name="delete-cookie" value="' + cookieKey + '">' +
                    '<button type="submit" class="btn kill">Kill</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';
                $('#cookie-table tbody').append(newRow);
            }
        }
    });
}

