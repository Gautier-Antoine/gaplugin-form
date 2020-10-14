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
  //
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




function html_form_code() {
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
    </style>
  ';

  echo '
    <p>We encourage you to take the time to share with us some outline information that will help us to understand your situation and respond back to you.
    Please try to avoid giving just \'yes\' or \'no\' answers.
    This is an opportunity to share with us so that we understand.
    We\'re listening and taking you seriously!</p>
    <p>* denotes a required field</p>
    <p>Please read the terms and conditions before reaching out to us.</p>

    <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
        <h2>Name</h2>
        <div>
          <label> Your Name <strong">*</strong><br>
            <span class="ga-form yourname">
              <input type="text" name="yourname" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['yourname'] ) ? $yourname : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>

        <h2>Adress</h2>
        <div>
          <label> Street Address <br>
            <span class="ga-form streetaddress">
              <input type="text" name="streetaddress" value="' . ( isset( $_POST['streetaddress'] ) ? $streetaddress : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> City <strong">*</strong><br>
            <span class="ga-form city">
              <input type="text" name="city" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST['city'] ) ? $city : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Province/State <br>
            <span class="ga-form state">
              <input type="text" name="state" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['state'] ) ? $state : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Country <strong">*</strong><br>
            <span class="ga-form country">
              <input type="text" name="country" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST['country'] ) ? $country : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>

        <h2>Contact Information</h2>
        <div>
          <label> E-Mail Address <strong">*</strong><br>
            <span class="ga-form email">
              <input type="email" name="email" value="' . ( isset( $_POST['email'] ) ? $email : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>
        <div>
          <label> Telephone Number <strong">*</strong><br>
            <span class="ga-form phone">
              <input type="tel" name="phone" value="' . ( isset( $_POST['phone'] ) ? $phone : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>


        <h2>Personal Information</h2>

        <div>
          <label> Gender <br>
            <span class="ga-form gender">
              <select name="gender" id="gender">
                <option value="notanswered">Prefer Not to answer</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="transgender">Trans Gender</option>
                <option value="genderqueer">Genderqueer</option>
                <option value="genderless">Genderless</option>
                <option value="nonbinary">Non Binary</option>
                <option value="other">Other</option>
              </select>
            </span>
          </label>
        </div>
        <div>
          <label> Age Range (e.g. 20-30) <br>
            <span class="ga-form age">
              <input type="text" name="age" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST['age'] ) ? $age : null ) . '" size="40" class="validates-as-required" aria-required="true" aria-invalid="false">
            </span>
          </label>
        </div>


        <h2>Situation Information</h2>

        <div>
          <label> What\'s up? Please tell us. <br>
            <span class="ga-form whatsup">
              <textarea rows="1" cols="35" name="whatsup">' . ( isset( $_POST["whatsup"] ) ? esc_attr( $_POST["whatsup"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> What\'s the cause of the emotional pain you’re feeling deep inside? (If you don\'t know, that\'s ok) <br>
            <span class="ga-form cause">
              <textarea rows="1" cols="35" name="cause">' . ( isset( $_POST["cause"] ) ? esc_attr( $_POST["cause"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Are you aware of any addictions you may have? Could you share with us? <br>
            <span class="ga-form addictions">
              <textarea rows="1" cols="35" name="addictions">' . ( isset( $_POST["addictions"] ) ? esc_attr( $_POST["addictions"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Do you struggle with self-harm? <br>
            <span class="ga-form selfharm">
              <textarea rows="1" cols="35" name="selfharm">' . ( isset( $_POST["selfharm"] ) ? esc_attr( $_POST["selfharm"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Have you visited your doctor recently? <br>
            <span class="ga-form doctor">
              <textarea rows="1" cols="35" name="doctor">' . ( isset( $_POST["doctor"] ) ? esc_attr( $_POST["doctor"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Are you on any medications? If so, please share with us. <br>
            <span class="ga-form medication">
              <textarea rows="1" cols="35" name="medication">' . ( isset( $_POST["medication"] ) ? esc_attr( $_POST["medication"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Have you had or are you having professional counselling or psychotherapy? Please also let us know if you are currently having these sessions. <br>
            <span class="ga-form counselling">
              <textarea rows="1" cols="35" name="counselling">' . ( isset( $_POST["counselling"] ) ? esc_attr( $_POST["counselling"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Who do you have around you in terms of support, family, and friends? Please describe what this all looks like to you. <br>
            <span class="ga-form support">
              <textarea rows="1" cols="35" name="support">' . ( isset( $_POST["support"] ) ? esc_attr( $_POST["support"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <div>
          <label> Please share any other information you feel would be helpful to us in understanding your situation. <br>
            <span class="ga-form information">
              <textarea rows="1" cols="35" name="information">' . ( isset( $_POST["information"] ) ? esc_attr( $_POST["information"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>





        Use of the Your Life Counts online submission form confirms your acceptance of these terms and conditions. If you do not agree, please do not submit this form to us.

        The information you give is confidential between you and YLC. We need this information to be able to assess your situation and determine whether we are a good fit for your support needs just now or whether we need to refer you to a partner agency with more experience/ specialism in your situation. You agree to YLC responding / communicating with you via email.


        <div>
          <label> I understand and agree to the terms and conditions
            <span class="ga-form terms">
              <input type="checkbox" name="terms">' . ( isset( $_POST["terms"] ) ? esc_attr( $_POST["terms"] ) : '' ) . '</textarea>
            </span>
          </label>
        </div>

        <input type="submit" name="submit" value="Send"/>
    </form>
  ';


/*
echo '
  <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
  <div>
  <label for="username">Username <strong>*</strong></label>
  <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
  </div>

  <div>
  <label for="email">Email <strong>*</strong></label>
  <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
  </div>

  <div>
  <label for="firstname">First Name</label>
  <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
  </div>

  <div>
  <label for="website">Last Name</label>
  <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
  </div>

  <div>
  <label for="bio">About / Bio</label>
  <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
  </div>
  <input type="submit" name="submit" value="Register"/>
  </form>
';

	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
  <p>
  Your Name (required) <br/>
  <input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />
  </p>
  <p>
  Your Email (required) <br/>
  <input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />
  </p>
  <p>
  Subject (required) <br/>
  <input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Your Message (required) <br/>';
	echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="cf-submitted" value="Send"></p>';
	echo '</form>';
}
*/
function deliver_mail() {
  // if the submit button is clicked, send the email
	if ( isset( $_POST['submit'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["yourname"] );
		$email   = sanitize_email( $_POST["email"] );









		$subject = sanitize_text_field( $_POST["cfsubject"] );
		$message = esc_textarea( $_POST["cf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
  /*
	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$subject = sanitize_text_field( $_POST["cf-subject"] );
		$message = esc_textarea( $_POST["cf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
  */
}

function cf_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );
























/*



function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ) {
    echo '
    <style>
    div {
        margin-bottom:2px;
    }

    input{
        margin-bottom:4px;
    }
    </style>
    ';

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="username">Username <strong>*</strong></label>
    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
    </div>

    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>

    <div>
    <label for="firstname">First Name</label>
    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
    </div>

    <div>
    <label for="website">Last Name</label>
    <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
    </div>

    <div>
    <label for="bio">About / Bio</label>
    <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
    </div>
    <input type="submit" name="submit" value="Register"/>
    </form>
    ';
}


function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio )  {
	global $reg_errors;
	$reg_errors = new WP_Error;
	if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
	}
	if ( 4 > strlen( $username ) ) {
	    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
	}
	// if ( username_exists( $username ) ) {
	// 		$reg_errors->add('user_name', 'Sorry, that username already exists!');
	// }
	if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
	}
	// if ( 5 > strlen( $password ) ) {
  //     $reg_errors->add( 'password', 'Password length must be greater than 5' );
  // }
	if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
	}
	// if ( email_exists( $email ) ) {
	//     $reg_errors->add( 'email', 'Email Already in use' );
	// }
	// if ( ! empty( $website ) ) {
	//     if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
	//         $reg_errors->add( 'website', 'Website is not a valid URL' );
	//     }
	// }
	if ( is_wp_error( $reg_errors ) ) {

    foreach ( $reg_errors->get_error_messages() as $error ) {

        echo '<div>';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';

    }

	}

}




function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   $nickname,
        'description'   =>   $bio,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
    }
}



function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['website'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['nickname'],
        $_POST['bio']
        );

        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $nickname   =   sanitize_text_field( $_POST['nickname'] );
        $bio        =   esc_textarea( $_POST['bio'] );

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio
        );
    }

    registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $nickname,
        $bio
        );
}


// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );

// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

?>
