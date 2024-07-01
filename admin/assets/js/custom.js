$(document).ready(function() {
    $(document).on('click', '.increment', function() {
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var currentValue = parseInt($quantityInput.val());
        
        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(currentValue,qtyVal);
        } else {
            $quantityInput.val(1); // Define um valor padrão caso currentValue seja NaN
        }
    });

    $(document).on('click', '.decrement', function() {
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');

        var currentValue = parseInt($quantityInput.val());

        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(currentValue,qtyVal);

        }
    });


    function quantityIncDec(currentValue, qty){

        $.ajax({
            type:"POST",
            url: "orders-code.php",
            data :{
                'productIncDec' :true, 
                'product_id':currentValue,
                'quantity':qty
            },
            dataType:'dataType',
            success: function(response){

                var res = JSON.parse(response);
               
                if(response.status == 200) {
                    window.location.reload();
                    alertify.success(res.message);
                } else{
                    alertify.error(res.message);
                }
            }
        })

    }


});
