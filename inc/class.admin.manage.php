<?php
class tagbag_Admin_Manage {
	/**
	 * Constructor
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public function __construct() {
		// Admin menu
		add_action('admin_menu', array(__CLASS__, 'admin_menu'));

		// Register taxo, parent method...
		tagbag_Admin::registerDetermineTaxonomy();

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
		wp_register_script('tb-helper-manage', TAGB_URL.'/assets/js/helper-manage.js', array('jquery'), TAGB_VERSION);

		// add JS for manage click tags
		if ( isset($_GET['page']) && $_GET['page'] == 'tb_manage' ) {
			wp_enqueue_script('tb-helper-manage');
		}
	}

	/**
	 * Add WP admin menu for Tags
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function admin_menu() {
		add_management_page( __('Tag Bag Terms: Manage Terms', 'tagbag'), __('Manage Terms', 'tagbag'), 'tag_bag', 'tb_manage', array(__CLASS__, 'page_manage_tags'));
	}

	/**
	 * Method for build the page HTML manage tags
	 *
	 * @return void
	 * @author Amaury Balmer
	 */
	public static function page_manage_tags() {
		// Control Post data
		if ( isset($_POST['term_action']) ) {
			if ( !wp_verify_nonce($_POST['term_nonce'], 'tagbag_admin') ) { // Origination and intention

				add_settings_error( __CLASS__, __CLASS__, __('Security problem. Try again. If this problem persist, contact <a href="mailto:amaury@wordpress-fr.net">plugin author</a>.', 'tagbag'), 'error' );

			} elseif ( !isset(tagbag_Admin::$taxonomy) || !taxonomy_exists(tagbag_Admin::$taxonomy) ) { // Valid taxo ?

				add_settings_error( __CLASS__, __CLASS__, __('Missing valid taxonomy for work... Try again. If this problem persist, contact <a href="mailto:amaury@wordpress-fr.net">plugin author</a>.', 'tagbag'), 'error' );

			} elseif ( $_POST['term_action'] == 'renameterm' ) {

				$oldtag = (isset($_POST['renameterm_old'])) ? $_POST['renameterm_old'] : '';
				$newtag = (isset($_POST['renameterm_new'])) ? $_POST['renameterm_new'] : '';
				self::renameTerms( tagbag_Admin::$taxonomy, $oldtag, $newtag );

			} elseif ( $_POST['term_action'] == 'deleteterm' ) {

				$todelete = (isset($_POST['deleteterm_name'])) ? $_POST['deleteterm_name'] : '';
				self::deleteTermsByTermList( tagbag_Admin::$taxonomy, $todelete );

			} elseif ( $_POST['term_action'] == 'addterm'  ) {

				$matchtag = (isset($_POST['addterm_match'])) ? $_POST['addterm_match'] : '';
				$newtag   = (isset($_POST['addterm_new'])) ? $_POST['addterm_new'] : '';
				self::addMatchTerms( tagbag_Admin::$taxonomy, $matchtag, $newtag );

			} elseif ( $_POST['term_action'] == 'remove-rarelyterms'  ) {

				self::removeRarelyUsed( tagbag_Admin::$taxonomy, (int) $_POST['number-rarely'] );

			} /* elseif ( $_POST['term_action'] == 'editslug'  ) {

				$matchtag = (isset($_POST['tagname_match'])) ? $_POST['tagname_match'] : '';
				$newslug  = (isset($_POST['tagslug_new'])) ? $_POST['tagslug_new'] : '';
				self::editTermSlug( tagbag_Admin::$taxonomy, $matchtag, $newslug );

			}*/
		}

		// Default order
		if ( !isset($_GET['order']) ) {
			$_GET['order'] = 'name-asc';
		}

		settings_errors( __CLASS__ );
		?>
		<div class="wrap tb_wrap">
			<?php tagbag_Admin::boxSelectorTaxonomy( 'tb_manage' ); ?>

			<h2><?php _e('Tag Bag: Manage Terms', 'tagbag'); ?></h2>
			<p><?php _e('Visit the <a href="https://github.com/STaRDoGG/tag-bag">plugin\'s homepage</a> for further details. If you find a bug, or have a fantastic idea for this plugin, <a href="https://github.com/STaRDoGG/tag-bag/issues">mention it</a>.', 'tagbag'); ?></p>

			<div class="clear"></div>
			<div id="term-list">
				<h3><?php _e('Click terms list:', 'tagbag'); ?></h3>
				<form action="" method="get">
					<div>
						<input type="hidden" name="page" value="tb_manage" />
						<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
						<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

						<select name="order">
							<option <?php selected( $_GET['order'], 'count-asc' ); ?> value="count-asc"><?php _e('Least used', 'tagbag'); ?></option>
							<option <?php selected( $_GET['order'], 'count-desc' ); ?> value="count-desc"><?php _e('Most popular', 'tagbag'); ?></option>
							<option <?php selected( $_GET['order'], 'name-asc' ); ?> value="name-asc"><?php _e('Alphabetical (default)', 'tagbag'); ?></option>
							<option <?php selected( $_GET['order'], 'name-desc' ); ?> value="name-desc"><?php _e('Inverse Alphabetical', 'tagbag'); ?></option>
							<option <?php selected( $_GET['order'], 'random' ); ?> value="random"><?php _e('Random', 'tagbag'); ?></option>
						</select>
						<input class="button" type="submit" value="<?php _e('Sort', 'tagbag'); ?>" />
					</div>
				</form>

				<div id="term-list-inner">
					<?php
					if ( isset($_GET['order']) ) {
						$order = explode('-', stripslashes($_GET['order']));
						if ( !isset($order[1]) ) $order[1] = ''; // for skip notice on random...

						$order = '&selectionby='.$order[0].'&selection='.$order[1].'&orderby='.$order[0].'&order='.$order[1];
					} else {
						$order = '&selectionby=name&selection=asc&orderby=name&order=asc';
					}
					tb_tag_cloud('hide_empty=false&number=&color=false&get=all&title='.$order.'&taxonomy='.tagbag_Admin::$taxonomy);
					?>
				</div>
			</div>

			<table id="manage-table-terms" class="form-table">
				<tr valign="top">
					<th scope="row"><strong><?php _e('Rename/Merge Terms', 'tagbag'); ?></strong></th>
					<td>
						<p><?php _e('Enter the term to rename and its new value. You can use this feature to merge terms too. Click "Rename" and all posts which use this term will be updated.', 'tagbag'); ?></p>
						<p><?php _e('You can specify multiple terms to rename by separating them with commas.', 'tagbag'); ?></p>

						<fieldset>
							<form action="" method="post">
								<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
								<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

								<input type="hidden" name="term_action" value="renameterm" />
								<input type="hidden" name="term_nonce" value="<?php echo wp_create_nonce('tagbag_admin'); ?>" />

								<p>
									<label for="renameterm_old"><?php _e('Term(s) to rename:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="renameterm_old" name="renameterm_old" value="" size="40" />
								</p>

								<p>
									<label for="renameterm_new"><?php _e('New term name(s):', 'tagbag'); ?>
									<br />
									<input type="text" class="autocomplete-input" id="renameterm_new" name="renameterm_new" value="" size="40" />
								</p>

								<input class="button-primary" type="submit" name="rename" value="<?php _e('Rename', 'tagbag'); ?>" />
							</form>
						</fieldset>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><strong><?php _e('Delete Terms', 'tagbag'); ?></strong></th>
					<td>
						<p><?php _e('Enter the name of terms to delete. Terms will be removed from all posts.', 'tagbag'); ?></p>
						<p><?php _e('You can specify multiple terms to delete by separating them with commas', 'tagbag'); ?>.</p>

						<fieldset>
							<form action="" method="post">
								<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
								<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

								<input type="hidden" name="term_action" value="deleteterm" />
								<input type="hidden" name="term_nonce" value="<?php echo wp_create_nonce('tagbag_admin'); ?>" />

								<p>
									<label for="deleteterm_name"><?php _e('Term(s) to delete:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="deleteterm_name" name="deleteterm_name" value="" size="40" />
								</p>

								<input class="button-primary" type="submit" name="delete" value="<?php _e('Delete', 'tagbag'); ?>" />
							</form>
						</fieldset>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><strong><?php _e('Add Terms', 'tagbag'); ?></strong></th>
					<td>
						<p><?php _e('This feature lets you add one or more new terms to all posts which match any of the terms given.', 'tagbag'); ?></p>
						<p><?php _e('You can specify multiple terms to add by separating them with commas.  If you want the term(s) to be added to all posts, then don\'t specify any terms to match.', 'tagbag'); ?></p>

						<fieldset>
							<form action="" method="post">
								<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
								<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

								<input type="hidden" name="term_action" value="addterm" />
								<input type="hidden" name="term_nonce" value="<?php echo wp_create_nonce('tagbag_admin'); ?>" />

								<p>
									<label for="addterm_match"><?php _e('Term(s) to match:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="addterm_match" name="addterm_match" value="" size="40" />
								</p>

								<p>
									<label for="addterm_new"><?php _e('Term(s) to add:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="addterm_new" name="addterm_new" value="" size="40" />
								</p>

								<input class="button-primary" type="submit" name="Add" value="<?php _e('Add', 'tagbag'); ?>" />
							</form>
						</fieldset>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><strong><?php _e('Remove rarely used terms', 'tagbag'); ?></strong></th>
					<td>
						<p><?php _e('This feature allows you to remove rarely used terms.', 'tagbag'); ?></p>
						<p><?php _e('You can specify the number below which will be removed terms. If you put 5, all terms with a counter inferior to 5 will be deleted. The terms with a counter equal to 5 is keep.', 'tagbag'); ?></p>

						<fieldset>
							<form action="" method="post">
								<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
								<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

								<input type="hidden" name="term_action" value="remove-rarelyterms" />
								<input type="hidden" name="term_nonce" value="<?php echo wp_create_nonce('tagbag_admin'); ?>" />

								<p>
									<label for="number-delete"><?php _e('Numbers minimum:', 'tagbag'); ?></label>
									<br />
									<select name="number-rarely" id="number-delete">
									<?php for( $i = 1; $i <= 100; $i++ ) : ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php endfor; ?>
									</select>
								</p>

								<input class="button-primary" type="submit" name="Delete" value="<?php _e('Delete rarely used', 'tagbag'); ?>" />
							</form>
						</fieldset>
					</td>
				</tr>

				<?php /*
				<tr valign="top">
					<th scope="row"><strong><?php _e('Edit Term Slug', 'tagbag'); ?></strong></th>
					<td>
						<p><?php _e('Enter the term name to edit and its new slug. <a href="http://codex.wordpress.org/Glossary#Slug">Slug definition</a>', 'tagbag'); ?></p>
						<p><?php _e('You can specify multiple terms to rename by separating them with commas.', 'tagbag'); ?></p>

						<fieldset>
							<form action="" method="post">
								<input type="hidden" name="taxo" value="<?php echo esc_attr(tagbag_Admin::$taxonomy); ?>" />
								<input type="hidden" name="cpt" value="<?php echo esc_attr(tagbag_Admin::$post_type); ?>" />

								<input type="hidden" name="term_action" value="editslug" />
								<input type="hidden" name="term_nonce" value="<?php echo wp_create_nonce('tagbag_admin'); ?>" />

								<p>
									<label for="tagname_match"><?php _e('Term(s) to match:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="tagname_match" name="tagname_match" value="" size="40" />
								</p>

								<p>
									<label for="tagslug_new"><?php _e('Slug(s) to set:', 'tagbag'); ?></label>
									<br />
									<input type="text" class="autocomplete-input" id="tagslug_new" name="tagslug_new" value="" size="40" />
								</p>

								<input class="button-primary" type="submit" name="edit" value="<?php _e('Edit', 'tagbag'); ?>" />
							</form>
						</fieldset>
					</td>
				</tr>
				*/?>

				<tr>
					<th scope="row"><strong><?php _e('Technical informations', 'tagbag'); ?></strong></th>
					<td>
						<p><strong><?php _e('Renaming', 'tagbag'); ?></strong></p>
						<p><em><?php _e('Tag Bag doesn\'t use the same method as WordPress to rename a term. For example, in WordPress you have 2 terms: "Blogging" and "Bloging". When you want to edit the term "Bloging" to rename it as "Blogging", WordPress will keep the two terms with the same name, but with a different slug.<br />With Tag Bag, when you edit "Bloging" to "Blogging", Tag Bag merges posts filled with "Bloging" to "Blogging" and it deletes the term "Bloging". Another logic ;)', 'tagbag'); ?><em></p>
					</td>
				</tr>
			</table>

			<div class="clear"></div>
			<?php tagbag_Admin::printAdminFooter(); ?>
		</div>
		<?php
		do_action( 'tagbag-manage_terms', tagbag_Admin::$taxonomy );
	}

	/**
	 * Method for rename or merge tags
	 *
	 * @param string $taxonomy
	 * @param string $old
	 * @param string $new
	 * @return boolean
	 * @author Amaury Balmer
	 */
	public static function renameTerms( $taxonomy = 'post_tag', $old = '', $new = '' ) {
		if ( trim( str_replace(',', '', stripslashes($new)) ) == '' ) {
			add_settings_error( __CLASS__, __CLASS__, __('No new term specified!', 'tagbag'), 'error' );
			return false;
		}

		// String to array
		$old_terms = explode(',', $old);
		$new_terms = explode(',', $new);

		// Remove empty element and trim
		$old_terms = array_filter($old_terms, '_delete_empty_element');
		$new_terms = array_filter($new_terms, '_delete_empty_element');

		// If old/new tag are empty => exit !
		if ( empty($old_terms) || empty($new_terms) ) {
			add_settings_error( __CLASS__, __CLASS__, __('No new/old valid term specified!', 'tagbag'), 'error' );
			return false;
		}

		$counter = 0;
		if( count($old_terms) == count($new_terms) ) { // Rename only
			foreach ( (array) $old_terms as $i => $old_tag ) {
				$new_name = $new_terms[$i];

				// Get term by name
				$term = get_term_by('name', $old_tag, $taxonomy);
				if ( !$term ) {
					continue;
				}

				// Get objects from term ID
				$objects_id = get_objects_in_term( $term->term_id, $taxonomy, array('fields' => 'all_with_object_id'));

				// Create the new term
				if ( !$term_info = term_exists($new_name, $taxonomy) ) {
					$term_info = wp_insert_term($new_name, $taxonomy);
				}

				// If default category, update the ID for new term...
				if ( 'category' == $taxonomy && $term->term_id == get_option( 'default_category' ) ) {
					update_option( 'default_category', $term_info['term_id'] );
					clean_term_cache($term_info['term_id'], $taxonomy);
				}

				// Delete old term
				wp_delete_term( $term->term_id, $taxonomy );

				// Set objects to new term ! (Append no replace)
				foreach ( (array) $objects_id as $object_id ) {
					wp_set_object_terms( $object_id, $new_name, $taxonomy, true );
				}

				// Clean cache
				clean_object_term_cache( $objects_id, $taxonomy);
				clean_term_cache($term->term_id, $taxonomy);

				// Increment
				$counter++;
			}

			if ( $counter == 0  ) {
				add_settings_error( __CLASS__, __CLASS__, __('No term renamed.', 'tagbag'), 'updated' );
			} else {
				add_settings_error( __CLASS__, __CLASS__, sprintf(__('Renamed term(s) &laquo;%1$s&raquo; to &laquo;%2$s&raquo;', 'tagbag'), $old, $new), 'updated' );
			}
		}
		elseif ( count($new_terms) == 1  ) { // Merge
			// Set new tag
			$new_tag = $new_terms[0];
			if ( empty($new_tag) ) {
				add_settings_error( __CLASS__, __CLASS__, __('No valid new term.', 'tagbag'), 'error' );
				return false;
			}

			// Get terms ID from old terms names
			$terms_id = array();
			foreach ( (array) $old_terms as $old_tag ) {
				$term = get_term_by('name', addslashes($old_tag), $taxonomy);
				$terms_id[] = (int) $term->term_id;
			}

			// Get objects from terms ID
			$objects_id = get_objects_in_term( $terms_id, $taxonomy, array('fields' => 'all_with_object_id'));

			// No objects ? exit !
			if ( !$objects_id ) {
				add_settings_error( __CLASS__, __CLASS__, __('No objects found for specified old terms.', 'tagbag'), 'error' );
				return false;
			}

			// Delete old terms
			foreach ( (array) $terms_id as $term_id ) {
				wp_delete_term( $term_id, $taxonomy );
			}

			// Set objects to new term ! (Append no replace)
			foreach ( (array) $objects_id as $object_id ) {
				wp_set_object_terms( $object_id, $new_tag, $taxonomy, true );
				$counter++;
			}

			// Test if term is also a category
			/*
			if ( is_term($new_tag, 'category') ) {
				// Edit the slug to use the new term
				self::editTermSlug( $new_tag, sanitize_title($new_tag) );
			}
			*/

			// Clean cache
			clean_object_term_cache( $objects_id, $taxonomy);
			clean_term_cache($terms_id, $taxonomy);

			if ( $counter == 0  ) {
				add_settings_error( __CLASS__, __CLASS__, __('No term merged.', 'tagbag'), 'updated' );
			} else {
				add_settings_error( __CLASS__, __CLASS__, sprintf(__('Merge term(s) &laquo;%1$s&raquo; to &laquo;%2$s&raquo;. %3$s objects edited.', 'tagbag'), $old, $new, $counter), 'updated' );
			}
		} else { // Error
			add_settings_error( __CLASS__, __CLASS__, sprintf(__('Error. No enough terms for rename. Too for merge. Choose !', 'tagbag'), $old), 'error' );
		}
		return true;
	}

	/**
	 * Method for delete a list of terms
	 *
	 * @param string $taxonomy
	 * @param string $delete
	 * @return boolean
	 * @author Amaury Balmer
	 */
	public static function deleteTermsByTermList( $taxonomy = 'post_tag', $delete ) {
		if ( trim( str_replace(',', '', stripslashes($delete)) ) == '' ) {
			add_settings_error( __CLASS__, __CLASS__, __('No term specified!', 'tagbag'), 'error' );
			return false;
		}

		// In array + filter
		$delete_terms = explode(',', $delete);
		$delete_terms = array_filter($delete_terms, '_delete_empty_element');

		// Delete tags
		$counter = 0;
		foreach ( (array) $delete_terms as $term ) {
			$term = get_term_by('name', $term, $taxonomy);
			$term_id = (int) $term->term_id;

			if ( $term_id != 0 ) {
				wp_delete_term( $term_id, $taxonomy );
				clean_term_cache( $term_id, $taxonomy );
				$counter++;
			}
		}

		if ( $counter == 0  ) {
			add_settings_error( __CLASS__, __CLASS__, __('No term deleted.', 'tagbag'), 'updated' );
		} else {
			add_settings_error( __CLASS__, __CLASS__, sprintf(__('%1s term(s) deleted.', 'tagbag'), $counter), 'updated' );
		}

		return true;
	}

	/**
	 * Method for add terms for all or specified posts
	 *
	 * @param string $taxonomy
	 * @param string $match
	 * @param string $new
	 * @return boolean
	 * @author Amaury Balmer
	 */
	public static function addMatchTerms( $taxonomy = 'post_tag', $match = '', $new = '' ) {
		if ( trim( str_replace(',', '', stripslashes($new)) ) == '' ) {
			add_settings_error( __CLASS__, __CLASS__, __('No new term(s) specified!', 'tagbag'), 'error' );
			return false;
		}

		$match_terms = explode(',', $match);
		$new_terms = explode(',', $new);

		$match_terms = array_filter($match_terms, '_delete_empty_element');
		$new_terms = array_filter($new_terms, '_delete_empty_element');

		$counter = 0;
		if ( !empty($match_terms) ) { // Match and add
			// Get terms ID from old match names
			$terms_id = array();
			foreach ( (array) $match_terms as $match_term ) {
				$term = get_term_by('name', $match_term, $taxonomy);
				$terms_id[] = (int) $term->term_id;
			}

			// Get object ID with terms ID
			$objects_id = get_objects_in_term( $terms_id, $taxonomy, array('fields' => 'all_with_object_id') );

			// Add new tags for specified post
			foreach ( (array) $objects_id as $object_id ) {
				wp_set_object_terms( $object_id, $new_terms, $taxonomy, true ); // Append terms
				$counter++;
			}

			// Clean cache
			clean_object_term_cache( $objects_id, $taxonomy );
			clean_term_cache($terms_id, $taxonomy );
		} else { // Add for all posts
			// Page or not ?
			$post_type_sql = ( is_page_have_tags() ) ? "post_type IN('page', 'post')" : "post_type = 'post'"; // TODO, CPT

			// Get all posts ID
			global $wpdb;
			$objects_id = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE {$post_type_sql}");

			// Add new tags for all posts
			foreach ( (array) $objects_id as $object_id ) {
				wp_set_object_terms( $object_id, $new_terms, $taxonomy, true ); // Append terms
				$counter++;
			}

			// Clean cache
			clean_object_term_cache( $objects_id, $taxonomy );
		}

		if ( $counter == 0  ) {
			add_settings_error( __CLASS__, __CLASS__, __('No term added.', 'tagbag'), 'updated' );
		} else {
			add_settings_error( __CLASS__, __CLASS__, sprintf(__('Term(s) added to %1s post(s).', 'tagbag'), $counter), 'updated' );
		}

		return true;
	}

	/**
	 * Delete terms when counter if inferior to a specific number
	 *
	 * @param string $taxonomy
	 * @param integer $number
	 * @return boolean
	 * @author Amaury Balmer
	 */
	public static function removeRarelyUsed( $taxonomy = 'post_tag', $number = 0 ) {
		global $wpdb;

		if ( (int) $number > 100 )
			wp_die( 'Tcheater ?' );

		// Get terms with counter inferior to...
		$terms_id = $wpdb->get_col( $wpdb->prepare("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = %s AND count < %d", $taxonomy, $number) );

		// Delete terms
		$counter = 0;
		foreach ( (array) $terms_id as $term_id ) {
			if ( $term_id != 0 ) {
				wp_delete_term( $term_id, $taxonomy );
				clean_term_cache( $term_id, $taxonomy );
				$counter++;
			}
		}

		if ( $counter == 0  ) {
			add_settings_error( __CLASS__, __CLASS__, __('No term deleted.', 'tagbag'), 'updated' );
		} else {
			add_settings_error( __CLASS__, __CLASS__, sprintf(__('%1s term(s) deleted.', 'tagbag'), $counter), 'updated' );
		}

		return true;
	}

	/**
	 * Method for edit one or more terms slug
	 *
	 * @param string $taxonomy
	 * @param string $names
	 * @param string $slugs
	 * @return boolean
	 * @author Amaury Balmer
	 */
	/*
	public static function editTermSlug( $taxonomy = 'post_tag', $names = '', $slugs = '') {
		if ( trim( str_replace(',', '', stripslashes($slugs)) ) == '' ) {
			add_settings_error( __CLASS__, __CLASS__, __('No new slug(s) specified!', 'tagbag'), 'error' );
			return false;
		}

		$match_names = explode(',', $names);
		$new_slugs = explode(',', $slugs);

		$match_names = array_filter($match_names, '_delete_empty_element');
		$new_slugs = array_filter($new_slugs, '_delete_empty_element');

		if ( count($match_names) != count($new_slugs) ) {
			add_settings_error( __CLASS__, __CLASS__, __('Terms number and slugs number isn\'t the same!', 'tagbag'), 'error' );
			return false;
		} else {
			$counter = 0;
			foreach ( (array) $match_names as $i => $match_name ) {
				// Sanitize slug + Escape
				$new_slug = sanitize_title($new_slugs[$i]);

				// Get term by name
				$term = get_term_by('name', $match_name, $taxonomy);
				if ( !$term ) {
					continue;
				}

				// Increment
				$counter++;

				// Update term
				wp_update_term($term->term_id, $taxonomy, array('slug' => $new_slug));

				// Clean cache
				clean_term_cache($term->term_id, $taxonomy);
			}
		}

		if ( $counter == 0  ) {
			add_settings_error( __CLASS__, __CLASS__, __('No slug edited.', 'tagbag'), 'updated' );
		} else {
			add_settings_error( __CLASS__, __CLASS__, sprintf(__('%s slug(s) edited.', 'tagbag'), $counter), 'updated' );
		}

		return true;
	}
	*/
}