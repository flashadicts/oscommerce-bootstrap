<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  function tep_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $server = 'p:' . $server;
    }

    $$link = mysqli_connect($server, $username, $password, $database);

    if ( !mysqli_connect_errno() ) {
      mysqli_set_charset($$link, 'utf8');
    } 

    return $$link;
  }

  function tep_db_close($link = 'db_link') {
    global $$link;

    return mysqli_close($$link);
  }

  function tep_db_error($query, $errno, $error) {
    global $logger;

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      $logger->write('[' . $errno . '] ' . $error, 'ERROR');
    }

    die('<font color="#000000"><strong>' . $errno . ' - ' . $error . '<br /><br />' . $query . '<br /><br /><small><font color="#ff0000">[TEP STOP]</font></small><br /><br /></strong></font>');
  }

  function tep_db_query($query, $link = 'db_link') {
    global $$link, $logger;

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      if (!is_object($logger)) $logger = new logger;
      $logger->write($query, 'QUERY');
    }

    $result = mysqli_query($$link, $query) or tep_db_error($query, mysqli_errno($$link), mysqli_error($$link));

    return $result;
  }

  function tep_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return tep_db_query($query, $link);
  }

  function tep_db_fetch_array($db_query) {
    return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
  }

  function tep_db_result($result, $row, $field = '') {
    if ( $field === '' ) {
      $field = 0;
    }

    tep_db_data_seek($result, $row);
    $data = tep_db_fetch_array($result);

    return $data[$field];
  }

  function tep_db_num_rows($db_query) {
    return mysqli_num_rows($db_query);
  }

  function tep_db_data_seek($db_query, $row_number) {
    return mysqli_data_seek($db_query, $row_number);
  }

  function tep_db_insert_id($link = 'db_link') {
    global $$link;

    return mysqli_insert_id($$link);
  }

  function tep_db_free_result($db_query) {
    return mysqli_free_result($db_query);
  }

  function tep_db_fetch_fields($db_query) {
    return mysqli_fetch_field($db_query);
  }

  function tep_db_output($string) {
    return htmlspecialchars($string);
  }

  function tep_db_input($string, $link = 'db_link') {
    global $$link;

    return mysqli_real_escape_string($$link, $string);
  }

  function tep_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = tep_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

  /*function tep_db_affected_rows($link = 'db_link') {
    global $$link;

    return mysqli_affected_rows($$link);
  }*/
    function tep_db_affected_rows($link = 'db_link') {
    global $$link;

    return mysqli_affected_rows($$link);
  }

  function gType($var) {
    if (is_numeric($var)) $var = (float)$var;
    if (is_numeric($var) && $var == intval($var)) $var = (int)$var;
    $typedef = gettype($var);

    $search = array("integer", "double", "string");
    $replace = array("i", "d", "s");
    $type = str_replace($search, $replace, $typedef);
    if ($type == "NULL") $type = "s";
    return $type;
  }

  function tep_db_prepared_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link', $prepared = false) {
    global $$link;
    reset($data);
    $params = array();
    $typeDef = '';
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= "?, ";
            $typeDef .= gType($value);
            array_push($params, $value);
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = ?, ';
            $typeDef .= gType($value);
            array_push($params, $value);
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return mysqli_prepared_query($query, $typeDef, $params);
  }

  function mysqli_prepared_query($sql, $typeDef = FALSE, $params = FALSE, $link = "db_link") {
    global $$link;

    // Kiss Error Debugger
    $start_time = microtime( true );

    if($stmt = mysqli_prepare($$link,$sql)){ 
      if(count($params) == count($params,1)){ 
        $params = array($params); 
        $multiQuery = FALSE; 
      } else { 
        $multiQuery = TRUE; 
      }  

      if($typeDef){ 
        $bindParams = array();    
        $bindParamsReferences = array(); 
        $bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");         
        foreach($bindParams as $key => $value){ 
          $bindParamsReferences[$key] = &$bindParams[$key];  
        } 
        array_unshift($bindParamsReferences,$typeDef); 
        $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
        $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); 
      } 

      $result = array(); 
      foreach($params as $queryKey => $query){ 
        if(isset($bindParams)){
          foreach($bindParams as $paramKey => $value){ 
            $bindParams[$paramKey] = $query[$paramKey]; 
          }
        }
        $queryResult = array(); 
        if(mysqli_stmt_execute($stmt)){ 
          $resultMetaData = mysqli_stmt_result_metadata($stmt); 
          if($resultMetaData){                                                                               
            $stmtRow = array();   
            $rowReferences = array(); 
            while ($field = mysqli_fetch_field($resultMetaData)) { 
              $rowReferences[] = &$stmtRow[$field->name]; 
            }                                
            mysqli_free_result($resultMetaData); 
            $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
            $bindResultMethod->invokeArgs($stmt, $rowReferences); 
            while(mysqli_stmt_fetch($stmt)){ 
              $row = array(); 
              foreach($stmtRow as $key => $value){ 
                $row[$key] = $value;           
              } 
              $queryResult[] = $row; 
            } 
            mysqli_stmt_free_result($stmt); 
          } else { 
            $queryResult[] = mysqli_stmt_affected_rows($stmt); 
          } 
        } else { 
          $queryResult[] = FALSE; 
        } 
        $result[$queryKey] = $queryResult; 
      } 
      mysqli_stmt_close($stmt);   
    } else { 
      $result = FALSE; 
    }

    // Kiss Error Debugger
    if ( class_exists( 'KissER' ) ) {
      KissER::q( round( ( microtime( true ) - $start_time ), 4 ), $sql );
    }

    if($multiQuery){ 
      return $result; 
    } else { 
      return $result[0]; 
    } 
  }

  function tep_db_prepared_statement($query, $link = 'db_link') {
    global $$link;

  // Kiss Error Debugger
    $start_time = microtime( true );

  /* Reformat the new Query and Pick out the Parameters */
    $hits = preg_match_all('/\'([^\']*)\'/', $query, $params);
    $new_query = preg_replace('/\'([^\']*)\'/', '?', $query);
    $type = '';

  /* Get the Parameter Type */
    if ($hits > 0) {
      foreach ($params[1] as $key => $value) {
        if (is_numeric($value)) $value = (float)$value;
        if (is_numeric($value) && $value == intval($value)) $value = (int)$value;
        $typedef = gettype($value);

        $search = array("integer", "double", "string");
        $replace = array("i", "d", "s");
        $type .= str_replace($search, $replace, $typedef);
      }
    }

    array_unshift($params[1], $type);

  /* Get instance of statement */
    $stmt = $$link->stmt_init();
  /* Get instance of statement */
    if(!$stmt->prepare($new_query))
      die ( "Failed to prepare statement\n" );

  /* Bind Parameters */
    $ref = new ReflectionClass('mysqli_stmt');
    $method = $ref->getMethod("bind_param");
    $method->invokeArgs($stmt, $params[1]);
    
  /* Execute statement */
    $stmt->execute();

  /* Fetch Result */
    $res = $stmt->get_result();
    while (($row = $res->fetch_assoc()))
      $result[] = $row;
    
  /* Close Statement */
    $stmt->close();

    // Kiss Error Debugger
    if ( class_exists( 'KissER' ) ) {
      KissER::q( round( ( microtime( true ) - $start_time ), 4 ), $query );
    }

    return $result;
  }

  function fetchRows($stmt){
    $stmt->execute();

    $res = $stmt->get_result();
    while (($row = $res->fetch_assoc()))
      $result[] = $row;
    return $result;
  }

  function tep_db_get_server_info($link = 'db_link') {
    global $$link;

    return mysqli_get_server_info($$link);
  }

  if ( !function_exists('mysqli_connect') ) {
    define('MYSQLI_ASSOC', MYSQL_ASSOC);

    function mysqli_connect($server, $username, $password, $database) {
      if ( substr($server, 0, 2) == 'p:' ) {
        $link = mysql_pconnect(substr($server, 2), $username, $password);
      } else {
        $link = mysql_connect($server, $username, $password);
      }

      if ( $link ) {
        mysql_select_db($database, $link);
      }

      return $link;
    }

    function mysqli_connect_errno($link = null) {
      if ( is_null($link) ) {
        return mysql_errno();
      }

      return mysql_errno($link);
    }

    function mysqli_connect_error($link = null) {
      if ( is_null($link) ) {
        return mysql_error();
      }

      return mysql_error($link);
    }

    function mysqli_set_charset($link, $charset) {
      if ( function_exists('mysql_set_charset') ) {
        return mysql_set_charset($charset, $link);
      }
    }

    function mysqli_close($link) {
      return mysql_close($link);
    }

    function mysqli_query($link, $query) {
      return mysql_query($query, $link);
    }

    function mysqli_errno($link = null) {
      if ( is_null($link) ) {
        return mysql_errno();
      }

      return mysql_errno($link);
    }

    function mysqli_error($link = null) {
      if ( is_null($link) ) {
        return mysql_error();
      }

      return mysql_error($link);
    }

    function mysqli_fetch_array($query, $type) {
      return mysql_fetch_array($query, $type);
    }

    function mysqli_num_rows($query) {
      return mysql_num_rows($query);
    }

    function mysqli_data_seek($query, $offset) {
      return mysql_data_seek($query, $offset);
    }

    function mysqli_insert_id($link) {
      return mysql_insert_id($link);
    }

    function mysqli_free_result($query) {
      return mysql_free_result($query);
    }

    function mysqli_fetch_field($query) {
      return mysql_fetch_field($query);
    }

    function mysqli_real_escape_string($link, $string) {
      if ( function_exists('mysql_real_escape_string') ) {
        return mysql_real_escape_string($string, $link);
      } elseif ( function_exists('mysql_escape_string') ) {
        return mysql_escape_string($string);
      }

      return addslashes($string);
    }

    function mysqli_affected_rows($link) {
      return mysql_affected_rows($link);
    }

    function mysqli_get_server_info($link) {
      return mysql_get_server_info($link);
    }
  }
?>
