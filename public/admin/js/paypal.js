

        paypal.Buttons({
        createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
            purchase_units: [{
                amount: {
                value: '{{ $total }}'
                }
            }]
            });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
            // This function shows a transaction success message to your buyer.
            // alert('Transaction completed by ' + details.payer.name.given_name);

            var firstname = $('.firstname').val();
            var lastname = $('.lastname').val();
            var email = $('.email').val();
            var phone = $('.phone').val();
            var address1 = $('.address1').val();
            var address2 = $('.address2').val();
            var city = $('.city').val();
            var state = $('.state').val();
            var country = $('.country').val();
            var pincode = $('.pincode').val();

            $.ajax({
                method: "POST",
                url: "/place-order",
                data: {
                    'fname':firstname,
                    'lname':lastname,
                    'email':email,
                    'phone':phone,
                    'address1':address1,
                    'address2':address2,
                    'city':city,
                    'state':state,
                    'country':country,
                    'pincode':pincode,
                    'payment_mode':"Paid by Paypal",
                    'payment_id':details.id,

                },
                success: function (response) {
                    swal(response.status)
                    .then((value) => {
                        window.location.href = "/my-orders";
                    });
                },
                error: function (response) {
                    swal(response.status)
                    .then((value) => {
                        window.location.href = "/my-orders";
                    });
                }
            });
            });
        }
        }).render('#paypal-button-container');
        //This function displays payment buttons on your web page.


