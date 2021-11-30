<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");

// Admin Share Globals.
$GG_SHARE_1 = [];
$GG_SHARE_2 = [];

// Constants.
//define( 'GG_PLUGIN_PATH', str_replace('/var/www', '', plugin_dir_path( __FILE__ ) ) );

// Get the gg_sharetable.
$gg_share_table = $wpdb->prefix . 'gg_share';
if($wpdb->get_var("SHOW TABLES LIKE '$gg_share_table'") == $gg_share_table) {

    $gg_share_table_data = $wpdb->get_results( "SELECT * FROM $gg_share_table" );

    $GG_SHARE_1 = array (
                    'id'                          => $gg_share_table_data[0]->id,
                    'share_id'                    => $gg_share_table_data[0]->share_id,
                    'show_lesson_plan'            => $gg_share_table_data[0]->show_lesson_plan,
                    'show_answers'                => $gg_share_table_data[0]->show_answers,
                    'show_video_only'             => $gg_share_table_data[0]->show_video_only,
                    'allow_visiting_other_pages'  => $gg_share_table_data[0]->allow_visiting_other_pages,
                    'hide_assessments'            => $gg_share_table_data[0]->hide_assessments,
                    'last_activity'               => $gg_share_table_data[0]->last_activity
                );
    $GG_SHARE_2 = array (
                    'id'                          => $gg_share_table_data[1]->id,
                    'share_id'                    => $gg_share_table_data[1]->share_id,
                    'show_lesson_plan'            => $gg_share_table_data[1]->show_lesson_plan,
                    'show_answers'                => $gg_share_table_data[1]->show_answers,
                    'show_video_only'             => $gg_share_table_data[1]->show_video_only,
                    'allow_visiting_other_pages'  => $gg_share_table_data[1]->allow_visiting_other_pages,
                    'hide_assessments'            => $gg_share_table_data[1]->hide_assessments,
                    'last_activity'               => $gg_share_table_data[1]->last_activity
                );
}
else {
    echo '<p style="color:#FFF;">Error installing plugin. Database table gg_share not found.</p>';
    die;
}

// Handle form submits.


?>

<!-- <div class="wrap gg-wrap"> -->
<div class="wrap gg-wrap">
    <h1>Genius Share Admin</h1>

    <div class="gg_form_wrapper"> 

       TEST

        

    </div>
</div>