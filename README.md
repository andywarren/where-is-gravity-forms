# README #

This small plugin will search all every post/page of every post types for the Gravity Forms shortcode and echo out a list containing the page/post URL, edit URL, and the Gravity Forms shortcodes present on the page. This currently **does not** search widgets or theme template files.

### Installation ###

* Download the plugin and unzip it.
* Upload the folder `where-is-gf` to your /wp-content/plugins/ directory.
* Activate the plugin from your WordPress admin panel.
* Installation finished.
>Alternatively, you can upload the `where-is-gf.zip` file using the WordPress plugin installer.


### Usage ###

* After installation and activation is complete, go to `Forms` > `Where is GF?` to see a list of all the pages or posts that contain a Gravity Forms shortcode in their content. This will display the Frontend URL, Backend URL, Page title, Page ID, and the actual Gravity Forms shortcodes on the particular page.

### Version ###

* 2.0 - Rewrite of display output. Group results by Gravity Form ID in numerical order. Show specific pages that each form is on.
* 1.0 - Initial release.