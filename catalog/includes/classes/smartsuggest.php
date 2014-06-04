<?php
/**
 * SmartSuggest 1.0
 *
 * This class adds a search suggestion to your OsCommerce search box, sort the result products 
 * order by popular search, or even simply show the result in term of popular keywords.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link http://www.richardfu.net/
 * @copyright Copyright 2013, Richard Fu
 * @author Richard Fu
 * @filesource 
 */

/**
 * SmartSuggest Class
 *
 * The smartsuggest class provides fetching page and output functions
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link http://www.richardfu.net/
 * @copyright Copyright 2013, Richard Fu
 * @author Richard Fu
 */
 
class smartsuggest {
  
  /**
   * $installer is the installer object
   * @var object
   */
  var $installer;
  
  function smartsuggest() {
    $this->installer = new smartsuggest_install;
  }
  
  function output(&$data = null) {
    if (is_null($data))
      echo '<script type="text/javascript" src="ext/javascript/smartsuggest.js"></script>';
	else
	  $data .= '<script type="text/javascript" src="ext/javascript/smartsuggest.js"></script>';
  }
}

/**
 * SmartSuggest Installer and Configuration Class
 *
 * smartsuggest_install class offers a modular and easy to manage method of 
 * configuration.  The class enables the base class to be configured and 
 * installed on the fly without the hassle of calling additional scripts 
 * or executing SQL.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link http://www.richardfu.net/
 * @copyright Copyright 2013, Richard Fu
 * @author Richard Fu
 */
class smartsuggest_install {        
  /**
   * The default_config array has all the default settings which should be all that is needed to make the base class work.
   * @var array
   */
  var $default_config;
  /**
   * $attributes array holds information about this instance
   * @var array
   */
  var $attributes;
        
/**
 * SMARTSUGGEST_install class constructor 
 * @author Richard Fu
 * @version 1.0
 */        
  function smartsuggest_install() {
    $this->attributes = array();
    
    $x = 0;
    $this->default_config = array();
    $this->default_config['SMARTSUGGEST_ENABLED'] = array('DEFAULT' => 'true',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Enable SmartSuggest?', 'SMARTSUGGEST_ENABLED', 'true', 'Enable SmartSuggest? This is a global setting and will turn them off completely.', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, 'tep_cfg_select_option(array(''true'', ''false''),')");
    $x++;
    $this->default_config['SMARTSUGGEST_RECORD_KEYWORDS'] = array('DEFAULT' => 'true',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Enable customers searched keywords record?', 'SMARTSUGGEST_RECORD_KEYWORDS', 'true', 'Record customers searched keywords. Use them for SmartSuggest sorting and result, or for your own marketing analyze.', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, 'tep_cfg_select_option(array(''true'', ''false''),')");
    $x++;
    $this->default_config['SMARTSUGGEST_RESULT'] = array('DEFAULT' => 'Product Names',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Suggest results type', 'SMARTSUGGEST_RESULT', 'Product Names', 'Suggesting results moethod. Either giving a list of full product names or simply the searched keywords from database.', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, 'tep_cfg_select_option(array(''Product Names'', ''Searched Keywords''),')");
    $x++;
    $this->default_config['SMARTSUGGEST_PRODUCTS_SORT'] = array('DEFAULT' => 'Product Names',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Suggest product results sort order', 'SMARTSUGGEST_PRODUCTS_SORT', 'Product Names', 'When suggesting results moethod is choosen to be product, sort the results by product names alphabetically or by most searched count.', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, 'tep_cfg_select_option(array(''Product Names'', ''Searched Keywords''),')");
    $x++;
    $this->default_config['SMARTSUGGEST_LIMIT'] = array('DEFAULT' => '10',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Number of suggestions', 'SMARTSUGGEST_LIMIT', '10', 'Maximum number of result suggestions.', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, '')");
    $x++;
    $this->default_config['SMARTSUGGEST_MARK_SEARCH_CHAR'] = array('DEFAULT' => 'true',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Mark search char as strong', 'SMARTSUGGEST_MARK_SEARCH_CHAR', 'true', 'Mark the actuall search char strong in suggest results..', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), NULL, 'tep_cfg_select_option(array(''products'', ''keywords''),')");
    $x++;
    $this->default_config['SMARTSUGGEST_UNINSTALL'] = array('DEFAULT' => 'false',
                'QUERY' => "INSERT INTO `".TABLE_CONFIGURATION."` VALUES (NULL, 'Uninstall SmartSuggest', 'SMARTSUGGEST_UNINSTALL', 'false', 'This will delete all of the entries in the configuration table and customers searched keywords for SmartSuggest', GROUP_INSERT_ID, ".$x.", NOW(), NOW(), 'tep_uninstall_smartsuggest', 'tep_cfg_select_option(array(''uninstall'', ''false''),')");
    $this->init();
  } # end class constructor
        
/**
 * Initializer - if there are settings not defined the default config will be used and database settings installed. 
 * @author Richard Fu
 * @version 1.0
 */        
  function init() {
    foreach( $this->default_config as $key => $value ){
      $container[] = defined($key) ? 'true' : 'false';
    } # end foreach
    $this->attributes['IS_DEFINED'] = in_array('false', $container) ? false : true;

    switch(true){
      case ( !$this->attributes['IS_DEFINED'] ):
        $this->eval_defaults();
        $sql = "SELECT configuration_key, configuration_value  
                FROM " . TABLE_CONFIGURATION . " 
                WHERE configuration_key LIKE 'SMARTSUGGEST_%'";
        $result = tep_db_query($sql);
        $num_rows = tep_db_num_rows($result);     
        $this->attributes['IS_INSTALLED'] = (sizeof($container) == $num_rows) ? true : false;
        if ( !$this->attributes['IS_INSTALLED'] ){
          $this->install_settings(); 
        }
        break;
      default:
        $this->attributes['IS_INSTALLED'] = true;
        break;
    } # end switch
  } # end function
        
/**
 * This function evaluates the default serrings into defined constants 
 * @author Richard Fu
 * @version 1.0
 */        
  function eval_defaults(){
    foreach( $this->default_config as $key => $value ){
      if (! defined($key))
        define($key, $value['DEFAULT']);
    } # end foreach
  } # end function
        
/**
 * This function removes the database settings (configuration and cache)
 * @author Richard Fu
 * @version 1.0
 */
  function uninstall_settings(){
    $cfgId_query = "SELECT configuration_group_id as ID FROM `".TABLE_CONFIGURATION_GROUP."` WHERE configuration_group_title = 'SmartSuggest'";
    $cfgID = tep_db_fetch_array( tep_db_query($cfgId_query) );
    tep_db_query("DELETE FROM `".TABLE_CONFIGURATION_GROUP."` WHERE `configuration_group_title` = 'SmartSuggest'");
    tep_db_query("DELETE FROM `".TABLE_CONFIGURATION."` WHERE configuration_group_id = '" . $cfgID['ID'] . "' OR configuration_key LIKE 'SMARTSUGGEST_%'");
    tep_db_query("DROP TABLE IF EXISTS `".TABLE_SEARCHED_KEYWORDS."`");
  } # end function
        
/**
 * This function installs the database settings
 * @author Richard Fu
 * @version 1.0
 */        
  function install_settings(){
    $this->uninstall_settings();
    $sort_order_query = "SELECT MAX(sort_order) as max_sort FROM `".TABLE_CONFIGURATION_GROUP."`";
    $sort = tep_db_fetch_array( tep_db_query($sort_order_query) );
    $next_sort = $sort['max_sort'] + 1;
    $insert_group = "INSERT INTO `".TABLE_CONFIGURATION_GROUP."` VALUES (NULL, 'SmartSuggest', 'Options for SmartSuggest by fuR', '".$next_sort."', '1')";
    tep_db_query($insert_group);
    $group_id = tep_db_insert_id();

    foreach ($this->default_config as $key => $value){
        $sql = str_replace('GROUP_INSERT_ID', $group_id, $value['QUERY']);
        tep_db_query($sql);
    }
    
    tep_db_query("CREATE TABLE IF NOT EXISTS `".TABLE_SEARCHED_KEYWORDS."` (
                  `searched_keywords_id` int(11) NOT NULL AUTO_INCREMENT,
                  `keywords` varchar(128) NOT NULL,
                  `number_of_results` int(3) NOT NULL,
                  `customers_id` int(11) DEFAULT NULL,
                  `ip` varchar(15) NOT NULL,
                  `pages` varchar(64) NOT NULL DEFAULT '1',
                  `products_ids` varchar(128) DEFAULT NULL,
                  `orders_id` int(11) DEFAULT NULL,
                  `date_added` datetime NOT NULL,
                  PRIMARY KEY (`searched_keywords_id`),
                  KEY `keywords` (`keywords`),
                  KEY `customers_id` (`customers_id`),
                  KEY `ip` (`ip`),
                  KEY `date_added` (`date_added`),
                  KEY `number_of_results` (`number_of_results`)
                  )");
  } # end function        
} # end class
  