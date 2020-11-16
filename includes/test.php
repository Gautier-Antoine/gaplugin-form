<?php

// wp-content/themes/YourTheme/CustomSettingsPage.php
// http://regularcoder.com/create-wordpress-settings-page-for-custom-options/

class CustomSettingsPage
{
    /**
     * Array of custom settings/options
     */
    private static $options;



      const
        /**
        * @var string name of the page
        */
        PAGE = 'test',
        /**
        * @var string name of the language file
        */
        LANGUAGE = 'test-text',
        /**
        * @var string name for the files
        */
        FILE = 'test',
        /**
        * @var string name for the plugin folder
        */
        FOLDER = 'gaplugin-test',





        /**
        * @var string name for the menu
        */
        MENU = 'GAPlugin',
        /**
        * @var string name for the extension title
        */
        EXTENSION = '_menu',
        /**
        * @var string name for the admin page
        */
        ADMINPAGE = 'ga-admin-page';

    public static $list = [
      // Add delete for options
        0 => ['name' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => 'on', 'selected' => 'off'],
        1 => ['name' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => 'off', 'selected' => 'off'],
        2 => ['name' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => 'on', 'selected' => 'off'],
        3 => ['name' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => 'off', 'selected' => 'off'],
        4 => ['name' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => 'on', 'selected' => 'off'],
        5 => ['name' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => 'on', 'selected' => 'on'],
        6 => ['name' => 'phone', 'type' => 'phone', 'question' => 'Telephone Number', 'required' => 'on', 'selected' => 'off'],
        7 => ['name' => 'option1', 'type' => 'textarea', 'question' => 'What’s up? Please tell us.', 'required' => 'off', 'selected' => 'off'],
        8 => ['name' => 'option2', 'type' => 'textarea', 'question' => 'What’s the cause of the emotional pain you’re feeling deep inside? (If you don’t know, that’s ok)', 'required' => 'off', 'selected' => 'off'],
        9 => ['name' => 'option3', 'type' => 'textarea', 'question' => 'Are you aware of any addictions you may have? Could you share with us?', 'required' => 'off', 'selected' => 'off'],
        10 => ['name' => 'option4', 'type' => 'textarea', 'question' => 'Do you struggle with self-harm?', 'required' => 'off', 'selected' => 'off'],
        11 => ['name' => 'option5', 'type' => 'textarea', 'question' => 'Have you visited your doctor recently?', 'required' => 'off', 'selected' => 'off'],
        12 => ['name' => 'option6', 'type' => 'textarea', 'question' => 'Are you on any medications? If so, please share with us.', 'required' => 'off', 'selected' => 'off'],
        13 => ['name' => 'option7', 'type' => 'textarea', 'question' => 'Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions.', 'required' => 'off', 'selected' => 'off'],
        14 => ['name' => 'option8', 'type' => 'textarea', 'question' => 'Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you.', 'required' => 'off', 'selected' => 'off'],
        15 => ['name' => 'option9', 'type' => 'textarea', 'question' => 'Please share any other information you feel would be helpful to us in understanding your situation.', 'required' => 'off', 'selected' => 'off']
    ];
    public static $update_list = [];
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
        // add_options_page(
        //     'Custom Settings', // Page title
        //     'Custom Settings Page', // Title
        //     'manage_options', // Capability
        //     'custom-settings-page', // Url slug
        //     array( $this, 'create_admin_page' ) // Callback
        // );

          if ( empty ( $GLOBALS['admin_page_hooks'][static::ADMINPAGE] ) ){
              add_menu_page(
                  'GAPlugins',
                  static::MENU,
                  'manage_options',
                  static::ADMINPAGE,
                  [static::class,'GAPlugin_admin_page'],
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
        if (!empty(get_option('custom_list'))){
          static::$options = get_option( 'custom_list' );
        } else {
          static::$options = static::$list;
        }
        ?>
        <div class="wrap">
            <h2><?= _e('Navigation ', static::LANGUAGE) . ucfirst(static::PAGE) ?></h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                // settings_fields( 'custom_settings_group' );
                // do_settings_sections( 'custom-settings-page' );
                // settings_fields( 'custom_list_group' );
                // do_settings_sections( 'custom-list-page' );
                // submit_button();

                settings_fields( 'custom_list_group' );
                do_settings_sections( 'custom-list-page' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        // register_setting(
        //     'custom_settings_group', // Option group
        //     'custom_settings', // Option name
        //     array( $this, 'sanitize' ) // Sanitize
        // );
        //
        // add_settings_section(
        //     'custom_settings_section', // ID
        //     'Custom Settings', // Title
        //     array( $this, 'custom_settings_section' ), // Callback
        //     'custom-settings-page' // Page
        // );
        // add_settings_field(
        //     'custom_setting_1', // ID
        //     'Custom Setting 1', // Title
        //     array( $this, 'custom_setting1_html' ), // Callback
        //     'custom-settings-page', // Page
        //     'custom_settings_section'
        // );

        // add_settings_field(
        //     'custom_setting_2',
        //     'Custom Setting 2',
        //     array( $this, 'custom_setting2_html' ),
        //     'custom-settings-page',
        //     'custom_settings_section'
        // );


        register_setting(
            'custom_list_group', // Option group
            'custom_list', // Option name
            array( $this, 'sanitize_list' ) // Sanitize
        );

        add_settings_section(
            'custom_list_section', // ID
            'Custom List', // Title
            array($this, 'custom_list_section' ), // Callback
            'custom-list-page' // Page
        );
        if (!empty(get_option( 'custom_list'))){
          static::$options = get_option( 'custom_list' );
        } else {
          static::$options = static::$list;
        }
        // var_dump(static::$options);
        $i = 0;
        foreach (static::$options as $key => $name) {
          // var_dump($name['name']);
          // var_dump($key);
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
            'custom-list-page', // Page
            'custom_list_section',
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
    // public function sanitize( $input )
    // {
    //     $sanitized_input= array();
    //     if( isset( $input['custom_setting_1'] ) )
    //         $sanitized_input['custom_setting_1'] = sanitize_text_field( $input['custom_setting_1'] );
    //
    //     if( isset( $input['custom_setting_2'] ) )
    //         $sanitized_input['custom_setting_2'] = sanitize_text_field( $input['custom_setting_2'] );
    //
    //     return $sanitized_input;
    // }

    public function sanitize_list( $input )
    {
      return $input;
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
    // public function custom_settings_section()
    // {
    //     print('Some text');
    // }
    public function custom_list_section() {
    }
    /**
     * HTML for custom setting 1 input
     */


     public static function addPageFunction($args) {
       // var_dump($args);
         ?>
             <input
               type="checkbox"
               class="checkbox"
               name="custom_list[<?= $args['id'] ?>][selected]"
               title="<?php printf(__('To ask for %1$s', static::LANGUAGE), $args['name']) ?>"
               <?php if ($args['selected'] === 'on') {echo ' checked';} // get_option(?>
             >
           </td><td>
             <input
               type="checkbox"
               class="checkbox"
               name="custom_list[<?= $args['id'] ?>][required]"
               title="<?php printf(__('To require the %1$s', static::LANGUAGE), $args['name']) ?>"
               <?php if ($args['required'] === 'on') {echo ' checked';} // get_option(?>
             >
           </td><td>
             <select name="custom_list[<?= $args['id'] ?>][type]" id="type">
               <option value="textfield" <?= (($args['type'] === 'textfield') ? "selected" : null ) ?> >TextField</option>
               <option value="textarea" <?= (($args['type'] === 'textarea') ? "selected" : null ) ?> >TextArea</option>
               <option value="phone" <?= (($args['type'] === 'phone') ? "selected" : null ) ?> >Phone</option>
               <option value="email" <?= (($args['type'] === 'email') ? "selected" : null ) ?> >Email</option>
               <option value="checkbox" <?= (($args['type'] === 'checkbox') ? "selected" : null ) ?> >CheckBox</option>
             </select>
           </td><td>
             <textarea name="custom_list[<?= $args['id'] ?>][question]"><?= $args['question']; ?></textarea>
           </td><td>
             <textarea name="custom_list[<?= $args['id'] ?>][name]"><?= $args['name']; ?></textarea>
           </td><td>
             <input type="hidden" name="custom_list[<?= $args['id'] ?>][id]" value="<?= $args['id']; ?>">
         <?php
     }
    // public function custom_setting1_html()
    // {
    //     printf(
    //         '<input type="text" id="custom_setting_1" name="custom_settings[custom_setting_1]" value="%s" />',
    //         isset( static::$options['custom_setting_1'] ) ? esc_attr( static::$options['custom_setting_1']) : ''
    //     );
    // }
    //
    // /**
    //  * HTML for custom setting 2 input
    //  */
    // public function custom_setting2_html()
    // {
    //     printf(
    //         '<input type="text" id="custom_setting_2" name="custom_settings[custom_setting_2]" value="%s" />',
    //         isset( static::$options['custom_setting_2'] ) ? esc_attr( static::$options['custom_setting_2']) : ''
    //     );
    // }
}
