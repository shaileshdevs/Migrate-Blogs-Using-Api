jQuery( document ).ready( function( $ ) {
    $( '#mbua_fetch_authors_action' ).click( function() {
        let $fetch_authors_btn  = $( this );
        let $fetch_articles_btn = $( '#mbua_fetch_articles_action' );
        let nonce               = $( '#mbua_fetch_authors_nonce_field' ).length > 0 ? $( '#mbua_fetch_authors_nonce_field' ).val(): '';

        $.ajax({
            type : 'POST',
            dataType : 'json',
            url : ajaxurl,
            beforeSend: function () {
                $fetch_authors_btn.prop( 'disabled', true );
                $fetch_articles_btn.prop( 'disabled', true );
                $( '.mbua-response-wrapper .mbua-response-message' ).text( '' );
                $( '.mbua-fetch-authors-wrapper .spinner' ).addClass( 'is-active' );
            },
            data : {
                action: 'mbua_fetch_authors_action',
                mbua_nonce: nonce,
            },
            success: function( response ) {
                $( '.mbua-response-wrapper .mbua-response-message' ).text( response.message );
            },
            complete: function() {
                $fetch_authors_btn.prop( 'disabled', false );
                $fetch_articles_btn.prop( 'disabled', false );
                $( '.mbua-fetch-authors-wrapper .spinner' ).removeClass( 'is-active' );
            }
        });  
    });

    $( '#mbua_fetch_articles_action' ).click( function() {
        let $fetch_articles_btn = $( this );
        let $fetch_authors_btn  = $( '#mbua_fetch_authors_action' );
        let nonce               = $( '#mbua_fetch_articles_nonce_field' ).length > 0 ? $( '#mbua_fetch_articles_nonce_field' ).val(): '';

        $.ajax({
            type : 'POST',
            dataType : 'json',
            url : ajaxurl,
            beforeSend: function () {
                $fetch_authors_btn.prop( 'disabled', true );
                $fetch_articles_btn.prop( 'disabled', true );
                $( '.mbua-response-wrapper .mbua-response-message' ).text( '' );
                $( '.mbua-fetch-articles-wrapper .spinner' ).addClass( 'is-active' );
            },
            data : {
                action: 'mbua_fetch_articles_action',
                mbua_nonce: nonce,
            },
            success: function( response ) {
                $( '.mbua-response-wrapper .mbua-response-message' ).text( response.message );
            },
            complete: function() {
                $fetch_authors_btn.prop( 'disabled', false );
                $fetch_articles_btn.prop( 'disabled', false );
                $( '.mbua-fetch-articles-wrapper .spinner' ).removeClass( 'is-active' );
            }
        });  
    });
});
