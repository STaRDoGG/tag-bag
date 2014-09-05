<?php
class tagbag_Admin_ClickTags {
	/**
	 * Constructor
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public function __construct() {
		// Ajax action, JS Helper and admin action
		add_action('wp_ajax_'.'tagbag', array(__CLASS__, 'ajax_check'));

		// Box for post/page
		add_action('admin_menu', array(__CLASS__, 'admin_menu'), 1);

		// Javascript
		add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'), 11);
	}

	/**
	 * Init somes JS and CSS need for this feature
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function admin_enqueue_scripts() {
		global $pagenow;

		wp_register_script('tb-helper-click-tags', TAGB_URL.'/assets/js/helper-click-tags.js', array('jquery', 'tb-helper-add-tags'), TAGB_VERSION);
		wp_localize_script('tb-helper-click-tags', 'tbHelperClickTagsL10n', array( 'show_txt' => __('Open Bag', 'tagbag'), 'hide_txt' => __('Close Bag', 'tagbag') ) );

		// Register location
		$wp_post_pages = array('post.php', 'post-new.php');
		$wp_page_pages = array('page.php', 'page-new.php');

		// Helper for posts/pages
		if ( in_array($pagenow, $wp_post_pages) || ( in_array($pagenow, $wp_page_pages) && is_page_have_tags() ) ) {
			wp_enqueue_script('tb-helper-click-tags');
		}
	}

	/**
	 * Register metabox
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function admin_menu() {
		add_meta_box('tb-clicks-tags', __('Tag Bag', 'tagbag'), array(__CLASS__, 'metabox'), 'post', 'advanced', 'core');
		if ( is_page_have_tags() )
			add_meta_box('tb-clicks-tags', __('Tag Bag', 'tagbag'), array(__CLASS__, 'metabox'), 'page', 'advanced', 'core');
	}

	/**
	 * Put default HTML for people without JS
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function metabox() {
		echo tagbag_Admin::getDefaultContentBox();
	}

	/**
	 * Ajax Dispatcher
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function ajax_check() {
		if ( isset($_GET['tb_action']) && $_GET['tb_action'] == 'click_tags' )  {
			self::ajax_click_tags();
		}
	}

	/**
	 * Display a span list for click tags
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function ajax_click_tags() {
		status_header( 200 ); // Send good header HTTP
		header("Content-Type: text/html; charset=" . get_bloginfo('charset'));
//global $wp_query;
		if ((int) wp_count_terms('post_tag', 'ignore_empty=false') == 0 ) { // No tags to suggest
			echo '<p>'.__('No terms in your WordPress database.', 'tagbag').'</p>';
			exit();
		}

		// Prepare search
		$search = ( isset($_GET['q']) ) ? trim(stripslashes($_GET['q'])) : '';

		// Order tags before selection (count-asc/count-desc/name-asc/name-desc/random)
		$order_click_tags = strtolower(tagbag_Plugin::get_option_value('order_click_tags'));
		$order_by = $order = '';
		switch ( $order_click_tags ) {
			case 'count-asc':
				$order_by = 'tt.count';
				$order = 'ASC';
				break;
			case 'random':
				$order_by = 'RAND()';
				$order = '';
				break;
			case 'count-desc':
				$order_by = 'tt.count';
				$order = 'DESC';
				break;
			case 'name-desc':
				$order_by = 't.name';
				$order = 'DESC';
				break;
			default : // name-asc
				$order_by = 't.name';
				$order = 'ASC';
			  break;
		}

		// Get all terms, or filter with search
		$terms = tagbag_Admin::getTermsForAjax( 'post_tag', $search, $order_by, $order );

		if ( empty($terms) || $terms == FALSE ) {
			echo '<p>'.__('No results from your WordPress database.', 'tagbag').'</p>';
			exit();
		}
/*var_dump($wp_query);
echo $wp_query->post->ID;*/

		foreach ( (array) $terms as $term ) {
/*				echo 'Page ID (Get Post): ' . $_GET['post'] . ' The ID: ' . the_ID() . ' Get The ID: ' . get_the_ID();*/

			$strDescription = "";
			$strActive = "local";

			// Return either the singular or plural version of the word
			$strPlural = ($term->count <> 1) ? "posts" : "post";

			if (has_tag($term->name, $_GET['post']) == TRUE) {
				/* In theory, if this tag is already set for this post, then use a different class (so we can highlight it with CSS)
				   HOWEVER, echo, the_ID, and get_the_ID all return jack shit (blank) and I have no idea why. even console.log spits out an error instead of showing in Firebug
				*/
			  $strActive = "local-active";
			}

      /* If there's a description with the tag, add it to the tool-tip as well.
       * Note: The multi-lines, empty spaces & starting the lines at the first column are required for proper tool-tip formatting, so don't change them.
       */
      // Clean it up first
      $strEscaped = esc_attr($term->description);
      if (!empty($strEscaped)) {
      	$strDescription = "

$strEscaped

";
      }

			/* TODO: Replace this basic tooltip with a nice jQuery one, with HTML in it using: http://iamceege.github.io/tooltipster
			 I'd like to add links in it to link to the page were all those tags are on, as well as it's Edit page, and whatever else would be useful, as well as some nice styling. */

			// Create and show the actual tag now
      echo '<span class="'.$strActive.'" title="'.' '.$term->count.' '.$strPlural.' '.$strDescription.'">'.esc_html(stripslashes($term->name)).'</span>'."\n";
		}
		echo '<div class="clear"></div>';
		exit();
	}
}