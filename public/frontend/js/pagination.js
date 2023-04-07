$(document).on('click', '.pagination a',function (e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    pproduct(page);
});

function pproduct(page) {
    $.ajax({
        url: "/pagination/paginate-prod?page=" + page,
        success:function (res) {
            $('.table-prod').html(res);
        }
    });
};

$(document).on('change', function (e) {
    e.preventDefault();

    let sort_by = $('#sort_by').val();
    let sort_price = $('#sort_price').val();
    $.ajax({
        url: "/sort-by",
        method: "GET",
        data: {sort_by: sort_by, sort_price: sort_price},
        success:function (res) {
            $('.table-prod').html(res);
        }
    })
});
