<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly.
if (!defined('ABSPATH'))
    exit;

if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}
?>
<div class="bs-docs-example tooltip-demo" style="background-color: #FFFFFF;">
    <div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;"><h3><?php _e("Services", "appointzilla"); ?></h3></div>
    <?php
    global $wpdb;?>
 
        <table class="table">
            <thead>
                <tr style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
                    <th colspan="3">
                        <div id="gruopnamedivbox">Servicii</div>
                        <div id="gruopnameedit<?php echo $GroupName->id; ?>" style="display:none; height:25px;">
                            <form method="post">
                                <input type="text" id="editgruopname" class="inputheight" name="editgruopname" value="<?php echo $GroupName->name; ?>"/>
                                <button id="editgruop" value="1" name="editgruop" type="submit" class="btn btn-small btn-success"><i class="icon-ok icon-white"></i> <?php _e("Save", "appointzilla"); ?></button>
                                <button id="editgruopcancel" type="button" class="btn btn-small btn-danger" onclick="canceleditgrup('<?php echo $GroupName->id; ?>')"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></button>
                            </form>
                        </div>
                    </th>
                    <th id="yw7_c1" colspan="3">
                        <!--- header rename and delete button right box-->
                        <div align="right">
                            <?php if($GroupName->id =='1') ?>
                                <a rel="tooltip" href="#" data-placement="left" class="btn btn-success btn-small" id="<?php echo $GroupName->id; ?>" onclick="editgruop('<?php echo $GroupName->id; ?>')" title="<?php _e("Rename Category", "appointzilla"); ?>"><?php _e("Rename", "appointzilla"); ?></a>
                            <?php if($GroupName->id !='1') { ?>
                                | <a rel="tooltip" href="?page=service&gid=<?php echo $GroupName->id; ?>" class="btn btn-danger btn-small" onclick="return confirm('<?php _e("Do you want to delete this Category?", "appointzilla"); ?>')" title="<?php _e("Delete", "appointzilla"); ?>"><?php _e("Delete", "appointzilla"); ?></a>
                            <?php } ?>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th><strong><?php _e("Name", "appointzilla"); ?></strong></th>
                    <th><strong><?php _e("Description", "appointzilla"); ?></strong></th>
                    <th><strong><?php _e("Duration", "appointzilla"); ?></strong></th>
                    <th><strong><?php _e("Cost", "appointzilla"); ?></strong></th>
                    <th><strong><?php _e("Availability", "appointzilla"); ?></strong></th>
                    <th><strong><?php _e("Action", "appointzilla"); ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // get service list group wise
                $ServiceTable = $wpdb->prefix . "services";
                $ServiceDetails = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$ServiceTable`"));
                foreach($ServiceDetails as $Service) { ?>
                <tr class="odd" style="border-bottom:1px;">
                    <td><em><?php echo ucwords($Service->name); ?></em></td>
                    <td> <em><?php echo ucfirst($Service->desc); ?></em> </td>
                    <td><em><?php echo $Service->duration. " ".ucfirst($Service->unit); ?></em></td>
                    <td><em><?php echo '&#36;'.$Service->cost; ?></em></td>
                    <td><em><?php echo ucfirst($Service->availability); ?></em></td>
                    <td class="button-column">
                        <a rel="tooltip" href="?page=manage-service&sid=<?php echo $Service->id; ?>" title="<?php _e("Update", "appointzilla"); ?>"><i class="icon-pencil"></i></a> &nbsp;
                        <?php if($Service->id != 1) { ?>
                        <a rel="tooltip" href="?page=service&sid=<?php echo $Service->id; ?>" onclick="return confirm('<?php echo _e("Do you want to delete this service?", "appointzilla"); ?>')" title="<?php _e("Delete", "appointzilla"); ?>" ><i class="icon-remove"></i>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="6">
                        <a href="?page=manage-service&gid=<?php echo $GroupName->id; ?>" rel="tooltip" title="<?php _e("Add New Service to this Category", "appointzilla"); ?>"><?php _e("+ Add New Service to this Category", "appointzilla"); ?></a>
                    </td>
                </tr>
            </tbody>
        </table>
    <!---New category div box--->
    <div id="gruopbuttonbox">
        <a class="btn btn-info" href="#" rel="tooltip" class="Create Gruop" onclick="creategruopname()"><i class="icon-plus icon-white"></i> <?php _e("Create New Service Category", "appointzilla"); ?></a></u>
    </div>

    <div style="display:none;" id="gruopnamebox">
        <form method="post">
			<?php wp_nonce_field('appointment_add_cat_nonce_check','appointment_add_cat_nonce_check'); ?>
            <?php _e("Service Category name ", "appointzilla"); ?>: <input type="text" id="gruopname" name="gruopname" class="inputheight" />
            <button style="margin-bottom:10px;" id="CreateGruop" type="submit" class="btn btn-small btn-success" name="CreateGruop"><i class="icon-ok icon-white"></i> <?php _e("Create Category", "appointzilla"); ?></button>
            <button style="margin-bottom:10px;" id="CancelGruop" type="button" class="btn btn-small btn-danger" name="CancelGruop" onclick="cancelgrup();"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></button>
        </form>
    </div>
    <!---New category div box end --->


<?php
    // Delete service
    if(isset($_GET['sid'])) {
        $DeleteId = intval( $_GET['sid'] );
        $wpdb->query($wpdb->prepare("DELETE FROM `$ServiceTable` WHERE `id` = %s;",$DeleteId));
        echo "<script>alert('" . __('Service successfully delete.', 'appointzilla') ."')</script>";
        echo "<script>location.href='?page=service';</script>";
    }
?>
</div>
<!--end of tooltip div-->

<!--js work-->
<style type="text/css">
    .error {  color:#FF0000;
    }
    input.inputheight {
        height:30px;
    }

    #editgruop {
        margin-bottom:10px;
    }

    #editgruopcancel {
        margin-bottom:10px;
    }
</style>

<script type="text/javascript">
    // edit group hide and show div box
    function editgruop(id) {
        var gneb='#gruopnamedivbox'+id;
        var gne='#gruopnameedit'+id;
        jQuery(gneb).hide();
        jQuery(gne).show();
    }

    function canceleditgrup(id) {
        var gneb='#gruopnamedivbox'+id;
        var gne='#gruopnameedit'+id;
        jQuery(gneb).show();
        jQuery(gne).hide();
    }

    //group create and  hide  or show div box ajax post data
    function creategruopname() {
        jQuery('#gruopnamebox').show();
        jQuery('#gruopbuttonbox').hide();
    }

    function cancelgrup() {
        jQuery('#gruopnamebox').hide();
        jQuery('#gruopbuttonbox').show();
    }

    jQuery(document).ready(function () {
        // create new group js
        jQuery('#CreateGruop').click(function() {
            jQuery('.error').hide();
            var gruopname = jQuery("input#gruopname").val();
            if (gruopname == "") {
                jQuery("#CancelGruop").after('<span class="error">&nbsp;<br><strong><?php _e('Category name cannot be blank.', 'appointzilla'); ?></strong></span>');
                return false;
            } else {
                var gruopname = isNaN(gruopname);
                if(gruopname == false) {
                    jQuery("#CancelGruop").after('<span class="error">&nbsp;<br><strong><?php _e('Invalid category name.', 'appointzilla'); ?></strong></span>');
                    return false;
                }
            }
            jQuery('#gruopnamebox').hide();
            jQuery('#gruopbuttonbox').show();
        });
    });
</script>