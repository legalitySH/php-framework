$(document).ready(function () {
    $('#update-button').click(function () {
        loadUsers();
    });
    $('#remove-form').submit(function (event) {
        event.preventDefault();
        removeUser();
    });
    $('#insert-form').submit(function (event) {
        event.preventDefault();
        addUser();
    })

});

function loadUsers() {
    $.ajax({
        url: '/update',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const table = $('#users-table');
            table.find('tbody').empty();
            const header = '<tr>' +
                '<th>Id</th>' +
                '<th>Login</th>' +
                '<th>Registration time</th>' +
                '</tr>';
            table.find('tbody').append(header);

            $.each(data, function (index, user) {
                const row = '<tr>' +
                    '<td>' + user.id + '</td>' +
                    '<td>' + user.login + '</td>' +
                    '<td>' + user.registration_time + '</td>' +
                    '</tr>';
                table.find('tbody').append(row);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching users:', textStatus, errorThrown);
        }
    });
}

function removeUser() {
    let data = $('#remove-form').serialize();
    $.ajax({
        type: 'POST',
        url: '/remove',
        data: data,
        success: function (response) {
            $('#response').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Request error: ' + status + ' ' + error);
        }
    });
    loadUsers();
}

function addUser() {
    let data = $('#insert-form').serialize();
    $.ajax({
        type: 'POST',
        url: '/add',
        data: data,
        success: function (response) {
            $('#response').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Request error: ' + status + ' ' + error);
        }
    });
    loadUsers();
}