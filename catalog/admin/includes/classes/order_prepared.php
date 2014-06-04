<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

  class order {
    var $info, $totals, $products, $customer, $delivery;

    function query($order_id) {
      global $stmt_o, $stmt_ot, $stmt_op, $stmt_opa;


      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

    // Kiss Error Debugger
/*      $start_time_o = microtime( true );
      $start_time_ot = microtime( true );
      $start_time_op = microtime( true );
      $start_time_opa = microtime( true );*/


      #Run the prepared statement
      $bp_o           = $stmt_o->execute();

      #Error checking the execution of the prepared statement
      if ( false === $bp_o )        {
                      die( json_encode( array( 'status' => 'error', 'message' => 'Executing ORDERS failed: ' . htmlspecialchars($stmt_o->error) ) ) );
      }


      #Get the customers info
      $res = $stmt_o->get_result();
      while (($row = $res->fetch_assoc()))
        $order_query[] = $row;

      $order = $order_query[0];


      #Run the prepared statement
      $bp_ot          = $stmt_ot->execute();

      if ( false === $bp_ot )        {
                      die( json_encode( array( 'status' => 'error', 'message' => 'Executing ORDERS_TOTAL failed: ' . htmlspecialchars($stmt_ot->error) ) ) );
      }

      #Get the orders total info
      $res = $stmt_ot->get_result();
      while (($totals = $res->fetch_assoc())) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' => $totals['text'],
                                'value' => $totals['value'],
                                'class' => $totals['class']);
        if ($totals['class']=='ot_total') $order['order_total'] = strip_tags($totals['text']);
      }

      $this->info = array('currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'cc_type' => $order['cc_type'],
                          'cc_owner' => $order['cc_owner'],
                          'cc_number' => $order['cc_number'],
                          'cc_expires' => $order['cc_expires'],
                          'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order['orders_status'],
                          'order_total' => $order['order_total'],
                          'last_modified' => $order['last_modified']);

      $this->customer = array('name' => $order['customers_name'],
                              'company' => $order['customers_company'],
                              'street_address' => $order['customers_street_address'],
                              'suburb' => $order['customers_suburb'],
                              'city' => $order['customers_city'],
                              'postcode' => $order['customers_postcode'],
                              'state' => $order['customers_state'],
                              'country' => $order['customers_country'],
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'email_address' => $order['customers_email_address']);

      $this->delivery = array('name' => $order['delivery_name'],
                              'company' => $order['delivery_company'],
                              'street_address' => $order['delivery_street_address'],
                              'suburb' => $order['delivery_suburb'],
                              'city' => $order['delivery_city'],
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      $this->billing = array('name' => $order['billing_name'],
                             'company' => $order['billing_company'],
                             'street_address' => $order['billing_street_address'],
                             'suburb' => $order['billing_suburb'],
                             'city' => $order['billing_city'],
                             'postcode' => $order['billing_postcode'],
                             'state' => $order['billing_state'],
                             'country' => $order['billing_country'],
                             'format_id' => $order['billing_address_format_id']);

      $index = 0;
      #Run the prepared statement
      $bp_op          = $stmt_op->execute();

      if ( false === $bp_op )        {
                      die( json_encode( array( 'status' => 'error', 'message' => 'Executing ORDERS_PRODUCTS failed: ' . htmlspecialchars($stmt_op->error) ) ) );
      }

      #Get the orders products info
      $res = $stmt_op->get_result();
      $orders_products_query = $res->fetch_all(MYSQLI_ASSOC);

      foreach ($orders_products_query as $orders_products) {
        $this->products[$index] = array('id' => $orders_products['orders_products_id'],
                                        'qty' => $orders_products['products_quantity'],
                                        'name' => $orders_products['products_name'],
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'final_price' => $orders_products['final_price']);
        if ($totals['class']=='ot_total') $order['order_total'] = strip_tags($totals['text']);

        $subindex = 0;

        #Run the prepared statement
        $bp_opa          = $stmt_opa->execute();

        if ( false === $bp_opa )        {
                      die( json_encode( array( 'status' => 'error', 'message' => 'Executing ORDERS_PRODUCTS_ATTRIBUTES failed: ' . htmlspecialchars($stmt_opa->error) ) ) );
        }

        #Get the orders attributes info
        $res = $stmt_opa->get_result();
        
        if (count($stmt_opa)) {
          while (($attributes = $res->fetch_assoc())) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                                     'value' => $attributes['products_options_values'],
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }
        $index++;
      }

      // Kiss Error Debugger
      /*if ( class_exists( 'KissER' ) ) {
        KissER::q( round( ( microtime( true ) - $start_time_o ), 4 ), $sql_o );
        KissER::q( round( ( microtime( true ) - $start_time_ot ), 4 ), $sql_ot );
        KissER::q( round( ( microtime( true ) - $start_time_op ), 4 ), $sql_op );
        KissER::q( round( ( microtime( true ) - $start_time_opa ), 4 ), $sql_opa );
      }*/

    }
  }
?>