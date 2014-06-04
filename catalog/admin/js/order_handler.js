/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

var timestamp=null,
    oID=null,
    xmlHttp,
    running = false;

$(function() {
    var title = $( "#title" ),
      value = $( "#value" ),
      allFields = $( [] ).add( name ).add( value ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n ) {
      o.removeClass( "ui-state-error" );
      if ( o.val().length <= 0 ) {
        o.addClass( "ui-state-error" );
        updateTips( "The " + n + " can not be empty." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkNumber( o, n ) {
      if ( isNaN( o.val() ) === true || o.val() === '' ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    $.fn.dialogForm = function() {
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: "auto",
      width: 350,
      modal: true,
      buttons: {
        "Add a field": function() {
            var bValid = true,
                orderID = '';
            allFields.removeClass( "ui-state-error" );
            bValid = bValid && checkLength( title, "Title" );
            bValid = bValid && checkNumber( value, "Value must contain a number." );

            if ( bValid ) {
                orderID = $( "#order_number" ).html();
                var form = $( this ).find( "form" ),
                    url = $(form).serialize();

                url = "orders_ajax.php?oID=" + orderID + "&" + url;

                var jqxhr = $.ajax({
                    type: 'GET',
                    url: encodeURI( url ),
                    async: true,
                    global: false,
                    dataType: 'json'
                });

                jqxhr.done(function( payload ) {
                    if( payload.status == 'success' ) {
                        $( this ).gritter( "Success", payload.message );
                        return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals', false );
                    } else if( payload.status == 'error' ) {
                        $( this ).gritter( "Error", payload.message );
                    }
                });

                $( this ).dialog( "close" );
            }

            return false;
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
        $( this ).dialog( "destroy" );
      }
    });
    $( "#dialog-form" ).dialog( "open" );

    };


    $.fn.ajaxOrderDelete = function( ) {
        var input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "batch_delete_x").val("1");
        $('#batch_orders').append($(input));

        var jqxhr =
        $.ajax({
            type: 'POST',
            url: encodeURI($( '#batch_orders' ).attr( 'action' )),
            data: $( '#batch_orders' ).serialize(),
            dataType: 'html'
        });

        jqxhr.done(function( data ) {
            $( "#ajaxOrderDelete" ).html( data );
            $( "#myModalButton" ).click();
        });

        return false;
    };


    $( "body" ).on( "click", "#batch_delete, .batch_delete", function(event){
        event.preventDefault();

        $( "#batch_confirm" ).show();
        $( this ).ajaxOrderDelete();
    });

    $( "#select_status" ).submit(function( event ) {
        var status = $( "#order_by_prod_quantity" ).prop( "checked" );

        history.pushState( null, null, this.action + '&' + $( this ).serialize() );
        var data_link = this.action + '&ajax=1&' + $( this ).serialize();

        return $( this ).ajaxLink( data_link, 'orderTable' );
    });

    $( "body" ).on('submit', 'form#batch_orders', function(event){
                event.preventDefault();
                var navbar = $( "#navbar" ).clone().appendTo( "body" ),
                        form = $( this ).find( "input" ).clone().appendTo( navbar ),
                        target = navbar.find( $( "input[type='radio'][name='target_file']:checked" ) ).val();
                if ( target != "invoice.php" )
                        navbar[0].target = "_self";
                $( navbar ).submit();
                $( navbar ).remove();
                return false;
        });


    $('body').on('click', '#batch_confirm', function(event){
        event.preventDefault();

        var restock = $( "input[name=restock]" ).prop( "checked" );

        if ( restock === true ) {
            var input = $("<input>")
            .attr("type", "checkbox")
            .attr("name", "restock").prop( "checked", true );
            $( '#formDelete' ).append( $( input ) );
        }

        var link = $( this ).attr( "data-href" ),
            jqxhr =
        $.ajax({
            type: 'POST',
            url: encodeURI($('#formDelete').attr('action')),
            data: $('#formDelete').serialize(),
            dataType: 'html'
        });

        jqxhr.done(function( data ) {
            $( "#ajaxOrderDelete" ).html( data );

            history.pushState( null, null, link );
            $( this ).ajaxLink(link, 'orderTable' );
            $( "#batch_confirm" ).hide();
            $( "#restock" ).hide();
        });

        return false;
    });

    /* Send Ajax GET for URL*/
    $.fn.ajaxLink = function( link, replace_with, global ) {
        global = ( typeof( global ) == "undefined" ? true : false );
        $.ajax({
            type: 'GET',
            url: encodeURI( link ),
            async: true,
            global: global,
            dataType: 'html'
        })
        .done(function( data ) {
            if ( replace_with === false ) return false;
            var replacement = $( data ).closest( '#' + replace_with );
            $( replacement ).find('.comments, .tooltip_set').tooltip('toggle').tooltip('hide');
            $( '#' + replace_with ).replaceWith( replacement );

            return false;
        });

        return false;
    };

    /* Close Dialog */
    $('body').on('click', '.closeWindow', function(event){
        event.preventDefault();
        return($('#ajax_cart_dialog').dialog('close'));
    });

    /* Poller Button */
    $('#navigationBottom').on('click', '#poller label', function(event){
        var target = event.currentTarget,
            parent = target.parentNode,
            classes = target.className,
            success = event.currentTarget.parentElement.children[2],
            danger = event.currentTarget.parentElement.children[3],
            cog = event.currentTarget.parentElement.children[0].children[0],
            poll_timer = $( "#poll_timer" ).val();

        //if ( classes.indexOf( "active" ) >= 0 ) return false;

        if ( target == success ) {
            cog.className = "fa fa-cog fa-spin";
            target.className = "btn btn-lg btn-success";
            danger.className = "btn btn-lg btn-default";
            $( this ).gritter( "Ajax Long-Polling", "Polling has been Enabled." );
            polling = true;
            return messages_longpolling( last_order_number, poll_timer );
        } else if ( target == danger ) {
            cog.className = "fa fa-cog fa-spin noAnimation";
            target.className = "btn btn-lg btn-danger active";
            success.className = "btn btn-lg btn-default";
            polling = false;
            return $( this ).gritter( "Ajax Long-Polling", "Polling has been Disabled.", true );
            
        }
        return false;
    });


    $.fn.ajaxDialog = function(data_link) {
    var $dialog = $('<div id="ajax_cart_dialog"></div>')
    .load(data_link + "&ajax=1", function(){
        $('#overlay').fadeOut('slow', function() {
            $('#overlay').remove();
        });
    })
    .dialog({
        resizable: true,
        modal: true,
        draggable: true,
        autoOpen: false,
        dialogClass: "ajax_cart",
        closeOnEscape: true,
        show: {effect: 'fade', duration: 250},
        hide: {effect: 'drop', direction: "down", duration: 200},
        open: function(event, ui)
        {
            //here we can apply unique styling
                
            $(this).parent()
            .css('top', '15%');

            $(this).parents(".ui-dialog:first")
            .find(".ui-dialog-titlebar").remove();

            $(this).parents(".ui-dialog")
            .css("background", '#FFF');

            $(this).parents(".ui-dialog:first").find(".ui-dialog-content")
            .css("padding", 0)
            .css("overflow", 'hidden');
        },
        close: function( event, ui ) {
            var checkout_page = $('form[name=checkout_confirmation]').length,
                url = $( location ).attr( "href" ).split("/"),
                filename = url[url.length - 1],
                addProduct = $( "#add-Product" ),
                orderTable = $( "#orderTable" );

            addProduct.insertBefore( orderTable );

            filename = filename.split('\?')[0] ;
            if ( filename == 'checkout_confirmation.php' || filename == 'shopping_cart.php' || checkout_page !== 0)
            {
                $('form[name=boxcart_quantity]').submit();
            }

            return $('#ajax_cart_dialog').dialog( "destroy" ).remove();
        }
        }).css('overflow', 'auto');

        return $dialog.dialog("open");
    };


    $.fn.capitalizeString = function(string) {
        var names = string.toLowerCase().match(/([A-ö0-9]+[-]{0,1})/g).slice(),
        name = '';

        for ( var i = 0, l = names.length; i < l; i++ ) {
            name += names[ i ].charAt(0).toUpperCase() + names[ i ].slice(1);
            if ( /[^-]$/.test( name ) && i < l - 1 )
            name += " ";
        }
        return this[0].innerText =
        name;
    };


    $('body').on('click', 'a.ajaxLink', function(event){
        event.preventDefault();

        var orderID = $( "#order_number" ).html(),
            table = $( this ).attr( "data-table" ),
            field = $( this ).attr( "data-field" ),
            pred = $( this ).html(),
            //newValue = prompt("New Value:", pred),
            id = this.id,
            url = "orders_ajax.php?action=update_order_field&oID=" + orderID + "&db_table=" + table + "&field=" + field + "&new_value=";
        return( $( this ).tDialog( url, orderID, pred, false, false, this ) );
    });

    $('body').on('click', 'a.ajaxLinkTotals', function(event){
        event.preventDefault();

        var orderID = $( "#order_number" ).html(),
            classe = $( this ).attr( "data-class" ),
            column = $( this ).attr( "data-column" ),
            pred = $( this ).attr( "data-pred" ),
            action = $( this ).attr( "data-action" ),
            data_title = $( this ).attr( "data-title" ),
            href = $( this ).attr( "href" ),
            jqxhr = '';

        if ( action == "eliminate" ) {
            jqxhr =
            $.ajax({
                type: 'POST',
                async: true,
                global: false,
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: { oID: orderID, total_class: classe, title: encodeURIComponent( data_title ) },
                url: encodeURI( href ),
                dataType: "JSON"
            });

            jqxhr.done(function( payload ) {
                if( payload.status == 'success' ) {
                    $( this ).gritter( "Success", payload.message );
                    return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals', false );
                } else if( payload.status == 'error' ) {
                    $( this ).gritter( "Error", payload.message );
                }
            });
            return false;
        }

        if ( column == "value" )
            pred = pred.replace(/[^0-9\.]+/g,"");

        var tdialog = $.fn.tdialog({
            type:"prompt",
            title:'Enter new value',
            closeKey: true,
            content: (typeof content != "undefined" ? content : "<h5>Enter new value</h5>"),
            promptCallback:function(){
                var newValue = $( "#newValue" ).val();

                if (newValue !== null){
                    if (classe == 'value') newValue = parseFloat(newValue);
                    var url="orders_ajax.php?action=orders_total_update&oID=" + orderID + "&column=" + column + "&class=" + classe + "&new_value=" + newValue;

                    jqxhr = $.ajax({
                        type: 'GET',
                        url: encodeURI( url ),
                        async: false,
                        global: false,
                        dataType: 'json'
                    });

                    jqxhr.done(function( payload ) {
                        if( payload.status == 'success' ) {
                            $( this ).gritter( "Success", payload.message );
                            return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals' );
                        } else if( payload.status == 'error' ) {
                            $( this ).gritter( "Error", payload.message );
                        }
                    });

                    return false;
                }
            }
        });

        $.when( tdialog ).done(function(){
            $( "#newValue" ).attr( "placeholder", pred).trigger( "focus" );
        });
        return false;
    });

    /* Avgrund Modal */
    $( "body" ).on( "keyup", "#newValue", function( event ){
        if ( event.keyCode == 13 ) {
            $( "#avgrund_button" ).click();
            $( ".button_ok" ).click();
        } else if ( event.keyCode == 27 ) {
            $( ".button_cancel" ).click();
        }
    });


    $( "body" ).on( "keyup", function( event ) {
        if ( event.keyCode == 27 ) {
            $.fn.closeTdialog();
        }
    });


    $( "body" ).on( "click", "#avgrund_button", function( event ){
        event.preventDefault();
        var url = this.href,
            extended = $( "#extended" ).val(),
            orderID = $( "#orderID" ).val(),
            newValue = $( "#newValue" ).val();

        if ( extended === true ) {
            if ( ( newValue !== null ) && ( newValue !== '' ) ) {
                newValue +=  "&option_price=" + prompt("Price:");
            }
        }

        url += newValue;

        var jqxhr = $.ajax({
            type: 'GET',
            url: encodeURI( url ),
            async: true,
            global: false,
            dataType: 'json'
        });

        jqxhr.done(function( payload ) {
            if( payload.status == 'success' ) {
                $( this ).gritter( "Success", payload.message );
                return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals', false );
            } else if( payload.status == 'error' ) {
                $( this ).gritter( "Error", payload.message );
            }
        });

        jqxhr.always(function() {
            $( ".avgrund-close" ).click();
        });
        
    });


    $.fn.aDialog = function( url, orderID, pred, extended ) {


        var adialog = $( this ).avgrund({
            //height: 200,
            holderClass: 'custom',
            showClose: true,
            showCloseText: 'close',
            onBlurContainer: '.container',
            enableStackAnimation: true,
            template: '<h3>Enter new value</h3>' +
            '<p>If you want to close modal, please hit "Esc", click somewhere on the screen or use special button.</p>' +
            '<input type="hidden" name="orderID" id="orderID" value="' + orderID + '" />' +
            '<input type="hidden" name="extended" id="extended" value="' + extended + '" />' +
            '<input type="text" class="form-control" id="newValue" placeholder="' + pred + '">' +
            '<div>' +
            '<a href="' + url + '" id="avgrund_button" class="avgrund_button">Submit</a>' +
            '</div>'
        });

        $.when( adialog ).done(function(){
            $( "#newValue" ).trigger( "focus" );
        });

        return false;
    };


    $.fn.tDialog = function( url, orderID, pred, extended, refreshTotals, capitalize, content ) {

    var tdialog = $.fn.tdialog({
        type:"prompt",
        title:'Enter new value',
        effect:'css3',
        css3EffectIn:'',
        css3EffectOut:'bench-out',
        content: (typeof content != "undefined" ? content : "<h5>Enter new value</h5>"),
        promptCallback:function(){
            newValue = $("#newValue").val();
            if ((newValue === null) || (newValue === '')) return false;

            if ( capitalize.id != 'customers_email_address' && capitalize !== false ) {
                    formattedValue = $( this ).capitalizeString( newValue );
                    $( capitalize ).html( formattedValue );
            } else {
                formattedValue = newValue;
                $( capitalize ).html( formattedValue );
            }

            if ( extended === true ) {
                if ( ( newValue !== null ) && ( newValue !== '' ) ) {
                    newValue +=  "&option_price=" + prompt("Price:");
                }
            }

            url += formattedValue;

            var jqxhr = $.ajax({
                type: 'GET',
                url: encodeURI( url ),
                async: true,
                global: false,
                dataType: 'json'
            });

            jqxhr.done(function( payload ) {
                if( payload.status == 'success' ) {
                    $( this ).gritter( "Success", payload.message );
                    if ( refreshTotals === true )
                        return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals', false );

                } else if( payload.status == 'error' ) {
                    $( this ).gritter( "Error", payload.message );
                }
            });

            return false;
        }
     });

        $.when( tdialog ).done(function(){
            $( "#newValue" ).attr( "placeholder", pred).trigger( "focus" );
        });
    };

    $('body').on('click', 'a.ajaxLinkProduct', function(event){
        event.preventDefault();

        var orderID = $( "#order_number" ).html(),
            productID = $( this ).attr( "data-product" ),
            field = $( this ).attr( "data-field" ),
            action = $( this ).attr( "data-action" ),
            extra = $( this ).attr( "data-extra" ),
            pred = $( this ).attr( "data-pred" ),
            newValue = '',
            url = '';

        if (action == 'eliminate') {
            $.fn.tdialog({
                type:"confirm",
                content:"Are you sure you want to eliminate this product from the order?",
                title:"Confirm",
                icon:"confirm",
                effect:'css3',
                css3EffectIn:'',
                css3EffectOut:'bench-out',
                confirmCallback:function(){
                    newValue = 0;
                    url = "orders_ajax.php?action=eliminate&pID=" + productID + "&order=" + orderID + "&new_value=" + newValue;

                    var jqxhr = $.ajax({
                        type: 'GET',
                        url: encodeURI( url ),
                        async: true,
                        global: false,
                        dataType: 'json'
                    });

                    jqxhr.done(function( payload ) {
                        if( payload.status == 'success' ) {
                            $( this ).gritter( "Success", payload.message );
                            return $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + orderID, 'productTotals', false );
                        } else if( payload.status == 'error' ) {
                            $( this ).gritter( "Error", payload.message );
                        }
                    });
                }
            });

        } else if (action == 'update') {
            url = "orders_ajax.php?action=update_product&pID=" + productID + "&order=" + orderID + "&field=" + field + "&new_value=";
            if (extra !== '') {
                url += "&extra=" + extra;
            }

            if (field == 'options') {
                return( $( this ).tDialog( url, orderID, pred, true, true, false ) );
            } else {
                return( $( this ).tDialog( url, orderID, pred, false, true, false ) );
            }
        }
        return false;
    });


    $('body').on('click', '#createOrdersTotal', function(event){
        event.preventDefault();
        return $( this ).dialogForm( );
    });


    $('body').on('click', 'button.ajax_button', function(event){
        event.preventDefault();

        var jqxhr = $.ajax({
                type: 'POST',
                url: $( "#update_status" ).attr( "action" ),
                data: $( "#update_status" ).serialize(),
                dataType: 'json'
            });

        jqxhr.done(function( payload ) {
            if( payload.status == 'success' ) {
                $( "#comment_table" ).html( $.parseJSON( payload.html ) );
                $( this ).gritter( "Success", payload.message );
            } else if( payload.status == 'error' ) {
                $( this ).gritter( "Warning", payload.message );
            }
        });
        return false;
    });

    $.fn.directLink = function( url ) {
        var topnavHeight = $( "#navigationTop" ).height(),
            botnavHeight = $( "#navigationBottom" ).height();
        history.pushState( null, null, url );

        if ( url.indexOf( "search=" ) === -1 ) {
            $( "#navigationBottom" ).animate( { bottom: '-' + botnavHeight + 'px' } );
            $.when( $( "#navigationTop" ).animate( { top: '-' + topnavHeight + 'px' } ) ).done(function() {
                $( "#navigationTop" ).toggle();
            });
        }

        return $( this ).ajaxLink(url + '&ajax=1', 'orderTable' );
    };

    $('body').on('click', 'a.ajax_button', function(event){
        event.preventDefault();

        var link = this.href,
            topnavHeight = $( "#navigationTop" ).height(),
            botnavHeight = $( "#navigationBottom" ).height();

        history.pushState( null, null, link );

        $( "#navigationBottom" ).animate( { bottom: 0 } );
        $( "#navigationTop" ).css( "display", "block" );
        $( "#navigationTop" ).animate( { top: 0 } );

        return $( this ).ajaxLink(link + '&ajax=1', 'orderTable' );
    });

    $('body').on('click', '#addProduct', function(event){
        event.preventDefault();
        var orderID = $( "#order_number" ).html(),
            count = $( "#ajax_cart_dialog" ).size(),
            addProduct = $("#add-Product"),
            ajax_cart_top = $("#ajax_cart_top"),
            width = '',
            height = '';

        if (navigator.appName == "Microsoft Internet Explorer"){
            width = screen.width;
            height = screen.height;
        } else {
            width = window.innerWidth;
            height = window.innerHeight;
        }
        document.getElementById('add-Product').style.top = (height/2)-100;
        document.getElementById('add-Product').style.left = (width/2)-100;
        document.getElementById('add-Product').style.display = 'block';
        document.getElementById('keywords').focus();


        if ( count > 0 ) addProduct.insertAfter( ajax_cart_top );
    });

    $( "body" ).on('submit','form#pages',function(){
        var data_link = this.action + '?ajax=1&' + $( this ).serialize();

        return $( this ).ajaxLink( data_link, 'orderTable' );
    });

    $('body').on('click', '#ordersTable td.dataTableContent:not(td.ajax_disable), #ordersTable a:not(a.ajax_disable), #ordersTable .splitPageLink, #orderTable a.duplicate_order', function(event){
        event.preventDefault();
        var classes = $( this ).attr( "class" ),
            jqxhr = '',
            ordersTable = '',
            data_link = '',
            topnavHeight = $( "#navigationTop" ).height(),
            botnavHeight = $( "#navigationBottom" ).height();
        
        if ( ( classes.indexOf( "ajax_disable" ) >= 0 ) || ( classes.indexOf( "splitPageLink" ) >= 0 ) ) {
            data_link = this.href;

            history.pushState( null, null, data_link );
            
            $( this ).ajaxLink( data_link + "&ajax=1", 'orderTable' );
            return false;
        } else if ( classes.indexOf( "expand_order" ) >= 0 ) {
            return( $( this ).ajaxDialog( this.href ) );
        } else if ( classes.indexOf( "duplicate_order" ) >= 0 || classes.indexOf( "mail_confirmation" ) >= 0 ) {
            running = true;
            jqxhr = $.ajax({
                type: 'GET',
                url: this.href,
                dataType: 'json'
            });
            
            ordersTable = $( "#ordersTable" ).size();

            jqxhr.done(function( payload ) {
                if ( classes.indexOf( "mail_confirmation" ) >= 0 ) {
                    if( payload.status == 'success' ) {
                        $( this ).gritter( "Success", payload.message );
                    } else if( payload.status == 'error' ) {
                        $( this ).gritter( "Error", payload.message );
                    }
                    return false;
                }

                if( payload.status == 'success' ) {
                    if ( ordersTable > 0 )
                        $( this ).getLines( last_order_number, false );
                    $( this ).gritter( "Order Duplicated", payload.message );
                } else if( payload.status == 'error' ) {
                    $( this ).gritter( "Error", payload.message );
                }
                return false;
            });
            return false;
        } else if ( classes.indexOf( "create_order" ) >= 0 ) {
            return( $( this ).ajaxDialog( this.href + "&ajax=1" ) );
        } else if( classes.indexOf( "edit_order" ) >= 0 ) {
            // Replace URL
            data_link = this.href;
            history.pushState( null, null, data_link );
            filename = data_link.replace(/order_handler/, 'ajax_handler');

            $( "#navigationBottom" ).animate( { bottom: '-' + botnavHeight + 'px' } );
            $.when( $( "#navigationTop" ).animate( { top: '-' + topnavHeight + 'px' } ) ).done(function() {
                $( "#navigationTop" ).toggle();
            });

            polling = false;
            return $( this ).ajaxLink( filename, 'orderTable' );
        }


        var table_row = $( this ).closest( "tr" ),
            table_id = table_row.attr( "id" ),
            filename = '';
            

        ordersTable = $('#ordersTable');
        data_link = table_row.attr( "data-link" );

        if ( typeof data_link == "undefined" ) return false;
            

        ordersTable.find('#defaultSelected').removeClass('info').addClass('dataTableRow').removeAttr('id');
        table_row.attr( 'id', 'defaultSelected' ).addClass( 'info' );

        if ( table_id != "defaultSelected" ) {
            // Replace URL
            var url = data_link.split("?");
            filename = '?' + url[url.length - 1];
            history.pushState( null, null, document.location.origin + document.location.pathname + filename );
            return false;
        } else if ( table_id == "defaultSelected" ) {
            // Replace URL
            filename = data_link.replace(/ajax_handler/, 'order_handler') + '&action=edit';
            history.pushState( null, null, filename );

            $( "#navigationBottom" ).animate( { bottom: '-' + botnavHeight + 'px' } );
            $.when( $( "#navigationTop" ).animate( { top: '-' + topnavHeight + 'px' } ) ).done(function() {
                $( "#navigationTop" ).toggle();
            });
            polling = false;
            return $( this ).ajaxLink( data_link + '&action=edit', 'orderTable' );
        }

        return false;
    });

    $( "body" ).on('ifToggled', '#order_by_prod_quantity', function( event ) {
        var input = $( this ),
            status = $( "#status" ).val();

        if ( status !== "1" )
            polling = false;

        $( input ).addClass( "checked" );

        return $( "#select_status" ).append( input ).submit();
    }).on('ifChecked', '#order_by_prod_quantity', function( event ) {
        $( "div.icheckbox_line-red" ).addClass( "checked" );
    }).on('ifUnchecked', '#order_by_prod_quantity', function( event ) {
        $( "div.icheckbox_line-red" ).removeClass( "checked" );
    });


    $( "body" ).on('change', '#status', function( event ) {
        var order_by_prod_quantity = $( "input[name=order_by_prod_quantity]" ).prop( "checked" ),
            input = $("<input>")
            .attr("type", "checkbox")
            .attr("name", "order_by_prod_quantity").prop( "checked", true ),
            form = $( this ).closest( "form" );

        if ( order_by_prod_quantity === true )
            form.append( $( input ) );

        polling = false;
        return $( form ).submit();
    });

    $( "body" ).on('submit','#cust_select, #cust_select_id, #cust_select_email, #cust_select_name, #create_order',function(){
        event.preventDefault();

        var thisID = this.id,
            reqType = "",
            createOrderTable = "",
            reqData = $( this ).serialize(),
            name = $( "#customers_firstname" ).val() + " " + $( "#customers_lastname" ).val();


        if ( thisID === "create_order" )
            reqType = "POST";
        else
            reqType = "GET";

        if ( reqType == "POST" && check_form( this ) === false )
            return false;

        var jqxhr = $.ajax({
                type: reqType,
                url: encodeURI( $( this ).prop( "action" ) + "?ajax=1" ),
                data: reqData,
                dataType: 'html'
            });

        jqxhr.done(function( data ) {
            if ( reqType === "GET" ) {
                createOrderTable = $( data ).find( "#createOrderTable" );
                if ( createOrderTable.size() === 0 )
                    createOrderTable = $( data ).closest( "#createOrderTable" );
                $( "#createOrderTable" ).replaceWith( createOrderTable );
                $( "#createOrderTable" ).find( "#customers_dob" ).datepicker({dateFormat: JQUERY_DATEPICKER_FORMAT, changeMonth: true, changeYear: true, yearRange: '-100:-18', defaultDate: "-30y"});
            } else {
                createOrderTable = $( data ).find( "#orderTable" );
                if ( createOrderTable.size() === 0 )
                    createOrderTable = $( data ).closest( "#orderTable" );
                $( "#orderTable" ).replaceWith( createOrderTable );
                $( "#createOrderTable" ).find( "#customers_dob" ).datepicker({dateFormat: JQUERY_DATEPICKER_FORMAT, changeMonth: true, changeYear: true, yearRange: '-100:-18', defaultDate: "-30y"});
                $( this ).gritter( "Order Created", "New order created for customer " + name );
                return($('#ajax_cart_dialog').dialog('close'));
            }

            return false;
        });
        return false;
    });

    /* History - Go Back/Forward */
    $( window ).bind( 'popstate', function( event ) {

        // URL location
        var location = document.location.search,
            searchString = "action=edit",
            topnavHeight = $( "#navigationTop" ).height(),
            botnavHeight = $( "#navigationBottom" ).height();

        if ( location.indexOf( searchString ) != -1 ) {
            $( "#navigationBottom" ).animate( { bottom: '-' + botnavHeight + 'px' } );
            $.when( $( "#navigationTop" ).animate( { top: '-' + topnavHeight + 'px' } ) ).done(function() {
                $( "#navigationTop" ).toggle();
            });
        } else {
            $( "#navigationBottom" ).animate( { bottom: 0 } );
            $( "#navigationTop" ).css( "display", "block" );
            $( "#navigationTop" ).animate( { top: 0 } );
        }

        // Receiving location from the window.history object
        var returnLocation = ( history.location.href.match( /\.php/ ) ? history.location.href + ( history.location.search === '' ? '?ajax=1' : '&ajax=1') : document.location.href + ( document.location.search === '' ? '?ajax=1' : '&ajax=1') ).replace(/cID=\d+&{0,1}/g, '');

        return $( this ).ajaxLink( decodeURIComponent( returnLocation ), 'orderTable' );
    });

    var $loading = $('#ajax_loader').hide();
    $(document)
    .ajaxStart(function () {
        $loading.fadeIn( 200 );
    })
    .ajaxStop(function () {
        $loading.fadeOut( 200 );
    });


    $('body').on('click', 'a.submit_button', function(event){
                event.preventDefault();
                var link = this.href,
                        notify = $( "input[name=autoupdatestatus]" ).prop( "checked" ),
                        autoupdatestatus = $( "input[name=autoupdatestatus]" ).prop( "checked" ),
                        target = $("input[type='radio'][name='target_file']:checked").val(),
                        form = $('#batch_orders');
                if ( notify === true || autoupdatestatus === true ) {
                        $( ".progress" ).show();
                        var jqxhr = $.ajax({
                                xhr: function() {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.addEventListener("progress", function(evt) {
                                                //if ( evt.loaded >= evt.total )
                                                        //return $( this ).ajaxLink(link + '&ajax=1', 'orderTable' );
                                           
                                                if (evt.lengthComputable)
                                                {   //evt.loaded the bytes browser receive
                                                        //evt.total the total bytes seted by the header
                                                        //
                                                        var percentComplete = (evt.loaded / evt.total)*100;
                                                        $('#progress-bar').css( "width", percentComplete + "%" );
                                                        $( "#progress-bar" ).find( "span" ).html( evt.loaded + "/" + evt.total + " Updated" );
                                                }
                                        }, false);
                                        return xhr;
                                },
                                type: 'POST',
                                url: 'ajax_handler.php?action=update_orders_status',
                                data: $( "#navbar" ).serialize() + "&" + $( "#batch_orders" ).serialize()
                        });
                        jqxhr.done(function( payload ) {
                                $( "#navbar" ).find($("input[type='radio'][name='notify']")).eq( 1 ).click();
                                $( "#navbar" ).find($("input[type='radio'][name='autoupdatestatus']")).eq( 1 ).click();
                                $( ".progress" ).hide();
                                if( typeof( payload ) == 'number' ) {
                                        var countOrdersUpdated = payload.toString().length;
                                        $( this ).gritter( "Success", countOrdersUpdated + " Orders Updated." );
                                        return $( this ).ajaxLink(link + '&ajax=1', 'orderTable' );
                                } else if( payload.status == 'error' ) {
                                        $( this ).gritter( "Error", payload.message );
                                }
                                return false;
                        });
                } else {
                        if ( target != "invoice.php" )
                                form[0].target = "_self";
                        else
                                newWin=window.open("","_newtab");
                        return form.submit();
                }
                return false;
        });

    /* Gritter - Growl like notifications */

    $.fn.gritter = function( title, notification, stopper ) {
        $( "#gritterRemove" ).fadeIn( "slow" );
        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: title,
            // (string | mandatory) the text inside the notification
            text: notification,
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: false,
            // (function | optional) function called after it opens
            after_open: function(e){
            //$( e ).find( ".gritter-title" ).before( '<span class="fa fa-cog fa-spin fa-3x"></span>' );
            if ( stopper === true )
                $( e ).find( ".fa-cog" ).removeClass( "fa-spin" );
            },
            before_close: function(){
                $( "#gritterRemove" ).fadeOut( "slow" );
            }
        });
    };

    $( "body" ).on( "click", "label#gritterRemove", function() {
        $.gritter.removeAll();
        $( "#gritterRemove" ).fadeOut( "slow" );
    });

    $( "body" ).on( "focus", "#newValue", function(event){
    // Select input field contents
        this.select();
    });


    $.fn.getLines = function( oID, showMessage ) {
        var input = $( "#order_by_prod_quantity" ),
            order_by_quantity = "";

        if ( input.prop( "checked" ) === true )
            order_by_quantity = "&order_by_prod_quantity=on";

        $.ajax({
        type: 'GET',
        url: "order_poller.php?action=duplicate&oID="+last_order_number+"&languages_id="+languages_id+order_by_quantity,
        async: true,
        global: false,
        dataType: 'html'
        }).done(function( data ) {
            var ordersTable = $( "#ordersTable" ).find( "tbody" ).find( ".dataTableRow:first" ),
                newRow = $( data ).not( "#last_order_number" );
            last_order_number = parseInt($( data ).closest( "#last_order_number" ).text(), 0);
            
            if ( ordersTable.size() === 0 ) {
                ordersTable = $( "#ordersTable" ).find( "thead" ).eq( 1 );
                data = "<tbody>" + data + "</tbody>";
            }
            $( newRow ).insertBefore( ordersTable );

            var data_order = $( "tr." + oID ),
                customers_name = data_order.attr( "data-customers_name" ),
                order_total = data_order.attr( "data-order_total" ),
                count = $( "tr." + oID ).size();

            running = false;
            messages_longpolling( last_order_number );

            if ( count > 0 && showMessage !== false )
                $( this ).gritter( "New Order", customers_name + " placed a new order for " + order_total );
        });
        return false;
    };

    $('#tax_value').multiselect({
        buttonClass: 'btn btn-default dialog_tax'
    });
    $('#autostatus').multiselect({
        buttonClass: 'btn btn-lg btn-default'
    });
    $('.comments, .tooltip_set').tooltip('toggle').tooltip('hide');

    if ( polling === true && typeof( last_order_number ) !== "undefined" )
        messages_longpolling( last_order_number );


    var cache = {};
    $("#keywords").autocomplete({
        minLength: 1,
        appendTo: "#addProductFind",
        select: function(event, ui) {
            window.location  = (ui.item.id);
        },
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache ) {
              response( cache[ term ] );
              return;
            }

            $.ajax({
              dataType: "json",
              url: "orders_ajax.php?action=search",
              data: request,
              global: false
            })
            .done(function( json ) {
                cache[ term ] = json;
                response( json );
            });
        }
    }).data("ui-autocomplete")._renderItem = function( ul, item ) {
        return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( "<a href='" + item.id + "'>"+ item.value + "</a>" )
        .appendTo( ul );
    };


    $.fn.selectProduct = function( prID, prName ) {
        $( "#addProdName" ).html( prName );
        $( "#addProductFind" ).show();
        var url="orders_ajax.php?action=attributes&prID=" + prID,
            jqxhr = $.ajax({
            type: 'GET',
            url: encodeURI( url ),
            async: true,
            global: false,
            dataType: 'html'
        });

        jqxhr.done(function( data ) {
            $( "#ProdAttr" ).html( data );
        });

    };

    $.fn.hideAddProducts = function() {
        $( "#add-Product" ).hide();
        $( "#addProdName" ).html( "" );
        $( "#ProdAttr" ).html( "" );
        $( "#keywords" ).val( "" );
    };

    $.fn.setAttr = function( ) {
        var oID = $( "#order_number" ).html(),
            url="orders_ajax.php?action=set_attributes&oID=" + oID,
            postVar = "products_quantity=";

        $.fn.tdialog({
            type:"prompt",
            content:"Quantity?",
            title:"Confirm",
            icon:"confirm",
            effect:'css3',
            css3EffectIn:'',
            css3EffectOut:'bench-out',
            promptCallback:function(){

                postVar += $( "#newValue").val();
                for (var i = 0; i < document.attributes.elements.length; i++){
                    postVar += '&' + document.attributes.elements[i].name + '=' + document.attributes.elements[i].value;
                }

                var jqxhr = $.ajax({
                    type: 'POST',
                    url: encodeURI( url ),
                    data: postVar,
                    async: false,
                    global: false,
                    dataType: 'json'
                });

                jqxhr.done(function( payload ) {
                    $( this ).hideAddProducts();
                    if( payload.status == 'success' ) {
                        $( this ).gritter( "Success", payload.message );
                        return( $( this ).ajaxLink('ajax_handler.php?action=update_products&oID=' + oID, 'productTotals', false ) );
                    } else if( payload.status == 'error' ) {
                        $( this ).gritter( "Error", payload.message );
                    }
                });
            }
        });

        $.when( tdialog ).done(function(){
            $( "#newValue" ).attr( "placeholder", pred).val( pred ).trigger( "focus" );
        });
        return false;
    };


// (C) Dylan Knutson 2012
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

    $.fn.scrollNav = function(opts) {
        var
            window_scroll = $(window).scrollTop(),
            navbar = this,
            navbar_height = navbar.height(),
            scroll_last = window_scroll,
            navbar_visible = navbar_height;

        var resize_handler = function(event) {
            navbar_height = navbar.height();
        };

        $(window).resize(resize_handler);

        $(window).scroll(function(event) {
            //calculate how far the window was scrolled
            //scrolling up the page is a positive delta
            window_scroll = $(window).scrollTop();
            var
                scroll_delta = scroll_last - window_scroll,
                navbar_visible_new = navbar_visible + scroll_delta;


            if(scroll_delta < 0) {
                //scrolling down the page
                if(navbar_visible == navbar_height) {
                    //navbar currently is totally visible, and has fixed positioning set
                    //set to abs positioning so it begins to go out of frame
                    if(window_scroll < 0) window_scroll = 0;
                    navbar.css({"position": "absolute", "top": window_scroll + "px"});
                }
                //else:
                //navbar will be partially visible, let abs positioning move it
            }
            else if(scroll_delta > 0) {
                if(navbar_visible <= 0) {
                //navbar was not visible, set abs positioning right above this
                    navbar.css({"position": "absolute", "top": (window_scroll - navbar_height) + "px"});
                }
                //scrolling up the page
                if(navbar_visible_new >= navbar_height) {
                    //navbar will be 100% visible
                    navbar.css({"position": "fixed", "top": "0px"});
                }
            }

            //recalculate the amount the navbar is visible
            navbar_visible = Math.min(Math.max(navbar_visible_new, 0), navbar_height);
            scroll_last = window_scroll;
        });
    };

    $('#order_by_prod_quantity').each(function(){
        var self = $(this),
        label = self.next(),
        label_text = label.text();

        label.remove();
        self.iCheck({
            checkboxClass: 'icheckbox_line-red',
          radioClass: 'iradio_line-red',
       //   checkedClass: 'checkedBox',
          insert: '<div class="icheck_line-icon"></div>' + label_text
      });
    });

    var elem = document.querySelector('.js-switch');
    var init = new Switchery(elem);

    elem.onchange = function() {
        var adminAppMenu = $( "#adminAppMenu" ).css( "position", "absolute" ),
            contentText = $( "#contentText" );
        if ( elem.checked ) {
            adminAppMenu.animate({ left: 0 });
            contentText.animate({ marginLeft: '150px' })
        } else {
            var width = $( "#adminAppMenu" ).outerWidth();
            adminAppMenu.animate({ left: '-' + width + 'px' });
            contentText.animate({ marginLeft: '15px' })
        }
    };

    $("#status").select2();

    $("#search_orders").select2({
        placeholder: "Search for an order",
        minimumInputLength: 3,
        quietMillis: 3000,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "orders_ajax.php?action=search_orders",
            dataType: 'json',
            data: function (term, page) {
                return {
                q: term, // search term
                page_limit: 10
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        },
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    }).on("change", function(e) {
        return( $( this ).directLink( e.added.id ) );
    });

    $( ".navbarOverlay" ).fadeOut(500, function() { $(this).remove(); });

    $( "#navigationTop" ).scrollNav();

    $('#pageHeading').find( "h1" ).css( "visibility", "visible" ).addClass('bounceInUp animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
    
});

/* Debug Function execution Time */
function debug_time(situation) {
    if ( situation )
        return new Date();

    var stop = new Date();
    var executionTime = stop.getTime() - start.getTime();
    var date = new Date(executionTime);

    return log("Code executed in: " + date.getMinutes() +  " min " + date.getSeconds() + "." + date.getMilliseconds() + " sec");
}


function messages_longpolling( last_order_number, poll_timer ){
    // Test if Polling is activated
    var input = $( "#order_by_prod_quantity" ),
        order_by_quantity = "";
    if ( input.prop( "checked" ) === true )
        order_by_quantity = "&order_by_prod_quantity=on";

    if ( polling === false ) return false;
    if ( typeof( poll_timer ) == "undefined" ) poll_timer = $( "#poll_timer" ).val();
    $.ajax({
        url: 'stream.php',
        type: 'GET',
        data: 'oID=' + last_order_number + '&poll_timer=' + poll_timer + order_by_quantity,
        global: false,
        async: true,
        cache: false,
        success: function( data ){
            if ( running === true ) return false;
            if ( typeof data == "object" ) {
                if ( data.status == 'no-results' ) {
                    setTimeout( function(){ messages_longpolling( last_order_number ); },1000);
                } else if( data.status == 'error' ){
                    setTimeout( function(){ messages_longpolling( last_order_number ); },15000);
                }
                return false;
            }

            var ordersTable = $( "#ordersTable" ).find( "tbody" ).find( ".dataTableRow:first" ),
                newRow = $( data ).not( "#last_order_number" ),
                last_order_number_current = window.last_order_number;
            
            last_order_number = parseInt($( data ).closest( "#last_order_number" ).text(), 0);

            if ( last_order_number_current >= last_order_number ) return false;

            if ( ordersTable.size() === 0 ) {
                ordersTable = $( "#ordersTable" ).find( "thead" ).eq( 1 );
                data = "<tbody>" + data + "</tbody>";
            }
            $( newRow ).insertBefore( ordersTable );

            var data_order = $( "tr." + last_order_number ),
                customers_name = data_order.attr( "data-customers_name" ),
                order_total = data_order.attr( "data-order_total" ),
                count = $( "tr." + last_order_number ).size();

            if ( count > 0 )
                $( this ).gritter( "New Order", customers_name + " placed a new order for " + order_total );

            setTimeout( function(){ messages_longpolling( last_order_number ); },1000);

            return false;
        },
        error: function(){
            setTimeout( function(){ messages_longpolling( last_order_number ); },15000);
        }
    });
    return false;
}

function f_scrollTop() {
    return f_filterResults (
        window.pageYOffset ? window.pageYOffset : 0,
        document.documentElement ? document.documentElement.scrollTop : 0,
        document.body ? document.body.scrollTop : 0
    );
}
function f_filterResults(n_win, n_docel, n_body) {
    var n_result = n_win ? n_win : 0;
    if (n_docel && (!n_result || (n_result > n_docel)))
        n_result = n_docel;
    return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

function getWindowHeight() // viewport, not document
{
    var windowHeight = 0;
    if (typeof(window.innerHeight) == 'number')
    {
        // DOM compliant, IE9+
        windowHeight = window.innerHeight;
    }
    else
    {
        // IE6-8 workaround, Note: document can be smaller than window
        var ieStrict = document.documentElement.clientHeight; // w/out DTD gives 0
        var ieQuirks = document.body.clientHeight; // w/DTD gives document height
        windowHeight = (ieStrict > 0) ? ieStrict : ieQuirks;
    }
    return windowHeight;
}

function log(message) {
    console.log(message);
}