<?php ?>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<div class="bs-docs-example tooltip-demo" style="background-color: #FFFFFF;">
    <div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;"><h3><?php _e("Employees", "appointzilla"); ?></h3></div>
<?php
    global $wpdb;
    if(isset($_GET['sid'])) {
        $sid = intval( $_GET['sid'] );
        $ServiceTable = $wpdb->prefix . "services";
        $ServiceDetails = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$ServiceTable` WHERE `id` =%s",$sid));
        

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
                echo "<script>alert('" . __("Invalid staff name.", "appointzilla") . "');</script>";
            }
        } else {
            echo "<script>alert('" . __("Category name cannot be blank.", "appointzilla") . "');</script>";
        }
    }
