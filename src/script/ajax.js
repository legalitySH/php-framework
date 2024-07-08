$(document).ready(function () {
    $('#cookie-form').submit(function (event) {
        event.preventDefault();
        addCookie();
    });

    $(document).on('submit', '.cookie-remove-form', function (event) {
        event.preventDefault();
        removeCookie($(this));
    });

    $('#start-session-btn').on('click', function () {
        startSession();
    });

    $('#abort-session-btn').on('click', function () {
        abortSession();
    });

    $('#text-area').on('input', function () {
        setSessionData();
    });

    $(window).on('load', function () {
        fetchCookies();
        fetchSessionStatus();
        getSessionData();
    })

});


setInterval(fetchCookies, 1000);
setInterval(fetchSessionStatus, 1000);


function getSessionData() {
    $.ajax({
        url: '/get-input-data',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#text-area').val(data.data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });

}

function setSessionData() {
    $.ajax({
        url: '/set-input-data',
        type: 'POST',
        data: {'input-data': $('#text-area').val()},
        dataType: 'json',
        success: function (data) {
            console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });

}

function abortSession() {
    $.ajax({
        url: '/abort-session',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            fetchSessionStatus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });

}

function startSession() {
    $.ajax({
        url: '/start-session',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            fetchSessionStatus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });
}

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

function fetchSessionStatus() {
    $.ajax({
        url: '/session-status',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let isStarted = data.status;
            if (isStarted) {
                $('#session-status').text('Active');
            } else {
                $('#session-status').text('Not active');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching cookies:', textStatus, errorThrown);
        }
    });
}
