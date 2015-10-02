<?php 
/**
 * Plugin Name: eli-tool.
 * Plugin URI: www.elinet.it
 * Description: libreria di funzioni e tool.
 * Version: 1.0.0
 * Author: Marco Bullo
 * Author URI: http://www.ifustiveneti.beer/
 * Text Domain: eli-tool
 */
 
// BANNER PER AVVISO SU UTILIZZO DEI COOKIE

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;


function my_plugin_load_plugin_textdomain() {
    load_plugin_textdomain( 'eli-tool', FALSE, basename( dirname( __FILE__ ).'/languages/' ));
}
add_action( 'plugins_loaded', 'my_plugin_load_plugin_textdomain' );

function active_eli_tool(){
	// definisco la pagina cookie policy	
	if( !get_option( 'id_pagina_info' ) ) {
		register_setting('page_tool','id_pagina_info');
		$arg_page = array(
		   'post_title'    => 'Informativa Cookie',
		   'post_content'  => 'Inserire il testo dell\'informativa' ,
		   'post_status'   => 'publish',
		   'post_type' =>'page'
		);
		// creo la pagina per l'informativa sui cookie
		$id_page=wp_insert_post( $arg_page );
		// registro i setting per salvare l'id dell pagina creata
		
		update_option( 'id_pagina_info', $id_page );
		}
		
	// definisco la pagina privacy policy		
	if( !get_option( 'privacy_policy' ) ) {
		register_setting('page_tool','privacy_policy');
		$arg_page1 = array(
		   'post_title'    => 'Privacy Policy',
		   'post_content'  => 'Inserire il testo dell\'informativa' ,
		   'post_status'   => 'publish',
		   'post_type' =>'page'
		);
		// creo la pagina per l'informativa sui cookie
		$id_page1=wp_insert_post( $arg_page1 );
		// registro i setting per salvare l'id dell pagina creata
		
		update_option( 'privacy_policy', $id_page1 );
		}
	
	// definisco la pagina note legali		
	if( !get_option( 'note_legali' ) ) {
		register_setting('page_tool','note_legali');
		$arg_page2 = array(
		   'post_title'    => 'Note Legali',
		   'post_content'  => 'Inserire il testo dell\'informativa' ,
		   'post_status'   => 'publish',
		   'post_type' =>'page'
		);
		// creo la pagina per l'informativa sui cookie
		$id_page2=wp_insert_post( $arg_page2 );
		// registro i setting per salvare l'id dell pagina creata
		
		update_option( 'note_legali', $id_page2 );
		}
}

// registro hook appena viene attivato il plugin
register_activation_hook(__FILE__,'active_eli_tool');

// callback per uninstall
function uninstall_process(){
	delete_option( 'eli_tool' );

	// For site options in multisite
	delete_site_option( 'eli_tool' ); 
}

// registro hook per uninstall
register_uninstall_hook(__FILE__, 'uninstall_process' );

/*function liftoff_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'liftoff_customize_register' );*/

function add_plugin_script() {
	wp_enqueue_style( 'cookieBar', get_bloginfo('wpurl').'/wp-content/plugins/eli-tool/css/jquery.cookiebar.css' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'cookieBar', get_bloginfo('wpurl').'/wp-content/plugins/eli-tool/js/jquery.cookiebar.js' );
}

// carico gli script da utilizzare
add_action( 'wp_enqueue_scripts', 'add_plugin_script' );


function add_admin_script(){
	wp_enqueue_script( 'jscolor', get_bloginfo('wpurl').'/wp-content/plugins/eli-tool/js/color/jscolor.js' );
}

// carico gli script per la parte di admin
add_action( 'admin_enqueue_scripts', 'add_admin_script' );

function active_script(){
	$option=get_option('eli_tool');
	?>
	<script type="text/javascript"> 
	  
	  // controllo se posso utilizzare lo script per analytics	  
	  if(jQuery.cookieBar('cookies')){
		 // console.log('cookie settati');
		  
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php if(isset($option['code_analytics']))echo $option['code_analytics']; else echo 'UA-XX-XXXXXX' ?>']);
		  // ANONYMIZE IP
		  _gaq.push (['_gat._anonymizeIp']); 
		  _gaq.push(['_trackPageview']);
		
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			//console.log(ga);
		  })();

			//console.log(ga);		  
		}	
	  
    </script>
    <?php
}
// head
add_action('wp_head', 'active_script');


// main menù page
function add_eli_tool()
  {
     ?>
	<div class="wrap">
        <h2>Eli-tool option</h2>
        <form method="post" action="#"> 
        	<?php if(isset($_REQUEST['id_pagina_info']))
					update_option( 'id_pagina_info', $_REQUEST['id_pagina_info'] );
				  if(isset($_REQUEST['privacy_policy']))
					update_option( 'privacy_policy', $_REQUEST['privacy_policy'] );
				  if(isset($_REQUEST['note_legali']))
					update_option( 'note_legali', $_REQUEST['note_legali'] ); ?>
        	<?php //do_settings_sections('page_tool'); ?>
            <ul>
            	<li><label for="id_pagina_info"><?php _e('Id page Cookie Policy','eli-tool'); ?></label> <input type="text" name="id_pagina_info" id="id_pagina_info" value="<?php echo get_option('id_pagina_info'); ?>" /></li>
                <li><label for="privacy_policy"><?php _e('Id page Privacy Policy','eli-tool'); ?></label> <input type="text" name="privacy_policy" id="privacy_policy" value="<?php echo get_option('privacy_policy'); ?>" /></li>
                <li><label for="note_legali"><?php _e('Id page legal note','eli-tool'); ?></label> <input type="text" name="note_legali" id="note_legali" value="<?php echo get_option('note_legali'); ?>" /></li>
            </ul>
            <?php submit_button(); ?>
        </form>
        <p><?php _e('Features','eli-tool'); ?></p>
        <ul>
        	<li>
            	<a href="<?php echo admin_url('admin.php?page=policy_page');?>"><?php _e('Cookie Banner and Policy','eli-tool'); ?></a>
            </li>
            <li>
            	<a href="<?php echo admin_url('admin.php?page=hide_setting');?>"><?php _e('Remove functionality for others admin','eli-tool'); ?></a>
            </li>
        </ul>
    </div>
    <?php
  }

function page_menu()
{
  add_menu_page( 'Eli-tool', 'Eli-tool', 'administrator', 'eli-tool', 'add_eli_tool', 'dashicons-hammer' );
}

add_action('admin_menu','page_menu');

// istruzione che serve a caricare la funzione wp_get_current_user() viene caricata solo alla fine del caricamento del plugin
require_once(ABSPATH . 'wp-includes/pluggable.php');
require_once(dirname(__FILE__).'/include/policy_setting.php');

require_once(dirname(__FILE__).'/include/hide_setting.php');


// istanzio la classe per i settaggi della policy page
if(is_admin()){
	 $myoptions = new MySettingsPage();
	 $hide = new HideSetting();
	 $hide->check_hide();
}

// hook per il inserire info nel footer

function add_to_footer() {
	$option=get_option('eli_tool');
	$note_legali=$privacy_policy=$cookie_policy="";
	$footer='';
	if(isset($option['check_cookie_policy'])){
		$cookie_policy='<a href="'.get_permalink(get_option( 'id_pagina_info' )).'">Cookie Policy</a>';
	}
	if(isset($option['check_privacy_policy'])){
		$privacy_policy='<a href="'. get_permalink(get_option('privacy_policy')).'">Privacy Policy</a>';
	}
	if(isset($option['check_note_legali'])){
		$note_legali='<a href="'. get_permalink(get_option('note_legali')).'">Note Legali</a>';
	}
	
	if($note_legali!='' || $privacy_policy!='' || $cookie_policy!='' ){
		$footer='<p id="policy_footer">';
		if($cookie_policy!='')
			$footer.=$cookie_policy;
		if($privacy_policy!='')
			$footer.=$privacy_policy;
		if($note_legali!='')
			$footer.=$note_legali;
	}
    $footer.='</p>';
	$selettore_css=$option['selector_footer'];
	?>
    <script>
		jQuery('<?php echo $selettore_css; ?>').append('<?php echo $footer; ?>');
		jQuery('#policy_footer a').css({
				'text-decoration':'none',
				'font-family':'arial',
				'font-size':'11px',
				'margin-right':'10px',
				'color':'#6A6A6A',
				'padding-bottom' : '5px'
			});
			
		// aggiungi la barra dei cookie
		jQuery.cookieBar({
			 message: '<?php if(isset($option['text_banner']) and $option['text_banner']!='')echo esc_attr($option['text_banner']); else echo 'Questo sito utilizza cookie tecnici per la navigazione'; ?>',
			 acceptText: '<?php if(isset($option['text_accetto']) and $option['text_accetto']!='')echo $option['text_accetto']; else echo 'Accetto'; ?>',
			 policyText: '<?php if(isset($option['text_cookie_policy']) and $option['text_cookie_policy']!='')echo $option['text_cookie_policy']; else echo 'Maggiori informazioni'; ?>',
			 policyURL: '<?php echo get_permalink(get_option( 'id_pagina_info' ));?>',
			 declineButton: <?php if(isset($option['button_disable']) and $option['button_disable']){ ?>true <?php } else {?> false <?php }?>,
			 declineText: '<?php if(isset($option['text_dis_button']) and $option['text_dis_button']!='')echo $option['text_dis_button']; else echo 'Disabilita'; ?>',
			 policyButton: true,
			 acceptOnContinue: <?php if(isset($option['acceptOnContinue']) and $option['acceptOnContinue']){ ?>true <?php } else {?> false <?php }?>,
			acceptOnScroll: <?php if(isset($option['acceptOnScroll']) and $option['acceptOnScroll']){ ?>true <?php } else {?> false <?php }?>, 
			acceptAnyClick: <?php if(isset($option['acceptAnyClick']) and $option['acceptAnyClick']){ ?>true <?php } else {?> false <?php }?>,
			 fixed: true,
			 bottom: <?php if(isset($option['bottom_banner']) and $option['bottom_banner']){ ?>true <?php } else {?> false <?php }?>,
			 zindex: '99999'
			 });
			 
		// colore testo banner	 
		jQuery('#cookie-bar').css({'color':'<?php 
		if($option['color_text_banner']!=false)
			 echo $option['color_text_banner']; 
		else
			echo "#eeeeee" ?>'});
			
		 // colore banner
		jQuery('#cookie-bar').css({'background':'<?php 
		if($option['color_banner']!=false)
			 echo $option['color_banner']; 
		else
			echo "#000" ?>'});	
			
		// colore testo bottone cookie
		jQuery('.cb-enable').css({'color':'<?php 
		if($option['color_text_btn_cookie']!=false)
			 echo $option['color_text_btn_cookie']; 
		else
			echo "#eeeeee" ?>'});
			
		// colore bottone cookie
		jQuery('.cb-enable').css({'background':'<?php 
		if($option['color_btn_cookie']!=false)
			 echo $option['color_btn_cookie']; 
		else
			echo "#green" ?>'});
			
		// colore test bottone cookiepolicy
		jQuery('.cb-policy').css({'color':'<?php 
		if($option['color_text_cookie_policy']!=false)
			 echo $option['color_text_cookie_policy']; 
		else
			echo "#0011FF" ?>'}); 
			
		// colore bottone cookiepolicy
		jQuery('.cb-policy').css({'background':'<?php 
		if($option['color_cookie_policy']!=false)
			 echo $option['color_cookie_policy']; 
		else
			echo "#eeeeee" ?>'});	
			
		// colore testo disabilita cookie
		jQuery('.cb-disable').css({'color':'<?php 
		if($option['text_color_dis_button']!=false)
			 echo $option['text_color_dis_button']; 
		else
			echo "#eeeeee" ?>'});	
			
		// colore testo disabilita cookie
		jQuery('.cb-disable').css({'background':'<?php 
		if($option['color_dis_button']!=false)
			 echo $option['color_dis_button']; 
		else
			echo "#eeeeee" ?>'});	
			
			
	</script>
    <?php
	
}
add_action('wp_footer', 'add_to_footer');

?>
