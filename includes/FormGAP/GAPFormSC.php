<?php
/**
 * @package GAP-Form
 */
 namespace FormGAP;
class  GAPFormSC extends GAPMail
{

  /**
    * Start the GAPFormSC
    * instead of Constructor
    */
  public static function startup() {
    $option_name = static::getOptionName();
    add_shortcode( 'GAP-Form', array( static::class, 'form_shortcode' ) );
  }

  /**
   * Function to call the email
  * @param array $atts is the array for this form
   */
  function form_shortcode($atts) {
  	ob_start();
    $tab = $atts['form'];
    static::send_mail($tab);
  	return ob_get_clean();
  }
  /**
   * Processing the Form
  * @param string $tab is the array for this form
  */
  public static function send_mail($tab) {

  	if ( isset( $_POST['submit'] ) ) {
      $option_name = static::getOptionName();
      $options = get_option( $option_name )[$tab];

      global $reg_errors;
      $reg_errors = new \WP_Error();
    // validate($option);

      foreach ($options as $key => $option){
        if (isset($option['hide'])) {
          if ($option['type'] === 'email') {
            if ( !is_email( $_POST[$option['label_for']] ) ) {
              $reg_errors->add( 'email_invalid', 'Email is not valid' );
            }
          }
          if (isset($option['required']) && $option['required'] == 1){
            if (empty($_POST[$option['label_for']])){
              $reg_errors->add('field', 'Required form field "' . $option['label_for'] . '" is missing');
            }
          }
        }
      }
      if ( is_wp_error( $reg_errors ) ) {
        //see if !empty errors
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div class="error">';
            echo '<strong>ERROR</strong>: ' . $error . '<br/>';
            echo '</div>';
        }
      }

    // sanitize($option) each field
      foreach ($options as $key => $option){
        if (isset($_POST[$option['label_for']])) {
          if ($option['type'] === 'textfield'){
            $_POST[$option['label_for']] = sanitize_text_field( $_POST[$option['label_for']] );
          }
          if ($option['type'] === 'textarea'){
            $_POST[$option['label_for']] = sanitize_textarea_field( $_POST[$option['label_for']] );
          }
          if ($option['type'] === 'email'){
            $_POST[$option['label_for']] = sanitize_email( $_POST[$option['label_for']] );
          }
        }
      }
      // Create the message

      // Get the settings
      $message = '';
      $to = '';
      $color = '';
      $colordark = '';
      foreach ($options as $key => $option){
        if ($key === 'settings') {
          $to = $option['email_to'];
          $color = $option['color'];
          $colordark = $option['colordark'];
        }
      }
  		$color = ( empty( $color ) ) ? '#0071a1' : $color;
  		$colordark = ( empty( $colordark ) ) ? '#202B34' : $colordark;
      $to = ( empty( $to ) ) ? get_option( 'admin_email' ) : $to;

      foreach ($options as $key => $option){
        // create message
        if (isset($option['hide']) && ($key !== 'settings') && ($option['hide'] == 0) && ($option['type'] != 'html') && !empty($_POST[$option['label_for']])){
          $message .= static::getMessages($option, $color, $colordark);
        }
      }
      $message = static::getHeaderEmail( $color, $colordark ) . $message . static::getFooterEmail( $color, $colordark );
  		// get the blog administrator's email address
      if (isset($_POST['yourname']) && isset($_POST['email'])){
        $postName = sanitize_text_field( $_POST['yourname'] );
        $postEmail = sanitize_email( $_POST['email'] );;
        $from_user = $postName . ' <' . $postEmail . '>';
      } else {
        $from_user = esc_url( $_SERVER['REQUEST_URI'] );
      }
      $subject = 'New form from GAP: ' . $from_user;
      // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  		$headers = array('Content-Type: text/html; charset=UTF-8; From: GAP-Form <' . $to . '> ');
      // echo '<pre>' . $message . '</pre';
      // exit;
      global $reg_errors;
  		// Check If email has been process
      if ( 1 > count( $reg_errors->get_error_messages() ) ) {
    		if ( wp_mail( $to, $subject, $message, $headers ) ) { // wp_mail( $to, $subject, $message, $headers = '', $attachments = array() )
    			echo '<div class="success">';
    			echo '<p><strong>SUCCESS</strong>: Thanks for contacting us, expect a response soon.</p>';
    			echo '</div>';
    		} else {
          echo '<div class="error">';
    			echo '<strong>ERROR</strong>: An unexpected error occurred';
    			echo '</div>';
    		}
      }
  	}
    // Call the Form
    static::form_code($tab);
  }
  /**
   * Create the HTML for the form
   * @param string $tab is the array for this form
   */
  public static function form_code($tab) {
    // Style for the form
    echo static::$FormStyle;
    // Start of the form
    echo '
      <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
    ';
    $option_name = static::getOptionName();
    // Access the part from the form array with $tab
    $options = get_option( $option_name )[$tab];
    // Loop array in the get_options
    foreach ($options as $key => $option){
      // var_dump($option);
      // var_dump($key);



      if ( !$option['hide'] == 1 ) {
        if (isset($_POST[$option['label_for']])) {
          if ($option['type'] === 'textfield'){
            $sanitizedLabel = sanitize_text_field( $_POST[$option['label_for']] );
          }
          if ($option['type'] === 'textarea'){
            $sanitizedLabel = sanitize_textarea_field( $_POST[$option['label_for']] );
          }
          if ($option['type'] === 'email'){
            $sanitizedLabel = sanitize_email( $_POST[$option['label_for']] );
          }
        }
      // if (!isset($option['hide'])) {
        // all the values for $option['type']: html, textfield, textarea, tel, email, checkbox
        if ($option['type'] === 'textfield'){
          echo '
            <div>
              <label> ' . esc_attr( $option['question'] ) . ( isset($option['required']) && ($option['required'] == 1 ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="gap-form ' . esc_attr( $option['label_for'] ) . '">
                  <input
                    type="text"
                    name="' . $option['label_for'] . '"
                    pattern="[a-zA-Z0-9 ]+"
                    value="' . ( isset( $sanitizedLabel ) ? esc_attr( $sanitizedLabel ) : null ) . '"
                    size="40"
                    class="validates-as-required"
                    aria-required="true"
                    aria-invalid="false"
                    ' . ( isset($option['required']) && ($option['required'] == 1 ) ? ' required' : null ) . '
                  >
                </span>
              </label>
            </div>
          ';
        }
        if ($option['type'] === 'textarea'){
          echo '
            <div>
              <label> ' . esc_attr( $option['question'] ) . ( isset($option['required']) && ($option['required'] == 1 ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="gap-form ' . esc_attr( $option['label_for'] ) . '">
                  <textarea
                    rows="1"
                    cols="35"
                    name="' . $option['label_for'] . '"
                    ' . ( isset($option['required']) && ($option['required'] == 1 ) ? ' required' : null ) . '
                  >' . ( isset( $sanitizedLabel ) ? esc_attr( $sanitizedLabel ) : null ) . '</textarea>
                </span>
              </label>
            </div>
          ';
        }
        if ($option['type'] === 'tel' || $option['type'] === 'email'){
          if ($option['type'] === 'tel') {
            $pattern = '^[0-9-+\s()]*$';
          } else {
            $pattern = '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$';
          }
          echo '
            <div>
              <label> ' . esc_attr( $option['question'] ) . ( isset($option['required']) && ($option['required'] == 1 ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="gap-form ' . esc_attr( $option['label_for'] ) . '">
                  <input
                    type="' . esc_attr( $option['type'] ) . '"
                    name="' . esc_attr( $option['label_for'] ) . '"
                    value="' . ( isset( $sanitizedLabel ) ? esc_attr( $sanitizedLabel ) : null ) . '"
                    pattern="' . $pattern . '"
                    size="40"
                    class="validates-as-required"
                    aria-required="true"
                    aria-invalid="false"
                    ' . ( isset($option['required']) && ($option['required'] == 1 ) ? ' required' : null ) . '
                  >
                </span>
              </label>
            </div>
          ';
        }
        if ($option['type'] === 'checkbox'){
          echo '
            <div>
              <label>
              <br>
                <span class="gap-form ' . esc_attr( $option['label_for'] ) . '">
                  <input
                    type="checkbox"
                    name="' . $option['label_for'] . '"
                    ' . ( isset( $sanitizedLabel ) ? 'checked' : null ) . '
                    ' . ( isset($option['required']) && ($option['required'] == 1 ) ? ' required' : null ) . '
                  >
                </span>
                 ' . esc_attr( $option['question'] ) . ( isset($option['required']) && ($option['required'] == 1 ) ? ' <strong">*</strong>' : null ) . '
              </label>
            </div>
          ';
        }
        if ($option['type'] === 'html'){
          echo '
            <div class="' . esc_attr( $option['label_for'] ) . '">' . wp_kses_post( $option['question'] ) . '</div>
          ';
        }
      }
    }
    echo '
          <br>
          <input type="submit" name="submit" value="Send"/>
      </form>
    ';
  }

}
