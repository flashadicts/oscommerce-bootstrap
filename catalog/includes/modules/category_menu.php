<?php
/*
  $Id: header.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- Can Horizontal Navigation bar-->
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-nav">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo tep_href_link(FILENAME_DEFAULT); ?>"><span class="glyphicon glyphicon-home"></span></a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse main-nav">
        <ul class="nav navbar-nav">
            <?php
            $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name limit 0,7");
                while ($categories = tep_db_fetch_array($categories_query))  {
            ?>		
                <?php
                    if (tep_has_category_subcategories($categories['categories_id'])) { ?>

                        <li class="dropdown">
                        <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$categories['categories_id']); ?>"  dropdown-toggle" data-toggle="dropdown" rel="images/"><?php echo $categories['categories_name']; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php
                            $categories_query_1 = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '".$categories['categories_id']."' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name");
                            while ($categories_1 = tep_db_fetch_array($categories_query_1))  {
                            ?>	
                                <li><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$categories['categories_id'].'_'.$categories_1['categories_id']); ?>" rel="images/products/sub_14.png"><?php echo $categories_1['categories_name']; ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }else{
                ?>
                <li><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$categories['categories_id']); ?>"  class="current" rel="images/"><?php echo $categories['categories_name']; ?></a></li>
            <?php
                }
            }
            ?>			
        </ul>
        <form name="search" id="frmSearch" action="<?php echo tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false); ?>" method="get" onsubmit="return check_form(this);" class="navbar-form navbar-right" role="search">
        <?php echo tep_draw_hidden_field('search_in_description','1') ?>
        <div class="form-group">
            <?php echo tep_draw_input_field('keywords', null, 'class="form-control" placeholder="Search" id="txtSearch" onkeyup="searchSuggest(event);" autocomplete="off"'); ?>
            <div id="smartsuggest" class="hidden-xs" ></div>
        </div>
        <div class="form-group">
            <?php echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))),'','class="form-control"') . tep_hide_session_id(); ?>
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
        </form>
    </div><!-- /.nav-collapse -->
</nav><!-- /.navbar -->

<!-- end Can Horizontal Navigation bar-->