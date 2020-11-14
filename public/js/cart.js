$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    updateQty();
    $("#modal-cart").on("show.bs.modal", function () {
        if (store.has('cart')) {
            reloadCart();
        }
    });





    function rebindEvent() {
        $('.btn-minus').click(function(){   
            var this_input = $(this).parent().siblings('input') ;
            var current_qty = parseInt($(this).parent().siblings('input').val()) - 1;

            if(current_qty == 0) {
                removeItem(this_input.data("item-id"));
            } else {
                this_input.val(current_qty);
            }
            updateCartItem(this_input.data("item-id"), current_qty);
            updateQty();
        });

        $('.btn-plus').click(function () {
            var this_input = $(this).parent().siblings('input');
            this_input.val(parseInt($(this).parent().siblings('input').val()) + 1);
            updateCartItem(this_input.data("item-id"), this_input.val());
            updateQty();
        });

        var remove_btn = $(".remove-item");

        remove_btn.unbind("click");


        remove_btn.click(function () {
            var remove_btn = $(this);

            removeItem(remove_btn.data("item-id"));
        });

        var item_qty = $(".item-qty");
        item_qty.unbind('change');

        item_qty.on("change", function () {
            updateCartItem($(this).data("item-id"), $(this).val());
        });
    }
    function removeItem(item_id) {
        $.ajax({
            type: "GET",
            url: "/order/remove-item/" + item_id,
            success: function (data) {
                if (data.success) {
                    reloadCart();
                }
                else {
                    alert(data.message);
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }
    function updateCartItem(id, qty) {
        if (!store.has('cart')) {
            return false;
        }

        var cart = store.get('cart');

        var updated_items = [{id: id, qty: qty}];
        $.ajax({
            type: "POST",
            url: "/order/update-cart/" + cart.session_id,
            data: {
                items: updated_items
            },
            dataType: "json",
            success: function (data) {
                if (!data.success) {
                    alert(data.message);
                } else {
                    updateQty();
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    function reloadCart() {
        var cart = store.get("cart");
        $("#cart-wrapper").html('<div class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom loading-text"></i></div>');
        $.ajax({
            type: "GET",
            url: "/order/cart-html/" + cart.session_id,
            success: function (data) {
                if(data == "") {
                    $("#cart-wrapper").html("<p class='text-center'>ยังไม่มีสินค้าในตะกร้า</p>");
                    $("#checkout-btn").attr("disabled", true);
                } else {
                    $("#cart-wrapper").html(data);
                    $("#checkout-btn").removeAttr("disabled");
                    $("#checkout-btn").attr("href", "/order/checkout/" + cart.session_id);
                    rebindEvent();
                    updateQty();
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    function updateQty() {
        if (!store.has("cart")) {
            return false ;
        }
        var cart = store.get("cart");
        $.ajax({
            type: "GET",
            url: "/order/cart-qty/" + cart.session_id,
            success: function (data) {
                console.log(data);
                if(data.success) {
                    $(".cart_item_count").html(data.qty);
                    $("#qty-text").html(data.qty);
                    $("#total-text").html(data.total);
                } else
                {
                    $(".cart_item_count").html("0");
                    $("#qty-text").html("0");
                    $("#total-text").html(0);
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

});