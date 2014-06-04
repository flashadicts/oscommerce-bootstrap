<?php
  require_once(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_HANDLER);
  $info_box_heading = array();
  $info_box_contents = array();

  $info_box_contents[] = array('text' => tep_draw_input_field('keywords',
                                                              '',
                                                              'id="keywords" autocomplete="off" style="width: 100%"'));
  $info_box_contents[] = array('text' => '<div class="" style="display: block; margin-left: 0%; width:100%; float: left; border:solid 1px; background-color:#CCCCCC;" id="quicksearch"></div>');

  $box = new box;
  echo $box->infoBox($info_box_heading, $info_box_contents);
?>