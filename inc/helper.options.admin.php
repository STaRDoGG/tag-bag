<?php
return array(
	'features' => array(
		array('auto_link_tags', __('Auto-Link Tags', 'tagbag'), 'checkbox', '1',
			__('<strong>Example:</strong> You have the tag "WordPress" and your post content contains "wordpress", this feature will replace "wordpress" with a link to the "wordpress" tags page. (http://myblog.net/tag/wordpress)', 'tagbag')),
		array('active_mass_edit', __('Mass Edit Terms', 'tagbag'), 'checkbox', '1',
			__('Allows editing terms from any taxonomy for many posts per page.', 'tagbag')),
		array('use_click_tags', __('Click tags feature', 'tagbag'), 'checkbox', '1',
			__('Adds a link allowing you to display all the tags in your database. Once displayed, you can click over to add tags to post.', 'tagbag')),
		array('use_autocompletion', __('Auto-completion with old input', 'tagbag'), 'checkbox', '1',
			__('Displays visual help to allow entering tags more easily. Also easier to add tags than the built-in WordPress auto-complete.', 'tagbag')),
		array('use_suggested_tags', __('Suggested tags feature', 'tagbag'), 'checkbox', '1',
			__('Adds a box allowing you get suggested tags, by comparing post content and various sources of tags.<br />(<em>Yahoo! Term Extraction API, OpenCalais, Alchemy, Zemanta, Tag The Net, Local DB</em>)', 'tagbag')),
		array('active_manage', __('Advanced Manage Terms', 'tagbag'), 'checkbox', '1',
			__('Allows editing, merging, deleting, and adding terms for any taxonomy.<br />(<em>Please consider the plugin <a href="http://wordpress.org/extend/plugins/term-management-tools" target="_blank">Term Management Tools</a> if you only need to merge terms.</em>)', 'tagbag')),
		array('active_related_posts', __('Related Posts by Terms', 'tagbag'), 'checkbox', '1',
			__('Allows displaying related posts with related terms.<br />(<em>Please consider plugins <a href="http://wordpress.org/extend/plugins/similar-posts" target="_blank">Similar Posts</a> or <a href="http://wordpress.org/extend/plugins/yet-another-related-posts-plugin" target="_blank">Yet Another Related Posts Plugin</a> for better results and performance.</em>)', 'tagbag')),
		array('active_autotags', __('Auto-Terms Posts', 'tagbag'), 'checkbox', '1',
			__('Allows automatically adding terms to a post by searching the content.', 'tagbag')),
		array('use_tag_pages', __('Tags for Page', 'tagbag'), 'checkbox', '1',
			__('Allows page post type to be tagged. This option adds pages in tags search. Also add tag management in write page.', 'tagbag')),
		array('allow_embed_tcloud', __('Tag Cloud Shortcode', 'tagbag'), 'checkbox', '1',
			__('Enabling this will allow Wordpress to look for the tag cloud shortcodes <code>[tb_tag_cloud]</code> or <code>[tb-tag-cloud]</code> when displaying posts. WordPress replaces these shortcodes with a tag cloud.', 'tagbag'))
	),
	'administration' => array(
		array('autocomplete_type', __('Type of Old Input', 'tagbag'), 'radio', array(
				'textarea'	=> __('<code>textarea</code> &ndash; Textarea multi-line.', 'tagbag'),
				'input'			=> __('<code>input</code> &ndash; Text input, only one line. (default)', 'tagbag')
			) ),
		array('autocomplete_min', __('Auto-completion Min. Chars', 'tagbag'), 'number', 'small-text',
			__('You can define how many characters needed for auto-completion to suggest terms. The default value in Tag Bag 2.0 is 0, prior this version, default was 1.', 'tagbag')),
		array('order_click_tags', __('Click Tags Order', 'tagbag'), 'radio',
			array(
				'count-asc'		=> __('<code>count-asc</code> &ndash; Least Used.', 'tagbag'),
				'count-desc'	=> __('<code>count-desc</code> &ndash; Most Popular.', 'tagbag'),
				'name-asc'		=> __('<code>name-asc</code> &ndash; Alphabetical. (default)', 'tagbag'),
				'name-desc'		=> __('<code>name-desc</code> &ndash; Inverse Alphabetical.', 'tagbag'),
				'random'			=> __('<code>random</code> &ndash; Random.', 'tagbag'),
			) ),
		array('opencalais_key', __('OpenCalais API Key', 'tagbag'), 'text', 'regular-text',
			__('You can get an API key <a href="http://www.opencalais.com">here</a>', 'tagbag')),
		array('alchemy_api', __('Alchemy API Key', 'tagbag'), 'text', 'regular-text',
			__('You can get an API key <a href="http://www.alchemyapi.com">here</a>', 'tagbag')),
		array('zemanta_key', __('Zemanta API Key', 'tagbag'), 'text', 'regular-text',
			__('You can get an API key <a href="http://developer.zemanta.com">here</a>', 'tagbag')),
		array('tag4site_key', __('Tag4Site API Key', 'tagbag'), 'text', 'regular-text',
			__('You can get an API key <a href="http://tag4site.ru">here</a>', 'tagbag')),
		array('datatxt_id', __('dataTXT API ID', 'tagbag'), 'text', 'regular-text',
			__('You can get an API ID <a href="https://dandelion.eu">here</a>', 'tagbag')),
		array('datatxt_key', __('dataTXT API Key', 'tagbag'), 'text', 'regular-text',
			__('You can get an API key <a href="https://dandelion.eu">here</a>', 'tagbag')),
		array('datatxt_min_confidence', __('dataTXT API min_confidence', 'tagbag'), 'text', 'regular-text',
			__('Default: 0.6', 'tagbag'))
	),
	'auto-links' => array(
		array('auto_link_min', __('Min. usage for auto-link tags:', 'tagbag'), 'number', 'small-text',
			__('This parameter allows to fix a minimal value of use of tags. Default: 1.', 'tagbag')),
		array('auto_link_max_by_post', __('Max. number of links per article:', 'tagbag'), 'number', 'small-text',
			__('Determines the maximum number of links created by article. Default: 10.', 'tagbag')),
		array('auto_link_max_by_tag', __('Maximum number of links for the same tag:', 'tagbag'), 'number', 'small-text',
			__('Determines the maximum number of links created by article for the same tag. Default: 1.', 'tagbag')),
		array('auto_link_case', __('Ignore case for auto link feature?', 'tagbag'), 'checkbox', '1',
			__('Example: If you ignore case, auto link feature will replace the word "wordpress" by the tag link "WordPress".', 'tagbag')),
		array('auto_link_exclude', __('Exclude some terms from tag link. For Ads Link subtition, etc.', 'tagbag'), 'text', 'regular-text',
			__('Example: If you enter the term "Paris", the auto link tags feature will never replace this term by this link.', 'tagbag')),
		array('auto_link_priority', __('Priority on hook the_content', 'tagbag'), 'number', 'small-text',
			__('For expert, possibility to change the priority of autolinks functions on the_content hook. Useful for fix a conflict with an another plugin. Default: 12.', 'tagbag')),
		array('auto_link_views', __('Enable autolinks into post content for theses views:', 'tagbag'), 'radio',
			array(
				'no'				=> __('<code>no</code> &ndash; Nowhere', 'tagbag'),
				'all'				=> __('<code>all</code> &ndash; On your blog and feeds.', 'tagbag'),
				'singular'	=> __('<code>singular</code> &ndash; Only on your singular view (single post & page) (default).', 'tagbag'),
			)
		),
		array('auto_link_dom', __('Try new engine replacement?', 'tagbag'), 'checkbox', '1',
			__('An engine replacement alternative uses DOMDocument PHP class and theoretically offers better performance. If your server does not offer the functionality, the plugin will use the usual engine.', 'tagbag')),
		array('auto_link_title', __('Text to display into title attribute for links:', 'tagbag'), 'text', 'regular-text'),
	),
	'tagcloud' => array(
		array('text_helper', 'text_helper', 'helper', '', __('What\'s difference between <strong>&#8216;Order tags selection&#8217;</strong> and <strong>&#8216;Order tags display&#8217;</strong>?<br />', 'tagbag')
			. '<ul style="list-style:square;margin-left:20px;">
				<li>'.__('<strong>&#8216;Order tags selection&#8217;</strong> is the first step during tag\'s cloud generation, corresponding to collect tags.', 'tagbag').'</li>
				<li>'.__('<strong>&#8216;Order tags display&#8217;</strong> is the second. Once tags choosen, you can reorder them before display.', 'tagbag').'</li>
			</ul>'.
			__('<strong>Example:</strong> You want to randomly display the 100 most popular tags.<br />', 'tagbag').
			__('You must set &#8216;Order tags selection&#8217; to <strong>count-desc</strong> for retrieve the 100 tags most popular and &#8216;Order tags display&#8217; to <strong>random</strong> for randomize cloud.', 'tagbag')),
		array('cloud_selectionby', __('Order By for Tags (Selection):', 'tagbag'), 'radio',
			array(
				'count'		=> __('<code>count</code> &ndash; Counter. (default)', 'tagbag'),
				'name'		=> __('<code>name</code> &ndash; Name.', 'tagbag'),
				'random'	=> __('<code>random</code> &ndash; Random.', 'tagbag'),
			) ),
		array('cloud_selection', __('Order of Tags (Selection):', 'tagbag'), 'radio',
			array(
				'asc'		=> __('<code>asc</code> &ndash; Ascending.', 'tagbag'),
				'desc'	=> __('<code>desc</code> &ndash; Descending.', 'tagbag'),
			) ),
		array('cloud_orderby', __('Order By:', 'tagbag'), 'radio',
			array(
				'count'		=> __('<code>count</code> &ndash; Counter.', 'tagbag'),
				'name'		=> __('<code>name</code> &ndash; Name.', 'tagbag'),
				'random'	=> __('<code>random</code> &ndash; Random. (default)', 'tagbag'),
			) ),
		array('cloud_order', __('Order of Tags (Display):', 'tagbag'), 'radio',
			array(
				'asc'		=> __('<code>asc</code> &ndash; Ascending.', 'tagbag'),
				'desc'	=> __('<code>desc</code> &ndash; Descending.', 'tagbag'),
			) ),
		array('cloud_format', __('Tags cloud type format:', 'tagbag'), 'radio',
			array(
				'list'	=> __('<code>list</code> &ndash; Display a formatted list (ul/li).', 'tagbag'),
				'flat'	=> __('<code>flat</code> &ndash; Display inline (no list, just a div)', 'tagbag'),
			) ),
		array('cloud_xformat', __('Tag link format:', 'tagbag'), 'text', 'widefat',
			__('You can find markers and explanations <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">in the online documentation.</a>', 'tagbag')),
		array('cloud_limit_qty', __('Max. number of tags to display: (default: 45)', 'tagbag'), 'number', 'small-text'),
		array('cloud_notagstext', __('Enter the text to show when there is no tag:', 'tagbag'), 'text', 'widefat'),
		array('cloud_title', __('Enter the positioned title before the list, leave blank for no title:', 'tagbag'), 'text', 'widefat'),
		array('cloud_max_color', __('"Most Popular" color:', 'tagbag'), 'text-color', 'medium-text',
			__("The colors are hexadecimal colors,  and need to have the full six digits (#eee is the shorthand version of #eeeeee).", 'tagbag')),
		array('cloud_max_size', __('"Most Popular" font size:', 'tagbag'), 'number', 'small-text',
			__("The two font sizes are the size of the largest and smallest tags.", 'tagbag')),
		array('cloud_min_color', __('"Least Popular" color:', 'tagbag'), 'text-color', 'medium-text'),
		array('cloud_min_size', __('"Least Popular" font size:', 'tagbag'), 'number', 'small-text'),
		array('cloud_unit', __('The units to display the font sizes with, on tag clouds:', 'tagbag'), 'dropdown', 'pt/px/em/%',
			__("The font size units option determines the units that the two font sizes use.", 'tagbag')),
		array('cloud_adv_usage', __('<strong>Advanced usage</strong>:', 'tagbag'), 'text', 'widefat',
			__('You can use the same syntax as <code>tb_tag_cloud()</code> public static function to customize display. See <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">documentation</a> for more details.', 'tagbag'))
	),
	'tagspost' => array(
		array('tt_feed', __('Automatically insert tags list into feeds', 'tagbag'), 'checkbox', '1'),
		array('tt_embedded', __('Automatically display tags list into post content:', 'tagbag'), 'radio',
			array(
				'no'						=> __('<code>no</code> &ndash; Nowhere (default)', 'tagbag'),
				'all'						=> __('<code>all</code> &ndash; On your blog and feeds.', 'tagbag'),
				'blogonly'			=> __('<code>blogonly</code> &ndash; Only on your blog.', 'tagbag'),
				'homeonly'			=> __('<code>homeonly</code> &ndash; Only on your home page.', 'tagbag'),
				'singularonly'	=> __('<code>singularonly</code> &ndash; Only on your singular view (single & page).', 'tagbag'),
				'singleonly'		=> __('<code>singleonly</code> &ndash; Only on your single view.', 'tagbag'),
				'pageonly'			=> __('<code>pageonly</code> &ndash; Only on your page view.', 'tagbag'),
			) ),
		array('tt_separator', __('Post tag separator string:', 'tagbag'), 'text', 'regular-text'),
		array('tt_before', __('Text to display before tags list:', 'tagbag'), 'text', 'regular-text'),
		array('tt_after', __('Text to display after tags list:', 'tagbag'), 'text', 'regular-text'),
		array('tt_number', __('Max tags display:', 'tagbag'), 'number', 'small-text',
			__('You must set zero (0) for display all tags.', 'tagbag')),
		array('tt_inc_cats', __('Include categories in result ?', 'tagbag'), 'checkbox', '1'),
		array('tt_xformat', __('Tag link format:', 'tagbag'), 'text', 'widefat',
			__('You can find markers and explanations <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">in the online documentation.</a>', 'tagbag')),
		array('tt_notagstext', __('Text to display if no tags found:', 'tagbag'), 'text', 'widefat'),
		array('tt_adv_usage', __('<strong>Advanced usage</strong>:', 'tagbag'), 'text', 'widefat',
			__('You can use the same syntax as <code>tb_the_tags()</code> public static function to customize display. See <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">documentation</a> for more details.', 'tagbag'))
	),
	'relatedposts' => array(
		array('rp_taxonomy', __('Taxonomy:', 'tagbag'), 'text', 'widefat',
			__('By default, related posts work with post tags, but you can use a custom taxonomy. Default value : post_tag', 'tagbag')),
		array('rp_feed', __('Automatically display related posts into feeds', 'tagbag'), 'checkbox', '1'),
		array('rp_embedded', __('Automatically display related posts into post content', 'tagbag'), 'dropdown', 'no/all/blogonly/feedonly/homeonly/singularonly/pageonly/singleonly',
			'<ul>
				<li>'.__('<code>no</code> &ndash; Nowhere (default)', 'tagbag').'</li>
				<li>'.__('<code>all</code> &ndash; On your blog and feeds.', 'tagbag').'</li>
				<li>'.__('<code>blogonly</code> &ndash; Only on your blog.', 'tagbag').'</li>
				<li>'.__('<code>homeonly</code> &ndash; Only on your home page.', 'tagbag').'</li>
				<li>'.__('<code>singularonly</code> &ndash; Only on your singular view (single & page).', 'tagbag').'</li>
				<li>'.__('<code>singleonly</code> &ndash; Only on your single view.', 'tagbag').'</li>
				<li>'.__('<code>pageonly</code> &ndash; Only on your page view.', 'tagbag').'</li>
			</ul>'),
		array('rp_order', __('Related Posts Order:', 'tagbag'), 'dropdown', 'count-asc/count-desc/date-asc/date-desc/name-asc/name-desc/random',
			'<ul>
				<li>'.__('<code>date-asc</code> &ndash; Older Entries.', 'tagbag').'</li>
				<li>'.__('<code>date-desc</code> &ndash; Newer Entries.', 'tagbag').'</li>
				<li>'.__('<code>count-asc</code> &ndash; Least common tags between posts', 'tagbag').'</li>
				<li>'.__('<code>count-desc</code> &ndash; Most common tags between posts (default)', 'tagbag').'</li>
				<li>'.__('<code>name-asc</code> &ndash; Alphabetical.', 'tagbag').'</li>
				<li>'.__('<code>name-desc</code> &ndash; Inverse Alphabetical.', 'tagbag').'</li>
				<li>'.__('<code>random</code> &ndash; Random.', 'tagbag').'</li>
			</ul>'),
		array('rp_xformat', __('Post link format:', 'tagbag'), 'text', 'widefat',
			__('You can find markers and explanations <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">in the online documentation.</a>', 'tagbag')),
		array('rp_limit_qty', __('Max. number of related posts to display: (Default: 5)', 'tagbag'), 'text', 'regular-text'),
		array('rp_notagstext', __('Enter the text to show when there is no related post:', 'tagbag'), 'text', 'widefat'),
		array('rp_title', __('Enter the positioned title before the list, leave blank for no title:', 'tagbag'), 'text', 'widefat'),
		array('rp_adv_usage', __('<strong>Advanced usage</strong>:', 'tagbag'), 'text', 'widefat',
			__('You can use the same syntax as <code>tb_related_posts()</code>public static function to customize display. See <a href="https://github.com/herewithme/simple-tags/wiki/Theme-functions-Integration">documentation</a> for more details.', 'tagbag'))
	),
);