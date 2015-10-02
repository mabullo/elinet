<?php

// Classe per la pagina di sottomenù che gestirà la scomparsa di alcune voci in menù
class HideSetting{
	// Memorizzazione opzioni per callback
  	private $options;
	
	// Funzione costruttore per aggiungere le funzioni di
    // azione durante gli hook di admin_init e admin_menu
  
    public function __construct() {
	  add_action('admin_init',array($this,'page_init'));
	  add_action('admin_menu',array($this,'page_hide'));
    }
	
	public function page_init()
  {
		// Registrazione impostazioni che identificano il nome
		// del gruppo che sarà utilizzato nel form e la callback
	 
		register_setting(
		  'hide_tool',           // option group
		  'hide_tool',            // option name
		  array($this,'page_sanitize') // sanitize
		);
	  
		// Aggiungo la sezione che contiene i campi
		// che ci interessano 
	 
		add_settings_section(
		  'eli_tool_hide',         // ID
		  'Hide setting',      // title
		  array($this,'page_section'), // callback
		  'hide_page'           // page	
		);
	  
		// Aggiungo il campo per larghezza video
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'set_hide_field',               // ID
		  __('Disable unnecessary entries'),                 // title
		  array($this,'hide_setting_check'),   // callback
		  'hide_page',          // page
		  'eli_tool_hide'          // section
		);
	  
		// Aggiungo il campo per il codice di analytics
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'super_admin',              // ID
		  __('Super Admin Name'),                   // title
		  array( $this,'super_admin_name'), // callback
		  'hide_page',          // page
		  'eli_tool_hide'          // section
		);
		
  }
  
  // Aggiungo un template HTML da visualizzare
  // durante l'elaborazione della sezione definita
 
  public function page_section() {
    echo __('Section to clear the parts from the menu that are not needed');
  }
 
  // Funzione per i controlli formali sui campi di input
  // ed eventualmente applicazione di filtri personalizzati
 
  public function page_sanitize($input)
  {
    $new_input = array();
 
    if(isset($input['set_hide_field'])) 
      $new_input['set_hide_field'] = absint($input['set_hide_field']);
  
    if(isset($input['super_admin'])){
      // controllo che l'input non sia nullo. Se nullo inserisco l'utente attuale.
	  if($input['super_admin']==''){
	  	global $current_user;
		$new_input['super_admin'] = $current_user->user_login;
	  }
	  else
	 	$new_input['super_admin'] = trim($input['super_admin']);
	}
    return $new_input;
  }
  
  // Definizione delle funzione per esecuzione 
  // callback che riguarda l'opzione di aggiunta del bottone per disabilitare analytics
 
  public function hide_setting_check()
  {
    
	if(!isset($this->options['set_hide_field'])) $option = ''; 
      else $option = esc_attr($this->options['set_hide_field']);
 	
	 echo '<input type="checkbox" id="set_hide_field" name="hide_tool[set_hide_field]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
 
  // Definizione delle funzione per esecuzione 
  // callback che riguarda l'opzione di altezza
 
  public function super_admin_name()
  {
	global $current_user;  
    if(!isset($this->options['super_admin'])) $option = $current_user->user_login; 
      else $option = esc_attr($this->options['super_admin']);
 
    printf('<input type="text" id="super_admin" '.
      'name="hide_tool[super_admin]" '.
      'value="%s" />',$option);
  }
  
  // Definzione funzione per aggiungere la pagina
  // nel menu delle impostazioni su sidebar di wordpress
 
  public function page_hide()
  {
	add_submenu_page( 'eli-tool', 'Hide Setting', 'Hide Setting', 'administrator', 'hide_setting', array( $this, 'add_hide_tool' ) );
  }
  
  // Funzione di callback per emissione HTML della 
  // pagina con le opzioni definite
 
  public function add_hide_tool()
  {
    $this->options = get_option('hide_tool');
 
    echo '<div class="wrap">';
    echo '<h2>Hide option</h2>';
    echo '<form method="post" action="options.php">';
 
    settings_fields('hide_tool');
    do_settings_sections('hide_page');
    submit_button();
 
    echo '</form>';	
    echo '</div>';
  }
  
  /**
 *  Hide Menu Items in Admin
 */
public function eli_configure_dashboard_menu() {
  global $menu,$submenu;

    remove_menu_page( 'edit-comments.php' );
  	remove_menu_page( 'themes.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'plugins.php' );
	remove_menu_page( 'options-general.php' );
	remove_menu_page( 'eli-tool' );
    

    //unset($submenu['users.php'][5]); // All users
    unset($submenu['users.php'][10]); // Add new user
    unset($submenu['themes.php'][5]); // Settings Themes
    unset($submenu['themes.php'][6]); // Settings Themes
    unset($submenu['themes.php'][7]); // Settings Widgets
    unset($submenu['themes.php'][10]); // Settings Menus
}

  
  
 public function admin_level($user_login=''){
  global $current_user;
  get_currentuserinfo();
  if(current_user_can('level_10')) {
    if ($user_login!=''){
      if($current_user->user_login==$user_login){
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  } else {
    return false;
  }
  return true;
}



 public function check_hide(){
	$this->options = get_option('hide_tool');
	//error_log("set_hide_field: ".$this->options['set_hide_field']." - super_admin: ".$this->options['super_admin'], 0, WP_CONTENT_DIR . '/debug.log');

	 global $current_user;
	if (current_user_can('manage_options') and isset($this->options['set_hide_field']) and $option['set_hide_field']=1) {
	  if( !$this->admin_level($user_login = $this->options['super_admin'])){
			//add_action('wp_dashboard_setup', 'remove_dashboard_widgets'); // Add action to hide dashboard widgets
			add_action('admin_head', array($this,'eli_configure_dashboard_menu')); // Add action to hide admin menu items
			//add_action( 'widgets_init', 'pc_unregister_default_widgets', 11 ); // Add action to hide widgets
		
			/*
			 * Remove the Update WordPress message in Admin
			 */
			add_action('admin_menu','wphidenag');
			function wphidenag() {
			  remove_action( 'admin_notices', 'update_nag', 3 );
			}
		
		  }
		}
	}
}
?>