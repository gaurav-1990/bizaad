(function () {
    var addToCart = {
        init: function ()
        {
            this.cacheDom();
            this.bindEvents();
            this.updateCardCount();
        },
        updateCardCount: function ()
        {

            $.ajax({
                url: this.$base + "Dashboard/cartCount",
                type: 'POST',
                success: function (data, textStatus, jqXHR) {
                    addToCart.setCartCount(data);
                }
            });

        },
        cacheDom: function ()
        {
            this.btnDiv = $('.btn-addcart-product-detail');
            this.btn = this.btnDiv.find('button');
            this.addToCart = this.find('.add-to-cart');
            this.$all_option = $('#all_option');
            this.$searchBox = $('#searchProduct');
            this.$price = $('.price_class');
            this.$zip_address = $("#zip_address");
            this.$user_pin_code=$('input[name="user_pin_code"]');
            this.$selecttion = $('.selection-2');
            this.$card_count = $('.header-icons-noti');
            this.$cartUpdate = $('#cartUpdate');
            this.$cartIcon = $('.header-wrapicon2');
            this.$checkAvail = $('#checkAvail');
            this.$base = window.origin;
            this.$firstCategory = $('#firstCategory');
            this.$shopping = $('.table-shopping-cart');
            this.$changeQty = $('.table-row');
            this.json = {};
            if (this.$base == 'http://192.168.1.247:8082')
            {
                this.$base = window.origin + "/shoptrendy/";
            } else
            {
                this.$base = this.$base + "/";
            }

        },
        showCartDetails: function (e)
        {
            var target = ".header-icon1";

            $(target).siblings('.header-dropdown').toggleClass('show-header-dropdown');
            if ($(target).siblings('.header-dropdown').hasClass('show-header-dropdown'))
            {
                $.ajax({
                    url: addToCart.$base + "Dashboard/getCardDetails",
                    type: 'POST',
                    beforeSend: function (xhr) {
                        $(target).siblings('.header-dropdown').text('loading..');
                    },
                    success: function (data, textStatus, jqXHR) {
                        $(target).siblings('.header-dropdown').html(data);
                    }
                });
            }
        },
        bindEvents: function ()
        {
            this.btn.on('click', this.addToCartEvent.bind(this));
            this.addToCart.on('click', this.addToCartEventDetails.bind(this));
            this.$shopping.find('.table-row').delegate("#select_option", 'change', this.changeQtySubmit.bind(this));
            this.$cartIcon.on('click', this.showCartDetails.bind(this));
            this.$checkAvail.on("click", this.checkAvail.bind(this));
            this.$user_pin_code.on("keyup",this.checkPinCode.bind(this));
            this.$searchBox.on("click", this.onFocusSearch.bind(this));
            this.$searchBox.on("keyup", this.loadProducts.bind(this));
//            this.$shopping.find('.column-6 i').on('click', this.trashItem.bind(this));

        },
        loadProducts: function (e)
        {

            if ($(e.target).val().length > 2)
            {
                $.ajax({
                    url: addToCart.$base + "Dashboard/getProductList",
                    type: 'POST',
                    data: {char: $(e.target).val()},
                    success: function (data, textStatus, jqXHR) {
                        if ($(e.target).val() != '')
                        {
                            $(e.target).next("button").next('ul').remove();
                            $(e.target).next("button").after(data);
                        }
                    }
                });

            } else
            {
                $(e.target).next("button").next('ul').remove();
            }
        },
        onFocusSearch: function (e)
        {
            $(e.target).attr('autocomplete', 'off');
        },
        changeQtySubmit: function (e)
        {
            this.$cartUpdate.submit();
        },
        addToCartEvent: function (e)
        {
            var producta = [];
            var productProp = [];
            var qty = $(e.target).parent().prev('div').find('input').val();
            var count = 0;
            this.$selecttion.each(function (i, val)
            {
                count++;
                if ($(this).val().length > 0 && $(this).val() != '' && $(this).val() != null)
                {
                    producta.push($(this).val());
                    var key = $(this).data("key");
                    productProp.push({[key]: $(this).val()});
                }
            });

            if (addToCart.$zip_address.val() == '' || addToCart.$zip_address.val() == null)
            {
                alert("Please enter pin code");
                addToCart.$zip_address.focus();
                return false;
            }
            if (producta.length !== count)
            {
                alert("Please select all option");
                return false;
            }


            var product = $(e.target).data('bind');
            var ap = parseFloat($(this.$selecttion).parent().parent().parent().data('price'));
            $.ajax({
                url: addToCart.$base + "Dashboard/getQty",
                type: 'POST',
                data: {product: product, data: productProp, qty: qty},
                success: function (data, textStatus, jqXHR) {
 
                    var jsonResponse = JSON.parse(data).response;
                    var jsondata = JSON.stringify(jsonResponse);
                    var last = JSON.parse(data).last;
                    
                    if (jsonResponse.qty == 0)
                    {
                        alert("Out of stock");
                        return false;
                    }
                    if (parseInt(jsonResponse.qty) < parseInt(qty))
                    {
                        alert("Only " + jsonResponse.qty + " product left ! please modify quantity");
                        return false;
                    }
                    if (parseInt(last) < 0)
                    {
                        alert("This Qty is not available please update quantity!");
                        return false;
                    }

                    $.ajax({
                        url: addToCart.$base + "Dashboard/addToCart",
                        type: 'POST',
                        async: false,
                        data: {product: product, data: jsondata, qty: qty},
                        success: function (data, textStatus, jqXHR) {
                            addToCart.$card_count.text(data);
                            swal(qty + " " + $(e.target).data('product'), "is added to cart !", "success");

                        }
                    });

                }
            });
        },
        addToCartEventDetails: function (e)
        {
            var producta = [];
            var productProp = [];
            var qty = 1;
            var count = 0;
            

            


            var product = $(e.target).data('bind');
            var ap = parseFloat($(this.$selecttion).parent().parent().parent().data('price'));
            $.ajax({
                url: addToCart.$base + "Dashboard/getQty",
                type: 'POST',
                data: {product: product, data: productProp, qty: qty},
                success: function (data, textStatus, jqXHR) {
 
                    var jsonResponse = JSON.parse(data).response;
                    var jsondata = JSON.stringify(jsonResponse);
                    var last = JSON.parse(data).last;
                    
                    if (jsonResponse.qty == 0)
                    {
                        alert("Out of stock");
                        return false;
                    }
                    if (parseInt(jsonResponse.qty) < parseInt(qty))
                    {
                        alert("Only " + jsonResponse.qty + " product left ! please modify quantity");
                        return false;
                    }
                    if (parseInt(last) < 0)
                    {
                        alert("This Qty is not available please update quantity!");
                        return false;
                    }

                    $.ajax({
                        url: addToCart.$base + "Dashboard/addToCart",
                        type: 'POST',
                        async: false,
                        data: {product: product, data: jsondata, qty: qty},
                        success: function (data, textStatus, jqXHR) {
                            addToCart.$card_count.text(data);
                            swal(qty + " " + $(e.target).data('product'), "is added to cart !", "success");

                        }
                    });

                }
            });
        },

        setCartCount: function (length)
        {
            this.$card_count.text(length);
        },
        changeProperty: function (e)
        {
            var ap = parseFloat($(this.$selecttion).parent().parent().parent().data('price'));
            var total = 0.0;
            this.$selecttion.each(function (i, val) {
                if ($(this).find(":selected").val() !== '') {
                    $.ajax({
                        url: addToCart.$base + "Dashboard/getAttr",
                        type: 'POST',
                        async: false,
                        data: {'red': $(this).find(":selected").val().toString()},
                        success: function (data, textStatus, jqXHR) {
                            total = total + parseFloat(data);
                        }
                    });
                }
            });

            this.$price.text(ap + total);
            return (ap + total);
        },
        checkPinCode:function(e)
        {
            if($(e.target).val().length==6)
            {
                $.ajax({
                url: addToCart.$base + "Dashboard/checkAvailability",
                type: 'POST',
                async: false,
                data: {zipAddress: $(e.target).val()},
                success: function (data, textStatus, jqXHR) {
                    var da = parseInt($.trim(data));
                    if (da > 0)
                    {
                     
                    } else
                    {

                        alert("Delivery is not available in this area");
                        $(e.target).focus();
                        return false;
                    }



                }
            }); 
            }
        },
        checkAvail: function (e)
        {

            $.ajax({
                url: addToCart.$base + "Dashboard/checkAvailability",
                type: 'POST',
                async: false,
                data: {zipAddress: addToCart.$zip_address.val()},
                success: function (data, textStatus, jqXHR) {
                    var da = parseInt($.trim(data));
                    if (da > 0)
                    {
                        $(e.target).siblings("p").removeClass("text-danger");
                        $(e.target).siblings("p").removeClass("text-success");
                        $(e.target).siblings("p").addClass("text-success").html('Delivery is available in this area');
                    } else
                    {

                        $(e.target).siblings("p").removeClass("text-danger");
                        $(e.target).siblings("p").removeClass("text-success");
                        $(e.target).siblings("p").addClass("text-danger").html('Delivery is not available in this area');
                    }



                }
            });
        }
    };
    addToCart.init();
})()


 