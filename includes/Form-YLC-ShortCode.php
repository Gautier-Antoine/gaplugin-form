<?php

class  YLCFormSC
{
  /**
   * Constructor
   */
  public function __construct()
  {
    add_shortcode( 'YLC-Form', array( $this, 'form_shortcode' ) );
  }
  /**
   * Function to call the email
   */
  function form_shortcode() {
  	ob_start();
  	$this->send_mail();
  	return ob_get_clean();
  }
  /**
   * Processing the Form
   */
  function send_mail() {
  	if ( isset( $_POST['submit'] ) ) {
      $options = get_option('ylc_form_list');
      global $reg_errors;
      $reg_errors = new WP_Error;
    // validate($name);
      foreach ($options as $key => $name){
        if (isset($name['selected'])) {
          if ($name['type'] === 'email') {
            if ( !is_email( $_POST[$name['name']] ) ) {
              $reg_errors->add( 'email_invalid', 'Email is not valid' );
            }
          }
          if (isset($name['required']) && $name['required'] === 'on'){
            if (empty($_POST[$name['name']])){
              $reg_errors->add('field', 'Required form field "' . $name['name'] . '" is missing');
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

    // sanitize($name) each field
      foreach ($options as $key => $name){
        if (isset($_POST[$name['name']])) {
          if ($name['type'] === 'textfield'){
            $_POST[$name['name']] = sanitize_text_field( $_POST[$name['name']] );
          }
          if ($name['type'] === 'textarea'){
            $_POST[$name['name']] = esc_textarea( $_POST[$name['name']] );
          }
          if ($name['type'] === 'email'){
            $_POST[$name['name']] = sanitize_email( $_POST[$name['name']] );
          }
        }
      }
      // Create the message
      $message = '';
      foreach ($options as $key => $name){
        // create message
        if (isset($name['selected']) && ($name['selected'] === 'on') && ($name['type'] != 'html') ){
          $message .= '
            ' . $name['question'] . ':
            ' . $_POST[$name['name']] . '

          ';
        }
      }


  		// get the blog administrator's email address
  		$to = get_option( 'admin_email' );
      $subject = "New form from ylc from $ yourname <$ email>";
  		$headers = "From: $ yourname <$ email>" . "\r\n";


      global $reg_errors;
  		// Check If email has been process
      if ( 1 > count( $reg_errors->get_error_messages() ) ) {
    		if ( wp_mail( $to, $subject, $message, $headers ) ) {
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
    $this->form_code();
  }

  function form_code() {
    // Style for the form
    echo '
      <style>
        div {
            margin-bottom:2px;
        }
        input{
            margin-bottom:4px;
        }
        .ga-form textarea, .ga-form input, .ga-form select {
        	width: 80%;
        	background-color: rgba(230,230,230,1);
        	padding: 5px;
        }
        .terms input{
        	width: auto !important;
        }
        div.error, div.success {
        	padding: 5px;
        	background-color: rgb(200,0,0);
        	width:auto;
        	border-radius: 4px;
        	border: 1px solid white;
          color: white;
        }
        div.success {
        	background-color: rgb(0,200,0);
        }
        div.success p {
        	margin-bottom: 0;
        }
      </style>
    ';
    // Start of the form
    echo '
      <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
    ';

    $options = get_option('ylc_form_list');
    // var_dump($options);
    // Loop array in the get_options
    foreach ($options as $key => $name){
      // var_dump($name);
      // var_dump($key);
      if (isset($name['selected'])) {
        // $name['type']: textfield, textarea, phone, email, checkbox
        if ($name['type'] === 'textfield'){
          echo '
            <div>
              <label> ' . $name['question'] . ( isset($name['required']) && ($name['required'] === 'on' ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="ylc-form ' . $name['name'] . '">
                  <input
                    type="text"
                    name="' . $name['name'] . '"
                    pattern="[a-zA-Z0-9 ]+"
                    value="' . ( isset( $_POST[$name['name']] ) ? $_POST[$name['name']] : null ) . '"
                    size="40"
                    class="validates-as-required"
                    aria-required="true"
                    aria-invalid="false"
                  >
                </span>
              </label>
            </div>
          ';
        }
        if ($name['type'] === 'textarea'){
          echo '
            <div>
              <label> ' . $name['question'] . ( isset($name['required']) && ($name['required'] === 'on' ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="ylc-form ' . $name['name'] . '">
                  <textarea
                    rows="1"
                    cols="35"
                    name="' . $name['name'] . '"
                  >
                    ' . ( isset( $_POST[$name['name']] ) ? $_POST[$name['name']] : null ) . '
                  </textarea>
                </span>
              </label>
            </div>
          ';
        }
        if ($name['type'] === 'tel' || $name['type'] === 'email'){
          echo '
            <div>
              <label> ' . $name['question'] . ( isset($name['required']) && ($name['required'] === 'on' ) ? ' <strong">*</strong>' : null ) . '
              <br>
                <span class="ylc-form ' . $name['name'] . '">
                  <input
                    type="' . $name['type'] . '"
                    name="' . $name['name'] . '"
                    value="' . ( isset( $_POST[$name['name']] ) ? $_POST[$name['name']] : null ) . '"
                    size="40"
                    class="validates-as-required"
                    aria-required="true"
                    aria-invalid="false"
                  >
                </span>
              </label>
            </div>
          ';
        }
        if ($name['type'] === 'checkbox'){
          echo '
            <div>
              <label>
              <br>
                <span class="ylc-form ' . $name['name'] . '">
                  <input
                    type="checkbox"
                    name="' . $name['name'] . '" ' . ( isset($_POST[$name['name']]) ? "checked" : null ) . '
                  >
                </span>
                 ' . $name['question'] . ( isset($name['required']) && ($name['required'] === 'on' ) ? ' <strong">*</strong>' : null ) . '
              </label>
            </div>
          ';
        }
        if ($name['type'] === 'html'){
          echo '
            <div class="' . $name['name'] . '">' . $name['question'] . '
            </div>
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
