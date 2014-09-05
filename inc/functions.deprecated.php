<?php
/**
 * Deprecated - Generate meta keywords for HTML header
 *
 * @return string
 */
function tb_get_meta_keywords() {
	return '';
}

/**
 * Deprecated - Display meta keywords for HTML header
 *
 */
function tb_meta_keywords() {
	echo tb_get_meta_keywords();
}

/**
 * Deprecated - Display related tags
 *
 * @param string $args
 */
function tb_related_tags( $args = '' ) {
	echo tb_get_related_tags( $args );
}

/**
 * Deprecated - Get related tags
 *
 * @param string $args
 * @return string|array
 */
function tb_get_related_tags( $args = '' ) {
	return '';
}

/**
 * Deprecated - Display remove related tags
 *
 * @param string $args
 */
function tb_remove_related_tags( $args = '' ) {
	echo tb_get_remove_related_tags( $args );
}

/**
 * Deprecated - Get remove related tags
 *
 * @param string $args
 * @return string|array
 */
function tb_get_remove_related_tags( $args = '' ) {
	return '';
}