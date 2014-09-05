<?php
/**
 * Generate HTML extended tag cloud
 *
 * @param string $args
 * @return string
 * @author Amaury Balmer
 */
function tb_get_tag_cloud( $args = '' ) {
	return tagbag_Client_TagCloud::extendedTagCloud( $args );
}

/**
 * Display extended tag cloud
 *
 * @param string $args
 * @return void
 * @author Amaury Balmer
 */
function tb_tag_cloud( $args = '' ) {
	echo tb_get_tag_cloud( $args );
}

/**
 * Generate extended current tags post
 *
 * @param string $args
 * @return string
 * @author Amaury Balmer
 */
function tb_get_the_tags( $args = '' ) {
	if (class_exists('tagbag_Client_PostTags') )
		return tagbag_Client_PostTags::extendedPostTags( $args );

	return '';
}

/**
 * Display extended current tags post
 *
 * @param string $args
 * @return void
 * @author Amaury Balmer
 */
function tb_the_tags( $args = '' ) {
	echo tb_get_the_tags( $args );
}

/**
 * Generate related posts for a post in WP loop
 *
 * @param string $args
 * @return string|array
 * @author Amaury Balmer
 */
function tb_get_related_posts( $args = '' ) {
	if (class_exists('tagbag_Client_RelatedPosts') )
		return tagbag_Client_RelatedPosts::get_related_posts( $args );

	return '';
}

/**
 * Display related posts for a post in WP loop
 *
 * @param string $args
 * @return void
 * @author Amaury Balmer
 */
function tb_related_posts( $args = '' ) {
	echo tb_get_related_posts( $args );
}