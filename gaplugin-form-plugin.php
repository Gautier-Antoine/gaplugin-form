<?php
/*
Plugin Name: Form-GA
Plugin URI: https://github.com/Pepite61/gaplugin-form
Description: Form for the website
Version: 0.00.01
Requires at least: 5.2
Requires PHP: 7.2
Author: GAUTIER Antoine
Author URI: gautierantoine.com
Text Domain: form-text
Domain Path: /languages
License:     GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
Form-GA is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.
Form-GA is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with DarkMode-GA.
If not, see https://www.gnu.org/licenses/gpl-3.0.en.html.
*/

  // defined('ABSPATH') or die('You cannot enter');
  // add_filter(
  //   'rest_authentication_errors',
  //   function( $result ) {
  //     if ( true === $result || is_wp_error( $result ) ) {
  //         return $result;
  //     }
  //     if ( ! is_user_logged_in() ) {
  //         return new WP_Error(
  //             'rest_not_logged_in',
  //             __( 'You are not currently logged in', 'form-text' ),
  //             array( 'status' => 401 )
  //         );
  //     }
  //     return $result;
  //   }
  // );
  // if (!class_exists('GAPlugin\AdminPage')){
  //   require_once 'includes/AdminPage.php';
  // }
  // require_once 'includes/Form.php';
  //
  //
  // register_uninstall_hook( __FILE__, ['GAPlugin\Form', 'removeOptions']);
  //
  // add_action(
  //   'init',
  //   function () {
  //     GAPlugin\Form::register();
  //   }
  // );

function form_code() {

  global $whatsup_q, $cause_q, $addictions_q, $selfharm_q, $doctor_q, $medication_q, $counselling_q, $support_q, $information_q;
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
      	border-radius: 3px;
      	border: 1px solid white;
      }
      div.success {
      	background-color: rgb(0,200,0);
      }
    </style>
  ';
  echo '

    <p>Our initial understanding of your situation depends on how much you are prepared to share with us. Please share as if you were explaining to someone who does not know you and has no information on your situation. This helps us to understand your situation a bit better so that we can communicate with you as relevantly and helpfully as we can.</p>

    <p>We encourage you to take the time to share with us some outline information that will help us to understand your situation and respond back to you. Please try to avoid giving just \'yes\' or \'no\' answers. This is an opportunity to share with us so that we understand. We\'re listening and taking you seriously!</p>
    <p><strong>*</strong> denotes a required field</p>

    <p>Please read the <a href="https://yourlifecounts.org/terms-reaching-out/" target="_blank">terms and conditions</a> before reaching out to us.</p>


    <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
        <h2>Name</h2>
        <div>
          <label> Your Name <strong">*</strong><br>
            <span class="ga-form yourname">
              <input type="text" name="yourname" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['yourname'] ) ? $_POST['yourname'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>

        <h2>Adress</h2>
        <div>
          <label> Street Address <br>
            <span class="ga-form streetaddress">
              <input type="text" name="streetaddress" value="' . ( isset( $_POST['streetaddress'] ) ? $_POST['streetaddress'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> City <strong">*</strong><br>
            <span class="ga-form city">
              <input type="text" name="city" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST['city'] ) ? $_POST['city'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Province/State <br>
            <span class="ga-form state">
              <input type="text" name="state" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['state'] ) ? $_POST['state'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Country <strong">*</strong><br>
            <span class="ga-form country">
              <input type="text" name="country" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST['country'] ) ? $_POST['country'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>

        <h2>Contact Information</h2>
        <div>
          <label> E-Mail Address <strong">*</strong><br>
            <span class="ga-form email">
              <input type="email" name="email" value="' . ( isset( $_POST['email'] ) ? $_POST['email'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Telephone Number <strong">*</strong><br>
            <span class="ga-form phone">
              <input type="tel" name="phone" value="' . ( isset( $_POST['phone'] ) ? $_POST['phone'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>


        <h2>Personal Information</h2>

        <div>
          <label> Gender <br>
            <span class="ga-form gender">
              <select name="gender" id="gender">
                <option value="notanswered" ' . ( ($_POST['gender'] === "notanswered") ? "selected" : null ) . '>Prefer Not to answer</option>
                <option value="male" ' . ( ($_POST['gender'] === "male") ? "selected" : null ) . '>Male</option>
                <option value="female" ' . ( ($_POST['gender'] === "female") ? "selected" : null ) . '>Female</option>
                <option value="transgender" ' . ( ($_POST['gender'] === "transgender") ? "selected" : null ) . '>Trans Gender</option>
                <option value="genderqueer" ' . ( ($_POST['gender'] === "genderqueer") ? "selected" : null ) . '>Genderqueer</option>
                <option value="genderless" ' . ( ($_POST['gender'] === "genderless") ? "selected" : null ) . '>Genderless</option>
                <option value="nonbinary" ' . ( ($_POST['gender'] === "nonbinary") ? "selected" : null ) . '>Non Binary</option>
                <option value="other" ' . ( ($_POST['gender'] === "other") ? "selected" : null ) . '>Other</option>
              </select>
            </span>
          </label>
        </div>
        <div>
          <label> Age Range (e.g. 20-30) <br>
            <span class="ga-form age">
              <input type="text" name="age" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['age'] ) ? $_POST['age'] : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>


        <h2>Situation Information</h2>

        <div>
          <label> ' . $whatsup_q . ' <br>
            <span class="ga-form whatsup">
              <textarea rows="1" cols="35" name="whatsup">' . ( isset( $_POST["whatsup"] ) ? $_POST["whatsup"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $cause_q . ' <br>
            <span class="ga-form cause">
              <textarea rows="1" cols="35" name="cause">' . ( isset( $_POST["cause"] ) ? $_POST["cause"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $addictions_q . ' <br>
            <span class="ga-form addictions">
              <textarea rows="1" cols="35" name="addictions">' . ( isset( $_POST["addictions"] ) ? $_POST["addictions"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $selfharm_q . ' <br>
            <span class="ga-form selfharm">
              <textarea rows="1" cols="35" name="selfharm">' . ( isset( $_POST["selfharm"] )? $_POST["selfharm"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $doctor_q . ' <br>
            <span class="ga-form doctor">
              <textarea rows="1" cols="35" name="doctor">' . ( isset( $_POST["doctor"] ) ? $_POST["doctor"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $medication_q . ' <br>
            <span class="ga-form medication">
              <textarea rows="1" cols="35" name="medication">' . ( isset( $_POST["medication"] ) ? $_POST["medication"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $counselling_q . ' <br>
            <span class="ga-form counselling">
              <textarea rows="1" cols="35" name="counselling">' . ( isset( $_POST["counselling"] ) ? $_POST["counselling"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $support_q . ' <br>
            <span class="ga-form support">
              <textarea rows="1" cols="35" name="support">' . ( isset( $_POST["support"] ) ? $_POST["support"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <div>
          <label> ' . $information_q . ' <br>
            <span class="ga-form information">
              <textarea rows="1" cols="35" name="information">' . ( isset( $_POST["information"] ) ? $_POST["information"] : null ) . '</textarea>
            </span>
          </label>
        </div>
        <p>
        Use of the Your Life Counts online submission form confirms your acceptance of these terms and conditions. If you do not agree, please do not submit this form to us.
        The information you give is confidential between you and YLC. We need this information to be able to assess your situation and determine whether we are a good fit for your support needs just now or whether we need to refer you to a partner agency with more experience/ specialism in your situation. You agree to YLC responding / communicating with you via email.
        </p>
        <div>
          <label>
            <span class="ga-form terms">
              <input type="checkbox" name="terms" ' . ( isset($_POST['terms']) ? "checked" : null ) . '>
            </span>
            I understand and agree to the terms and conditions
          </label>
        </div>
        <br>
        <input type="submit" name="submit" value="Send"/>
    </form>
  ';
}
function send_mail() {


  global $whatsup_q, $cause_q, $addictions_q, $selfharm_q, $doctor_q, $medication_q, $counselling_q, $support_q, $information_q;

  $whatsup_q = "What's up? Please tell us.";
  $cause_q = "What's the cause of the emotional pain you’re feeling deep inside? (If you don't know, that's ok)";
  $addictions_q = "Are you aware of any addictions you may have? Could you share with us?";
  $selfharm_q = "Do you struggle with self-harm?";
  $doctor_q = "Have you visited your doctor recently?";
  $medication_q = "Are you on any medications? If so, please share with us.";
  $counselling_q = "Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions.";
  $support_q = "Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you.";
  $information_q = "Please share any other information you feel would be helpful to us in understanding your situation.";

  // if the submit button is clicked, send the email
	if ( isset( $_POST['submit'] ) ) {

    validation_form(
      $_POST["yourname"],
      $_POST["terms"],
      $_POST["email"],
      $_POST["phone"],
      $_POST["city"],
      $_POST["country"]
      // $yourname, $terms, $email, $phone, $city, $country
    );
		// sanitize form values
    global $yourname, $streetaddress, $city, $state, $country, $email, $phone, $gender, $age, $whatsup, $cause, $addictions, $selfharm, $doctor, $medication, $counselling, $support, $information, $terms;


		$yourname    = sanitize_text_field( $_POST["yourname"] );
		$streetaddress  = sanitize_text_field( $_POST["streetaddress"] );
		$city    = sanitize_text_field( $_POST["city"] );
		$state    = sanitize_text_field( $_POST["state"] );
		$country    = sanitize_text_field( $_POST["country"] );
		$email   = sanitize_email( $_POST["email"] );
		$phone    = sanitize_text_field( $_POST["phone"] );

    $gender = sanitize_text_field( $_POST["gender"] );
    $age = sanitize_text_field( $_POST["age"] );

    $whatsup = esc_textarea( $_POST["whatsup"] );
    $cause = esc_textarea( $_POST["cause"] );
    $addictions = esc_textarea( $_POST["addictions"] );
    $selfharm = esc_textarea( $_POST["selfharm"] );
    $doctor = esc_textarea( $_POST["doctor"] );
    $medication = esc_textarea( $_POST["medication"] );
    $counselling = esc_textarea( $_POST["counselling"] );

    $support = esc_textarea( $_POST["support"] );
    $information = esc_textarea( $_POST["information"] );
    $terms = $_POST["terms"];



//    $message = "test";
    $message = '
      Name: ' . $yourname . '
      Street Adress: ' . $streetaddress . '
      City: ' . $city . '
      State: ' . $state . '
      Country: ' . $country . '
      Email: ' . $email . '
      Phone: ' . $phone . '
      Gender: ' . $gender . '
      Age: ' . $age . '

      - ' . $whatsup_q . ':
      ' . $whatsup . '

      - ' . $cause_q . ':
      ' . $cause . '

      - ' . $addictions_q . ':
      ' . $addictions . '

      - ' . $selfharm_q . ':
      ' . $selfharm . '

      - ' . $doctor_q . ':
      ' . $doctor . '

      - ' . $medication_q . ':
      ' . $medication . '

      - ' . $counselling_q . ':
      ' . $counselling . '

      - ' . $support_q . ':
      ' . $support . '

      - ' . $information_q . ':
      ' . $information . '
    ';

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );
    $subject = "New form from ylc from $yourname <$email>";
		$headers = "From: $yourname <$email>" . "\r\n";

    global $reg_errors;
		// If email has been process for sending, display a success message
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
  		if ( wp_mail( $to, $subject, $message, $headers ) ) {
  			echo '<div class="success">';
  			echo '<p>Thanks for contacting me, expect a response soon.</p>';
  			echo '</div>';
  		} else {
        echo '<div class="error">';
  			echo 'An unexpected error occurred';
  			echo '</div>';
  		}
    }
	}
  form_code();
}


function validation_form($yourname, $terms, $email, $phone, $city, $country){
  global $reg_errors;
  $reg_errors = new WP_Error;
  if ( empty( $terms ) ){
    $reg_errors->add('terms', 'You need to accept the terms and agreement');
  }
  if ( empty( $yourname ) || empty( $email ) || empty( $phone ) || empty( $city ) || empty( $country ) ) {
    $reg_errors->add('field', 'Required form field is missing');
  }
  if ( 2 > strlen( $yourname ) ) {
      $reg_errors->add( 'username_length', 'Your name is too short. At least 3 characters is required' );
  }
  if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
  }
  if ( is_wp_error( $reg_errors ) ) {
    //see if !empty errors
    foreach ( $reg_errors->get_error_messages() as $error ) {
        echo '<div class="error">';
        echo '<strong>ERROR</strong>: ' . $error . '<br/>';
        echo '</div>';
    }
  }
}


function form_shortcode() {
	ob_start();
	send_mail();
//	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'ylc_contact_form', 'form_shortcode' );
