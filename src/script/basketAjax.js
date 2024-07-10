$(document).ready(function () {
    $('#delete-from-basket-form').on('submit', function (event) {
        event.preventDefault();
        deleteFromBasket($(this));
    });
});

function deleteFromBasket(form) {
    $.ajax({
        url: '/delete-from-basket',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (data) {
            let basketCard = document.querySelector(`.card-${data.id}`);
            basketCard.remove();
            console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching request:', textStatus, errorThrown);
        }
    });
}