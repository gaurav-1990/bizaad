(function () {

    var addToCart = {
        initModule: function () {
            this.cacheDom();
            this.bindEvents();
        },
        cacheDom: function () {

            this.$cartBucket = $('.shopping-cart');
            this.$imageParent = $('.list-block');
            this.$addToCart = $("button.add-cart");
            this.$addToCartDetails = $("button.add-to-cart");
            this.$cartdiv = $('.cart_details');

            this.$bookNow = $(".book-now");
            this.$base = window.origin;
           
            this.$cart_icon = $('.cart-icon');
            if (this.$base == 'http://192.168.1.247:8082')
            {
                this.$base = window.origin + "/bizaad/";
            } else
            {
                this.$base = this.$base + "/bizaad/";
            }
        },
        bindEvents: function () {
            this.$addToCart.on("click", this.addToCart.bind(this));
            this.$addToCartDetails.on("click", this.addToCartDetails.bind(this));
            this.$cart_icon.find("a").on("click", this.showCartDetails.bind(this));
        },
        shakeAndAddMe: function (e) {

            this.$imgtodrag = $(e.target).parent().parent().find("img").eq(0);  // getImage object

            if (this.$imgtodrag)
            {
                var imgclone = this.$imgtodrag.clone()
                        .offset({
                            top: this.$imgtodrag.offset().top,
                            left: this.$imgtodrag.offset().left
                        }).css({
                    'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                }).appendTo($('body'))
                        .animate({
                            'top': this.$cartBucket.offset().top + 10,
                            'left': this.$cartBucket.offset().left + 10,
                            'width': 75,
                            'height': 75
                        }, 1000, 'easeInOutExpo');
                setTimeout(function () {
                    addToCart.$cartBucket.effect("shake", {
                        times: 2
                    }, 200);
                }, 1500);
                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function () {
                    $(this).detach();
                });
            }
        },
        shakeAndAddMeDetails: function (e) {

            this.$imgtodrag = $(e.target).parent().parent().parent().siblings("div").nextUntil("image").eq(0);  // getImage object


            if (this.$imgtodrag)
            {
                var imgclone = this.$imgtodrag.clone()
                        .offset({
                            top: this.$imgtodrag.offset().top,
                            left: this.$imgtodrag.offset().left
                        }).css({
                    'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                }).appendTo($('body'))
                        .animate({
                            'top': this.$cartBucket.offset().top + 10,
                            'left': this.$cartBucket.offset().left + 10,
                            'width': 75,
                            'height': 75
                        }, 1000, 'easeInOutExpo');
                setTimeout(function () {
                    addToCart.$cartBucket.effect("shake", {
                        times: 2
                    }, 200);
                }, 1500);
                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function () {
                    $(this).detach();
                });
            }
        },
        showCartDetails: function (e)
        {
            if (this.show == 0)
            {
                $.ajax({
                    url: addToCart.$base + "getCartResult.php",
                    type: 'POST',
                    beforeSend: function (xhr) {
                        addToCart.$cartdiv.html("Loading..");
                    },
                    success: function (data, textStatus, jqXHR) {
                        addToCart.$cartdiv.show();
                        addToCart.show = 1;
                        addToCart.$cartdiv.css({"position": "absolute", "top": "61px", "right": "-15px", "z-index": "999", "background": "#fff", "width": "332px", "padding": "14px 12px"});
                        addToCart.$cartdiv.html(data);

                    }
                });
            } else
            {
                addToCart.$cartdiv.hide();
                addToCart.show = 0;
            }
        },
        addToCart: function (e)
        {
            
            var pro_id = $(e.target).data('pro');
            
            var vendor_id = $(e.target).data('ven');
           
            $.ajax({
                url: addToCart.$base + "addToCartSession.php",
                type: 'POST',
                data: {pro_id: pro_id, qty: 1 ,ven_id:vendor_id},
                success: function (data, textStatus, jqXHR) {
                    
                    addToCart.shakeAndAddMe(e);
                    addToCart.$cart_icon.find("a span").text(data);
                }
            });
        },
        addToCartDetails: function (e)
        {

            var pro_id = $(e.target).data('pro');
     
            $.ajax({
                url: addToCart.$base + "addToCartSession.php",
                type: 'POST',
                data: {pro_id: pro_id, qty: 1},
                success: function (data, textStatus, jqXHR) {
                    addToCart.shakeAndAddMeDetails(e);
                    addToCart.$cart_icon.find("a span").text(data);
                }
            });
        },

    };
    addToCart.initModule();
})();





    