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
      // ['name' => 'FaceBook', 'url' => 'https://www.facebook.com/sharer/sharer.php?u='],
      // ['name' => 'Twitter', 'url' => 'https://twitter.com/share?url='],
      // [
      //   'name' => 'Pinterest', 'url' => 'http://pinterest.com/pin/create/button/?url=',
      //   'imgurl' => '&amp;media=',
      //   'titleurl' => '&amp;description='
      // ],
      // ['name' => 'WhatsApp', 'url' => 'https://wa.me/?text='],
      // ['name' => 'Telegram', 'url' => 'https://t.me/share/url?url='],
      // ['name' => 'Email', 'url' => 'mailto:?body=']

      ['name' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => true, 'selected' => false],
      ['name' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => false, 'selected' => false],
      ['name' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => true, 'selected' => false],
      ['name' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => false, 'selected' => false],
      ['name' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => true, 'selected' => false],

      ['name' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => true, 'selected' => true],
      ['name' => 'phone', 'type' => 'phone', 'question' => 'Telephone Number', 'required' => true, 'selected' => false],

      ['name' => 'texttest', 'type' => 'textarea', 'question' => 'texttest area', 'required' => false, 'selected' => false]
      // CSS ready: insta,Map, Youtube, Twitch, linkedin, vimeo, github, WeChat, Tumblr, Viber, Snapchat, flipboard
  ];

  // if (!get_option(list_fields_form)) {
  //   // Create an array as an option
  //
  // $list_fields =
  //   [
  //     ['name' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => true, 'selected' => false],
  //     ['name' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => false, 'selected' => false],
  //     ['name' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => true, 'selected' => false],
  //     ['name' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => false, 'selected' => false],
  //     ['name' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => true, 'selected' => false],
  //
  //     ['name' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => true, 'selected' => false],
  //     ['name' => 'phone', 'type' => 'phone', 'question' => 'Telephone Number', 'required' => true, 'selected' => false],
  //     ['name' => 'terms', 'type' => 'checkbox', 'question' => 'I understand and agree to the terms and conditions', 'required' => true, 'selected' => false],
  //
  //   ]
  // add_option( 'list_fields_form', $list_fields );
  // }


  public static function removeExtraOptions() {
    delete_option(static::PAGE . '-gap-showtext' );
  }
  public static function getExtraSettings () {
    $text = __('Click to hide text before socials', static::LANGUAGE);
    register_setting(
      static::PAGE . static::EXTENSION,
      static::PAGE . '-gap-showtext'
    );
    add_settings_field(
      static::PAGE . static::EXTENSION . '_gap_showtext',
      $text,
      [static::class, 'showText'],
      static::PAGE . static::EXTENSION,
      static::PAGE . static::EXTENSION . '_section'
    );
  }
  public static function showText() {
      ?>
        <input
          type="checkbox"
          name="<?= static::PAGE . '-gap-showtext' ?>"
          class="checkbox show-text"
          title="<?php printf(__('Checkbox for hiding text', static::LANGUAGE)) ?>"
          <?php if (get_option(static::PAGE . '-gap-showtext')) {echo ' checked';} ?>
        >
      <?php
  }

  public static function registerSettingsText () {
    printf(
      __( 'Which Form field do you want to show to your visitors', static::LANGUAGE ) .
      '<br>Shortcode = [' . static::PAGE . '-nav]'
    );
  }




  public static function registerSettings () {
        add_settings_section(
          static::PAGE . static::EXTENSION . '_section',
          __( 'Parameters', static::LANGUAGE ),
          [static::class, 'registerSettingsText'],
          static::PAGE . static::EXTENSION
        );
        static::getExtraSettings();
        foreach (static::$list as $name){
            $class = strtolower($name['name']);
            $title = static::PAGE . static::EXTENSION . '_' . $class;
            register_setting(
              static::PAGE . static::EXTENSION,
              static::PAGE . '-' . $class
            );
            add_settings_field(
              $title,
              $name['question'],
              [static::class, 'addPageFunction'],
              static::PAGE . static::EXTENSION,
              static::PAGE . static::EXTENSION . '_section',
              ['class' => $class, 'required' => $name['required'], 'selected' => $name['selected'], 'type' => $name['type'], 'question' => $name['question']]
            );
        }
  }

// ['name' => 'phone', 'type' => 'phone', 'question' => 'Telephone Number', 'required' => true, 'selected' => false]


  public static function addPageFunction($args) {
      ?>
        <input
          type="checkbox"
          class="checkbox"
          name="<?= static::PAGE . '-' . $args['class'] ?>"
          title="<?php printf(__('To ask for %1$s', static::LANGUAGE), $args['class']) ?>"
          <?php if ($args['selected'] === true) {echo ' checked';} // get_option(?>
        >
      </td><td>
        <input
          type="checkbox"
          class="checkbox"
          name="<?= static::PAGE . '-' . $args['class'] ?>"
          title="<?php printf(__('To require the %1$s', static::LANGUAGE), $args['class']) ?>"
          <?php if ($args['required'] === true) {echo ' checked';} // get_option(?>
        >
      </td><td>
        <select name="<?= static::PAGE . '-' . $args['class'] ?>" id="type">
          <option value="textfield" <?= (($args['type'] === 'textfield') ? "selected" : null ) ?> >TextField</option>
          <option value="textarea" <?= (($args['type'] === 'textarea') ? "selected" : null ) ?> >TextArea</option>
          <option value="phone" <?= (($args['type'] === 'phone') ? "selected" : null ) ?> >Phone</option>
          <option value="email" <?= (($args['type'] === 'email') ? "selected" : null ) ?> >Email</option>
          <option value="checkbox" <?= (($args['type'] === 'checkbox') ? "selected" : null ) ?> >CheckBox</option>
        </select>
      </td><td>
        <textarea name="<?= static::PAGE . '-' . $args['class'] ?>"><?= $args['question']; ?></textarea>
      </td><td>
        <textarea name="<?= static::PAGE . '-' . $args['class'] ?>"><?= $args['class']; ?></textarea>

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
