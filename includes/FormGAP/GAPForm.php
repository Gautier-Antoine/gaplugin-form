<?php
/**
 * @package GAP-Form
 */
// http://regularcoder.com/create-wordpress-settings-page-for-custom-options/

namespace FormGAP;
class GAPForm extends BaseConst
{
    /**
      * Start the GAPForm
      * instead of Constructor
      */
    public static function startup() {
        static::checkOptionsCreated();
        add_action( 'admin_menu', array( static::class, 'add_settings_page' ) );
        add_action( 'admin_init', array( static::class, 'page_init' ) );

        add_action( 'admin_enqueue_scripts', array( static::class, 'admin_form' ) );
        add_action( 'admin_enqueue_scripts', array( static::class, 'enqueue_color_picker' ) );

    }
    /**
     * Add color picker script
     */
    public function admin_form( $hook_suffix ) {
      if ( strpos( $_SERVER['REQUEST_URI'], static::ADMINPAGE . '-' . strtolower( static::PAGE ) ) !== false ) {
        // // check error mail admin_enqueue_scripts
        // wp_register_style('admin_form_gap );
        wp_enqueue_style('admin_form_gap', plugin_dir_url( __FILE__ ) . 'admin_form_gap.css');
        wp_enqueue_script( 'jquery-ui-sortable' );
        // wp_register_script('admin_form_gap_js');
        wp_enqueue_script('admin_form_gap_js', plugin_dir_url( __FILE__ ) . 'admin_form_gap_js.js' );
      }
    }
    /**
     * Add color picker script
     */
    public function enqueue_color_picker( $hook_suffix ) {
        // first check that $hook_suffix is appropriate for your admin page
        // admin
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'my-script-handle', plugin_dir_url( __FILE__ ) . 'colorPicker.js', array( 'wp-color-picker' ), false, true );
    }
    /**
     * Add settings page
     * Creating a AdminPage in the DashBoard and a SubMenuPage
     */
    public function add_settings_page()
    {
          // if the ADMINPAGE doesn't exist, create it
          if ( empty ( $GLOBALS['admin_page_hooks'][static::ADMINPAGE] ) ){
              add_menu_page(
                  'GAPlugin',
                  static::MENU,
                  'manage_options',
                  static::ADMINPAGE,
                  [static::class,'GAP_Plugin_admin_page'],
                  plugin_dir_url( __DIR__ ) . '../images/icon.svg',

                  // 'dashicons-share',
                  30
              );
          }
          // Add the SubMenuPage for the Plugin
          add_submenu_page(
            static::ADMINPAGE,
            ucfirst(static::PAGE),
            ucfirst(static::PAGE),
            'manage_options',
            static::ADMINPAGE . '-' . strtolower(static::PAGE),
            [static::class, 'create_admin_page']
          );
    }

    /**
     * Options page callback
     */
    public static function create_admin_page()
    {
        // Set class property
        // static::$options = get_option( static::OPTION );

        $tab = static::getTab();

        ?>
        <div class="wrap">
            <h2><?= _e('Navigation ', static::LANGUAGE) . ucfirst(static::PAGE) ?></h2>
            <?php
              $countKeys = 0;
              $option_name = static::getOptionName();
              $options = get_option($option_name);
              foreach ($options as $key => $value) {
                $countKeys = $countKeys + 1;
              }
              if ( !isset( $options[$tab])){
                if ( !empty( $options ) ) {
                  $adress = admin_url() . 'admin.php?page=gap-admin-page-form&tab=' . esc_attr( $key );
                  echo '<META HTTP-EQUIV=REFRESH CONTENT="1; ' . esc_attr( $adress ) . '">';
                }
                if ($key === null) {
                  echo 'empty array';
                    update_option($option_name, static::$list);
                    $adress = admin_url() . 'admin.php?page=gap-admin-page-form&tab=' . esc_attr( $key );
                    echo '<META HTTP-EQUIV=REFRESH CONTENT="1; ' . esc_attr( $adress ) . '">';
                }
              }
              if ( $countKeys > 1 ){
                echo '<nav class="form">';
                  foreach (get_option($option_name) as $key => $value){
                    $active = ($tab == $key) ? 'active' : '';
                    echo '<a href="' . admin_url() . 'admin.php?page=gap-admin-page-form&tab=' . esc_attr( $key ) . '" class="' . esc_attr( $active ) . '">Form ' . esc_attr( $key ) . '</a>';
                  }
                echo '</nav>';
              }
            ?>
            <form method="post" action="options.php" class="main">
            <?php
                submit_button( 'Add a form', 'primary small', 'submit', false );
                echo ' <input type="hidden" name="tab" value="' . esc_attr( $tab ) . '"> ';
                submit_button('Delete this form', 'delete small', 'submit', false, array(
                  'onclick' => 'return confirm("Are you sure you want to delete the form-' . esc_attr( $tab ) .'?");'
                ));

                settings_fields( 'gap_list_group' );
                do_settings_sections( 'gap-list-page' );
                submit_button( 'Add a field', 'primary small', 'submit', false );
                echo '<br>';
                submit_button( null, 'primary', 'submit', false );
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        $option_name = static::getOptionName();
        $tab = static::getTab();
        register_setting(
            'gap_list_group', // Option group
            $option_name, // Option name
            array( static::class, 'sanitize_list' ) // Sanitize
        );
        add_settings_section(
            'gap_list_section', // ID
            'GAP FORM ' . esc_attr( $tab ), // Title
            array(static::class, 'gap_list_section' ), // Callback
            'gap-list-page' // Page
        );
        // Add titles for options form

        $options = (get_option( $option_name )) ?: static::$list;
        foreach ( $options as $array => $value ) {
          if ( $array == $tab ) {
            foreach ( $value as $id => $option ) {
              if ($id === 'settings') {
                // echo 'settings found in $id<br>';
                $title = static::PAGE . static::EXTENSION . '_' . $id;
                add_settings_field(
                  $title,
                  ucfirst($id),
                  [static::class, 'SettingsPageFunction'],
                  'gap-list-page', // Page
                  'gap_list_section',
                  [
                    'email_to' => (esc_attr( $option['email_to'] )) ?: false,
                    'color' => (esc_attr( $option['color'] )) ?: false,
                    'colordark' => (esc_attr( $option['colordark'] )) ?: false,
                    'id' => $id
                  ]
                );
                add_settings_field(
                  static::PAGE . static::EXTENSION . '_titles',
                  '',
                  [static::class, 'addPageTitle'],
                  'gap-list-page', // Page
                  'gap_list_section',
                  [
                    'label_for' => 'Name',
                    'required' => 'Require',
                    'hide' => 'Hide',
                    'type' => 'Type',
                    'question' => 'Question',
                    'id' => 'ID'
                  ]
                );
              } else {
                $title = static::PAGE . static::EXTENSION . '_' . strtolower(esc_attr( $option['label_for'] ));
                add_settings_field(
                  $title,
                  esc_attr( $option['label_for'] ),
                  [static::class, 'addPageFunction'],
                  'gap-list-page', // Page
                  'gap_list_section',
                  [
                    'label_for' => $option['label_for'],
                    'required' => ($option['required']) ?: 0,
                    'hide' => ($option['hide']) ?: 0,
                    'type' => $option['type'],
                    'question' => $option['question'],
                    'id' => $id
                  ]
                );
              }
            }
          }
        }
    }

    /**
     * Sanitize POST data from custom settings form
     *
     * @param array $input Contains custom settings which are passed when saving the form
     */

    // this should be the callback function of register_setting() (last argument)
    public function sanitize_list($input) {
      $tab = static::getTab();


      $output = get_option(static::getOptionName());
      // if delete is clicked
      if ($_POST['submit'] == 'Delete this form') {
        unset($output[$_POST['tab']]);
        if ($output === []) {
          $output = static::$list;
        }
        return $output;
      }
      if ($_POST['submit'] == 'Delete') {
        unset($output[$_POST['tab']][$_POST["remove"]]);
        return $output;
      }
      // replace $output[$tab] by $valid_input
      $valid_input = []; // this will be the array of the validated settings that will be saved to the db, of course using one array for all options.
      $i = 0;
      foreach ($input as $in => $value) {
        foreach ($value as $key => $option){
          if ($key === 'settings') {
            $valid_input[$in][$key]['email_to'] = sanitize_email( $option['email_to'] );
            $valid_input[$in][$key]['color'] = sanitize_text_field( $option['color'] );
            $valid_input[$in][$key]['colordark'] = sanitize_text_field( $option['colordark'] );
          } else {
            $key = $i;
            //sanitizing the fields that doesn't change
            $valid_input[$in][$key]['label_for'] = sanitize_text_field( $option['label_for'] );
            $valid_input[$in][$key]['type'] = sanitize_text_field( $option['type'] );
            $valid_input[$in][$key]['required'] = (isset($option['required'])) ? true : false;
            $valid_input[$in][$key]['hide'] = (isset($option['hide'])) ? true : false;

            $valid_input[$in][$key]['id'] = sanitize_key( $key );
            switch ( $option['type'] ) {
              // $option['type'] where type is the key we set before in the option->'gap-form-list'
              // all the possibilities for $option['type']: html, textfield, textarea, tel, email, checkbox
                case 'html':
                  $valid_input[$in][$key]['question'] = wp_kses_post( $option['question'] );
                break;
                case 'textarea':
                    $valid_input[$in][$key]['question'] = sanitize_textarea_field( $option['question'] );
                break;
                case 'textfield':
                case 'tel':
                case 'email':
                case 'checkbox':
                  $valid_input[$in][$key]['question'] = sanitize_text_field( $option['question'] );
                break;
              }
              $i = $i + 1;
          }
        }
      }
      // if Add is clicked
      if ($_POST['submit'] == 'Add a field') {
        $valid_input[$_POST['tab']][$i] = array(
          'label_for' => 'option' . $i,
          'type' => 'textfield',
          'required' => false,
          'hide' => true,
          'id' => "$i",
          'question' => ''
        );
      }

      if ($_POST['submit'] == 'Add a form') {
        $n = 0;
        foreach ($output as $key => $value) {
          $n = $key + 1;
        }
        $ok = $n;
        $valid_input[$ok] = [
          'settings' => ['email_to' => false, 'color' => false, 'colordark' => false],
          0 => ['label_for' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => 1, 'hide' => 0],
          1 => ['label_for' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => 0, 'hide' => 0],
          2 => ['label_for' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => 1, 'hide' => 0],
          3 => ['label_for' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => 0, 'hide' => 0]
        ];
      }
      $output = array_replace($output, $valid_input);
      return $output;
    }

    /**
     * HTML for Titles in menu
     * @param array $option is the (name, required, hide, type, question, id)
     */
     public static function addPageTitle($option) {
         ?>
             <h2><?= esc_attr( $option['hide'] ) ?></h2>
           </td><td>
             <h2><?= esc_attr( $option['required'] ) ?></h2>
           </td><td>
             <h2><?= esc_attr( $option['type'] ) ?></h2>
           </td><td>
             <h2><?= esc_attr( $option['question'] ) ?></h2>
           </td><td>
             <h2><?= esc_attr( $option['label_for'] ) ?></h2>
           </td>
           <td>
             <form>
             <?php
                 echo '<input type="hidden" name="remove" value="' . esc_attr( $option['id'] ) . '">';
             ?>
             </form>
           </td>
           <td>
             <h2 style="visibility: hidden;"><?= esc_attr( $option['id'] ) ?></h2>
         <?php
     }


     /**
      * HTML for custom setting 1 input
      * @param array $option is the (name, required, hide, type, question, id)
      */
      public static function SettingsPageFunction($option) {
          $option_name = static::getOptionName();
          $tab = static::getTab();
          ?>
          </td><td>
          </td><td>

              <p>Main Color</p>
              <input width="100px" class="my-color-field" data-default-color="#0071a1" placeholder="#0071a1" name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][color]" rows="1" value="<?= esc_attr( $option['color'] ); ?>"></input>
            </td><td>
              <p>Dark Color</p>
              <input width="100px" class="my-color-field" data-default-color="#202B34" placeholder="#202B34" name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][colordark]" rows="1" value="<?= esc_attr( $option['colordark'] ); ?>"></input>
            </td><td>
                <p>Recipient Email</p>
                <input type="email" placeholder="admin@example.com" name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][email_to]" rows="1" value="<?= esc_attr( $option['email_to'] ); ?>"></input>
            </td><td>
              <input type="hidden" name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][id]" value="<?= esc_attr( $option['id'] ); ?>">
            </td>
          <?php
      }

    /**
     * HTML for custom setting 1 input
     * @param array $option is the (name, required, hide, type, question, id)
     */
     public static function addPageFunction( $option ) {
         $option_name = static::getOptionName();
         $tab = static::getTab();
         ?>
             <input
               type="checkbox"
               class="checkbox"
               name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][hide]"
               id="<?=  esc_attr( $option['label_for'] ) ?>"
               title="<?php printf(__('Hide %1$s', static::LANGUAGE), esc_attr( $option['label_for'] ) ) ?>"
               <?= ($option['hide'] == 1) ? ' checked' : '' ?>
             >
           </td><td>
             <input
               type="checkbox"
               class="checkbox"
               name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][required]"
               title="<?php printf(__('Require %1$s', static::LANGUAGE), esc_attr( $option['label_for'] ) ) ?>"
               <?= ($option['required'] == 1) ? ' checked' : '' ?>
             >
           </td><td>
             <select name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][type]" id="type">
               <option value="textfield" <?= (($option['type'] === 'textfield') ? "selected" : null ) ?> >TextField</option>
               <option value="textarea" <?= (($option['type'] === 'textarea') ? "selected" : null ) ?> >TextArea</option>
               <option value="tel" <?= (($option['type'] === 'tel') ? "selected" : null ) ?> >Phone</option>
               <option value="email" <?= (($option['type'] === 'email') ? "selected" : null ) ?> >Email</option>
               <option value="checkbox" <?= (($option['type'] === 'checkbox') ? "selected" : null ) ?> >CheckBox</option>
               <option value="html" <?= (($option['type'] === 'html') ? "selected" : null ) ?> >HTML</option>
             </select>
           </td><td>
             <textarea name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][question]" rows="1"><?= htmlspecialchars( $option['question'] ); ?></textarea>
           </td><td>
             <textarea name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][label_for]" rows="1" required><?= esc_textarea( $option['label_for'] ); ?></textarea>
           </td>
           <td>
             <form method="post" action="options.php">
             <?php
                 settings_fields( 'gap_list_group' );
                 echo '<input type="hidden" name="remove" value="' . esc_attr( $option['id'] ) . '">';
                 echo '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '">';
                 submit_button('Delete', 'delete small', 'submit', false, array(
                   'onclick' => 'return confirm("Are you sure you want to delete this entry?");'
                 ));
             ?>
             </form>
           </td>
           <td>
             <input type="hidden" name="<?= esc_attr( $option_name ) ?>[<?= esc_attr( $tab ) ?>][<?= esc_attr( $option['id'] ) ?>][id]" value="<?= esc_attr( $option['id'] ); ?>">
         <?php
     }

     /**
      * Find which form with the tab
      */
     protected static function getTab() {
         $tab = isset($_GET['tab'])  ? filter_var($_GET['tab'], FILTER_SANITIZE_NUMBER_INT) : '';
         return $tab;
     }

     /**
      * Custom settings section text (Add information about the AdminMenuPage)
      */
     public function gap_list_section() {
       $tab = static::getTab();
       echo 'shortcode = [GAP-' . static::PAGE . ' form=' . esc_attr( $tab ) . ']<br>' .
       __('If you don\'t select an email recipient, the email will be sent to the admin email from your settings.', static::LANGUAGE) . '<br>' .
       __('You can select the colors for the email.', static::LANGUAGE) . '<br>';

     }

     /**
      * HTML to show in the admin Page
      */
     public static function GAP_Plugin_admin_page() {
       ?>
       <div class="wrap">
         <h2><?=
          __('Welcome to GAPlugin Page', static::LANGUAGE) . '<h2>
          <p>' .
          __('You\'ll find the different sections in the tabs', static::LANGUAGE) . '</p><br />';
       ?>
       </div>
       <?php
     }

     public static function Deactivation() {
       flush_rewrite_rules();
     }

     public static function Activation() {
       static::checkOptionsCreated();
       flush_rewrite_rules();
     }


}
