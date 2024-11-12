<?php
add_shortcode('product_grid', 'display_product_grid');



function fetch_product_grid($category_slug = '', $price = '') {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($category_slug) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categories',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        );
    }

    if ($price) {
        $args['meta_query'] = array(
            array(
                'key' => '_product_price',
                'value' => $price,
                'compare' => '<=',
                'type' => 'NUMERIC',
            ),
        );
    }

    $query = new WP_Query($args);
    $output = '<div class="product-grid">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $price = get_post_meta(get_the_ID(), '_product_price', true);
            $categories = get_the_terms(get_the_ID(), 'categories');
            $category_names = is_array($categories) ? implode(', ', wp_list_pluck($categories, 'name')) : '';

            $output .= '<div class="product-item product">';
                $output .= '<a href="' . get_permalink() . '">';
                $output .= '<div class="product-image">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</div>';
                $output .= '<div class="product-info">';
                $output .= '<a href="#" class="quickview" data-product-id="' . get_the_ID() . '"><i class="fas fa-eye"></i> Quick View</a>';
                    
                    $output .= '<h3>' . get_the_title() . '</h3>';
                    $output .= '<div class="meta">';
                        $output .= '<p class="cat">' . $category_names . '</p>';
                        $output .= '<p class="price">' . ($price ? '$' . $price : 'Price not available') . '</p>';
                        
                    $output .= '</div>';
                    
                    
                $output .= '</div>';
                $output .= '<a href="#" class="vi-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>';
                $output .= '</a>';
            $output .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No products found.</p>';
    }
    $output .= '</div>';

    return $output;
}


function display_product_grid($atts) {
    $categories = get_terms(array(
        'taxonomy' => 'categories',
        'hide_empty' => true,
    ));

    $output = '<div class="product-grid-wrapper">'; 

    $output .= '<div class="filter-sidebar">';
    
    $output .= '<h3>Filter by Category</h3>';
    $output .= '<select id="product-category-filter">';
    $output .= '<option value="">All Categories</option>';
    foreach ($categories as $category) {
        $output .= '<option value="' . $category->slug . '">' . $category->name . '</option>';
    }
    $output .= '</select>';

    $output .= '<div id="price-filter-container">';
    $output .= '<h3>Filter by Price</h3>';
    $output .= '<label for="price-range">Price Range: </label>';
    $output .= '<input type="range" id="price-range" name="price-range" min="0" max="1000" step="10" value="1000">';
    $output .= '<span id="price-range-value">$1000</span>';
    $output .= '</div>';

    $output .= '</div>';  

    $output .= '<div id="product-grid-container" class="product-grid-container">';
    $output .= fetch_product_grid();  
    $output .= '</div>'; 

    $output .= '</div>';  

     $output .= '<div id="quick-view-modal" class="quick-view-modal">';
     $output .= '<div class="quick-view-backdrop"></div>';
     $output .= '<div class="quick-view-content-wrapper">';
     $output .= '<span id="close-quick-view">&times;</span>'; 
     $output .= '<div id="quick-view-content"></div>'; 
     $output .= '</div></div>';

    return $output;
}


function fetch_product_details() {
    $product_id = $_POST['product_id'];
    $product = get_post($product_id);
    $price = get_post_meta($product_id, '_product_price', true);
    $categories = get_the_terms($product_id, 'categories');
    $category_names = is_array($categories) ? implode(', ', wp_list_pluck($categories, 'name')) : '';
    $thumbnail = get_the_post_thumbnail($product_id, 'medium');
    
    $output = '<div class="quick-view-content">';
    $output .= '<div class="quick-view-left">' . $thumbnail . '</div>';
    $output .= '<div class="quick-view-right">';
    $output .= '<h3>' . $product->post_title . '</h3>';
    $output .= '<p class="quick-view-price">' . ($price ? '$' . $price : 'Price not available') . '</p>';
    $output .= '<div class="quick-view-category">' . $category_names . '</div>';
    $output .= '<p class="quick-view-description">' . $product->post_content . '</p>';
    $output .= '<a href="#" class="vi-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>';
    $output .= '</div></div>';

    echo $output;
    wp_die();
}

add_action('wp_ajax_fetch_product_details', 'fetch_product_details');
add_action('wp_ajax_nopriv_fetch_product_details', 'fetch_product_details');



function enqueue_product_filter_scripts() {
    wp_enqueue_script('product-filter', get_template_directory_uri() . '/product-filter.js', array('jquery'), '1.0', true);
    wp_enqueue_style('product-grid-style', get_template_directory_uri() . '/product-grid-style.css');
    wp_localize_script('product-filter', 'productFilter', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_product_filter_scripts');

add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');

function filter_products() {
    $category_slug = $_POST['category'];
    $price = isset($_POST['price']) ? $_POST['price'] : 1000;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($category_slug) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categories',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        );
    }

    if ($price) {
        $args['meta_query'] = array(
            array(
                'key' => '_product_price',
                'value' => $price,
                'compare' => '<=',
                'type' => 'NUMERIC',
            ),
        );
    }

    $query = new WP_Query($args);
    echo fetch_product_grid($category_slug, $price);
    wp_die();
}

