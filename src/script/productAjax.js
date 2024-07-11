$(document).ready(function () {
    $(document).on('submit', '.to-basket-form', function (event) {
        event.preventDefault();
        addToBasket($(this));
    });

    $('input[name="sortingType"]').change(function () {
        const selectedValue = $(this).val();
        localStorage.setItem('sortingType', selectedValue);
        $('#sortingForm').submit();
    });

    const savedSortingType = localStorage.getItem('sortingType');

    if (savedSortingType) {
        $('input[name="sortingType"][value="' + savedSortingType + '"]').prop('checked', true);
        console.log(savedSortingType);
    }
})


function sortProducts(strategy) {
    $.ajax({
        url: '/sort-products',
        type: 'POST',
        data: strategy,
        dataType: 'json',
        success: function (data) {
            console.log(data)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching request:', textStatus, errorThrown);
        }
    });

}
function addToBasket(form) {
    $.ajax({
        url: '/add-to-basket',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (data) {
            console.log(data)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching request:', textStatus, errorThrown);
        }
    });
}


