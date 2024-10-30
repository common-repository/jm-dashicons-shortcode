<?php
defined( 'ABSPATH' ) or	die( 'No !' );
 
// Helper in post edits
add_action( 'admin_enqueue_scripts', '_jm_ds_add_helper' );
function _jm_ds_add_helper( $hook_suffix ) {
	if(current_user_can('edit_posts') ) {
		if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
		    if ( _jm_ds_admin_pointers_check() ) {
			  add_action( 'admin_print_footer_scripts', '_jm_ds_admin_pointers_footer' );
			  wp_enqueue_script( 'wp-pointer' );
			  wp_enqueue_style( 'wp-pointer' );
			}
			wp_enqueue_script('quicktags-dashicons', JM_DS_JS_URL.'quicktags.js', false, '1.0', true);
		 }
	}
}

//Pointers
function _jm_ds_admin_pointers_check() {
   $admin_pointers = _jm_ds_admin_pointers();
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] )
         return true;
   }
}

function _jm_ds_admin_pointers_footer() {
   $admin_pointers = _jm_ds_admin_pointers();
   ?>
<script type="text/javascript">
/* <![CDATA[ */
( function($) {
   <?php
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] ) {
         ?>
         $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
			pointerClass: 'wp-pointer <?php echo $array['class']; ?>',
            content: '<?php echo $array['content']; ?>',
            position: {
				edge: '<?php echo $array['edge']; ?>',
				align: '<?php echo $array['align']; ?>',
			},
            close: function() {
               $.post( ajaxurl, {
                  pointer: '<?php echo $pointer; ?>',
                  action: 'dismiss-wp-pointer'
               } );
            }
         } ).pointer( 'open' );
         <?php
      }
   }
   ?>
} )(jQuery);
/* ]]> */
</script>
   <?php
}

function _jm_ds_admin_pointers() {
   $dismiss = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
   $version = '1_2';
   $prefix = 'custom_admin_pointers' . $version . '_';

   $pointer_content  = '<h3>' . __( 'Dashicons' ) . '</h3>';
   $pointer_content .= '<p>' . __( 'Dashicons and full list of icons', 'jm-ds' ) . '</p>';

   return array(
      $prefix . 'new_items' => array(
         'content' => $pointer_content,
         'anchor_id' => '#contextual-help-link',
         'edge'  => 'top',
		 'align' => 'middle',
		 'class' => 'jm-ds-pointer',
         'active' => ( ! in_array( $prefix . 'new_items', $dismiss ) )
      ),
   );
}



//Add styles
add_action( 'admin_head', '_jm_ds_add_styles');
function _jm_ds_add_styles(){

  global $pagenow;

   if ( in_array( $pagenow, array('post.php', 'post-new.php', 'nav-menus.php', 'widgets.php') ) ) { 
	
	// A little bit far-fetched for "fun part" but this is not so easy to style...
	?>
	<style>
	
		/* Just for fun */
		 .wp-pointer.jm-ds-pointer.wp-pointer-top .wp-pointer-content h3:before { color:#0075A2; }
		 .wp-pointer.jm-ds-pointer.wp-pointer-top h3{ background:#0075A2; border:1px solid #0075A2; }
		 .wp-pointer.jm-ds-pointer.wp-pointer-top .wp-pointer-arrow:before, .wp-pointer.jm-ds-pointer.wp-pointer-undefined .wp-pointer-arrow:before,
		 .wp-pointer.jm-ds-pointer.wp-pointer-top .wp-pointer-arrow, .wp-pointer.jm-ds-pointer.wp-pointer-undefined .wp-pointer-arrow { border-bottom-color:#0075A2; }
		 .wp-pointer.jm-ds-pointer.wp-pointer-top .wp-pointer-arrow, .wp-pointer.jm-ds-pointer.wp-pointer-top.wp-pointer-undefined .wp-pointer-arrow { left:250px; }
		/*Just for fun */
		 
	     .ds-help { columns: 2; -webkit-columns: 2; -moz-columns: 2; }
	     .ds-help li{ list-style-type:none!important; }
		 .ds-help .smith-icons:after{ margin-left:1em; font-style:italic; font-weight:bold; content:"<?php _e('Only WP 3.9++ !');?>" }
		 .ds-help li div { margin-right:1em; }
		 .help-tab-content h3 { text-transform:capitalize; }
	</style>
	<?php
	}
}


//Add lists
//The trick is that WordPress already include dashicons font so you can choose in WYSIWYG
add_action( 'contextual_help', '_jm_ds_add_tab');
function _jm_ds_add_tab() {
   $screen = get_current_screen();

    global $pagenow;

	if ( in_array( $pagenow, array('post.php', 'post-new.php', 'nav-menus.php', 'widgets.php') ) ) { 
    // Pannels
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-1',
        'title'		=> 'DS admin menu',
        'content'	=> '<h3> admin menu </h3>'
					    .'<ul class="ds-help">'
							.'<li><div data-code="f333" class="dashicons dashicons-menu"></div>[dashicon name="menu"]</li>'
							.'<li><div data-code="f319" class="dashicons dashicons-admin-site"></div>[dashicon name="admin-site"]</li>'
							.'<li><div data-code="f226" class="dashicons dashicons-dashboard"></div>[dashicon name="dashboard"]</li>'
							.'<li><div data-code="f109" class="dashicons dashicons-admin-post"></div>[dashicon name="admin-post"]</li>'
							.'<li><div data-code="f104" class="dashicons dashicons-admin-media"></div>[dashicon name="admin-media"]</li>'
							.'<li><div data-code="f103" class="dashicons dashicons-admin-links"></div>[dashicon name="admin-links"]</li>'
							.'<li><div data-code="f105" class="dashicons dashicons-admin-page"></div>[dashicon name="admin-page"]</li>'
							.'<li><div data-code="f101" class="dashicons dashicons-admin-comments"></div>[dashicon name="admin-comments"]</li>'
							.'<li><div data-code="f100" class="dashicons dashicons-admin-appearance"></div>[dashicon name="admin-appearance"]</li>'
							.'<li><div data-code="f106" class="dashicons dashicons-admin-plugins"></div>[dashicon name="admin-plugins"]</li>'
							.'<li><div data-code="f110" class="dashicons dashicons-admin-users"></div>[dashicon name="admin-users"]</li>'
							.'<li><div data-code="f107" class="dashicons dashicons-admin-tools"></div>[dashicon name="admin-tools"]</li>'
							.'<li><div data-code="f108" class="dashicons dashicons-admin-settings"></div>[dashicon name="admin-settings"]</li>'
							.'<li><div data-code="f112" class="dashicons dashicons-admin-network"></div>[dashicon name="admin-network"]</li>'
							.'<li><div data-code="f102" class="dashicons dashicons-admin-home"></div>[dashicon name="admin-home"]</li>'
							.'<li><div data-code="f111" class="dashicons dashicons-admin-generic"></div>[dashicon name="admin-generic"]</li>'	
							.'<li><div data-code="f148" class="dashicons dashicons-admin-collapse"></div>[dashicon name="admin-collapse"]</li>'					
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-2',
        'title'		=> 'DS welcome screen',
        'content'	=> '<h3> welcome screen </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f119" class="dashicons dashicons-welcome-write-blog"></div>[dashicon name="welcome-write-blog"]</li>'
							.'<!--<li><div data-code="f119" class="dashicons dashicons-welcome-edit-page"></div>[dashicon name="welcome-edit-page"] Duplicate </li>-->'
							.'<li><div data-code="f133" class="dashicons dashicons-welcome-add-page"></div>[dashicon name="welcome-add-page"]</li>'
							.'<li><div data-code="f115" class="dashicons dashicons-welcome-view-site"></div>[dashicon name="welcome-view-site"]</li>'
							.'<li><div data-code="f116" class="dashicons dashicons-welcome-widgets-menus"></div>[dashicon name="welcome-widgets-menus"]</li>'
							.'<li><div data-code="f117" class="dashicons dashicons-welcome-comments"></div>[dashicon name="welcome-comments"]</li>'
							.'<li><div data-code="f118" class="dashicons dashicons-welcome-learn-more"></div>[dashicon name="welcome-learn-more"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-3',
        'title'		=> 'DS post formats',
        'content'	=> '<h3> post formats </h3>'
						.'<ul class="ds-help">'
							.'<!--<li><div data-code="f109" class="dashicons dashicons-format-standard"></div>[dashicon name="format-standard Duplicate "]</li>-->'
							.'<li><div data-code="f123" class="dashicons dashicons-format-aside"></div>[dashicon name="format-aside"]</li>'
							.'<li><div data-code="f128" class="dashicons dashicons-format-image"></div>[dashicon name="format-image"]</li>'
							.'<li><div data-code="f161" class="dashicons dashicons-format-gallery"></div>[dashicon name="format-gallery"]</li>'
							.'<li><div data-code="f126" class="dashicons dashicons-format-video"></div>[dashicon name="format-video"]</li>'
							.'<li><div data-code="f130" class="dashicons dashicons-format-status"></div>[dashicon name="format-status"]</li>'
							.'<li><div data-code="f122" class="dashicons dashicons-format-quote"></div>[dashicon name="format-quote"]</li>'
							.'<!--<li><div data-code="f103" class="dashicons dashicons-format-links"></div>[dashicon name="format-links"] Duplicate </li>-->'
							.'<li><div data-code="f125" class="dashicons dashicons-format-chat"></div>[dashicon name="format-chat"]</li>'
							.'<li><div data-code="f127" class="dashicons dashicons-format-audio"></div>[dashicon name="format-audio"]</li>'
							.'<li><div data-code="f306" class="dashicons dashicons-camera"></div>[dashicon name="camera"]</li>'
							.'<li><div data-code="f232" class="dashicons dashicons-images-alt"></div>[dashicon name="images-alt"]</li>'
							.'<li><div data-code="f233" class="dashicons dashicons-images-alt2"></div>[dashicon name="images-alt2"]</li>'
							.'<li><div data-code="f234" class="dashicons dashicons-video-alt"></div>[dashicon name="video-alt"]</li>'
							.'<li><div data-code="f235" class="dashicons dashicons-video-alt2"></div>[dashicon name="video-alt2"]</li>'
							.'<li><div data-code="f236" class="dashicons dashicons-video-alt3"></div>[dashicon name="video-alt3"]</li>'
					   .'</ul>',
	) );
	
	
	
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-3bis',
        'title'		=> 'DS media',
        'content'	=> '<h3>help</h3>'
						.'<ul class="ds-help">'
							.'<li class="smith-icons"><div data-code="f501" class="dashicons dashicons-media-archive"></div>[dashicon name="media-archive"]</li>'
							.'<li class="smith-icons"><div data-code="f500" class="dashicons dashicons-media-audio"></div>[dashicon name="media-audio"]</li>'
							.'<li class="smith-icons"><div data-code="f499" class="dashicons dashicons-media-code"></div>[dashicon name="media-code"]</li>'
							.'<li class="smith-icons"><div data-code="f498" class="dashicons dashicons-media-default"></div>[dashicon name="media-default"]</li>'
							.'<li class="smith-icons"><div data-code="f497" class="dashicons dashicons-media-document"></div>[dashicon name="media-document"]</li>'
							.'<li class="smith-icons"><div data-code="f496" class="dashicons dashicons-media-interactive"></div>[dashicon name="media-interactive"]</li>'
							.'<li class="smith-icons"><div data-code="f495" class="dashicons dashicons-media-spreadsheet"></div>[dashicon name="media-spreadsheet"]</li>'
							.'<li class="smith-icons"><div data-code="f491" class="dashicons dashicons-media-text"></div>[dashicon name="media-text"]</li>'
							.'<li class="smith-icons"><div data-code="f490" class="dashicons dashicons-media-video"></div>[dashicon name="media-video"]</li>'
							.'<li class="smith-icons"><div data-code="f492" class="dashicons dashicons-playlist-audio"></div>[dashicon name="playlist-audio"]</li>'
							.'<li class="smith-icons"><div data-code="f493" class="dashicons dashicons-playlist-video"></div>[dashicon name="playlist-video"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-4',
        'title'		=> 'DS image editing',
        'content'	=> '<h3>help</h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f165" class="dashicons dashicons-image-crop"></div>[dashicon name="image-crop"]</li>'
							.'<li><div data-code="f166" class="dashicons dashicons-image-rotate-left"></div>[dashicon name="image-rotate-left"]</li>'
							.'<li><div data-code="f167" class="dashicons dashicons-image-rotate-right"></div>[dashicon name="image-rotate-right"]</li>'
							.'<li><div data-code="f168" class="dashicons dashicons-image-flip-vertical"></div>[dashicon name="image-flip-vertical"]</li>'
							.'<li><div data-code="f169" class="dashicons dashicons-image-flip-horizontal"></div>[dashicon name="image-flip-horizontal"]</li>'
							.'<li><div data-code="f171" class="dashicons dashicons-undo"></div>[dashicon name="undo"]</li>'
							.'<li><div data-code="f172" class="dashicons dashicons-redo"></div>[dashicon name="redo"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-5',
        'title'		=> 'DS tinymce',
        'content'	=> '<h3>tinymce</h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f200" class="dashicons dashicons-editor-bold"></div>[dashicon name="editor-bold"]</li>'
							.'<li><div data-code="f201" class="dashicons dashicons-editor-italic"></div>[dashicon name="editor-italic"]</li>'
							.'<li><div data-code="f203" class="dashicons dashicons-editor-ul"></div>[dashicon name="editor-ul"]</li>'
							.'<li><div data-code="f204" class="dashicons dashicons-editor-ol"></div>[dashicon name="editor-ol"]</li>'
							.'<li><div data-code="f205" class="dashicons dashicons-editor-quote"></div>[dashicon name="editor-quote"]</li>'
							.'<li><div data-code="f206" class="dashicons dashicons-editor-alignleft"></div>[dashicon name="editor-alignleft"]</li>'
							.'<li><div data-code="f207" class="dashicons dashicons-editor-aligncenter"></div>[dashicon name="editor-aligncenter"]</li>'
							.'<li><div data-code="f208" class="dashicons dashicons-editor-alignright"></div>[dashicon name="editor-alignright"]</li>'
							.'<li><div data-code="f209" class="dashicons dashicons-editor-insertmore"></div>[dashicon name="editor-insertmore"]</li>'
							.'<li><div data-code="f210" class="dashicons dashicons-editor-spellcheck"></div>[dashicon name="editor-spellcheck"]</li>'
							.'<li><div data-code="f211" class="dashicons dashicons-editor-distractionfree"></div>[dashicon name="editor-distractionfree"]</li>'
							.'<li><div data-code="f212" class="dashicons dashicons-editor-kitchensink"></div>[dashicon name="editor-kitchensink"]</li>'
							.'<li><div data-code="f213" class="dashicons dashicons-editor-underline"></div>[dashicon name="editor-underline"]</li>'
							.'<li><div data-code="f214" class="dashicons dashicons-editor-justify"></div>[dashicon name="editor-justify"]</li>'
							.'<li><div data-code="f215" class="dashicons dashicons-editor-textcolor"></div>[dashicon name="editor-textcolor"]</li>'
							.'<li><div data-code="f216" class="dashicons dashicons-editor-paste-word"></div>[dashicon name="editor-paste-word"]</li>'
							.'<li><div data-code="f217" class="dashicons dashicons-editor-paste-text"></div>[dashicon name="editor-paste-text"]</li>'
							.'<li><div data-code="f218" class="dashicons dashicons-editor-removeformatting"></div>[dashicon name="editor-removeformatting"]</li>'
							.'<li><div data-code="f219" class="dashicons dashicons-editor-video"></div>[dashicon name="editor-video"]</li>'
							.'<li><div data-code="f220" class="dashicons dashicons-editor-customchar"></div>[dashicon name="editor-customchar"]</li>'
							.'<li><div data-code="f221" class="dashicons dashicons-editor-outdent"></div>[dashicon name="editor-outdent"]</li>'
							.'<li><div data-code="f222" class="dashicons dashicons-editor-indent"></div>[dashicon name="editor-indent"]</li>'
							.'<li><div data-code="f223" class="dashicons dashicons-editor-help"></div>[dashicon name="editor-help"]</li>'
							.'<li><div data-code="f224" class="dashicons dashicons-editor-strikethrough"></div>[dashicon name="editor-strikethrough"]</li>'
							.'<li><div data-code="f225" class="dashicons dashicons-editor-unlink"></div>[dashicon name="editor-unlink"]</li>'
							.'<li><div data-code="f320" class="dashicons dashicons-editor-rtl"></div>[dashicon name="editor-rtl"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-6',
        'title'		=> 'DS posts',
        'content'	=> '<h3> posts </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f135" class="dashicons dashicons-align-left"></div>[dashicon name="align-left"]</li>'
							.'<li><div data-code="f136" class="dashicons dashicons-align-right"></div>[dashicon name="align-right"]</li>'
							.'<li><div data-code="f134" class="dashicons dashicons-align-center"></div>[dashicon name="align-center"]</li>'
							.'<li><div data-code="f138" class="dashicons dashicons-align-none"></div>[dashicon name="align-none"]</li>'
							.'<li><div data-code="f160" class="dashicons dashicons-lock"></div>[dashicon name="lock"]</li>'
							.'<li><div data-code="f145" class="dashicons dashicons-calendar"></div>[dashicon name="calendar"]</li>'
							.'<li><div data-code="f177" class="dashicons dashicons-visibility"></div>[dashicon name="visibility"]</li>'
							.'<li><div data-code="f173" class="dashicons dashicons-post-status"></div>[dashicon name="post-status"]</li>'
							.'<li><div data-code="f464" class="dashicons dashicons-edit"></div>[dashicon name="edit"]</li>'
							.'<li><div data-code="f182" class="dashicons dashicons-trash"></div>[dashicon name="trash"]</li>'
					   .'</ul>',
	) );
	
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-7',
        'title'		=> 'DS sorting',
        'content'	=> '<h3> sorting </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f142" class="dashicons dashicons-arrow-up"></div>[dashicon name="arrow-up"]</li>'
							.'<li><div data-code="f140" class="dashicons dashicons-arrow-down"></div>[dashicon name="arrow-down"]</li>'
							.'<li><div data-code="f139" class="dashicons dashicons-arrow-right"></div>[dashicon name="arrow-right"]</li>'
							.'<li><div data-code="f141" class="dashicons dashicons-arrow-left"></div>[dashicon name="arrow-left"]</li>'
							.'<li><div data-code="f342" class="dashicons dashicons-arrow-up-alt"></div>[dashicon name="arrow-up-alt"]</li>'
							.'<li><div data-code="f346" class="dashicons dashicons-arrow-down-alt"></div>[dashicon name="arrow-down-alt"]</li>'
							.'<li><div data-code="f344" class="dashicons dashicons-arrow-right-alt"></div>[dashicon name="arrow-right-alt"]</li>'
							.'<li><div data-code="f340" class="dashicons dashicons-arrow-left-alt"></div>[dashicon name="arrow-left-alt"]</li>'
							.'<li><div data-code="f343" class="dashicons dashicons-arrow-up-alt2"></div>[dashicon name="arrow-up-alt2"]</li>'
							.'<li><div data-code="f347" class="dashicons dashicons-arrow-down-alt2"></div>[dashicon name="arrow-down-alt2"]</li>'
							.'<li><div data-code="f345" class="dashicons dashicons-arrow-right-alt2"></div>[dashicon name="arrow-right-alt2"]</li>'
							.'<li><div data-code="f341" class="dashicons dashicons-arrow-left-alt2"></div>[dashicon name="arrow-left-alt2"]</li>'
							.'<li><div data-code="f156" class="dashicons dashicons-sort"></div>[dashicon name="sort"]</li>'
							.'<li><div data-code="f229" class="dashicons dashicons-leftright"></div>[dashicon name="leftright"]</li>'
							.'<li class="smith-icons"><div data-code="f503" class="dashicons dashicons-randomize"></div>[dashicon name="randomize"]</li>'
							.'<li><div data-code="f163" class="dashicons dashicons-list-view"></div>[dashicon name="list-view"]</li>'
							.'<li><div data-code="f164" class="dashicons dashicons-exerpt-view"></div>[dashicon name="exerpt-view"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-8',
        'title'		=> 'DS social',
        'content'	=> '<h3>Social</h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f237" class="dashicons dashicons-share"></div>[dashicon name="share"]</li>'
							.'<li><div data-code="f240" class="dashicons dashicons-share-alt"></div>[dashicon name="share-alt"]</li>'
							.'<li><div data-code="f242" class="dashicons dashicons-share-alt2"></div>[dashicon name="share-alt2"]</li>'
							.'<li><div data-code="f301" class="dashicons dashicons-twitter"></div>[dashicon name="twitter"]</li>'
							.'<li><div data-code="f303" class="dashicons dashicons-rss"></div>[dashicon name="rss"]</li>'
							.'<li><div data-code="f465" class="dashicons dashicons-email"></div>[dashicon name="email"]</li>'
							.'<li><div data-code="f466" class="dashicons dashicons-email-alt"></div>[dashicon name="email-alt"]</li>'
							.'<li><div data-code="f304" class="dashicons dashicons-facebook"></div>[dashicon name="facebook"]</li>'
							.'<li><div data-code="f305" class="dashicons dashicons-facebook-alt"></div>[dashicon name="facebook-alt"]</li>'
							.'<li><div data-code="f462" class="dashicons dashicons-googleplus"></div>[dashicon name="googleplus"]</li>'
							.'<li><div data-code="f325" class="dashicons dashicons-networking"></div>[dashicon name="networking"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-9',
        'title'		=> 'DS jobs',
        'content'	=> '<h3> jobs </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f308" class="dashicons dashicons-hammer"></div>[dashicon name="hammer"]</li>'
							.'<li><div data-code="f309" class="dashicons dashicons-art"></div>[dashicon name="art"]</li>'
							.'<li><div data-code="f310" class="dashicons dashicons-migrate"></div>[dashicon name="migrate"]</li>'
							.'<li><div data-code="f311" class="dashicons dashicons-performance"></div>[dashicon name="performance"]</li>'
							.'<li class="smith-icons"><div data-code="f483" class="dashicons dashicons-universal-access"></div[dashicon name="universal-access"]></li>'
							.'<li class="smith-icons"><div data-code="f486" class="dashicons dashicons-tickets"></div>[dashicon name="tickets"]</li>'
							.'<li class="smith-icons"><div data-code="f484" class="dashicons dashicons-nametag"></div>[dashicon name="nametag"]</li>'
							.'<li class="smith-icons"><div data-code="f481" class="dashicons dashicons-organizer"></div>[dashicon name="organizer"]</li>'
							.'<li class="smith-icons"><div data-code="f487" class="dashicons dashicons-sponsor"></div>[dashicon name="sponsor"]</li>'
							.'<li class="smith-icons"><div data-code="f488" class="dashicons dashicons-speaker"></div>[dashicon name="speaker"]</li>'
							.'<li class="smith-icons"><div data-code="f489" class="dashicons dashicons-session"></div>[dashicon name="session"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-10',
        'title'		=> 'DS internal/products',
        'content'	=> '<h3> internal/products </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f120" class="dashicons dashicons-wordpress"></div>[dashicon name="wordpress"]</li>'
							.'<li><div data-code="f324" class="dashicons dashicons-wordpress-alt"></div>[dashicon name="wordpress-alt"]</li>'
							.'<li><div data-code="f157" class="dashicons dashicons-pressthis"></div>[dashicon name="pressthis"]</li>'
							.'<li><div data-code="f463" class="dashicons dashicons-update"></div>[dashicon name="update"]</li>'
							.'<li><div data-code="f180" class="dashicons dashicons-screenoptions"></div>[dashicon name="screenoptions"]</li>'
							.'<li><div data-code="f348" class="dashicons dashicons-info"></div>[dashicon name="info"]</li>'
							.'<li><div data-code="f174" class="dashicons dashicons-cart"></div>[dashicon name="cart"]</li>'
							.'<li><div data-code="f175" class="dashicons dashicons-feedback"></div>[dashicon name="feedback"]</li>'
							.'<li><div data-code="f176" class="dashicons dashicons-cloud"></div>[dashicon name="cloud"]</li>'
							.'<li><div data-code="f326" class="dashicons dashicons-translation"></div>[dashicon name="translation"]</li>'
					   .'</ul>',
	) );
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-11',
        'title'		=> 'DS taxonomies',
        'content'	=> '<h3> taxonomies </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f323" class="dashicons dashicons-tag"></div>[dashicon name="tag"]</li>'
							.'<li><div data-code="f318" class="dashicons dashicons-category"></div>[dashicon name="category"]</li>'
					   .'</ul>',
	) );

	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-12',
        'title'		=> 'DS alerts',
        'content'	=> '<h3> alerts/notifications/flags </h3>'
						.'<ul class="ds-help">'
							.'<li><div data-code="f147" class="dashicons dashicons-yes"></div>[dashicon name="yes"]</li>'
							.'<li><div data-code="f158" class="dashicons dashicons-no"></div>[dashicon name="no"]</li>'
							.'<li><div data-code="f335" class="dashicons dashicons-no-alt"></div>[dashicon name="no-alt"]</li>'
							.'<li class="smith-icons"><div data-code="f502" class="dashicons dashicons-plus-alt"></div>[dashicon name="plus-alt"]</li>'
							.'<li><div data-code="f132" class="dashicons dashicons-plus"></div>[dashicon name="plus"]</li>'
							.'<li><div data-code="f460" class="dashicons dashicons-minus"></div>[dashicon name="minus"]</li>'
							.'<li><div data-code="f153" class="dashicons dashicons-dismiss"></div>[dashicon name="dismiss"]</li>'
							.'<li><div data-code="f159" class="dashicons dashicons-marker"></div>[dashicon name="marker"]</li>'
							.'<li><div data-code="f155" class="dashicons dashicons-star-filled"></div>[dashicon name="star-filled"]</li>'
							.'<li><div data-code="f459" class="dashicons dashicons-star-half"></div>[dashicon name="star-half"]</li>'
							.'<li><div data-code="f154" class="dashicons dashicons-star-empty"></div>[dashicon name="star-empty"]</li>'
							.'<li><div data-code="f227" class="dashicons dashicons-flag"></div>[dashicon name="flag"]</li>'
					   .'</ul>',
	) );
	
	
	$screen->add_help_tab( array(
        'id'		=> 'jm-ds-help-tab-13',
        'title'		=> 'DS misc/cpt',
        'content'	=> '<h3> misc/cpt </h3>'
							.'<ul class="ds-help">'
							.'<li><div data-code="f230" class="dashicons dashicons-location"></div>[dashicon name="location"]</li>'
							.'<li><div data-code="f231" class="dashicons dashicons-location-alt"></div>[dashicon name="location-alt"]</li>'
							.'<li><div data-code="f178" class="dashicons dashicons-vault"></div>[dashicon name="vault"]</li>'
							.'<li><div data-code="f332" class="dashicons dashicons-shield"></div>[dashicon name="shield"]</li>'
							.'<li><div data-code="f334" class="dashicons dashicons-shield-alt"></div>[dashicon name="shield-alt"]</li>'
							.'<li><div data-code="f468" class="dashicons dashicons-sos"></div>[dashicon name="sos"]</li>'
							.'<li><div data-code="f179" class="dashicons dashicons-search"></div>[dashicon name="search"]</li>'
							.'<li><div data-code="f181" class="dashicons dashicons-slides"></div>[dashicon name="slides"]</li>'
							.'<li><div data-code="f183" class="dashicons dashicons-analytics"></div>[dashicon name="analytics"]</li>'
							.'<li><div data-code="f184" class="dashicons dashicons-chart-pie"></div>[dashicon name="chart-pie"]</li>'
							.'<li><div data-code="f185" class="dashicons dashicons-chart-bar"></div>[dashicon name="chart-bar"]</li>'
							.'<li><div data-code="f238" class="dashicons dashicons-chart-line"></div>[dashicon name="chart-line"]</li>'
							.'<li><div data-code="f239" class="dashicons dashicons-chart-area"></div>[dashicon name="chart-area"]</li>'
							.'<li><div data-code="f307" class="dashicons dashicons-groups"></div>[dashicon name="groups"]</li>'
							.'<li><div data-code="f338" class="dashicons dashicons-businessman"></div>[dashicon name="businessman"]</li>'
							.'<li><div data-code="f336" class="dashicons dashicons-id"></div>[dashicon name="id"]</li>'
							.'<li><div data-code="f337" class="dashicons dashicons-id-alt"></div>[dashicon name="id-alt"]</li>'
							.'<li><div data-code="f312" class="dashicons dashicons-products"></div>[dashicon name="products"]</li>'
							.'<li><div data-code="f313" class="dashicons dashicons-awards"></div>[dashicon name="awards"]</li>'
							.'<li><div data-code="f314" class="dashicons dashicons-forms"></div>[dashicon name="forms"]</li>'
							.'<li><div data-code="f473" class="dashicons dashicons-testimonial"></div>[dashicon name="testimonial"]</li>'
							.'<li><div data-code="f322" class="dashicons dashicons-portfolio"></div>[dashicon name="portfolio"]</li>'
							.'<li><div data-code="f330" class="dashicons dashicons-book"></div>[dashicon name="book"]</li>'
							.'<li><div data-code="f331" class="dashicons dashicons-book-alt"></div>[dashicon name="book-alt"]</li>'
							.'<li><div data-code="f316" class="dashicons dashicons-download"></div>[dashicon name="download"]</li>'
							.'<li><div data-code="f317" class="dashicons dashicons-upload"></div>[dashicon name="upload"]</li>'
							.'<li><div data-code="f321" class="dashicons dashicons-backup"></div>[dashicon name="backup"]</li>'
							.'<li><div data-code="f469" class="dashicons dashicons-clock"></div>[dashicon name="clock"]</li>'
							.'<li><div data-code="f339" class="dashicons dashicons-lightbulb"></div>[dashicon name="lightbulb"]</li>'
							.'<li class="smith-icons"><<div data-code="f482" class="dashicons dashicons-microphone"></div>[dashicon name="microphone"]</li>'
							.'<li><div data-code="f472" class="dashicons dashicons-desktop"></div>[dashicon name="desktop"]</li>'
							.'<li><div data-code="f471" class="dashicons dashicons-tablet"></div>[dashicon name="tablet"]</li>'
							.'<li><div data-code="f470" class="dashicons dashicons-smartphone"></div>[dashicon name="smartphone"]</li>'
							.'<li><div data-code="f328" class="dashicons dashicons-smiley"></div>[dashicon name="smiley"]</li>'
					   .'</ul>',
	) );
	
	}
}
