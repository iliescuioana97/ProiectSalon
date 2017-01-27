<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;"><h3><?php _e("Services"); ?></h3></div>
<!-- manage service form -->	
<div class="bs-docs-example tooltip-demo">
    <?php global $wpdb;
    if(isset($_GET['sid'])) {
        $sid = intval( $_GET['sid'] );
        $ServiceTable = $wpdb->prefix . "services";
        $ServiceDetails = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$ServiceTable` WHERE `id` =%s",$sid));
        $ServiceDetails->category_id;
    } else {
        $ServiceDetails = NULL;
    } ?>
    <form action="" method="post" name="manageservice">
        <table width="100%" class="table" >
            <tr>
                <th width="18%" scope="row"><?php _e("Name"); ?></th>
                <td width="5%">&nbsp;</td>
                <td width="77%"><input name="name" type="text" id="name"  value="<?php if($ServiceDetails) { echo $ServiceDetails->name; } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Name"); ?>" ><i class="icon-question-sign"></i></a></td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Description"); ?></strong></th>
                <td>&nbsp;</td>
                <td><textarea name="desc" id="desc"><?php if($ServiceDetails) { echo $ServiceDetails->description; } ?></textarea>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Description"); ?>" ><i class="icon-question-sign"></i></a>
            </td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Duration"); ?></strong></th>
                <td>&nbsp;</td>
                <td><input name="Duration" type="text" id="Duration"  value="<?php if($ServiceDetails) { echo $ServiceDetails->duration; } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Duration.<br>Enter Numeric Value.<br>Eg: 5, 10, 15, 30, 60"); ?>" ><i class="icon-question-sign"></i> </a></td>
            </tr>
           
            <tr>
                <th scope="row"><strong><?php _e("Cost"); ?></strong></th>
                <td>&nbsp;</td>
                <td><input name="cost" type="text" id="cost" value="<?php if($ServiceDetails) { echo $ServiceDetails->cost; } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Cost<br>Enter Numeric Value<br> Eg: 5 , 10, 25, 50, 100, 150"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Availability"); ?></strong></th>
                <td>&nbsp;</td>
                <td>
                    <select id="availability" name="availability">
                        <option value="0"><?php _e("Select Service Availability"); ?></option>
                        <option value="yes" <?php if($ServiceDetails) { if($ServiceDetails->availability == 'yes') echo "selected"; } ?> ><?php _e("Yes"); ?></option>
                        <option value="no" <?php if($ServiceDetails) { if($ServiceDetails->availability == 'no') echo "selected"; } ?> ><?php _e("No"); ?></option>
                    </select>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Availability"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Category"); ?></th>
                <td>&nbsp;</td>
                <td>
                    <select id="category" name="category">
                        <option value="0"><?php _e("Select Category"); ?></option>
                        <?php //get all category list
                            $table_name = $wpdb->prefix . "service_category";
                            $service_category = $wpdb->get_results($wpdb->prepare("select * from $table_name where id > %d",null));
                            foreach($service_category as $gruopname) { ?>
                                <option value="<?php echo $gruopname->id; ?>"
                                    <?php if($ServiceDetails) { if($ServiceDetails->category_id == $gruopname->id) echo "selected";  ?><?php if(isset($_GET['gid']) == $gruopname->id) echo "selected"; } ?> >
                                    <?php echo $gruopname->name; ?>
                                </option>
                            <?php } ?>
                        </select>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Category"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row">&nbsp;</th>
                <td>&nbsp;</td>
                <td>
                    <?php if(isset($_GET['sid'])) { ?>
                    <button id="saveservice" type="submit" class="btn btn-success" name="updateservice"><i class="icon-pencil icon-white"></i> <?php _e("Update"); ?></button>
                    <?php } else {?>
                    <button id="saveservice" type="submit" class="btn btn-success" name="saveservice"><i class="icon-ok icon-white"></i> <?php _e("Create"); ?></button>
                    <?php } ?>
                    <a href="?page=service" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php _e("Cancel"); ?></a>
                </td>
            </tr>
      </table>
    </form>
</div>

<?php 
//inserting a service
if(isset($_POST['saveservice'])) {

		
    $servicename = sanitize_text_field( $_POST['name'] );
    $desc = sanitize_text_field( $_POST['description'] );
    $Duration = intval( $_POST['Duration'] );
    $cost = intval( $_POST['cost'] );
    $availability = sanitize_text_field( $_POST['availability'] );
    $category = intval( $_POST['category'] );
    $ServiceTable = $wpdb->prefix . "services";
    if($wpdb->query($wpdb->prepare("INSERT INTO `$ServiceTable` ( `name` , `description` , `duration` , `cost` , `availability`, `category_id` ) VALUES ('$servicename', '$desc', '$Duration', '$cost', '$availability', %s);",$category))) {
        echo "<script>alert('". __('New service successfully created.') ."');</script>";
    }
    echo "<script>location.href='?page=service';</script>";
}

//update a service
if(isset($_POST['updateservice'])) {
    $sid = intval( $_GET['sid'] );
    $ServiceName = sanitize_text_field( $_POST['name'] );
    $desc = sanitize_text_field( $_POST['desc'] );
    $Duration = intval( $_POST['Duration'] );
    $cost = intval( $_POST['cost'] );
    $availability = sanitize_text_field( $_POST['availability'] );
    $category = intval( $_POST['category'] );
    $ServiceTable = $wpdb->prefix . "ap_services";
    $wpdb->query($wpdb->prepare("UPDATE `$ServiceTable` SET `name` = '$ServiceName', `desc` = '$desc', `duration` = '$Duration', `cost` = '$cost', `availability` = '$availability', `category_id` = '$category' WHERE `id` = %s;",$sid));
    echo "<script>alert('". __('Service successfully updated.') ."');</script>";
    echo "<script>location.href='?page=service';</script>";
} ?>

<style type="text/css">
    .error{  color:#FF0000; }
    input.inputheight { height:30px; }
</style>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#saveservice').click(function() {
            jQuery('.error').hide();
            var name = jQuery("input#name").val();
            if (name == "") {
                jQuery("#name").after('<span class="error">&nbsp;<br><strong><?php _e("Name cannot be blank."); ?></strong></span>');
                return false;
            } else {
                var name = isNaN(name);
                if(name == false) {
                    jQuery("#name").after('<span class="error">&nbsp;<br><strong><?php _e("Invalid name."); ?></strong></span>');
                    return false;
                }
            }

            var desc = jQuery("textarea#desc").val();
            if (desc == "") {
                jQuery("#desc").after('<span class="error">&nbsp;<br><strong><?php _e('Description  cannot be blank.');?></strong></span>');
                return false;
            }

            var Duration = jQuery("input#Duration").val();
            if (Duration == "") {
                jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration cannot be blank.');?></strong></span>');
                return false;
            } else if(Duration != 0) {
                var Duration = isNaN(Duration);
                if(Duration == true) {
                    jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Invalid Duration.');?></strong></span>');
                    return false;
                }  else {
                    var Duration = jQuery("input#Duration").val();
                    var testvalue = Duration%5;
                    if(testvalue !=0) {
                        jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration will be in multiple of 5, like as: 5, 10, 15, 20, 25.');?></strong></span>');
                        return false;
                    }
                }
            } else {
                jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration will be in multiple of 5, like as: 5, 10, 15, 20, 25.');?></strong></span>');
                return false;
            }

            var cost = jQuery("input#cost").val();
            if (cost == "") {
                jQuery("#cost").after('<span class="error">&nbsp;<br><strong><?php _e("Cost cannot be blank."); ?></strong></span>');
                return false;
            } else {
                var cost = isNaN(cost);
                if(cost == true) {
                    jQuery("#cost").after('<span class="error">&nbsp;<br><strong><?php _e("Invalid cost."); ?></strong></span>');
                    return false;
                }
            }

            var availability = jQuery('#availability').val();
            if(availability == 0) {
                jQuery("#availability").after('<span class="error">&nbsp;<br><strong><?php _e("Select availability."); ?></strong></span>');
                return false;
            }

            var category = jQuery('#category').val();
            if(category == 0) {
                jQuery("#category").after('<span class="error">&nbsp;<br><strong><?php _e("Select category."); ?></strong></span>');
                return false;
            }
        });
    });
</script>