<?php
/**
 * @package GAP-Form
 * http://regularcoder.com/create-wordpress-settings-page-for-custom-options/
 */
namespace FormGAP;
class BaseConst
{

  /**
   * Return the name of the option
   */
  protected static function getOptionName() {
    if (!is_multisite()){
      $option_name = static::OPTION;
    } else {
      $option_name = static::OPTION . '_' . get_current_blog_id();
    }
    return $option_name;
  }

  /**
   * Checking if multisite and creating option
   */
  protected static function checkOptionsCreated() {
    if (!is_multisite()){
      if (empty(get_option( static::OPTION ))) {
        add_option( static::OPTION, static::$list);
      }
    } else {
      global $wpdb;
      $blogs = $wpdb->get_results("
        SELECT blog_id
        FROM {$wpdb->blogs}
        WHERE site_id = '{$wpdb->siteid}'
        AND spam = '0'
        AND deleted = '0'
        AND archived = '0'
      ");
      $original_blog_id = get_current_blog_id();
      foreach ( $blogs as $blog_id ) {
        $id = $blog_id->blog_id;
        switch_to_blog( $id );
        if (empty(get_option( static::OPTION . '_' . $id ))) {
          add_option( static::OPTION . '_' . $id, static::$list);
        }
      }
      switch_to_blog( $original_blog_id );
    }
  }

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
    FOLDER = 'gap-form-plugin',

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
    ADMINPAGE = 'gap-admin-page',

    /**
    * @var string name for the option
    */
    OPTION = 'gap_form_option',

    /**
    * @var string id of the page
    */
    IDPAGE = 'gap-form-page',
    /**
    * @var string id of the page
    */
    SECTION = 'gap_form_section';

  /**
  * @var array Basic array for the options in the admin menu
  */
  protected static $list = [
    0 => [
      'settings' => ['email_to' => false, 'color' => false, 'colordark' => false],
      0 => ['label_for' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => 1, 'hide' => 0],
      1 => ['label_for' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => 0, 'hide' => 0],
      2 => ['label_for' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => 1, 'hide' => 0],
      3 => ['label_for' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => 0, 'hide' => 0],
      4 => ['label_for' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => 1, 'hide' => 0],
      5 => ['label_for' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => 1, 'hide' => 0],
      6 => ['label_for' => 'phone', 'type' => 'tel', 'question' => 'Telephone Number', 'required' => 1, 'hide' => 0],
      7 => ['label_for' => 'message', 'type' => 'textarea', 'question' => 'Your message', 'required' => 0, 'hide' => 0],
      8 => ['label_for' => 'copy', 'type' => 'checkbox', 'question' => 'Would you like to receive a copy of this form by email?', 'required' => 0, 'hide' => 0]
    ]
  ];

}
