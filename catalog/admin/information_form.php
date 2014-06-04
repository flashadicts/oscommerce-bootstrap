<?php
/*
  Module: Information Pages Unlimited
          File date: 2007/02/17
          Based on the FAQ script of adgrafics
          Adjusted by Joeri Stegeman (joeri210 at yahoo.com), The Netherlands
          Modified by SLiCK_303@hotmail.com for OSC v2.3.1

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/
?>
    <tr>
      <td class="pageHeading"><?php echo $title; ?></td>
    </tr>
    <tr>
    <td>
	<table border="0" cellpadding="0" cellspacing="2" width="100%">
<?php
      if (!strstr($info_group['locked'], 'visible')) {
?>
        <tr>
          <td class="main"><?php echo ENTRY_STATUS; ?></td>
          <td class="main"><?php echo tep_draw_radio_field('visible', '1', true, $edit['visible']) . '&nbsp;&nbsp;' . STATUS_ACTIVE . '&nbsp;&nbsp;' . tep_draw_radio_field('visible', '0', false, $edit['visible']) . '&nbsp;&nbsp;' . STATUS_INACTIVE; ?></td>
        </tr>
        <tr>
          <td colspan="2" height="10">&nbsp;</td>
        </tr>
<?php
      }

      if (!strstr($info_group['locked'], 'parent_id')) {
?>
        <tr>
          <td class="main"><?php echo ENTRY_PARENT_PAGE; ?></td>
          <td class="main">
<?php
          if ((sizeof($data) > 0)) {
            $options = '<option value="0">-</option>';
            reset($data);
            while (list($key, $val) = each($data)) {
              $selected = ($val['information_id'] == $edit['parent_id']) ? 'selected="selected"' : '';
              $options .= '<option value="' . $val['information_id'] . '" ' . $selected . '>' . $val['information_title'] . '</option>';
            }
            echo '<select name="parent_id">' . $options . '</select>';
          } else {
            echo '<span class="messageStackError">' . WARNING_PARENT_PAGE .'</span>';
          }
?>  
         </td>
        </tr>
        <tr>
          <td colspan="2" height="10">&nbsp;</td>
        </tr>
<?php
      }

      if (!strstr($info_group['locked'], 'sort_order')) {
?>
        <tr>
          <td class="main"><?php echo ENTRY_SORT_ORDER; ?></td>
          <td><?php
             if ($edit['sort_order']) {
                $no = $edit['sort_order'];
             }
             echo tep_draw_input_field('sort_order', "$no", 'size=3 maxlength=4');
?>
          </td>
        </tr>
        <tr>
          <td colspan="2" height="10">&nbsp;</td>
        </tr>
<?php
     }


     if (!strstr($info_group['locked'], 'information_description')) {
?>				
<!-- tabs		-->
       <tr>
       <td colspan="2">
       <div id="tab_descrip" class="ui-tabs">
       <table border="0" width="100%" cellspacing="0" cellpadding="0">
	     <ul>
           <?php
		     //$languages = tep_get_languages();
             for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
           ?>
		     <li><a href="#<?php echo $languages[$i]['name'];?>"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?><?php echo "  " . $languages[$i]['name'];?></a></li>
		   <?php
		     }
		   ?>
	     </ul>
		 
		 <tr>
	     <td>
 		 
		 <?php
		    //$languages = tep_get_languages();
            for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
               $languages_id=$languages[$i]['id'];	 		   
         ?>
	          <div id="<?php echo $languages[$i]['name'];?>" class="ui-tabs" >
	             <table border="0" cellspacing="0" cellpadding="2" align="left">
                    <tr>
                      <td>
					  <table border="0" cellspacing="0" cellpadding="2">	
                       <tr>
					   <?php if (!strstr($info_group['locked'], 'information_title')) { ?>					   
                          <td class="main"><?php echo ENTRY_TITLE ?></td>
                          <td align="left" class="main"><?php echo tep_draw_input_field('information_title[' . $languages[$i]['id'] . ']', (isset($information_title[$languages[$i]['id']]) ? stripslashes($edit[information_title]) : tep_get_information_entry($information_id, $languages[$i]['id'], 'information_title')), 'maxlength=255 size=75'); ?></td>
                       <?php } ?>						  
                        </tr>						  
                        <tr>
						<td class="main"><?php echo ENTRY_TEXT ; ?></td>
                        <td class="ui-widget-content">
                        <?php  
                          echo tep_draw_textarea_field('information_description[' . $languages[$i]['id'] . ']', '', '140', '80', (isset($information_description[$languages[$i]['id']]) ? stripslashes($edit[information_description]) : tep_get_information_entry($information_id, $languages[$i]['id'], 'information_description'))); 						
                       ?>
                       </td>						
                       </tr>
                      </table>
					  </td>
                    </tr>				 
		         </table>
		      </div>
		 <?php
		   }
		 ?>
		 </td>
		 </tr>
		 
		</table>
		</div>
		</td>
		</tr>
		
<!-- tabs -->		
<?php

    }
?>

    <tr>
    <td colspan="2" align="left"><br /><?php
      // Decide when to show the buttons (Determine or 'locked' is active)
      if ((empty($info_group['locked'])) || ($_GET['information_action'] == 'Edit')) {
        echo tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary');
      } else {
        echo tep_draw_button(IMAGE_INSERT, 'plus', null, 'primary');
      }
      echo tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_INFORMATION_MANAGER, 'gID=' . $gID));
?>
    </td>
    </tr>
<script>
<!--   bof sub tabs product description  -->
    $(function() {
		$( "#tab_descrip" ).tabs( ) ;
	});
	</script>
<!-- eof tabs ui -->			
    </table>
    </td>  
    </tr>
    </form>