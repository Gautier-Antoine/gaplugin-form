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
    MENU = 'GAP-Plugin',
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
  // Add && delete for options
    'settings' => ['email_to' => false, 'header_text' => false, 'color1' => false, 'color2' => false, 'colortext' => false],
    0 => [
      'label_for' => 'intro',
      'type' => 'html',
      'question' => '
<p>Our initial understanding of your situation depends on how much you are prepared to share with us. Please share as if you were explaining to someone who does not know you and has no information on your situation. This helps us to understand your situation a bit better so that we can communicate with you as relevantly and helpfully as we can.</p>
<p>We encourage you to take the time to share with us some outline information that will help us to understand your situation and respond back to you. Please try to avoid giving just \'yes\' or \'no\' answers. This is an opportunity to share with us so that we understand. We\'re listening and taking you seriously!</p>
<p><strong>*</strong> denotes a required field</p>
<p>Please read the <a href="https://yourlifecounts.org/terms-reaching-out/" target="_blank">terms and conditions</a> before reaching out to us.</p>
',
      'required' => 0,
      'hide' => 0
    ],
    1 => ['label_for' => 'yourname', 'type' => 'textfield', 'question' => 'Your Name', 'required' => 1, 'hide' => 0],
    2 => ['label_for' => 'streetaddress', 'type' => 'textfield', 'question' => 'Street Address', 'required' => 0, 'hide' => 0],
    3 => ['label_for' => 'city', 'type' => 'textfield', 'question' => 'City', 'required' => 1, 'hide' => 0],
    4 => ['label_for' => 'state', 'type' => 'textfield', 'question' => 'Province / State', 'required' => 0, 'hide' => 0],
    5 => ['label_for' => 'country', 'type' => 'textfield', 'question' => 'Country', 'required' => 1, 'hide' => 0],
    6 => ['label_for' => 'email', 'type' => 'email', 'question' => 'E-Mail Address', 'required' => 1, 'hide' => 0],
    7 => ['label_for' => 'phone', 'type' => 'tel', 'question' => 'Telephone Number', 'required' => 1, 'hide' => 0],
    8 => ['label_for' => 'option1', 'type' => 'textarea', 'question' => 'What’s up? Please tell us.', 'required' => 0, 'hide' => 0],
    9 => ['label_for' => 'option2', 'type' => 'textarea', 'question' => 'What’s the cause of the emotional pain you’re feeling deep inside? (If you don’t know, that’s ok)', 'required' => 0, 'hide' => 0],
    10 => ['label_for' => 'option3', 'type' => 'textarea', 'question' => 'Are you aware of any addictions you may have? Could you share with us?', 'required' => 0, 'hide' => 0],
    11 => ['label_for' => 'option4', 'type' => 'textarea', 'question' => 'Do you struggle with self-harm?', 'required' => 0, 'hide' => 0],
    12 => ['label_for' => 'option5', 'type' => 'textarea', 'question' => 'Have you visited your doctor recently?', 'required' => 0, 'hide' => 0],
    13 => ['label_for' => 'option6', 'type' => 'textarea', 'question' => 'Are you on any medications? If so, please share with us.', 'required' => 0, 'hide' => 0],
    14 => ['label_for' => 'option7', 'type' => 'textarea', 'question' => 'Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions.', 'required' => 0, 'hide' => 0],
    15 => ['label_for' => 'option8', 'type' => 'textarea', 'question' => 'Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you.', 'required' => 0, 'hide' => 0],
    16 => ['label_for' => 'option9', 'type' => 'textarea', 'question' => 'Please share any other information you feel would be helpful to us in understanding your situation.', 'required' => 0, 'hide' => 0],
    17 => [
      'label_for' => 'outro',
      'type' => 'html',
      'question' => '
<p>Use of the Your Life Counts online submission form confirms your acceptance of these terms and conditions. If you do not agree, please do not submit this form to us.
The information you give is confidential between you and YLC. We need this information to be able to assess your situation and determine whether we are a good fit for your support needs just now or whether we need to refer you to a partner agency with more experience/ specialism in your situation.
<br>
You agree to YLC responding / communicating with you via email.</p>
',
      'required' => 0,
      'hide' => 0
    ],
    18 => ['label_for' => 'terms', 'type' => 'checkbox', 'question' => 'Terms and agreement', 'required' => 1, 'hide' => 0],
    19 => ['label_for' => 'copy', 'type' => 'checkbox', 'question' => 'Would you like to receive a copy of this form by email?', 'required' => 0, 'hide' => 0]
]
];


}
