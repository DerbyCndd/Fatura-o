$(document).ready(function() {
    $(document).on('click', '.increment', function() {
        var $qtyBox = $(this).closest('.qtyBox');
        var $quantityInput = $qtyBox.find('.qty');
        var productId = $qtyBox.find('.proId').val();
        var currentValue = parseInt($quantityInput.val());
        var price = parseFloat($qtyBox.closest('tr').find('td:nth-child(3)').text());

        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            updateTotal($qtyBox, price, qtyVal);
            quantityIncDec(productId, qtyVal);
        } else {
            $quantityInput.val(1);
        }
    });

    $(document).on('click', '.decrement', function() {
        var $qtyBox = $(this).closest('.qtyBox');
        var $quantityInput = $qtyBox.find('.qty');
        var productId = $qtyBox.find('.proId').val();
        var currentValue = parseInt($quantityInput.val());
        var price = parseFloat($qtyBox.closest('tr').find('td:nth-child(3)').text());

        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            updateTotal($qtyBox, price, qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    function updateTotal($qtyBox, price, qtyVal) {
        var $totalCell = $qtyBox.closest('tr').find('#total');
        var newTotal = price * qtyVal;
        $totalCell.text(newTotal.toFixed(2));
    }

    function quantityIncDec(productId, qty) {

        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': productId,
                'quantity': qty
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    alertify.success(response.message);
                } else {
                    alertify.error(response.message);
                }
            }
        });
    }

    $(document).on('click','.proceedToPlace', function(){

        var payment_mode = $('#payment_mode').val();
        var cphone = $('#cphone').val();

        var data = {

            'proceedToPlaceBtn':true,
            'cphone':cphone,
            'payment_mode': payment_mode,
        };

        $.ajax({

            type: "POST",
            url: "orders-code.php",
            data: data,
            dataType: "dataType",
            success: function(response){
                var res = JSON.parse(response);
                if(res.status == 200){
                    window.location.href = "order-summary.php";

                }else if(res.status == 404){

                    swal(res.message,res.message,res.status_type, {
                        buttons:{
                            catch:{
                                text : "Add Customer",
                                value: "catch"
                            },
                            cancel: "Cancel"
                        }
                    })
                    .then((value) =>{
                        switch(value){

                            case "catch":
                                
                            default:

                        }

                    });


                }
            }

        });


    });


});
