$(document).ready(function () {

    load_more_cmt();

    function load_more_cmt(id = '') {
        var prod_id = $("input[name='product_id']").val();
        $.ajax({
            url: "/load_more_cmt/" + prod_id,
            method: "POST",

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data:{id:id},
            success: function (data) {
                $('#load_more_button').remove();
                $('#table-cmt').append(data);
            }
        });
    }
    $('#load_more_button').click(function () {
        e.preventDefault();

        var product_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            method: "POST",
            url: "/add-to-wishlist",
            data: {
                'product_id' : product_id,
            },
            success: function(response) {
                if (response.success) {
                    swal("", response.status, "success");
                    loadwishlist();
                } else {
                    swal("", response.status, "error");
                }
            }
        });
    });
    $(document).on('click','#load_more_button',function () {
        let id = $(this).data('id');
        if (id){
            load_more_cmt(id);
        }
    })
});
