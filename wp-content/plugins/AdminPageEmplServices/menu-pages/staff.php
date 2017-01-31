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
    <div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;"><h3><?php _e("Angajati", "appointzilla"); ?></h3></div>
    <?php
    global $wpdb;
    //get all category list
    $StaffTable = $wpdb->prefix . "staff";
    $StaffCategory = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$StaffTable` where id > %d", null));
    foreach ($StaffCategory as $GroupName) {
        ?>
        <table class="table">
            <thead>
                <tr style="background:#C3D9FF; margin-bottom:10px; padding-left:10px; ">
                    <th colspan="3">
                        <div id="gruopnamedivbox <?php echo $GroupName->id; ?>"><?php echo ucfirst($GroupName->name); ?></div>
                        <div id="gruopnameedit<?php echo $GroupName->id; ?>" style="display:none; height:25px;">
                            <form method="post">
                                <input type="text" id="editgruopname" class="inputheight" name="editgruopname" value="<?php echo $GroupName->name; ?>"/>
                                <button id="editgruop" value="<?php echo $GroupName->id; ?>" name="editgruop" type="submit" class="btn btn-small btn-success"><i class="icon-ok icon-white"></i> <?php _e("Save", "appointzilla"); ?></button>
                                <button id="editgruopcancel" type="button" class="btn btn-small btn-danger" onclick="canceleditgrup('<?php echo $GroupName->id; ?>')"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></button>
                            </form>
                        </div>
                           </th>
                    <th id="yw7_c1" colspan="3">
                        <!--- header rename and delete button right box-->
                        <div align="">
                            <?php if($GroupName->id =='1') ?>
                                <a rel="tooltip" href="#" data-placement="left" class="btn btn-success btn-small" id="<?php echo $GroupName->id; ?>" onclick="editgruop('<?php echo $GroupName->id; ?>')" title="<?php _e("Rename Category", "appointzilla"); ?>"><?php _e("Redenumeste", "appointzilla"); ?></a>
                            <?php if($GroupName->id !='1') { ?>
                                | <a rel="tooltip" href="?page=staff&gid=<?php echo $GroupName->id; ?>" class="btn btn-danger btn-small" onclick="return confirm('<?php _e("Esti sigur ca doresti sa stergi acest angajat?", "appointzilla"); ?>')" title="<?php _e("Delete", "appointzilla"); ?>"><?php _e("Sterge", "appointzilla"); ?></a>
                            <?php } ?>
                        </div
                    </th>
                </tr>
                <tr>
                    <th><strong><?php _e("Nume", "appointzilla"); ?></strong></th>

                </tr>
            </thead>
            <tbody>
                <?php
                // get service list group wise
                $ServiceTable = $wpdb->prefix . "services";
                $StaffTable = $wpdb->prefix . "staff";
                $StaffServiceRel = $wpdb->prefix . "services_staff";
                $StaffServiceTable = $wpdb->get_results($wpdb->prepare("select * from `$ServiceTable` as s left join `$StaffServiceRel` as r on  s.id = r.service_id where r.staff_id = %d;", $GroupName->id));
                foreach ($StaffServiceTable as $Service) {
                    ?>
                    <tr class="odd" style="border-bottom:1px;">
                        <td><em><?php echo ucwords($Service->name); ?></em></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6">
                        <a href="?page=manage-staff&sid=<?php echo $GroupName->id; ?>" rel="tooltip" title="<?php _e("Assign new service to this staff member", "appointzilla"); ?>"><?php _e("+ Adauga un nou serviciu pentru acest angajat", "appointzilla"); ?></a>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
    <!---New category div box--->
    <div id="gruopbuttonbox">
        <a class="btn btn-info" href="#" rel="tooltip" class="Create Gruop" onclick="creategruopname()"><i class="icon-plus icon-white"></i> <?php _e("Adauga un nou angajat", "appointzilla"); ?></a></u>
    </div>

    <div style="display:none;" id="gruopnamebox">
        <form method="post">
            <?php wp_nonce_field('appointment_add_cat_nonce_check', 'appointment_add_cat_nonce_check'); ?>
            <?php _e("Numele angajatului: ", "appointzilla"); ?>: <input type="text" id="gruopname" name="gruopname" class="inputheight" />
            <br>

            <?php
            global $wpdb;
            //get all category list
            $ServiceTable = $wpdb->prefix . "services";
            $Services = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$ServiceTable` where id > %d", null));
            foreach ($Services as $Service) {
                ?>
                <div style="display:block">
                    <input style="display: inline-block" id="radioboxes" type="checkbox" name="options[]" value="<?php echo ucwords($Service->id); ?>" />
                    <label style="display: inline-block"><?php echo ucwords($Service->name); ?></label> <?php } ?>
            </div>

            <br>
            <button style="margin-bottom:10px;" id="CreateGruop2" type="submit" class="btn btn-small btn-success" name="CreateGruop"><i class="icon-ok icon-white"></i> <?php _e("Creaza angajat", "appointzilla"); ?></button>
            <button style="margin-bottom:10px;" id="CancelGruop2" type="button" class="btn btn-small btn-danger" name="CancelGruop" onclick="cancelgrup();"><i class="icon-remove icon-white"></i> <?php _e("Anuleaza", "appointzilla"); ?></button>

        </form>
    </div>
    <script>
        jQuery('#CreateGruop2').click(function () {
            if (!jQuery('#gruopname').val()) {
                jQuery("#gruopname").after("<span class='apcal-error'><br><strong><?php _e("Completeaza numele.", "appointzilla"); ?></strong></span>");
                return false;
            } else if (!isNaN(jQuery('#gruopname').val())) {
                jQuery("#gruopname").after("<span class='apcal-error'><p><strong><?php _e("Nume invalid.", "appointzilla"); ?></strong></p></span>");
                return false;
            }
        })
    </script>

    <!---New category div box end --->


    <?php
    // insert new staff member
    global $wpdb;
    $StaffServiceRel = $wpdb->prefix . "services_staff";
    $StaffTable = $wpdb->prefix . "staff";
    $ServiceTable = $wpdb->prefix . "services";
    if (isset($_POST['CreateGruop'])) {

        $groupename = sanitize_text_field($_POST['gruopname']);
        $options = $_POST['options'];

        $wpdb->query($wpdb->prepare("INSERT INTO `$StaffTable` ( `name` ) VALUES (%s);
        ", $groupename));
        $StaffId = $wpdb->get_row($wpdb->prepare("SELECT `id` FROM `$StaffTable` WHERE `name` = %s", $groupename), OBJECT);
        foreach ($options as $o) {
            $wpdb->query($wpdb->prepare("INSERT INTO `$StaffServiceRel` ( `service_id`, `staff_id` ) VALUES (%d, %d);
        ", array($o, $StaffId->id)));
        }
        echo "<script>alert('" . __('Angajat adaugat cu succes.', 'appointzilla') . "')</script>";
        echo "<script>location.href='?page=staff';</script>";
    }

    // update service category
    if (isset($_POST['editgruop'])) {
        $update_id = intval($_POST['editgruop']);
        $update_name = sanitize_text_field($_POST['editgruopname']);
        $tt = !is_numeric($update_name);
        if ($update_name) {
            if (!is_numeric($update_name)) {
                $wpdb->query($wpdb->prepare("UPDATE `$StaffTable` SET `name` = '$update_name' WHERE `id` =%s;", $update_id));
                echo "<script>location.href = '?page=staff';</script>";
            } else {
                echo "<script>alert('" . __("Numele angajatului este invalid.", "appointzilla") . "');</script>";
            }
        } else {
            echo "<script>alert('" . __("Completati numele angajatului.", "appointzilla") . "');</script>";
        }
    }

    // Delete employee
    if (isset($_GET['gid'])) {
        $DeleteId = intval($_GET['gid']);
        $wpdb->query($wpdb->prepare("DELETE FROM `$StaffTable` WHERE `id` = %s;", $DeleteId));

        //update all service category id
        $UpdateServiceSQL = "UPDATE `$StaffServiceRel` SET `staff_id` = '0' WHERE `staff_id` ='$DeleteId';";
        $wpdb->query($UpdateServiceSQL); // update category
        echo "<script>alert('" . __('Angajat sters cu succes.', 'appointzilla') . "')</script>";
        echo "<script>location.href = '?page=staff';</script>";
    }

    // Delete employee's services
    if (isset($_GET['sid'])) {
        $DeleteId = intval($_GET['sid']);
        $wpdb->query($wpdb->prepare("DELETE FROM `$StaffServiceRel` WHERE `service_id` = %s;", $DeleteId));
        echo "<script>alert('" . __('Serviciu sters cu succes.', 'appointzilla') . "')</script>";
        echo "<script>location.href = '?page=staff';</script>";
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
        var gneb = '#gruopnamedivbox' + id;
        var gne = '#gruopnameedit' + id;
        jQuery(gneb).hide();
        jQuery(gne).show();
    }

    function canceleditgrup(id) {
        var gneb = '#gruopnamedivbox' + id;
        var gne = '#gruopnameedit' + id;
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
        jQuery('#CreateGruop').click(function () {
            jQuery('.error').hide();
            var gruopname = jQuery("input#gruopname").val();
            if (gruopname == "") {
                jQuery("#CancelGruop").after('<span class="error">&nbsp;<br><strong><?php _e('Category name cannot be blank.', 'appointzilla'); ?></strong></span>');
                return false;
            } else {
                var gruopname = isNaN(gruopname);
                if (gruopname == false) {
                    jQuery("#CancelGruop").after('<span class="error">&nbsp;<br><strong><?php _e('Invalid category name.', 'appointzilla'); ?></strong></span>');
                    return false;
                }
            }
            jQuery('#gruopnamebox').hide();
            jQuery('#gruopbuttonbox').show();
        });
    });
</script>

