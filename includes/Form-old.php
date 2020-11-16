<?php
namespace GAPlugin;
/**
* Class Share
* manage the social media where we can share the article in your Share ShortcodeNav
*/
class Form extends AdminPage {
  const
    /**
    * @var string name of the page
    */
    PAGE = 'form',
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
    FOLDER = 'gaplugin-form';

    public static function getfolder(){
      return plugin_dir_url( __DIR__ );
    }
  /**
  * @var array names of the share social medias and urls
  */
  public static $list = [
    // Add delete for options
      ['name' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => true, 'selected' => false],
      ['name' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => false, 'selected' => false],
      ['name' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => true, 'selected' => false],
      ['name' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => false, 'selected' => false],
      ['name' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => true, 'selected' => false],

      ['name' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => true, 'selected' => true],
      ['name' => 'phone', 'type' => 'phone', 'question' => 'Telephone Number', 'required' => true, 'selected' => false],

      ['name' => 'option1', 'type' => 'textarea', 'question' => 'What’s up? Please tell us.', 'required' => false, 'selected' => false],
      ['name' => 'option2', 'type' => 'textarea', 'question' => 'What’s the cause of the emotional pain you’re feeling deep inside? (If you don’t know, that’s ok)', 'required' => false, 'selected' => false],
      ['name' => 'option3', 'type' => 'textarea', 'question' => 'Are you aware of any addictions you may have? Could you share with us?', 'required' => false, 'selected' => false],
      ['name' => 'option4', 'type' => 'textarea', 'question' => 'Do you struggle with self-harm?', 'required' => false, 'selected' => false],
      ['name' => 'option5', 'type' => 'textarea', 'question' => 'Have you visited your doctor recently?', 'required' => false, 'selected' => false],
      ['name' => 'option6', 'type' => 'textarea', 'question' => 'Are you on any medications? If so, please share with us.', 'required' => false, 'selected' => false],
      ['name' => 'option7', 'type' => 'textarea', 'question' => 'Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions.', 'required' => false, 'selected' => false],
      ['name' => 'option8', 'type' => 'textarea', 'question' => 'Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you.', 'required' => false, 'selected' => false],
      ['name' => 'option9', 'type' => 'textarea', 'question' => 'Please share any other information you feel would be helpful to us in understanding your situation.', 'required' => false, 'selected' => false]
  ];
  public static $update_list = [];
  public static function checkOptionList(){
      if (empty('list_fields_form')) { //!get_option('list_fields_form') ||
        add_option( 'list_fields_form', static::$list );
        update_option( 'list_fields_form', static::$list );
      }
  }

  public static function register () {
      add_action('wp_enqueue_scripts', [static::class, 'registerPublicScripts']);
      add_action('admin_enqueue_scripts', [static::class, 'AdminScripts']);
      add_action('admin_init', [static::class, 'registerSettings']);
      add_action('admin_init', [static::class, 'checkOptionList']);
      add_action('admin_menu', [static::class, 'addMenu']);
      add_shortcode(static::PAGE . '-nav', [static::class, 'ShortcodeNav']);
      load_plugin_textdomain(static::LANGUAGE, false, static::FOLDER . '/languages/' );
  }

  public static function registerSettingsText () {
    // var_dump(static::$list);
    printf(
      __( 'Which Form field do you want to show to your visitors', static::LANGUAGE ) .
      '<br>Shortcode = [' . static::PAGE . '-nav]'
    );
  }

  public static function registerSettings () {
        $info = get_option('list_fields_form');
        add_settings_section(
          static::PAGE . static::EXTENSION . '_section',
          __( 'Parameters', static::LANGUAGE ),
          [static::class, 'registerSettingsText'],
          static::PAGE . static::EXTENSION
        );
        static::getExtraSettings();
        register_setting(
            static::PAGE . static::EXTENSION, // Option group
            'my_option_name', // Option name
            [static::class, 'sanitize'] // Sanitize
        );
        foreach ($info as $name){

            $class = strtolower($name['name']);
            $title = static::PAGE . static::EXTENSION . '_' . $class;

            static::$update_list[] = [
                'name' => $class,
                'required' => $name['required'],
                'selected' => $name['selected'],
                'type' => $name['type'],
                'question' => $name['question']
            ];
            add_settings_field(
              $title,
              $name['name'],
              [static::class, 'addPageFunction'],
              static::PAGE . static::EXTENSION,
              static::PAGE . static::EXTENSION . '_section',
              [
                'name' => $class,
                'required' => $name['required'],
                'selected' => $name['selected'],
                'type' => $name['type'],
                'question' => $name['question']
              ]
            );
          /*
            $class = strtolower($name['name']);
            $title = static::PAGE . static::EXTENSION . '_' . $class;
            register_setting(
              static::PAGE . static::EXTENSION,
              static::PAGE . '-' . $class// ,
              // add function check list to update []
            );
            add_settings_field(
              $title,
              $name['name'],
              [static::class, 'addPageFunction'],
              static::PAGE . static::EXTENSION,
              static::PAGE . static::EXTENSION . '_section',
              [
                // 'label for' => 'test-label' . $name['name'],
                // 'name' => 'test' . $name['name'],
                // 'value' => [
                  'class' => $class,
                  'required' => $name['required'],
                  'selected' => $name['selected'],
                  'type' => $name['type'],
                  'question' => $name['question']
                // ]
              ]
            );
            */
        }


        // foreach ($info as $name){
            // register_setting(
            //   static::PAGE . static::EXTENSION,
            //   static::PAGE . '-' . 'updated_list_for_form'
            // );

        // foreach ($info as $name){
        //     $class = strtolower($name['name']);
        //     $title = static::PAGE . static::EXTENSION . '_' . $class;
        //
        // }
        static::addButton();
        // if onclick add a row
        // var_dump(static::$update_list);


  }
  //edit to save one option
  public function sanitize($input) {

    $new_input = array();
        if( isset( $input['name'] ) )
            $new_input['name'] = absint( $input['name'] );

        if( isset( $input['type'] ) )
            $new_input['type'] = sanitize_text_field( $input['type'] );

        if( isset( $input['question'] ) )
            $new_input['question'] = sanitize_text_field( $input['question'] );
            //
            // 'required' => $name['required'],
            // 'selected' => $name['selected'],
        return $new_input;
    //
    // if (static::$update_list !== get_option( 'list_fields_form')) {
    //   update_option( 'list_fields_form', static::$update_list );
    // }
    // var_dump(static::$update_list);
    //return $lll;
       // $new_input = array();
       // if( isset( $input['id_number'] ) )
       //     $new_input['id_number'] = absint( $input['id_number'] );
       //
       // if( isset( $input['title'] ) )
       //     $new_input['title'] = sanitize_text_field( $input['title'] );
       //
       // return $new_input;
   }

  public static function addButton(){
      $text = __('Click to add an option', static::LANGUAGE);
      register_setting(
        static::PAGE . static::EXTENSION,
        static::PAGE . '-gap-showtext'
      );
      add_settings_field(
        static::PAGE . static::EXTENSION . '_gap_showtext',
        $text,
        [static::class, 'showButton'],
        static::PAGE . static::EXTENSION,
        static::PAGE . static::EXTENSION . '_section'
      );
  }

  public static function showButton() {
      ?>
        <input
          type="button"
          name="<?= static::PAGE . '-gap-showbutton' ?>"
          class="button show-button"
          title="<?php printf(__('Add', static::LANGUAGE)) ?>"
          value="<?php printf(__('Add', static::LANGUAGE)) ?>"
        >
      <?php
  }

  public static function addPageFunction($args) {
      ?>
          <input
            type="checkbox"
            class="checkbox"
            name="<?= static::PAGE . '-' . $args['name'] ?>"
            title="<?php printf(__('To ask for %1$s', static::LANGUAGE), $args['name']) ?>"
            <?php if ($args['selected'] === true) {echo ' checked';} // get_option(?>
          >
        </td><td>
          <input
            type="checkbox"
            class="checkbox"
            name="<?= static::PAGE . '-' . $args['name'] ?>"
            title="<?php printf(__('To require the %1$s', static::LANGUAGE), $args['name']) ?>"
            <?php if ($args['required'] === true) {echo ' checked';} // get_option(?>
          >
        </td><td>
          <select name="<?= static::PAGE . '-' . $args['name'] ?>" id="type">
            <option value="textfield" <?= (($args['type'] === 'textfield') ? "selected" : null ) ?> >TextField</option>
            <option value="textarea" <?= (($args['type'] === 'textarea') ? "selected" : null ) ?> >TextArea</option>
            <option value="phone" <?= (($args['type'] === 'phone') ? "selected" : null ) ?> >Phone</option>
            <option value="email" <?= (($args['type'] === 'email') ? "selected" : null ) ?> >Email</option>
            <option value="checkbox" <?= (($args['type'] === 'checkbox') ? "selected" : null ) ?> >CheckBox</option>
          </select>
        </td><td>
          <textarea name="<?= static::PAGE . '-' . $args['name'] ?>"><?= $args['question']; ?></textarea>
        </td><td>
          <textarea name="<?= static::PAGE . '-' . $args['name'] ?>"><?= $args['name']; ?></textarea>
      <?php
  }

  public static function render () {

      ?>
        <h1><?= _e('Navigation ', static::LANGUAGE) . ucfirst(static::PAGE) ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields(static::PAGE . static::EXTENSION);
            do_settings_sections(static::PAGE . static::EXTENSION);
            submit_button();
            // When submit do
            // if (static::$update_list != get_option( 'list_fields_form')) {
            //   update_option( 'list_fields_form', static::$update_list );
            // }
            ?>
        </form>
      <?php
  }

  public static function ShortcodeNav() {
      echo '<div class="' . static::PAGE . '">';

      if (!get_option(static::PAGE . '-agp-showtext')){
        echo '<div class="' . static::PAGE . '-text">';
          printf(__( 'Show this on', static::LANGUAGE ));
        echo '</div>';
      }
      foreach (static::$list as $social) {
            $class = strtolower($social['name']);
            if (isset($social['imgurl'])) {
              $img = $social['imgurl'] . get_the_post_thumbnail_url(get_the_ID(),'full');
            } else { $img = '';}
            if (isset($social['titleurl'])) {
              $title = $social['titleurl'] . get_the_title();
            } else { $title = '';}

            if (get_option(static::PAGE . '-' . $class)) {
              echo '
                <a
                  target="_blank"
                  title="' . __( 'Show this on', static::LANGUAGE ) . ' ' . $social['name'] . '"
                  href="' . $social['url'] . get_permalink() . $img . $title . '"
                >
                  <div class="' . $class . '"></div>
                </a>';
            }
        }
      echo '</div>';
  }
}
