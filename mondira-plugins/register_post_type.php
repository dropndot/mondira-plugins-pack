<?php
/**
* Plugins custom post type management file.
*
* @package Wordpress
* @subpackage Mondira
* @version 1.0
*/

/*
---------------------------------------------------------------------------------------
	Registering Plugin Post Type
	@Author: Jewel Ahmed
	@Author Web: http://codeatomic.com
	@Last Updated: 15 Nov, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_plugins_register' ) ) { 
    function mondira_plugins_register() {  
        $labels = array(
            'name' => 'M. Plugins', 
            'singular_name' => __( 'Plugin Item', 'mondira' ),
            'add_new' => __( 'Add New Plugin', 'mondira' ), 
            'add_new_item' => __( 'Add New Plugin Item', 'mondira' ), 
            'edit_item' => __( 'Edit Plugin Item', 'mondira' ), 
            'new_item' => __( 'Add New Plugin Item', 'mondira' ),
            'view_item' => __( 'View Item', 'mondira' ), 
            'search_items' => __( 'Search Plugin', 'mondira' ), 
            'not_found' => __( 'No plugin items found', 'mondira' ),
            'not_found_in_trash' => __( 'No plugin items found in trash', 'mondira' )
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'page-attributes'),
            'rewrite' => array( 'slug' => 'plugin' ), // Permalinks format
            'menu_position' => 5,
            'menu_icon' => 'dashicons-screenoptions', //https://developer.wordpress.org/resource/dashicons/
            'has_archive' => true
        ); 
        
        $args = apply_filters('mondira_plugins_args', $args);
        register_post_type( 'plugins', $args );

        $taxonomy_plugins_category_labels = array(
            'name' => __( 'Plugin Categories', 'mondira' ), 
            'singular_name' => __( 'Plugin Category', 'mondira' ), 
            'search_items' => __( 'Search Plugin Categories', 'mondira' ), 
            'popular_items' => __( 'Popular Plugin Categories', 'mondira' ), 
            'all_items' => __( 'All Plugin Categories', 'mondira' ), 
            'parent_item' => __( 'Parent Plugin Category', 'mondira' ), 
            'parent_item_colon' => __( 'Parent Plugin Category:', 'mondira' ), 
            'edit_item' => __( 'Edit Plugin Category', 'mondira' ), 
            'update_item' => __( 'Update Plugin Category', 'mondira' ), 
            'add_new_item' => __( 'Add New Plugin Category', 'mondira' ), 
            'new_item_name' => __( 'New Plugin Category Name', 'mondira' ), 
            'separate_items_with_commas' => __( 'Separate Plugin categories with commas', 'mondira' ), 
            'add_or_remove_items' => __( 'Add or remove plugin categories', 'mondira' ), 
            'choose_from_most_used' => __( 'Choose from the most used plugin categories', 'mondira' ), 
            'menu_name' => __( 'Plugin Categories', 'mondira' )
        );

        $taxonomy_plugins_category_args = array(
            'labels' => $taxonomy_plugins_category_labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'plugins-category' ),
            'query_var' => true
        );

        $taxonomy_plugins_category_args = apply_filters('mondira_taxonomy_plugins_category_args', $taxonomy_plugins_category_args);
        register_taxonomy( 'plugins_category', array( 'plugins' ), $taxonomy_plugins_category_args );
        flush_rewrite_rules();        
    }  
}
add_action('init', 'mondira_plugins_register');

/*
---------------------------------------------------------------------------------------
    Registering Plugin Template Redirect for plugin category
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 20 Oct, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_plugins_category_redirect' ) ) { 
    function mondira_plugins_category_redirect(){
        global $wp;
        if( !empty( $wp->query_vars['plugins_category'] ) ){
            if( file_exists(TEMPLATEPATH."/taxonomy-plugins_category.php") ){
                include(TEMPLATEPATH."/taxonomy-plugins_category.php");
                exit();    
            }   
        }
    }
}
add_action('template_redirect','mondira_plugins_category_redirect');

/*
---------------------------------------------------------------------------------------
    Registering Mondira Plugin Custom Post Grid Interface
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 20 Oct, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_plugins_edit_columns' ) ) {
    function mondira_plugins_edit_columns( $columns ) {
		$columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', 'mondira' ), 
            'plugins_thumbnail' => __( 'Thumbnail', 'mondira' ), 
            'plugins_category' => __( 'Category', 'mondira' ), 
            'plugins_menu_order' => __( 'Sort Order', 'mondira' ),  
            'date' => __( 'Date', 'mondira' ) 
        );
        return $columns;
    }
}
add_filter( 'manage_edit-plugins_columns', 'mondira_plugins_edit_columns' ) ;

/*
---------------------------------------------------------------------------------------
    Making menu order sortable
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 31 Oct, 2014
---------------------------------------------------------------------------------------
*/
function mondira_plugins_order_column_register_sortable($columns){
	if ( !array_key_exists('plugins_menu_order', $columns ) ) {
		$columns['plugins_menu_order'] = 'plugins_menu_order';
	}
	return $columns;
}
add_filter('manage_edit-plugins_sortable_columns','mondira_plugins_order_column_register_sortable');

/*
---------------------------------------------------------------------------------------
    Return attachment id by url
	@param image_src attachment url
	@return attachment id
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 20 Oct, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_get_the_attachments_id_by_url' ) ) {
    function mondira_get_the_attachments_id_by_url( $image_src ) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
        $id = $wpdb->get_var( $query );
        return $id;
    }
}

/*
---------------------------------------------------------------------------------------
    Registering the plugin custom post type post grid column display
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 20 Oct, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_plugins_column_display' ) ) { 
    function mondira_plugins_column_display( $plugins_columns, $post_id ) {
		global $post;
	
        switch ( $plugins_columns ) {
            case 'plugins_thumbnail':
                $width = (int) 80;
                $height = (int) 80;
                $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
                
                $plugins_gallery_image1 = '';
				$max_gallery_image = 10;
				for( $i=1; $i <= $max_gallery_image; $i++ ) {
					$tmp_image = get_post_meta( $post_id, 'plugins-image_plugin_image'.$i, TRUE );
					
					if( empty( $tmp_image ) || ( filter_var( $tmp_image, FILTER_VALIDATE_URL ) === FALSE ) ) {
						continue;
					} else {
						$plugins_gallery_image1 = mondira_get_the_attachments_id_by_url ( $tmp_image );   
						break;
					}
				}
                
                if ( empty( $thumbnail_id ) && !empty( $plugins_gallery_image1 ) ) {
                    $thumbnail_id = $plugins_gallery_image1;    
                }
                
                
                if ( $thumbnail_id ) {
                    $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
                }
                if ( isset( $thumb ) ) {
                    echo $thumb;
                } else {
                    echo 'None';
                }
                break;    

            case 'plugins_category':
                if ( $category_list = get_the_term_list( $post_id, 'plugins_category', '', ', ', '' ) ) {
                    echo $category_list;
                } else {
                    echo 'None';
                }
				break;
				
            case 'plugins_menu_order':
				echo $post->menu_order;
            break;  
        }
    }
}
add_action( 'manage_posts_custom_column', 'mondira_plugins_column_display' , 10, 2 );

/*
---------------------------------------------------------------------------------------
    Return first image of plugins
    @since: 1.0.0
---------------------------------------------------------------------------------------
*/
function mondira_get_first_image_of_plugin_by_id( $post_id ) {
	for( $i=1; $i <= 10; $i++ ) {
		$thumb = get_post_meta( $post_id, 'plugins-image_plugin_image'.$i, TRUE );
		if( empty( $thumb ) || ( filter_var( $thumb, FILTER_VALIDATE_URL ) === FALSE ) ) {
			continue;
		} else {
			break;
		}
	}
	return $thumb;
}

/*
---------------------------------------------------------------------------------------
    Shorting plugin post type admin plugin index data grid
    @since: 1.0.0
---------------------------------------------------------------------------------------
*/
function mondira_previous_plugins_where( $in_same_term, $excluded_terms ) {
	global $post, $wpdb;
	//$where = apply_filters( 'get_previous_post_where', "WHERE p.post_date < '$current_post_date' AND p.post_type = 'post' AND p.post_status = 'publish' $posts_in_ex_cats_sql", $in_same_cat, $excluded_categories );
	if ( $post->post_type == 'plugins' ) {
		//Skipping upcoming plugin
		//$_is_upcoming = get_post_meta( get_the_ID(), 'plugins_is_upcoming', TRUE ); 
		$_is_upcoming_where = " AND p.ID NOT IN ( SELECT post_id FROM $wpdb->postmeta WHERE ($wpdb->postmeta.post_id = p.ID ) AND $wpdb->postmeta.meta_key = 'plugins_is_upcoming' )";
		$sql = $wpdb->prepare( "WHERE p.menu_order < %s AND p.post_type = %s AND p.post_status = 'publish' AND p.ID != $post->ID $_is_upcoming_where", $post->menu_order, $post->post_type);
		return $sql;
	} else {
		return $in_same_term;
	}
}
function mondira_next_plugins_where( $in_same_term, $excluded_terms ) {
	global $post, $wpdb;
	//$where = apply_filters( 'get_next_post_where', "WHERE p.post_date > '$current_post_date' AND p.post_type = 'post' AND p.post_status = 'publish' $posts_in_ex_cats_sql AND p.ID != $post->ID", $in_same_cat, $excluded_categories );
	if ( $post->post_type == 'plugins' ) {
		//Skipping upcoming plugin
		//$_is_upcoming = get_post_meta( get_the_ID(), 'plugins_is_upcoming', TRUE ); 
		$_is_upcoming_where = " AND p.ID NOT IN ( SELECT post_id FROM $wpdb->postmeta WHERE ($wpdb->postmeta.post_id = p.ID ) AND $wpdb->postmeta.meta_key = 'plugins_is_upcoming' )";
		$sql = $wpdb->prepare( "WHERE p.menu_order > %s AND p.post_type = %s AND p.post_status = 'publish' AND p.ID != $post->ID $_is_upcoming_where", $post->menu_order, $post->post_type);
		return $sql;
	} else {
		return $in_same_term;
	}
}
add_filter( 'get_previous_post_where', 'mondira_previous_plugins_where', 10, 2 );
add_filter( 'get_next_post_where', 'mondira_next_plugins_where', 10, 2 );

	
/*
---------------------------------------------------------------------------------------
    Adding order by menu single plugin navigation
    @since: 1.0.0
---------------------------------------------------------------------------------------
*/ 
function mondira_previous_plugins_sort($order_by) {
	global $post;
	if ( get_post_type( $post ) == 'plugins' ) {
		return "ORDER BY p.menu_order desc LIMIT 1";
	} else {
		return $order_by;
	}
}
add_filter( 'get_previous_post_sort', 'mondira_previous_plugins_sort' );
 
function mondira_next_plugins_sort($order_by) {
	global $post;
	
	if ( get_post_type( $post ) == 'plugins' ) {	
		return "ORDER BY p.menu_order asc LIMIT 1";
	} else {
		return $order_by;
	}
}
add_filter( 'get_next_post_sort', 'mondira_next_plugins_sort' );

/*
---------------------------------------------------------------------------------------
    Adding plugin custom post type taxonomy filter as plugin category
    @Author: Jewel Ahmed
    @Author Web: http://codeatomic.com
    @Last Updated: 20 Oct, 2014
---------------------------------------------------------------------------------------
*/

if ( !function_exists( 'mondira_plugins_add_taxonomy_filters' ) ) {
    function mondira_plugins_add_taxonomy_filters() {
        global $typenow;
        $taxonomies = array( 'plugins_category' );
        if ( $typenow == 'plugins' ) {
            foreach ( $taxonomies as $tax_slug ) {
                $current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
                $tax_obj = get_taxonomy( $tax_slug );
                $tax_name = $tax_obj->labels->name;
                $terms = get_terms($tax_slug);
                if ( count( $terms ) > 0) {
                    echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
                    echo "<option value=''>$tax_name</option>";
                    foreach ( $terms as $term ) {
                        echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
                    }
                    echo "</select>";
                }
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'mondira_plugins_add_taxonomy_filters'  );
