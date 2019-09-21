<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
    // Change this to use your theme slug
    return 'options-framework-theme';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
function optionsframework_options() {

    // Test data
    $test_array = array(
        'one' => __('One', 'theme-textdomain'),
        'two' => __('Two', 'theme-textdomain'),
        'three' => __('Three', 'theme-textdomain'),
        'four' => __('Four', 'theme-textdomain'),
        'five' => __('Five', 'theme-textdomain')
    );
    // Multicheck Array
    $multicheck_array = array(
        'one' => __('French Toast', 'theme-textdomain'),
        'two' => __('Pancake', 'theme-textdomain'),
        'three' => __('Omelette', 'theme-textdomain'),
        'four' => __('Crepe', 'theme-textdomain'),
        'five' => __('Waffle', 'theme-textdomain')
    );
    $days = array(
        '0' => __('Sunday', 'theme-textdomain'),
        '1' => __('Monday', 'theme-textdomain'),
        '2' => __('Tuesday', 'theme-textdomain'),
        '3' => __('Wednesday', 'theme-textdomain'),
        '4' => __('Thursday', 'theme-textdomain'),
        '5' => __('Friday', 'theme-textdomain'),
        '6' => __('Saturday', 'theme-textdomain')
    );
//    for($i = 1 ; $i < 25 ; $i++ ){ 
//        $times[$i] = $i;
//    }
    $timesAM = array(
        '0' => __('12:00 AM', 'theme-textdomain'),
        '1' => __('01:00 AM', 'theme-textdomain'),
        '2' => __('02:00 AM', 'theme-textdomain'),
        '3' => __('03:00 AM', 'theme-textdomain'),
        '4' => __('04:00 AM', 'theme-textdomain'),
        '5' => __('05:00 AM', 'theme-textdomain'),
        '6' => __('06:00 AM', 'theme-textdomain'),
        '7' => __('07:00 AM', 'theme-textdomain'),
        '8' => __('08:00 AM', 'theme-textdomain'),
        '9' => __('09:00 AM', 'theme-textdomain'),
        '10' => __('10:00 AM', 'theme-textdomain'),
        '11' => __('11:00 AM', 'theme-textdomain'),
    );
    $timesPM = array(
        '12' => __('12:00 PM', 'theme-textdomain'),
        '13' => __('01:00 PM', 'theme-textdomain'),
        '14' => __('02:00 PM', 'theme-textdomain'),
        '15' => __('03:00 PM', 'theme-textdomain'),
        '16' => __('04:00 PM', 'theme-textdomain'),
        '17' => __('05:00 PM', 'theme-textdomain'),
        '18' => __('06:00 PM', 'theme-textdomain'),
        '19' => __('07:00 PM', 'theme-textdomain'),
        '20' => __('08:00 PM', 'theme-textdomain'),
        '21' => __('09:00 PM', 'theme-textdomain'),
        '22' => __('10:00 PM', 'theme-textdomain'),
        '23' => __('11:00 PM', 'theme-textdomain'),
    );
    // Multicheck Defaults
    $multicheck_defaults = array(
        'one' => '1',
        'five' => '1'
    );

    // Background Defaults
    $background_defaults = array(
        'color' => '',
        'image' => '',
        'repeat' => 'repeat',
        'position' => 'top center',
        'attachment' => 'scroll');

    // Typography Defaults
    $typography_defaults = array(
        'size' => '15px',
        'face' => 'georgia',
        'style' => 'bold',
        'color' => '#bada55');

    // Typography Options
    $typography_options = array(
        'sizes' => array('6', '12', '14', '16', '20'),
        'faces' => array('Helvetica Neue' => 'Helvetica Neue', 'Arial' => 'Arial'),
        'styles' => array('normal' => 'Normal', 'bold' => 'Bold'),
        'color' => false
    );

    // Pull all the categories into an array
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }

    // Pull all tags into an array
    $options_tags = array();
    $options_tags_obj = get_tags();
    foreach ($options_tags_obj as $tag) {
        $options_tags[$tag->term_id] = $tag->name;
    }


    // Pull all the pages into an array
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }

    // Pull all the products into an array
    $options_products = array();
//    $args = array('post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC');
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $options_products_obj = new WP_Query($args);
    if ($options_products_obj->have_posts()) {
//        
        $args = array('post_type' => 'product', 'posts_per_page' => 10);
        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
             $ids = (get_the_ID());            
            $options_products[$ids] = get_the_title().' - ID:'.$ids;            
        endwhile;
//        wp_reset_postdata();
    } else {
        echo "No products found";
    }

    // If using image radio buttons, define a directory path
    $imagepath = get_template_directory_uri() . '/theme_options/images/';

    $options = array();
    $options[] = array(
        'name' => __('Top Bar', 'theme-textdomain'),
        'type' => 'heading'
    );
    $options[] = array(
        "name" => "Top Bar Left text",
        "id" => "topbar_left_text",
        "std" => "",
        "type" => "text"
    );
    $options[] = array(
        "name" => "Top Bar Right text (Phone number)",
        "id" => "topbar_right_phone",
        "std" => "",
        "type" => "text"
    );
    $options[] = array(
        "name" => "Top Bar Right text (Email Address)",
        "id" => "topbar_right_email",
        "std" => "",
        "type" => "text"
    );
    $options[] = array(
        "name" => "Top Bar Right text (Email Address Image)",
        "id" => "topbar_right_email_image",
        "std" => "",
        "desc" => __("If you not upload the image for email, above email address display automatically. Recomended size is: 187x19", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        'name' => __('Mini Cart', 'theme-textdomain'),
        'type' => 'heading'
    );
    $options[] = array(
        "name" => "Upload Minicart security image",
        "id" => "minicart_image",
        "std" => "",
        "desc" => __("Upload Minicart bottom image. Recomended size is: 229x37", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Secure image URL",
        "id" => "secure_image_link",
        "std" => "",
        "type" => "text"
    );
    $options[] = array(
        'name' => __('HomePage Slider', 'theme-textdomain'),
        'type' => 'heading'
    );
    $options[] = array(
        "name" => "Slider 1",
        "id" => "slider1",
        "std" => "",
        "desc" => __("Upload slider 1 image", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Slider 2",
        "id" => "slider2",
        "std" => "",
        "desc" => __("Upload slider 2 image", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Slider 3",
        "id" => "slider3",
        "std" => "",
        "desc" => __("Upload slider 3 image", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Slider 4",
        "id" => "slider4",
        "std" => "",
        "desc" => __("Upload slider 4 image", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Trending Products",
        "id" => "trending_products",
        "std" => "",
        "desc" => __("Please write the Ids (separated by commas) of products which you want to display in trending.---- Ex.: 10,20,30", "veriyas"),
        "type" => "text"        
    );    
    $options[] = array(
        'name' => __('Footer Section', 'theme-textdomain'),
        'type' => 'heading'
    );
    $options[] = array(
        "name" => "Copyright text",
        "id" => "copyright_text",
        "std" => "",
        "type" => "editor"
    );
    $options[] = array(
        "name" => "Store Information Widget (Email Address Image)",
        "id" => "store_email_image",
        "std" => "",
        "desc" => __("If you not upload the image for email, Store Information Widget email address display automatically. Recomended size is: 198x20", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        "name" => "Upload payment accept image",
        "id" => "payment-accept",
        "std" => "",
        "desc" => __("Upload image", "veriyas"),
        "type" => "upload"
    );
    $options[] = array(
        'name' => __('Google Analytics', 'theme-textdomain'),
        'type' => 'heading',
    );
    $options[] = array(
        "name" => "Google Analytics Code",
        "id" => "google_code",
        "desc" => __("<b>Note: Require &lt;script&gt; tag</b>", "veriyas"),
        "std" => "",
        "type" => "editor"
    );
    $options[] = array(
        'name' => __('Paypal URL', 'theme-textdomain'),
        'type' => 'heading',
    );
    $options[] = array(
        "name" => "Paypal URL",
        "id" => "paypal_url",
        "desc" => __("<b>Note: No need to write entire URL Just write only name like: https://www.paypal.me/XYZTech/. Just write: XYZTech</b>", "veriyas"),
        "std" => "sanjutech",
        "type" => "text"
    );
    $options[] = array(
        'name' => __('Express Counter', 'theme-textdomain'),
        'type' => 'heading',
    );
    $options[] = array(
        "name" => "",
        "id" => "express_products",
        "desc" => __("<b>Note: Just add the product Ids separated by commas(,). Ex: 10, 20, 30</b>", "veriyas"),
        "std" => "",
        "type" => "text"
    );
    $options[] = array(
        'name' => __('Feedback Email Rating Image', 'theme-textdomain'),
        'type' => 'heading',
    );
    $options[] = array(
        "name" => "",
        "id" => "feedback_image",
        "desc" => __("Please upload the feedback rating image, It will display on email after order complete.", "veriyas"),
        "std" => "",
        "type" => "upload"
    );
    $options[] = array(
        "name" => "",
        "id" => "feedback_url",
        "desc" => __("Please upload the feedback rating url, It will display on email after order complete.", "veriyas"),
        "std" => "https://www.trustpilot.com/evaluate/genericvilla.com?utm_medium=trustbox&utm_source=TrustBoxReviewCollector",
        "type" => "text"
    );

    return $options;
}
