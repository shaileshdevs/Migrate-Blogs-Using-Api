<?php
/**
 * Fetch Authors and Articles Template.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="mbua-fetch-articles-sub-menu" role="main">
    <div class="mbua-header-wrapper">
        <h1 class="mbua-header">
            <?php esc_html_e('Fetch Articles', 'mbua-migrate-blogs'); ?>
        </h1>
    </div>
    <div class="mbua-content-wrapper">
        <p class="mbua-fetch-authors-wrapper">
            <input type="submit" name="mbua_fetch_authors_action" id="mbua_fetch_authors_action" value="<?php esc_attr_e('Fetch Users', 'mbua-migrate-blogs'); ?>" class="button button-primary" />
            <span class="spinner" style="float: none"></span>
            <?php wp_nonce_field( 'mbua_fetch_authors_action', 'mbua_fetch_authors_nonce_field' ); ?>
        </p>
        <p class="mbua-fetch-articles-wrapper">
            <input type="submit" name="mbua_fetch_articles_action" id="mbua_fetch_articles_action" value="<?php esc_attr_e('Fetch Articles', 'mbua-migrate-blogs'); ?>" class="button button-primary" />
            <span class="spinner" style="float: none"></span>
            <?php wp_nonce_field( 'mbua_fetch_articles_action', 'mbua_fetch_articles_nonce_field' ); ?>
        </p>
    </div>
    <div class="mbua-response-wrapper">
        <p class="mbua-response-message"></p>
    </div>
</div>