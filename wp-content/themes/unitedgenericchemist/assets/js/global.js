/* global twentyseventeenScreenReaderText */
(function ($) {

    // Variables and DOM Caching.
    var $body = $('body'),
            $customHeader = $body.find('.custom-header'),
            $branding = $customHeader.find('.site-branding'),
            $navigation = $body.find('.navigation-top'),
            $navWrap = $navigation.find('.wrap'),
            $navMenuItem = $navigation.find('.menu-item'),
            $menuToggle = $navigation.find('.menu-toggle'),
            $menuScrollDown = $body.find('.menu-scroll-down'),
            $sidebar = $body.find('#secondary'),
            $entryContent = $body.find('.entry-content'),
            $formatQuote = $body.find('.format-quote blockquote'),
            isFrontPage = $body.hasClass('twentyseventeen-front-page') || $body.hasClass('home blog'),
            navigationFixedClass = 'site-navigation-fixed',
            navigationHeight,
            navigationOuterHeight,
            navPadding,
            navMenuItemHeight,
            idealNavHeight,
            navIsNotTooTall,
            headerOffset,
            menuTop = 0,
            resizeTimer;

    // Ensure the sticky navigation doesn't cover current focused links.
    $('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex], [contenteditable]', '.site-content-contain').filter(':visible').focus(function () {
        if ($navigation.hasClass('site-navigation-fixed')) {
            var windowScrollTop = $(window).scrollTop(),
                    fixedNavHeight = $navigation.height(),
                    itemScrollTop = $(this).offset().top,
                    offsetDiff = itemScrollTop - windowScrollTop;

            // Account for Admin bar.
            if ($('#wpadminbar').length) {
                offsetDiff -= $('#wpadminbar').height();
            }

            if (offsetDiff < fixedNavHeight) {
                $(window).scrollTo(itemScrollTop - (fixedNavHeight + 50), 0);
            }
        }
    });

    // Set properties of navigation.
    function setNavProps() {
        navigationHeight = $navigation.height();
        navigationOuterHeight = $navigation.outerHeight();
        navPadding = parseFloat($navWrap.css('padding-top')) * 2;
        navMenuItemHeight = $navMenuItem.outerHeight() * 2;
        idealNavHeight = navPadding + navMenuItemHeight;
        navIsNotTooTall = navigationHeight <= idealNavHeight;
    }

    // Make navigation 'stick'.
    function adjustScrollClass() {

        // Make sure we're not on a mobile screen.
        if ('none' === $menuToggle.css('display')) {

            // Make sure the nav isn't taller than two rows.
            if (navIsNotTooTall) {

                // When there's a custom header image or video, the header offset includes the height of the navigation.
                if (isFrontPage && ($body.hasClass('has-header-image') || $body.hasClass('has-header-video'))) {
                    headerOffset = $customHeader.innerHeight() - navigationOuterHeight;
                } else {
                    headerOffset = $customHeader.innerHeight();
                }

                // If the scroll is more than the custom header, set the fixed class.
                if ($(window).scrollTop() >= headerOffset) {
                    $navigation.addClass(navigationFixedClass);
                } else {
                    $navigation.removeClass(navigationFixedClass);
                }

            } else {

                // Remove 'fixed' class if nav is taller than two rows.
                $navigation.removeClass(navigationFixedClass);
            }
        }
    }

    // Set margins of branding in header.
    function adjustHeaderHeight() {
        if ('none' === $menuToggle.css('display')) {

            // The margin should be applied to different elements on front-page or home vs interior pages.
            if (isFrontPage) {
                $branding.css('margin-bottom', navigationOuterHeight);
            } else {
                $customHeader.css('margin-bottom', navigationOuterHeight);
            }

        } else {
            $customHeader.css('margin-bottom', '0');
            $branding.css('margin-bottom', '0');
        }
    }

    // Set icon for quotes.
    function setQuotesIcon() {
        $(twentyseventeenScreenReaderText.quote).prependTo($formatQuote);
    }

    // Add 'below-entry-meta' class to elements.
    function belowEntryMetaClass(param) {
        var sidebarPos, sidebarPosBottom;

        if (!$body.hasClass('has-sidebar') || (
                $body.hasClass('search') ||
                $body.hasClass('single-attachment') ||
                $body.hasClass('error404') ||
                $body.hasClass('twentyseventeen-front-page')
                )) {
            return;
        }

        sidebarPos = $sidebar.offset();
        sidebarPosBottom = sidebarPos.top + ($sidebar.height() + 28);

        $entryContent.find(param).each(function () {
            var $element = $(this),
                    elementPos = $element.offset(),
                    elementPosTop = elementPos.top;

            // Add 'below-entry-meta' to elements below the entry meta.
            if (elementPosTop > sidebarPosBottom) {
                $element.addClass('below-entry-meta');
            } else {
                $element.removeClass('below-entry-meta');
            }
        });
    }

    /*
     * Test if inline SVGs are supported.
     * @link https://github.com/Modernizr/Modernizr/
     */
    function supportsInlineSVG() {
        var div = document.createElement('div');
        div.innerHTML = '<svg/>';
        return 'http://www.w3.org/2000/svg' === ('undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI);
    }

    /**
     * Test if an iOS device.
     */
    function checkiOS() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    }

    /*
     * Test if background-attachment: fixed is supported.
     * @link http://stackoverflow.com/questions/14115080/detect-support-for-background-attachment-fixed
     */
    function supportsFixedBackground() {
        var el = document.createElement('div'),
                isSupported;

        try {
            if (!('backgroundAttachment' in el.style) || checkiOS()) {
                return false;
            }
            el.style.backgroundAttachment = 'fixed';
            isSupported = ('fixed' === el.style.backgroundAttachment);
            return isSupported;
        } catch (e) {
            return false;
        }
    }

    // Fire on document ready.
    $(document).ready(function () {

        // If navigation menu is present on page, setNavProps and adjustScrollClass.
        if ($navigation.length) {
            setNavProps();
            adjustScrollClass();
        }

        // If 'Scroll Down' arrow in present on page, calculate scroll offset and bind an event handler to the click event.
        if ($menuScrollDown.length) {

            if ($('body').hasClass('admin-bar')) {
                menuTop -= 32;
            }
            if ($('body').hasClass('blog')) {
                menuTop -= 30; // The div for latest posts has no space above content, add some to account for this.
            }
            if (!$navigation.length) {
                navigationOuterHeight = 0;
            }

            $menuScrollDown.click(function (e) {
                e.preventDefault();
                $(window).scrollTo('#primary', {
                    duration: 600,
                    offset: {top: menuTop - navigationOuterHeight}
                });
            });
        }

        adjustHeaderHeight();
        setQuotesIcon();
        if (true === supportsInlineSVG()) {
            document.documentElement.className = document.documentElement.className.replace(/(\s*)no-svg(\s*)/, '$1svg$2');
        }

        if (true === supportsFixedBackground()) {
            document.documentElement.className += ' background-fixed';
        }
    });

    // If navigation menu is present on page, adjust it on scroll and screen resize.
    if ($navigation.length) {

        // On scroll, we want to stick/unstick the navigation.
        $(window).on('scroll', function () {
            adjustScrollClass();
            adjustHeaderHeight();
        });

        // Also want to make sure the navigation is where it should be on resize.
        $(window).resize(function () {
            setNavProps();
            setTimeout(adjustScrollClass, 500);
        });
    }

    $(window).resize(function () {
        clearTimeout(resizeTimer);
        $(".footer-widgets-section .widget-column .widget-title").addClass("toggle");
        resizeTimer = setTimeout(function () {
            belowEntryMetaClass('blockquote.alignleft, blockquote.alignright');
        }, 300);
        setTimeout(adjustHeaderHeight, 1000);

    });

    // Add header video class after the video is loaded.
    $(document).on('wp-custom-header-video-loaded', function () {
        $body.addClass('has-header-video');
    });
    /* Product category menu open when click on it - Start */
    $(".main-product-category-list .cat-menu .cate-title a").hover(function () {
        $("#mega_menu_block").addClass('show');
    }, function () {
        $("#mega_menu_block").removeClass('show');
    });
    $("#mega_menu_block").hover(function () {
        $(this).addClass('show');
    }, function () {
        $(this).removeClass('show');
    });
    /* Product category menu open when click on it - End */
    jQuery(".footer-widgets-section .widget-column .widget-title").on("click", function () {
        jQuery(this).next().find("ul.menu").stop().slideToggle();
    });

    jQuery(".view-more-button").on("click", function () {
        jQuery(this).parent().prev().find("p:not(:first-child)").slideToggle();
        jQuery(this).text(jQuery(this).text() == 'View More' ? 'View Less' : 'View More');
    });

    jQuery("select.select-qty").change(function () {
        var selectedQty = jQuery(this).children("option:selected").val();
        jQuery(this).parent().next().find('.btn-add-to-cart-ajax').attr('data-quantity', selectedQty);
    });
    jQuery(".btn-add-to-cart-ajax").on("click", function () {
        var product_id, variation_id, qty, variation_key, variation_val, var_data = '';
        var var_data = {};
        product_id = jQuery(this).attr('data-product_id');
        variation_id = jQuery(this).attr('data-variation_id');
        qty = jQuery(this).attr('data-quantity');
        //console.log("Product ID = "+product_id+ "Variation ID = "+ variation_id + "Quantity = "+ qty);
        data_variation = jQuery(this).attr('data-variation');
        var_data = data_variation.split("=");
        variation_key = var_data['0'];
        variation_val = var_data['1'];
        var_data[variation_key] = variation_val;
        //jQuery(this).prop("disabled", true);
        var btn = jQuery(this);
        jQuery(this).html('<i class="fa fa-refresh fa-spin"></i>');
        console.log("Product ID = " + product_id + " Variation ID = " + variation_id + " Quantity = " + qty + " variation_key=" + variation_key + " variation_val=" + variation_val);
        jQuery.ajax({
            url: WC_VARIATION_ADD_TO_CART.ajax_url,
            data: {
                "action": "woocommerce_add_variation_to_cart",
                "product_id": product_id,
                "variation_id": variation_id,
                "quantity": qty,
                "variation": var_data
            },
            type: "POST",
            success: function (data) {
                btn.html('<i class="fa fa-shopping-cart" aria-hidden="true"></i>');
                btn.parent(".footable-last-visible").append('<a href="' + WC_VARIATION_ADD_TO_CART.checkout_url + '" title="Checkout" alt="Checkout" class="btn checkout_button" ><i class="fa fa-check" aria-hidden="true"></i></a>');

                console.log(data.fragments[".cart-items-count"]);
                jQuery('span.cart-items-count').replaceWith(data.fragments["span.cart-items-count"]);
                jQuery('div.widget_shopping_cart_content').replaceWith(data.fragments["div.widget_shopping_cart_content"]);
                jQuery(".cart.btn-group").addClass("show");
                jQuery(".cart.btn-group .dropdown-menu-mini-cart").addClass("show");
            }
        });
    });
    /* Product categories children dropdown */
    jQuery("<span class='arrow-toggle'></span>").insertAfter("li.cat-parent > a");
    jQuery(".product-categories .children")
    jQuery(".arrow-toggle").on("click", function () {
        jQuery(this).toggleClass("active");
        jQuery(this).next().stop().slideToggle();
    });

    /*Autocomplete search */
    $('.woocommerce-product-search').each(function () {
        var append = $(this).find('.live-search-results');
        var search_categories = $(this).find('.product_cat');
        var serviceUrl = WC_VARIATION_ADD_TO_CART.ajax_url + '?action=products_live_search';
        //var product_cat = '';

        if (search_categories.length && search_categories.val() !== '') {
            serviceUrl += '&product_cat=' + search_categories.val();
        }

        $(this).find('.search-text').devbridgeAutocomplete({
            minChars: 3,
            appendTo: append,
            triggerSelectOnValidInput: false,
            serviceUrl: serviceUrl,
            onSearchStart: function () {
                $('.btn-search .fa').removeClass('fa-refresh fa-spin');
                $('.btn-search .fa').addClass('fa-refresh fa-spin');
            },
            onSelect: function (suggestion) {
                if (suggestion.id !== -1) {
                    window.location.href = suggestion.url;
                }
            },
            onSearchComplete: function () {
                $('.btn-search .fa').removeClass('fa-refresh fa-spin');
            },
            beforeRender: function (container) {
                $(container).removeAttr('style');
            },
            formatResult: function (suggestion, currentValue) {
                var pattern = '(' + $.Autocomplete.utils.escapeRegExChars(currentValue) + ')';
                var html = '';
                if (suggestion.img) {
                    html += '<div class="search-product-image"><img src="' + suggestion.img + '" width="50" height="50" class="img-circle"></div>';
                }
                html += '<div class="search-product-title"><a href="' + suggestion.url + '">' + suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') + '</a></div>';
                if (suggestion.price) {
                    html += '<span class="search-product-price">' + suggestion.price + '</span>';
                }

                return html;
            }
        });

        if (search_categories.length) {
            var searchForm = $(this).find('.search-text').devbridgeAutocomplete();

            search_categories.on('change', function ( ) {
                if (search_categories.val() !== '') {
                    searchForm.setOptions({
                        serviceUrl: WC_VARIATION_ADD_TO_CART.ajax_url + '?action=products_live_search&product_cat=' + search_categories.val()
                    });
                } else {
                    searchForm.setOptions({
                        serviceUrl: WC_VARIATION_ADD_TO_CART.ajax_url + '?action=products_live_search'
                    });
                }
                // update suggestions
                searchForm.hide();
                searchForm.onValueChange();
            });
        }
    });
    /*
     * Trending Products display
     */
    $('.trending-products-rv .products').slick({
        dots: false,
        lazyLoad: 'ondemand',
        infinite: true,
        speed: 500,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    //*******************************************************************
    //*  Mobile menu display
    //*******************************************************************/

    //Menu wrapper
    $(".mobile-nav-tabs li").click(function () {
        if (!$(this).hasClass("active")) {
            var cn = $(this).data("menu");
            $(this).parent().find(".active").removeClass("active");
            $(this).addClass("active");
            $(".mobile-nav-content").removeClass("active").fadeOut(300);
            $(".mobile-" + cn + "-menu").addClass("active").fadeIn(300);
        }
    });

    //Menu
    var $mobileMenu = $('#mobile-menu-wrapper');
    $(document).on('click', '.navbar-toggle', function (e) {
        e.preventDefault();
        $mobileMenu.toggleClass('open');
        $('body').toggleClass('mobile-menu-opened');
    });

    $('.mobile-main-menu li.menu-item-has-children').append('<span class="menu-toggle"></span>');

    $mobileMenu.on('click', '.menu-item-has-children > .menu-toggle', function (e) {
        e.preventDefault();

        $(this).closest('li').siblings().find('ul').slideUp();
        $(this).closest('li').siblings().removeClass('active');
        $(this).closest('li').siblings().find('li').removeClass('active');

        $(this).closest('li').children('ul').slideToggle();
        $(this).closest('li').toggleClass('active');

    });

    $(document).on('click', '.panel-overlay, #mobile-nav-close', function (e) {
        e.preventDefault();
        $mobileMenu.removeClass('open');
        $('body').removeClass('mobile-menu-opened');
    });
    $(window).resize(function () {
        if ($(window).width() > 1199) {
            if ($mobileMenu.hasClass('open')) {
                $mobileMenu.removeClass('open');
                $('body').removeClass('mobile-menu-opened');
            }
        }
    });


    $('.homepage-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });
    var prescription_upload_url = WC_VARIATION_ADD_TO_CART.ajax_url + '?action=upload_prescription';
    var prescription_delete_url = WC_VARIATION_ADD_TO_CART.ajax_url + '?action=delete_prescription';
    /* file upload at checkout page*/
    $("#uploader").uploadFile({
        url: prescription_upload_url,
        fileName: "prescription",
        showDelete: true,
        returnType: "json",
        multiple: false,
        dragDrop: true,
        allowedTypes: "pdf,jpg,jpeg,png",
        onSuccess: function (files, data, xhr, pd) {
            $("#prescription_name").val(data);
        },
        deleteCallback: function (data, pd) {
            $.post(prescription_delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {

                    });
            pd.statusbar.hide(); //You choice.

//            loadAudioList();
        },
    });

    /**************************************************/
    /* Express Counter */
    /**************************************************/
    jQuery("#select_product").change(function () {
        let selectedProduct = '';
        selectedProduct = this.value;
        if (selectedProduct != '') {
            jQuery('.express_products').addClass('processing').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.75
                }
            });
            jQuery.ajax({
                url: WC_VARIATION_ADD_TO_CART.ajax_url,
                data: {
                    "action": "get_attributes_selected_products",
                    "product_id": selectedProduct,
                },
                type: "POST",
                success: function (data) {
                    console.log(data);
                    jQuery('.express_products').removeClass('processing').unblock();
                    jQuery('#strength_mg_list').html(data);
                    jQuery('.btn-express-section').find('.btn-express').prop('disabled', true);
                }
            });
        }
        check_visible_add_to_cart_button();
    });
    jQuery("#strength_mg_list").change(function () {
        let selectedMg = '';
        selectedMg = this.value;
        if (selectedMg != '') {
            jQuery('.express_products').addClass('processing').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.75
                }
            });
            jQuery.ajax({
                url: WC_VARIATION_ADD_TO_CART.ajax_url,
                data: {
                    "action": "get_variation",
                    "upsell_id": selectedMg,
                },

                type: "POST",
                success: function (data) {
//                    console.log(data);
                    jQuery('.express_products').removeClass('processing').unblock();
                    jQuery('#variation_list').html(data);
                    jQuery('.btn-express-section').find('.btn-express').prop('disabled', true);
                }
            });
        }
        check_visible_add_to_cart_button();
    });
    jQuery("#product_qty").change(function () {
        check_visible_add_to_cart_button();
    });
    jQuery("#variation_list").change(function () {
        check_visible_add_to_cart_button();
    });

    jQuery(".btn-express").on('click', function () {
        let btn = jQuery(this);
        let pId = btn.attr('data-product_id');
        let vId = btn.attr('data-variation_id');
        let qTy = btn.attr('data-quantity');
        btn.find('.fa').addClass('fa-refresh fa-spin');
        jQuery.ajax({
            url: WC_VARIATION_ADD_TO_CART.ajax_url,
            data: {
                "action": "woocommerce_ajax_add_to_cart",
                "product_id": pId,
                "quantity": qTy,
                "variation_id": vId,
            },
            type: "POST",
            success: function (data) {
                console.log(data);
                btn.find('.fa').removeClass('fa-refresh fa-spin');
                btn.find('.fa').addClass('fa-check');
                setTimeout(function () {
                    btn.find('.fa').removeClass('fa-check');
                }, 1000);
                jQuery('span.cart-items-count').replaceWith(data.fragments["span.cart-items-count"]);
                jQuery('div.widget_shopping_cart_content').replaceWith(data.fragments["div.widget_shopping_cart_content"]);
                jQuery(".cart.btn-group").addClass("show");
                jQuery(".cart.btn-group .dropdown-menu-mini-cart").addClass("show")
            }
        });
    });
})(jQuery);

function check_visible_add_to_cart_button() {
    let qty = jQuery('#product_qty').val();
    let select_product = jQuery('#select_product').val();
    let strength_mg_list = jQuery('#strength_mg_list').val();
    let variation_list = jQuery('#variation_list').val();
    if ((qty != '') && (select_product != '') && (strength_mg_list != '') && (variation_list != '')) {
        jQuery('.btn-express-section').find('.btn-express').prop('disabled', false);
    } else {
        jQuery('.btn-express-section').find('.btn-express').prop('disabled', true);
    }
    jQuery('.btn-express').attr('data-product_id', select_product);
    jQuery('.btn-express').attr('data-variation_id', strength_mg_list);
    jQuery('.btn-express').attr('data-quantity', qty);
}
