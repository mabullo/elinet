<?php

// Definizione della classe per la creazione
// pagina delle opzioni nel pannello Admin
  
class MySettingsPage
{
  // Memorizzazione opzioni per callback
  private $options;
  
  // Funzione costruttore per aggiungere le funzioni di
  // azione durante gli hook di admin_init e admin_menu
  
  public function __construct() {
    add_action('admin_init',array($this,'page_init'));
    add_action('admin_menu',array($this,'page_policy'));
  }
  
  // Registrazione delle opzioni di configurazione
  // con definizione gruppo e sezione
  
  public function page_init()
  {
		// Registrazione impostazioni che identificano il nome
		// del gruppo che sarà utilizzato nel form e la callback
	 
		register_setting(
		  'eli_tool',           // option group
		  'eli_tool',            // option name
		  array($this,'page_sanitize') // sanitize
		);
	  
		// ***** SEZIONE PER I COOKIE ******
	 
		add_settings_section(
		  'eli_tool_option_cookie',         // ID
		  'Cookie',      // title
		  array($this,'page_section'), // callback
		  'policy_page'           // page	
		);
	  
		// Aggiungo il campo per scegliere se visualizzare il bottone per disabilitare i cookie
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'button_disable',               // ID
		  __('Aggiungi bottone disabilita analytics'),                 // title
		  array($this,'add_button_dis'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
	  
		// Aggiungo il campo per il codice di analytics
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'code_analytics',              // ID
		  __('Codice di Google Analitycs'),                   // title
		  array( $this,'code_analytics'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per il testo del pulsante di accettazione cookie
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'text_accetto',              // ID
		  __('Testo per accettare i cookie'),                   // title
		  array( $this,'testo_accetto'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		
		// campo per memorizzare il colore del testo del bottone per accettre i cookie
		add_settings_field(
		  'color_text_btn_cookie',               // ID
		  __('Colore testo bottone accettazione cookie'),                 // title
		  array($this,'add_color_text_btn_cookie'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// campo per memorizzare il colore del testo del bottone per accettre i cookie
		add_settings_field(
		  'color_btn_cookie',               // ID
		  __('Colore bottone accettazione cookie'),                 // title
		  array($this,'add_color_btn_cookie'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per il testo del pulsante cookie policy
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'text_cookie_policy',              // ID
		  __('Testo per bottone cookie policy'),                   // title
		  array( $this,'testo_cookie_policy'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// campo per memorizzare il colore del testo del bottone per la cookie policy
		add_settings_field(
		  'color_text_cookie_policy',               // ID
		  __('Colore testo bottone cookie policy'),                 // title
		  array($this,'add_color_text_cookie_policy'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// campo per memorizzare il colore del bottone per la cookie policy
		add_settings_field(
		  'color_cookie_policy',               // ID
		  __('Colore bottone cookie policy'),                 // title
		  array($this,'add_color_cookie_policy'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per il testo del pulsante cookie policy
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'text_dis_button',              // ID
		  __('Testo per bottone disabilita cookie'),                   // title
		  array( $this,'testo_dis_button'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		
		// Aggiungo il campo per il colore del testo disabilita button
	 
		add_settings_field(
		  'text_color_dis_button',              // ID
		  __('Colore testo per bottone disabilita cookie'),                   // title
		  array( $this,'add_text_color_dis_button'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per colore del bottone disabilita cookie 
	 
		add_settings_field(
		  'color_dis_button',              // ID
		  __('Colore per bottone disabilita cookie'),                   // title
		  array( $this,'add_color_dis_button'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per il testo del messaggio nel banner
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'text_banner',              // ID
		  __('Testo per il banner di avviso'),                   // title
		  array( $this,'testo_banner'), // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Aggiungo il campo per scegliere se visualizzare il banner
		// nel bottom del sito
	 
		add_settings_field(
		  'bottom_banner',               // ID
		  __('Visualizza il banner nella parte bassa del sito'),                 // title
		  array($this,'add_bottom_banner'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// campo per memorizzare il colore del testo del banner
		add_settings_field(
		  'color_text_banner',               // ID
		  __('Colore testo banner'),                 // title
		  array($this,'add_color_text_banner'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// Modifiche colore banner
		// campo per memorizzare il colore del bottone per la cookie policy
		add_settings_field(
		  'color_banner',               // ID
		  __('Colore sfondo banner'),                 // title
		  array($this,'add_color_banner'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		// campo per memorizzare la scelta acceptOnContinue
		add_settings_field(
		  'acceptOnContinue',               // ID
		  __('Accetta proseguendo'),                 // title
		  array($this,'add_acceptOnContinue'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		
		// campo per memorizzare la scelta acceptOnScroll
		
		add_settings_field(
		  'acceptOnScroll',               // ID
		  __('Accetta con lo scroll'),                 // title
		  array($this,'add_acceptOnScroll'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
		
		
		// campo per memorizzare la scelta acceptOnScroll
		
		add_settings_field(
		  'acceptAnyClick',               // ID
		  __('Accetta con i click'),                 // title
		  array($this,'add_acceptAnyClick'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_cookie'          // section
		);
				
		
		// ***** SEZIONE PER LE PRIVACY POLICY ******
	 
		add_settings_section(
		  'eli_tool_option_footer',         // ID
		  __('Link Footer'),      // title
		  array($this,'page_section_footer'), // callback
		  'policy_page'           // page	
		);
		
		// Aggiungo il campo per confermare l'aggiunta delle cookie policy nel footer
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'check_cookie_policy',               // ID
		  __('Aggiungi link Cookie Policy nel footer'),                 // title
		  array($this,'add_check_cookie_policy'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_footer'          // section
		);
		
				
		// Aggiungo il campo per confermare l'aggiunta della privacy policy
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'check_privacy_policy',               // ID
		  __('Aggiungi link Privacy Policy nel footer'),                 // title
		  array($this,'add_check_privacy_policy'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_footer'          // section
		);
		
		// Aggiungo il campo per confermare l'aggiunta delle note legali
		// nella sezione definita precedentemente
	 
		add_settings_field(
		  'check_note_legali',               // ID
		  __('Aggiungi link Note Legali nel footer'),                 // title
		  array($this,'add_check_note_legali'),   // callback
		  'policy_page',          // page
		  'eli_tool_option_footer'          // section
		);
		
		// Aggiungo il campo per il selettore css  nel footer
		add_settings_field(
		  'selector_footer',              // ID
		  __('Selettore css per il footer'),                   // title
		  array( $this,'selector_footer'), // callback
		  'policy_page',          // page
		  'eli_tool_option_footer'          // section
		);
		
			  
	  
  }
 
  // testo sezioni
 
  public function page_section() {
    echo __('Sezione per i cookie');
  }
  
  public function page_section_footer(){
  	echo __('Sezione per i link nel footer');
  }
 
  // Funzione per i controlli formali sui campi di input
  // ed eventualmente applicazione di filtri personalizzati
 
  public function page_sanitize($input)
  {
    $new_input = array();
 
    if(isset($input['button_disable'])) 
      $new_input['button_disable'] = absint($input['button_disable']);
	  
	if(isset($input['bottom_banner'])) 
      $new_input['bottom_banner'] = absint($input['bottom_banner']);  
  
    if(isset($input['code_analytics']))
      $new_input['code_analytics'] = trim($input['code_analytics']);
	  
	if(isset($input['text_accetto']))
      $new_input['text_accetto'] = sanitize_text_field($input['text_accetto']);
  
  	if(isset($input['text_cookie_policy']))
      $new_input['text_cookie_policy'] = sanitize_text_field($input['text_cookie_policy']);
  
  	if(isset($input['text_dis_button']))
      $new_input['text_dis_button'] = sanitize_text_field($input['text_dis_button']);
	 
	if(isset($input['text_banner']))
      $new_input['text_banner'] = sanitize_text_field($input['text_banner']); 
	
	if(isset($input['check_privacy_policy']))
      $new_input['check_privacy_policy'] = absint($input['check_privacy_policy']); 
	
	if(isset($input['check_note_legali']))
      $new_input['check_note_legali'] = absint($input['check_note_legali']);  
	 
	if(isset($input['check_cookie_policy'])) 
	  $new_input['check_cookie_policy'] = absint($input['check_cookie_policy']);
	  
	if(isset($input['acceptOnContinue'])) 
	  $new_input['acceptOnContinue'] = absint($input['acceptOnContinue']);  
	
	if(isset($input['acceptOnScroll'])) 
	  $new_input['acceptOnScroll'] = absint($input['acceptOnScroll']);  
	  
	if(isset($input['acceptAnyClick'])) 
	  $new_input['acceptAnyClick'] = absint($input['acceptAnyClick']);  
	     
	if(isset($input['selector_footer']))
      $new_input['selector_footer'] = sanitize_text_field($input['selector_footer']); 
	  
	if(isset($input['color_text_banner']))
      $new_input['color_text_banner'] = trim($input['color_text_banner']);
	  
	if(isset($input['color_text_btn_cookie']))
      $new_input['color_text_btn_cookie'] = trim($input['color_text_btn_cookie']);
	
	if(isset($input['color_text_cookie_policy']))
      $new_input['color_text_cookie_policy'] = trim($input['color_text_cookie_policy']);
	  
	if(isset($input['color_btn_cookie']))
      $new_input['color_btn_cookie'] = trim($input['color_btn_cookie']);
	  
	if(isset($input['color_cookie_policy']))
      $new_input['color_cookie_policy'] = trim($input['color_cookie_policy']);
	  
	if(isset($input['color_banner']))
      $new_input['color_banner'] = trim($input['color_banner']);
	  
	if(isset($input['color_dis_button']))
      $new_input['color_dis_button'] = trim($input['color_dis_button']);
	  
	if(isset($input['text_color_dis_button']))
      $new_input['text_color_dis_button'] = trim($input['text_color_dis_button']);
	     
	return $new_input;
  }
  
  // Definizione delle funzione per esecuzione 
  // callback che riguarda l'opzione di aggiunta del bottone per disabilitare analytics
 
  public function add_button_dis()
  {
    
	if(!isset($this->options['button_disable'])) $option = ''; 
      else $option = esc_attr($this->options['button_disable']);
 	
	 echo '<input type="checkbox" id="button_disable" name="eli_tool[button_disable]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
  // funzione per gestire la scelta di visualizzare il banner nel bottom del sito
  
  public function add_bottom_banner(){
	  
  	if(!isset($this->options['bottom_banner'])) $option = ''; 
      else $option = esc_attr($this->options['bottom_banner']);
 	
	 echo '<input type="checkbox" id="bottom_banner" name="eli_tool[bottom_banner]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
  // funzione per gestire la scelta del colore del testo del banner
  public function add_color_text_banner(){
  	if(!isset($this->options['color_text_banner'])) $option = ''; 
      else $option = esc_attr($this->options['color_text_banner']);
 
    printf('<input class="color {hash:true,caps:false}" id="color_text_banner" '.
      'name="eli_tool[color_text_banner]" '.
      'value="%s" />',$option);
  }
  
  // funzione per gestire il colore del testo dei bottoni
  public function add_color_text_btn_cookie(){
  	if(!isset($this->options['color_text_btn_cookie'])) $option = ''; 
      else $option = esc_attr($this->options['color_text_btn_cookie']);
 
    printf('<input class="color {hash:true,caps:false}" id="color_text_btn_cookie" '.
      'name="eli_tool[color_text_btn_cookie]" '.
      'value="%s" />',$option);
  }
 
  // Definizione delle funzione per esecuzione 
  // callback che riguarda l'opzione di altezza
 
  public function code_analytics()
  {
    if(!isset($this->options['code_analytics'])) $option = ''; 
      else $option = esc_attr($this->options['code_analytics']);
 
    printf('<input type="text" id="code_analytics" '.
      'name="eli_tool[code_analytics]" '.
      'value="%s" />',$option);
  }
  
  // Funzione per modificare il testo del pulsante per accettazione cookie
  public function testo_accetto()
  {
    if(!isset($this->options['text_accetto'])) $option = ''; 
      else $option = esc_attr($this->options['text_accetto']);
 
    printf('<input type="text" id="text_accetto" '.
      'name="eli_tool[text_accetto]" '.
      'value="%s" />',$option);
  }
  
  // Funzione per modificare il testo del pulsante per accettazione cookie
  public function testo_cookie_policy()
  {
    if(!isset($this->options['text_cookie_policy'])) $option = ''; 
      else $option = esc_attr($this->options['text_cookie_policy']);
 
    printf('<input type="text" id="text_cookie_policy" '.
      'name="eli_tool[text_cookie_policy]" '.
      'value="%s" />',$option);
  }
  
  // Funzione per modificare il testo del pulsante per disabilitare i cookie
  public function testo_dis_button()
  {
    if(!isset($this->options['text_dis_button'])) $option = ''; 
      else $option = esc_attr($this->options['text_dis_button']);
 
    printf('<input type="text" id="text_dis_button" '.
      'name="eli_tool[text_dis_button]" '.
      'value="%s" />',$option);
  }
 
 // Funzione per modificare il testo del pulsante per disabilitare i cookie
  public function testo_banner()
  {
    if(!isset($this->options['text_banner'])) $option = ''; 
      else $option = esc_attr($this->options['text_banner']);
 
    echo '<textarea id="text_banner" name="eli_tool[text_banner]" " />'.$option.'</textarea>';
  }
  
  // Funzione per modificare il contenuto per il selettore css nel footer
  public function selector_footer()
  {
    if(!isset($this->options['selector_footer'])) $option = ''; 
      else $option = esc_attr($this->options['selector_footer']);
 
    printf('<input type="text" id="selector_footer" '.
      'name="eli_tool[selector_footer]" '.
      'value="%s" />',$option);
  }
  
  
  // funzione per inserire il campo di check per le privacy policy
  public function add_check_privacy_policy(){
  	if(!isset($this->options['check_privacy_policy'])) $option = ''; 
      else $option = esc_attr($this->options['check_privacy_policy']);
 	
	 echo '<input type="checkbox" id="check_privacy_policy" name="eli_tool[check_privacy_policy]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
   
  // funzione per inserire il campo di check per le privacy policy
  public function add_check_note_legali(){
  	if(!isset($this->options['check_note_legali'])) $option = ''; 
      else $option = esc_attr($this->options['check_note_legali']);
 	
	 echo '<input type="checkbox" id="check_note_legali" name="eli_tool[check_note_legali]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
  // funzione per la checkbox acceptOnContinue
  
  public function add_acceptOnContinue(){
  	if(!isset($this->options['acceptOnContinue'])) $option = ''; 
      else $option = esc_attr($this->options['acceptOnContinue']);
 	
	 echo '<input type="checkbox" id="acceptOnContinue" name="eli_tool[acceptOnContinue]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
   // funzione per la checkbox add_acceptOnScroll
   
   public function add_acceptOnScroll(){
  	if(!isset($this->options['acceptOnScroll'])) $option = ''; 
      else $option = esc_attr($this->options['acceptOnScroll']);
 	
	 echo '<input type="checkbox" id="acceptOnScroll" name="eli_tool[acceptOnScroll]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
  // funzione per la checkbox add_acceptAnyClick
   
   public function add_acceptAnyClick(){
  	if(!isset($this->options['acceptAnyClick'])) $option = ''; 
      else $option = esc_attr($this->options['acceptAnyClick']);
 	
	 echo '<input type="checkbox" id="acceptAnyClick" name="eli_tool[acceptAnyClick]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
 
 
  
  // funzione per inserire il campo di check per le privacy policy
  public function add_check_cookie_policy(){
  	if(!isset($this->options['check_cookie_policy'])) $option = ''; 
      else $option = esc_attr($this->options['check_cookie_policy']);
 	
	 echo '<input type="checkbox" id="check_cookie_policy" name="eli_tool[check_cookie_policy]" value="1" ' . checked(1, $option, false) . '/>'; 
  }
  
  // funzione per cambiare il colore del testo del bottone per la cookie policy
  public function add_color_text_cookie_policy(){
	  	if(!isset($this->options['color_text_cookie_policy'])) $option = ''; 
		  else $option = esc_attr($this->options['color_text_cookie_policy']);
	 
		printf('<input class="color {hash:true,caps:false}" id="color_text_cookie_policy" '.
		  'name="eli_tool[color_text_cookie_policy]" '.
		  'value="%s" />',$option);
  }
  
  // funzione per cambiare il colore del bottone per la cookie policy
  public function add_color_btn_cookie(){
	  	if(!isset($this->options['color_btn_cookie'])) $option = ''; 
		  else $option = esc_attr($this->options['color_btn_cookie']);
	 
		printf('<input class="color {hash:true,caps:false}" id="color_btn_cookie" '.
		  'name="eli_tool[color_btn_cookie]" '.
		  'value="%s" />',$option);
  }
  
  // funzione per cambiare il colore del bottone per la cookie policy
  public function add_color_cookie_policy(){
	  	if(!isset($this->options['color_cookie_policy'])) $option = ''; 
		  else $option = esc_attr($this->options['color_cookie_policy']);
	 
		printf('<input class="color {hash:true,caps:false}" id="color_cookie_policy" '.
		  'name="eli_tool[color_cookie_policy]" '.
		  'value="%s" />',$option);
  }
  
  // funzione per cambiare il colore del bottone per la cookie policy
  public function add_color_banner(){
	  	if(!isset($this->options['color_banner'])) $option = ''; 
		  else $option = esc_attr($this->options['color_banner']);
	 
		printf('<input class="color {hash:true,caps:false}" id="color_banner" '.
		  'name="eli_tool[color_banner]" '.
		  'value="%s" />',$option);
  }
  
  // funzione per cambiare il colore del test del bottone per disabilitare i cookie
  public function add_text_color_dis_button(){
	  	if(!isset($this->options['text_color_dis_button'])) $option = ''; 
		  else $option = esc_attr($this->options['text_color_dis_button']);
	 
		printf('<input class="color {hash:true,caps:false}" id="text_color_dis_button" '.
		  'name="eli_tool[text_color_dis_button]" '.
		  'value="%s" />',$option);
  }
  
  // funzione per cambiare il colore del test del bottone per disabilitare i cookie
  public function add_color_dis_button(){
	  	if(!isset($this->options['color_dis_button'])) $option = ''; 
		  else $option = esc_attr($this->options['color_dis_button']);
	 
		printf('<input class="color {hash:true,caps:false}" id="color_dis_button" '.
		  'name="eli_tool[color_dis_button]" '.
		  'value="%s" />',$option);
  }
 
  // Definzione funzione per aggiungere la pagina
  // nel menu delle impostazioni su sidebar di wordpress
 
  public function page_policy()
  {
	add_submenu_page( 'eli-tool', 'Policy Page', 'Policy page', 'administrator', 'policy_page', array( $this, 'add_policy_tool' ) );
  }
  
  // Funzione di callback per emissione HTML della 
  // pagina con le opzioni definite
 
  public function add_policy_tool()
  {
    
		
	$this->options = get_option('eli_tool');
 
    echo '<div class="wrap">';
    echo '<h2>Eli-tool Cookie option</h2>';
    echo '<form method="post" action="options.php">';
 
    do_settings_sections('policy_page');
	settings_fields('eli_tool');
    submit_button();
 
    echo '</form>';
	echo '<p><a href="'.get_edit_post_link(get_option( 'id_pagina_info')).'" title="link alle cookie policy">Modifica le cookie policy</a></p>';
	echo '<p><a href="'.get_edit_post_link(get_option( 'privacy_policy')).'" title="link alle privacy policy">Modifica le privacy policy</a></p>';
	echo '<p><a href="'.get_edit_post_link(get_option( 'note_legali')).'" title="link alle note legali">Modifica le note legali</a></p>';
    echo '</div>';
  }
}
  
// Se la funzione viene richiamata dal backend eseguo
// la creazione dell'istanza e eseguo l'elaborazione
?>