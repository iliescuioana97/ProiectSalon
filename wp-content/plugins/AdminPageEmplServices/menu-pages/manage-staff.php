<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
if (isset($_GET['sid'])) {
    $sid = intval($_GET['sid']);
    $StaffTable = $wpdb->prefix . "staff";
    $Staff = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$StaffTable` WHERE `id` = %s", $sid));
}
?>    
<div id="gruopnamebox">
    <p><?php echo $Staff->name; ?><p>

        <?php
        global $wpdb;
        //get all category list
        $ServiceTable = $wpdb->prefix . "services";
        $StaffServTable = $wpdb->prefix . "services_staff";

        $Services = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$ServiceTable` where id > %d", null));
        $SelectedServices = $wpdb->get_results($wpdb->prepare("SELECT service_id FROM `$StaffServTable` where staff_id = %d", $Staff->id));
//        var_dump($SelectedServices);die;
        $NonSelectedServices = $wpdb->get_results($wpdb->prepare("SELECT service_id FROM `$StaffServTable` where staff_id != %d", $Staff->id));
        ?>

    <form method="post">
        <?php wp_nonce_field(); ?>

            <!--<input type="HIDDEN" id="gruopname" name="gruopname" class="inputheight" />-->
            
        <?php
        foreach ($Services as $Service) {
            $S = 0;
            foreach ($SelectedServices as $SelectedService) {
                if ($Service->id === $SelectedService->service_id) {
                    $S = $SelectedService->service_id;
                }
            }
            ?>
            <div style="display:block">
                <label style="display: inline-block">
                <input type="checkbox" name="options[]" value="<?php echo $Service->id; ?>" 
                           <?php echo $S > 0 ? "checked" : ''; ?> />
                <?php
                       echo $Service->name;
                   ?></label>
            </div>
            <?php }
        ?>

        <br>
        <button style="margin-bottom:10px;" id="CreateGruop" type="submit" class="btn btn-small btn-success" name="CreateGruop"><i class="icon-ok icon-white"></i> <?php _e("Creaza angajat", "appointzilla"); ?></button>

    </form>

</div>



<?php
global $wpdb;
$StaffServiceRel = $wpdb->prefix . "services_staff";
$StaffTable = $wpdb->prefix . "staff";
$ServiceTable = $wpdb->prefix . "services";
if (isset($_POST['CreateGruop'])) {

    $options = $_POST['options'];

    foreach ($SelectedServices as $SelectedService) {
        $wpdb->query($wpdb->prepare("DELETE FROM `$StaffServiceRel` WHERE `staff_id` = %d;
        ", $sid));
    }

   foreach ($options as $o) {
            $wpdb->query($wpdb->prepare("INSERT INTO `$StaffServiceRel` ( `service_id`, `staff_id` ) VALUES (%d, %d);
        ", array($o, $sid)));
        }
        echo "<script>alert('" . __('Serviciile angajatului au fost updatate.', 'appointzilla') . "')</script>";
        echo "<script>location.href='?page=staff';</script>";
    
}
?>
<script>
    jQuery('#CreateGruop2').click(function () {
        if (!jQuery('#gruopname').val()) {
            jQuery("#gruopname").after("<span class='apcal-error'><br><strong><?php _e("Completati numele.", "appointzilla"); ?></strong></span>");
            return false;
        } else if (!isNaN(jQuery('#gruopname').val())) {
            jQuery("#gruopname").after("<span class='apcal-error'><p><strong><?php _e("Nume invalid.", "appointzilla"); ?></strong></p></span>");
            return false;
        }
    });
</script>
