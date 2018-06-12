<?php

/*
	Plugin Name: Where Is Gravity Forms?
	Plugin URI: https://www.402websites.com/downloads/where-is-gravity-forms/
	Description: This small plugin will search every post and page of every post type for the Gravity Forms shortcode and echo out a list containing the page/post URL, edit URL, and the Gravity Forms shortcodes present on the page.
	Version: 2.0
	Author: Andy Warren
	Author URI: https://www.402websites.com/
	Text Domain: where-is-gf
*/

// add submenu page to Gravity Forms admin menu
function add_gf_submenu_item($menus) {

	$menus[] = array('name' => 'where-is-gf', 'label' => __( 'Where is GF?' ),
		'callback' => 'list_pages_with_gravity_forms',
		'permission' => 'activate_plugins');

	return $menus;

}

add_filter('gform_addon_navigation', 'add_gf_submenu_item');

// build the output of info detailing where Gravity Forms is at throughout the site's post and page content
function list_pages_with_gravity_forms() {

	// get all Gravity Forms
	$forms = GFAPI::get_forms();

	// get all post/page IDs
	$allPostIDs = get_posts(array(
		'post_type' => 'any', 'fields' => 'ids', 'posts_per_page' => -1));

	// create variable to concatenate output content to
	$output = '';

	// admin page title
	$output =
		'<h2>' . __('Where are Gravity Forms used?', 'where-is-gf') . '</h2>' .
		'<hr/>';

	//build the Where is GF? page output
	foreach ($forms as $form) {

		$gfFormID = (string)$form['fields']['0']['formId'];

		// open the paragraph
		$output .= '<p style="font-size:16px;">';

			// form id and title
			$output .=
			// form edit url
				'<a href="' . site_url() . '/wp-admin/admin.php?page=gf_edit_forms&id=' . $gfFormID . '">Edit</a>' .
				'&nbsp;|&nbsp;' .
			// form settings url
				'<a href="' . site_url() . '/wp-admin/admin.php?page=gf_edit_forms&view=settings&subview=settings&id=' . $gfFormID . '">Settings</a>' .
				'&nbsp;|&nbsp;' .
			// form entries url
				'<a href="' . site_url() . '/wp-admin/admin.php?page=gf_entries&id=' . $gfFormID . '">Entries</a>' .
				'&nbsp;|&nbsp;' .
			// form title
				'<strong>' . $form['title'] . '</strong> ' .
			// form id
				'(Form ID: ' . $gfFormID . ')' .
			// close the paragraph
				'</p>';

		$output .= '<p><strong>Can be found on:</strong></p>';

		// check each post and page for Gravity Forms shortcodes
		foreach ($allPostIDs as $singlePostID) {

			$postContent = get_post_field('post_content', $singlePostID, 'edit');

			if (has_shortcode($postContent, 'gravityform')) {

				$gravityRegex = '#' . get_shortcode_regex(array('gravityform')) . '#';

				preg_match_all($gravityRegex, $postContent, $gravityShortcodes);

				foreach ($gravityShortcodes[0] as $match) {

					if (strpos($match, $gfFormID) !== false) {

						// open the unordered list
						$output .= '<blockquote><ul>';

							$output .= '<li>';

								$output .=
									// post/page view url
									'<a href="' . get_the_permalink($singlePostID) . '">View</a>' .
									'&nbsp;|&nbsp;' .
									// post/page edit url
									'<a href="' . site_url() . '/wp-admin/post.php?post=' . $singlePostID . '&action=edit">Edit</a>' .
									'&nbsp;|&nbsp;' .
									// Title in bold
									'<strong>' . get_the_title($singlePostID) . '</strong> ' .
									// Post type name and ID
									'(' . ucwords(get_post_type($singlePostID)) . ' ID: ' . $singlePostID . ')' .
									// end of line
									 '</li>';

						// close the unordered list
						$output .= '</ul></blockquote>';

					}

				}

			}

		}

		$output .= '<br/><hr/>';

	}

	echo $output;

}

?>
