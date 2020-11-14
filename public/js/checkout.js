$(document).ready(function () {
    /*
     Submit data checkout
     */
    $('#btn-submit').click(function () {
        if ($('#shipping-form').valid()) {
            $(this).attr('disabled', 'disabled');
            $(this).html('<i class="fa fa-spinner fa-pulse"></i>&nbsp;กรุณารอสักครู่');
            saveTotal();
            saveShippingData();
            var hash_id = getHashID();
            var key = hash_id[0] + '/' + hash_id[1];
            var campaign = parseOut(key);
            $.ajax({
                type: "POST",
                url: $(this).data('url'),
                data: {
                    "_token": $('#token').val(),
                    "campaign": campaign.campaign
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 'success') {
                        window.location = data.redirect_url;
                    }

                    $(this).removeAttr('disabled');
                    $(this).html('<i class="fa fa-check"></i>&nbsp;ดำเนินการต่อ');
                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        }
        else
        {
            var body = $("html, body");
            body.stop().animate({scrollTop:0}, '500', 'swing');
        }
    });

    function loadOrderedProduct() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        var text = "";
        var product_name = campaign.campaign.product.name;
        var total = 0;
        var transport_cost = 0;
        var card_cost = 0;

        $("#product-name").html(product_name);
        $("#product-image-front").attr('src', "../" + campaign.campaign.thmb_mini_front);
        $("#product-image-back").attr('src', "../" + campaign.campaign.thmb_mini_back);
        $('.basket-items').html('');
        $.each(campaign.campaign.order.items, function (key, o) {
            $.each(campaign.products, function (k, v) {
                $.each(v.products, function (index, value) {
                    var product = $(value).filter(function () {
                        return this.id == o.product_id;
                    })[0];
                    if (product) {
                        var total_qty = campaign.campaign.order.total;
                        var block_count = campaign.campaign.block_front_count + campaign.campaign.block_back_count;
                        var block_cost = parseInt($('#block_cost').val());
                        var block_total = (block_cost * 5) + (block_cost * block_count);
                        var block_per_unit = Math.round(block_total / total_qty);
                        var sell_price = (parseInt(o.qty) * (product.price + block_per_unit));
                        var image_data = $(product.image).filter(function () {
                            return this.id == o.image_id;
                        })[0];
                        total = total + parseInt(sell_price);

                        text = "<p>" + image_data.color_name + " " + o.size + " " + o.qty + " ตัว <span class='pull-right'> ฿" + parseInt(campaign.campaign.unit_price) * o.qty + "</span><p>";
                        $('.basket-items').append(text);


                        transport_cost = parseInt($("#transport-cost").attr('data-cost'));
                        $('#transport_cost').html($("#transport-cost").attr('data-cost'));
                        // if ($('#ems').is(':checked')) {
                        //     transport_cost = parseInt($("#transport-cost").attr('data-ems-cost'));
                        // }


                        if ($('#add-card').is(':checked')) {
                            card_cost = parseInt($('#card-cost').attr('data-card-cost'));
                            $('#show-card-cost').css("visibility", "visible");
                        }
                        else {
                            $('#show-card-cost').css("visibility", "hidden");
                        }
                    }
                    $("#product-name").text(product_name);
                });
            });

        });
        var sub_total = parseInt(campaign.campaign.sub_total);
        $("#total").html(sub_total + transport_cost + card_cost);
        //$('#sub-total').append(total);
    }

    function saveShippingData() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        var shipping = campaign.campaign.shipping;
        var payment_type = campaign.campaign.payment_type;

        shipping.full_name = $('#full_name').val();
        shipping.address = $('#address').val();
        shipping.building = $('#building').val();
        shipping.district = $('#district').val();
        shipping.province = $('#province').val();
        shipping.zipcode = $('#zipcode').val();
        shipping.phone = $('#phone').val();
        shipping.email = $('#email').val();
        campaign.campaign.shipping = shipping;
        campaign.campaign.order.shipping_type_id = $('input[name=shipping_type_id]:checked').val();
        var card = {};
        if ($('#add-card').is(':checked')) {
            card.add_card = 1;
            card.card_content = $('#card-content').val();
        }
        else {
            card.add_card = 0;
        }

        console.log(card);

        campaign.campaign.card = card;

        if ($('#radio-card:checked').val()) {
            payment_type = $('#radio-card:checked').val();
        }
        else {
            payment_type = $('#radio-bank:checked').val();
        }

        campaign.campaign.payment_type = payment_type;
        console.log(payment_type);
        parseIn(key, campaign);
    }

    function saveTotal() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        var order = campaign.campaign.order;
        order[total] = $('#total').text();
        campaign.campaign.order = order;
        console.log(order);
        parseIn(key, campaign);
    }

    function loadShippingData() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        var shipping = campaign.campaign.shipping;
        var payment_type = campaign.campaign.payment_type;

        $('#full_name').val(shipping.full_name);
        $('#address').val(shipping.address);
        $('#building').val(shipping.building);
        $('#district').val(shipping.district);
        $('#province').val(shipping.province);
        $('#zipcode').val(shipping.zipcode);
        $('#phone').val(shipping.phone);
        $('#email').val(shipping.email);

        if (campaign.campaign.order.shipping_type_id == "registered") {
            $('#registered').prop('checked', true);
            $('#transport-cost').html("฿" + 0);
        }
        else if (campaign.campaign.order.shipping_type_id == "ems") {
            $('#ems').prop('checked', true);
            $('#transport-cost').html("฿" + $('#transport-cost').attr('data-ems-cost'));
        }

        if (campaign.campaign.card.add_card == 1) {
            $('#add-card').prop('checked', true);
            $('#card-content').val(campaign.campaign.card.card_content);
        }

        if (payment_type == "bank") {
            $('#radio-bank').attr('checked', '');
            $('#radio-card').removeAttr('checked');
        }
        else if (payment_type == "card") {
            $('#radio-bank').removeAttr('checked');
            $('#radio-card').attr('checked', '');
        }
    }

    $('.shipping-type').change(function () {
        calShippingCost();
    });

    function calShippingCost()
    {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        var order = campaign.campaign.order;
        var type = $('.shipping-type:checked').val();
        var qty = order.sum_qty;

        $.ajax({
            type: "GET",
            url: './cal-shipping-cost/' + type + '/' + qty,
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#transport-cost').html("฿" + data.cost);
                $('#transport-cost').attr('data-cost', data.cost);
                loadOrderedProduct();
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    $('#add-card').click(function () {
        if ($('#add-card').is(':checked')) {
            $('#card-input-wrapper').toggleClass('hide');
            $('#show-card-cost').css("visibility", "visible");
        }
        else {
            $('#card-input-wrapper').toggleClass('hide');
            $('#show-card-cost').css("visibility", "hidden");
        }
        loadOrderedProduct();
    });
    saveShippingData();
    loadShippingData();
    loadOrderedProduct();

    calShippingCost();
});

function getHashID() {
    var url_hash = window.location.hash;
    var key = '';
    var hash_id = new Hashids("mubaza");
    if (url_hash == "") {
        key = hash_id.encode(Date.now());
        return [key, 0];
    }
    else {
        var url_split = url_hash.split('/');
        return [url_split[1], url_split[2]];
    }
}

function parseOut(key) {
    return JSON.parse(localStorage.getItem(key));
}

function parseIn(key, data) {
    localStorage.setItem(key, JSON.stringify(data))
}

function setUrl(key) {
    window.location.hash = "!/" + key;
}