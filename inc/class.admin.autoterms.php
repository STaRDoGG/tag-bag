<?php
class tagbag_Admin_AutoTags {

	// Build admin URL
	static $tools_base_url = '';

	public function __construct() {
		self::$tools_base_url = admin_url('tools.php')  . '?page=';

		// Admin menu
		add_action('admin_menu', array(__CLASS__, 'admin_menu'));

		// Register taxo, parent method...
		tagbag_Admin::registerDetermineTaxonomy();
	}

	/**
	 * Add WP admin menu for Tags
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function admin_menu() {
		add_management_page( __('Tag Bag Terms: Auto Terms', 'tagbag'), __('Auto Terms', 'tagbag'), 'tag_bag', 'tb_auto', array(__CLASS__, 'pageAutoTerms'));
	}

	/**
	 * WP Page - Auto Tags
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function pageAutoTerms() {
		global $wpdb;

		// Get options
		$options = get_option( TAGB_OPTIONS_NAME_AUTO );
		if ($options == false) // First save ?
			$options = array();

		if (!isset($options[tagbag_Admin::$post_type])) { // First save for this CPT ?
			$options[tagbag_Admin::$post_type] = array();
		}

		if (!isset($options[tagbag_Admin::$post_type][tagbag_Admin::$taxonomy])) { // First save for this taxo ?
			$options[tagbag_Admin::$post_type][tagbag_Admin::$taxonomy] = array();
		}

		$taxo_options = $options[tagbag_Admin::$post_type][tagbag_Admin::$taxonomy]; // Edit local option taxo

		$action = false;
		if (isset($_POST['update_auto_list'])) {
			check_admin_referer('update_auto_list-tagbag');

			// Tags list
			$terms_list	= stripslashes($_POST['auto_list']);
			$terms			= explode(',', $terms_list);

			// Remove empty and duplicate elements
			$terms = array_filter($terms, '_delete_empty_element');
			$terms = array_unique($terms);

			$taxo_options['auto_list'] = maybe_serialize($terms);

			// Active auto terms?
			$taxo_options['use_auto_terms'] = (isset($_POST['use_auto_terms']) && $_POST['use_auto_terms'] == '1') ? '1' : '0';

			// All terms?
			$taxo_options['at_all'] = (isset($_POST['at_all']) && $_POST['at_all'] == '1') ? '1' : '0';

			// Empty only?
			$taxo_options['at_empty'] = (isset($_POST['at_empty']) && $_POST['at_empty'] == '1') ? '1' : '0';

			// Full word?
			$taxo_options['only_full_word'] = (isset($_POST['only_full_word']) && $_POST['only_full_word'] == '1') ? '1' : '0';

			// Support hashtag format?
			$taxo_options['allow_hashtag_format'] = (isset($_POST['allow_hashtag_format']) && $_POST['allow_hashtag_format'] == '1') ? '1' : '0';

			$options[tagbag_Admin::$post_type][tagbag_Admin::$taxonomy] = $taxo_options;
			update_option( TAGB_OPTIONS_NAME_AUTO, $options );

			add_settings_error( __CLASS__, __CLASS__, __('Auto terms options updated !', 'tagbag'), 'updated' );
		} elseif (isset($_GET['action']) && $_GET['action'] == 'auto_tag') {
			$action = true;
			$n = (isset($_GET['n'])) ? intval($_GET['n']) : 0;
		}

		$terms_list = '';
		if (isset($taxo_options['auto_list']) && !empty($taxo_options['auto_list'])) {
			$terms = maybe_unserialize($taxo_options['auto_list']);
			if (is_array($terms)) {
				$terms_list = implode(', ', $terms);
			}
		}

		settings_errors( __CLASS__ );
		?>
		<div class="wrap tb_wrap">
			<h2><?php _e('Overview', 'tagbag'); ?>
			<p><?php _e('The bulb is lit when the association taxonomy and custom post type have the classification automatic activated. Otherwise, the bulb is dimmed.', 'tagbag'); ?>
			<table class="widefat tag fixed" cellspacing="0">
				<thead>
					<tr>
						<th scope="col" id="label" class="manage-column column-name"><?php _e('Custom types / Taxonomies', 'tagbag'); ?></th>
						<?php
						foreach ( get_taxonomies( array( 'show_ui' => true ), 'object' ) as $taxo ) {
							if ( empty($taxo->labels->name) )
								continue;
							echo '<th scope="col">'.esc_html($taxo->labels->name).'</th>';
						}
						?>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column column-name"><?php _e('Custom types / Taxonomies', 'tagbag'); ?></th>
						<?php
						foreach ( get_taxonomies( array( 'show_ui' => true ), 'object' ) as $taxo ) {
							if ( empty($taxo->labels->name) )
								continue;
							echo '<th scope="col">'.esc_html($taxo->labels->name).'</th>';
						}
						?>
					</tr>
				</tfoot>

				<tbody id="the-list" class="list:taxonomies">
					<?php
					$class	= 'alternate';
					$i			= 0;

					foreach ( get_post_types( array(), 'objects' ) as $post_type ) :
						if ( !$post_type->show_ui || empty($post_type->labels->name) ) {
							continue;
						}

						// Get compatible taxo for current post type
						$compatible_taxonomies = get_object_taxonomies( $post_type->name );
						if ( empty($compatible_taxonomies) ) {
							continue;
						}

						$i++;
						$class = ( $class == 'alternate' ) ? '' : 'alternate';
						?>
						<tr id="custom type-<?php echo $i; ?>" class="<?php echo $class; ?>">
							<th class="name column-name"><?php echo esc_html($post_type->labels->name); ?></th>
							<?php
							foreach ( get_taxonomies( array( 'show_ui' => true ), 'object' ) as $line_taxo ) {
								if ( empty($line_taxo->labels->name) )
									continue;

								echo '<td>' . "\n";
									if ( in_array($line_taxo->name, $compatible_taxonomies) ) {
										if ( isset($options[$post_type->name][$line_taxo->name]) && isset($options[$post_type->name][$line_taxo->name]['use_auto_terms']) && $options[$post_type->name][$line_taxo->name]['use_auto_terms'] == '1' ) {
											echo '<a href="'.self::$tools_base_url.'tb_auto&taxo='.$line_taxo->name.'&cpt='.$post_type->name.'"><img src="'.TAGB_URL.'/assets/images/lightbulb.png" alt="'.__('Context configured & actived.', 'tagbag').'" /></a>' . "\n";
										} else {
											echo '<a href="'.self::$tools_base_url.'tb_auto&taxo='.$line_taxo->name.'&cpt='.$post_type->name.'"><img src="'.TAGB_URL.'/assets/images/lightbulb_off.png" alt="'.__('Context unconfigured.', 'tagbag').'" /></a>' . "\n";
										}
									} else {
										echo '-' . "\n";
									}
								echo '</td>' . "\n";
							}
							?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="clear"></div>
		</div>

		<div class="wrap tb_wrap">
			<h2><?php printf(__('Auto Terms for %s and %s', 'tagbag'), '<strong>'.tagbag_Admin::$post_type_name.'</strong>',  '<strong>'.tagbag_Admin::$taxo_name.'</strong>' ); ?></h2>

			<?php if ( $action === false ) : ?>

				<h3><?php _e('Auto terms list', 'tagbag'); ?></h3>
				<p><?php _e('This feature allows Wordpress to examine the post content and title for specified terms when saving posts, if your post content or title contains the word "WordPress" and you have "wordpress" in auto terms list, Tag Bag will automatically add "wordpress" as a term for this post.', 'tagbag'); ?></p>

				<h3><?php _e('Options', 'tagbag'); ?></h3>
				<form action="<?php echo self::$tools_base_url.'tb_auto&taxo='.tagbag_Admin::$taxonomy.'&cpt='.tagbag_Admin::$post_type; ?>" method="post">
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Activation', 'tagbag'); ?></th>
							<td>
								<input type="checkbox" id="use_auto_terms" name="use_auto_terms" value="1" <?php echo ( isset($taxo_options['use_auto_terms']) && $taxo_options['use_auto_terms'] == 1 ) ? 'checked="checked"' : ''; ?>  />
								<label for="use_auto_terms"><?php _e('Active Auto Tags.', 'tagbag'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Terms database', 'tagbag'); ?></th>
							<td>
								<input type="checkbox" id="at_all" name="at_all" value="1" <?php echo ( isset($taxo_options['at_all']) && $taxo_options['at_all'] == 1 ) ? 'checked="checked"' : ''; ?>  />
								<label for="at_all"><?php _e('Also use local terms database with auto terms. (Warning, this option can increases the CPU consumption a lot if you have many terms)', 'tagbag'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Target', 'tagbag'); ?></th>
							<td>
								<input type="checkbox" id="at_empty" name="at_empty" value="1" <?php echo ( isset($taxo_options['at_empty']) && $taxo_options['at_empty'] == 1 ) ? 'checked="checked"' : ''; ?>  />
								<label for="at_empty"><?php _e('Auto-tag only posts without terms.', 'tagbag'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Whole Word?', 'tagbag'); ?></th>
							<td>
								<input type="checkbox" id="only_full_word" name="only_full_word" value="1" <?php echo ( isset($taxo_options['only_full_word']) && $taxo_options['only_full_word'] == 1 ) ? 'checked="checked"' : ''; ?>  />
								<label for="only_full_word"><?php _e('Auto-tag only a post when terms found in the content are the same name. (whole word only)', 'tagbag'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Hashtag Support?', 'tagbag'); ?></th>
							<td>
								<input type="checkbox" id="allow_hashtag_format" name="allow_hashtag_format" value="1" <?php echo ( isset($taxo_options['allow_hashtag_format']) && $taxo_options['allow_hashtag_format'] == 1 ) ? 'checked="checked"' : ''; ?> />
								<label for="allow_hashtag_format"><?php _e('When the whole word option is enabled, hashtags will not be auto-tagged because of the # prefix. This option fixes this issue.', 'tagbag'); ?></label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="auto_list"><?php _e('Keyword List', 'tagbag'); ?></label></th>
							<td>
								<input type="text" id="auto_list" class="auto_list" name="auto_list" value="<?php echo esc_attr($terms_list); ?>" style="width:98%;" />
								<br /><?php _e('Separated with a comma', 'tagbag'); ?>
							</td>
						</tr>
					</table>

					<p class="submit">
						<?php wp_nonce_field( 'update_auto_list-tagbag' ); ?>
						<input class="button-primary" type="submit" name="update_auto_list" value="<?php _e('Update options &raquo;', 'tagbag'); ?>" />
					</p>
				</form>

				<h3><?php _e('Auto terms old content', 'tagbag'); ?></h3>
				<p>
					<?php _e('Tag Bag can also tag all existing contents of your blog. This feature use auto terms list above-mentioned.', 'tagbag'); ?>
				</p>
				<p class="submit">
					<a class="button-primary" href="<?php echo self::$tools_base_url.'tb_auto&amp;taxo='.tagbag_Admin::$taxonomy.'&amp;cpt='.tagbag_Admin::$post_type.'&amp;action=auto_tag'; ?>"><?php _e('Auto terms all content &raquo;', 'tagbag'); ?></a>
				</p>

			<?php else:
				// Counter
				if ( $n == 0 ) {
					update_option('tmp_auto_terms_st', 0);
				}

				// Get objects
				$objects = (array) $wpdb->get_results( $wpdb->prepare("SELECT ID, post_title, post_content FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish' ORDER BY ID DESC LIMIT %d, 20", tagbag_Admin::$post_type, $n) );

				if( !empty($objects) ) {
					echo '<ul>';
					foreach( $objects as $object ) {
						tagbag_Client_Autoterms::auto_terms_post( $object, tagbag_Admin::$taxonomy, $taxo_options, true );

						echo '<li>#'. $object->ID .' '. $object->post_title .'</li>';
						unset($object);
					}
					echo '</ul>';
					?>
					<p><?php _e("If your browser doesn't start loading the next page automatically click this link:", 'tagbag'); ?> <a href="<?php echo self::$tools_base_url.'tb_auto&amp;taxo='.tagbag_Admin::$taxonomy.'&amp;cpt='.tagbag_Admin::$post_type.'&amp;action=auto_tag&amp;n='.($n + 20); ?>"><?php _e('Next content', 'tagbag'); ?></a></p>
					<script type="text/javascript">
						// <![CDATA[
						function nextPage() {
							location.href = "<?php echo self::$tools_base_url.'tb_auto&taxo='.tagbag_Admin::$taxonomy.'&cpt='.tagbag_Admin::$post_type.'&action=auto_tag&n='.($n + 20); ?>";
						}
						window.setTimeout( 'nextPage()', 300 );
						// ]]>
					</script>
					<?php
				} else {
					$counter = get_option('tmp_auto_terms_st');
					delete_option('tmp_auto_terms_st');
					echo '<p><strong>'.sprintf(__('All done! %s terms added.', 'tagbag'), $counter).'</strong></p>';
				}

			endif;
			?>
			<p><?php _e('Visit the <a href="https://github.com/STaRDoGG/tag-bag">plugin\'s homepage</a> for further details. If you find a bug, or have a fantastic idea for this plugin, <a href="https://github.com/STaRDoGG/tag-bag/issues">mention it</a>.', 'tagbag'); ?></p>
			<?php tagbag_Admin::printAdminFooter(); ?>
		</div>
		<?php
		do_action( 'tagbag-auto_terms', tagbag_Admin::$taxonomy );
	}

}