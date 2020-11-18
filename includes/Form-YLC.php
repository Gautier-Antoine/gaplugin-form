<?php

// wp-content/themes/YourTheme/CustomSettingsPage.php
// http://regularcoder.com/create-wordpress-settings-page-for-custom-options/

class YLCForm
{
    /**
     * Array of custom settings/options
     */
    private static $options;

      const
        /**
        * @var string name of the page
        */
        PAGE = 'Form',
        /**
        * @var string name of the language file
        */
        LANGUAGE = 'form-text',
        /**
        * @var string name for the files
        */
        FILE = 'form',
        /**
        * @var string name for the plugin folder
        */
        FOLDER = 'ylc-plugin-form',

        /**
        * @var string name for the menu
        */
        MENU = 'YLC-Plugin',
        /**
        * @var string name for the extension title
        */
        EXTENSION = '_menu',
        /**
        * @var string name for the admin page
        */
        ADMINPAGE = 'ylc-admin-page';

    private static $list = [
      // Add delete for options
        0 => [
          'name' => 'intro',
          'type' => 'html',
          'question' => '
            <p>Our initial understanding of your situation depends on how much you are prepared to share with us. Please share as if you were explaining to someone who does not know you and has no information on your situation. This helps us to understand your situation a bit better so that we can communicate with you as relevantly and helpfully as we can.</p>
            <p>We encourage you to take the time to share with us some outline information that will help us to understand your situation and respond back to you. Please try to avoid giving just \'yes\' or \'no\' answers. This is an opportunity to share with us so that we understand. We\'re listening and taking you seriously!</p>
            <p><strong>*</strong> denotes a required field</p>
            <p>Please read the <a href="https://yourlifecounts.org/terms-reaching-out/" target="_blank">terms and conditions</a> before reaching out to us.</p>
          ',
          'required' => 'off',
          'selected' => 'on'
        ],
        1 => ['name' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => 'on', 'selected' => 'on'],
        2 => ['name' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => 'off', 'selected' => 'on'],
        3 => ['name' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => 'on', 'selected' => 'off'],
        4 => ['name' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => 'off', 'selected' => 'off'],
        5 => ['name' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => 'on', 'selected' => 'on'],
        6 => ['name' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => 'on', 'selected' => 'on'],
        7 => ['name' => 'phone', 'type' => 'tel', 'question' => 'Telephone Number', 'required' => 'on', 'selected' => 'off'],
        8 => ['name' => 'option1', 'type' => 'textarea', 'question' => 'What’s up? Please tell us.', 'required' => 'off', 'selected' => 'off'],
        9 => ['name' => 'option2', 'type' => 'textarea', 'question' => 'What’s the cause of the emotional pain you’re feeling deep inside? (If you don’t know, that’s ok)', 'required' => 'off', 'selected' => 'off'],
        10 => ['name' => 'option3', 'type' => 'textarea', 'question' => 'Are you aware of any addictions you may have? Could you share with us?', 'required' => 'off', 'selected' => 'off'],
        11 => ['name' => 'option4', 'type' => 'textarea', 'question' => 'Do you struggle with self-harm?', 'required' => 'off', 'selected' => 'off'],
        12 => ['name' => 'option5', 'type' => 'textarea', 'question' => 'Have you visited your doctor recently?', 'required' => 'off', 'selected' => 'off'],
        13 => ['name' => 'option6', 'type' => 'textarea', 'question' => 'Are you on any medications? If so, please share with us.', 'required' => 'off', 'selected' => 'off'],
        14 => ['name' => 'option7', 'type' => 'textarea', 'question' => 'Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions.', 'required' => 'off', 'selected' => 'off'],
        15 => ['name' => 'option8', 'type' => 'textarea', 'question' => 'Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you.', 'required' => 'off', 'selected' => 'off'],
        16 => ['name' => 'option9', 'type' => 'textarea', 'question' => 'Please share any other information you feel would be helpful to us in understanding your situation.', 'required' => 'off', 'selected' => 'off'],
        17 => [
          'name' => 'outro',
          'type' => 'html',
          'question' => '
            <p>
              Use of the Your Life Counts online submission form confirms your acceptance of these terms and conditions. If you do not agree, please do not submit this form to us.
              The information you give is confidential between you and YLC. We need this information to be able to assess your situation and determine whether we are a good fit for your support needs just now or whether we need to refer you to a partner agency with more experience/ specialism in your situation.
              <br>
              You agree to YLC responding / communicating with you via email.
            </p>
          ',
          'required' => 'off',
          'selected' => 'on'
        ],
        18 => ['name' => 'terms', 'type' => 'checkbox', 'question' => 'Terms and agreement', 'required' => 'on', 'selected' => 'on'],
        19 => ['name' => 'copy', 'type' => 'checkbox', 'question' => 'Would you like to receive a copy of this form by email', 'required' => 'off', 'selected' => 'on']
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add settings page
     * The page will appear in "Settings" menu dropdown
     */
    public function add_settings_page()
    {
          if ( empty ( $GLOBALS['admin_page_hooks'][static::ADMINPAGE] ) ){
              add_menu_page(
                  'YLC-Plugins',
                  static::MENU,
                  'manage_options',
                  static::ADMINPAGE,
                  [static::class,'YLC_Plugin_admin_page'],
                  'dashicons-share',
                  30
              );
          }
          add_submenu_page(
            static::ADMINPAGE,
            ucfirst(static::PAGE),
            ucfirst(static::PAGE),
            'manage_options',
            static::ADMINPAGE . '-' . static::PAGE,
            [static::class, 'create_admin_page']
          );
    }

    /**
     * Options page callback
     */
    public static function create_admin_page()
    {
        // Set class property
        if (!empty(get_option('ylc_form_list'))){
          static::$options = get_option( 'ylc_form_list' );
        } else {
          static::$options = static::$list;
        }
        ?>
        <div class="wrap">
            <h2><?= _e('Navigation ', static::LANGUAGE) . ucfirst(static::PAGE) ?></h2>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'ylc_list_group' );
                do_settings_sections( 'ylc-list-page' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'ylc_list_group', // Option group
            'ylc_form_list', // Option name
            array( $this, 'sanitize_list' ) // Sanitize
        );

        add_settings_section(
            'ylc_list_section', // ID
            'YLC List', // Title
            array($this, 'ylc_list_section' ), // Callback
            'ylc-list-page' // Page
        );
        if (!empty(get_option( 'ylc_form_list'))){
          static::$options = get_option( 'ylc_form_list' );
        } else {
          static::$options = static::$list;
        }
        $i = 0;
        foreach (static::$options as $key => $name) {
          $class = strtolower($name['name']);
          $title = static::PAGE . static::EXTENSION . '_' . $class;
          if (empty($name['selected'])) {
            $name['selected'] = 'off-test';
          }
          if (empty($name['required'])) {
            $name['required'] = 'off-test';
          }
          add_settings_field(
            $title,
            $name['name'],
            [static::class, 'addPageFunction'],
            'ylc-list-page', // Page
            'ylc_list_section',
            [
              'name' => $name['name'],
              'required' => $name['required'],
              'selected' => $name['selected'],
              'type' => $name['type'],
              'question' => $name['question'],
              'id' => $key
            ]
          );
          $i = $i + 1;
        }
    }

    /**
     * Sanitize POST data from custom settings form
     *
     * @param array $input Contains custom settings which are passed when saving the form
     */

    public function sanitize_list( $input )
    {
      return $input;
      //see sanitize html and others


      // if ($name['type'] === 'html'){
      //   $_POST[$name['name']] = esc_html( $_POST[$name['name']] );
      // }


        // $sanitized_input= array();
        // foreach ($input as $name) {
        //   $class = strtolower($name['name']);
        //   $title = static::PAGE . static::EXTENSION . '_' . $class;
        //   if( isset( $name['name'] ) )
        //       $sanitized_input[$name['name']] = sanitize_text_field( $input[$name['name']] );
        // }
        // // var_dump($sanitized_input);
        // return $sanitized_input;
    }
    /**
     * Custom settings section text
     */
    public function ylc_list_section() {
      echo 'shortcode = [YLC-' . static::PAGE . ']';
    }
    /**
     * HTML for custom setting 1 input
     */


     public static function addPageFunction($args) {
       // var_dump($args);
       // if html checkboxes = hidden
         ?>
             <input
               type="checkbox"
               class="checkbox"
               name="ylc_form_list[<?= $args['id'] ?>][selected]"
               title="<?php printf(__('To ask for %1$s', static::LANGUAGE), $args['name']) ?>"
               <?php if ($args['selected'] === 'on') {echo ' checked';} // get_option(?>
             >
           </td><td>
             <input
               type="checkbox"
               class="checkbox"
               name="ylc_form_list[<?= $args['id'] ?>][required]"
               title="<?php printf(__('To require the %1$s', static::LANGUAGE), $args['name']) ?>"
               <?php if ($args['required'] === 'on') {echo ' checked';} // get_option(?>
             >
           </td><td>
             <select name="ylc_form_list[<?= $args['id'] ?>][type]" id="type">
               <option value="textfield" <?= (($args['type'] === 'textfield') ? "selected" : null ) ?> >TextField</option>
               <option value="textarea" <?= (($args['type'] === 'textarea') ? "selected" : null ) ?> >TextArea</option>
               <option value="tel" <?= (($args['type'] === 'tel') ? "selected" : null ) ?> >Phone</option>
               <option value="email" <?= (($args['type'] === 'email') ? "selected" : null ) ?> >Email</option>
               <option value="checkbox" <?= (($args['type'] === 'checkbox') ? "selected" : null ) ?> >CheckBox</option>
               <option value="html" <?= (($args['type'] === 'html') ? "selected" : null ) ?> >HTML</option>
             </select>
           </td><td>
             <textarea name="ylc_form_list[<?= $args['id'] ?>][question]"><?= $args['question']; ?></textarea>
           </td><td>
             <textarea name="ylc_form_list[<?= $args['id'] ?>][name]"><?= $args['name']; ?></textarea>
           </td><td>
             <input type="hidden" name="ylc_form_list[<?= $args['id'] ?>][id]" value="<?= $args['id']; ?>">
         <?php
     }


     public static function YLC_Plugin_admin_page(){
       ?>
       <div class="wrap">
         <h2><?=
          __('Welcome to YLC-Plugin Page', static::LANGUAGE) . '<h2>
            <p>' .
            __('You\'ll find the different sections in the tabs', static::LANGUAGE) . '</p><br />';
           ?>
       </div>
       <?php
     }

}
