<?php
/**
 * @package GAP-Form
 */
 namespace FormGAP;
class  GAPMail extends BaseConst
{

  /**
   * HTML for header of the email
   * @param string hexdec $color principal
   * @param string hexdec $colordark is a darker color
   */
  protected static function getHeaderEmail( $color, $colordark ) {
    $html = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "' . esc_url( "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" ) . '">
        <html xmlns:v="urn:schemas-microsoft-com:vml">
          <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
            <meta label_for="viewport" content="width=device-width; initial-scale=1.0; maximal-scale=1.0;">
            <link href="' . esc_url( "https://fonts.googleapis.com/css?family=Teko") . '" rel="stylesheet">
            <style type="text/css">
              @font-face {
                font-family: "Raleway";
                font-style: normal;
                font-weight: 100;
                src: url(' . esc_url( "https://fonts.gstatic.com/s/raleway/v18/1Ptxg8zYS_SKggPN4iEgvnHyvveLxVvao7CFPrEHJA.woff2" ) . ') format("woff2");
                unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
              }
              a {text-decoration: none !important;}
              input {color: rgba(40, 160, 255, 0.8); text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45); border: 3px solid rgba(0, 0, 0, 0.1); background-color: rgba(0, 0, 0, 0.25); width: 90%; margin-top: 15px;border-radius: 5px; font-size: 1.1em; font-weight: 600;}
              input:hover { background-color: rgba(80,120,210,1); color: rgba(0, 0, 0, 0.65);}
              span {font-size: 0.7em; vertical-align: middle;}
              body {font-family: Railway, Arial, sans-serif;}
              td a {color: #FFF;}
              footer a {color: ' . esc_attr( $colordark ) . ';}
            </style>
          </head>
          <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
            <table bgcolor="#FFF" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
              <tr>
                <td>
                  <div>
                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                      <tr>
                        <td height="10" style="font-size:10px; line-height:10px;">
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                  <td align="center" style="text-align:center; font-size:1.3em; color: ' . esc_attr( $color ) . '; mso-line-height-rule: exactly; line-height:2em;">
                                    <h2>' . esc_attr( get_bloginfo( 'name' ) ) . '
                                    <span style="font-size: 0.7em; vertical-align: middle;"><i>Form</i></span></h2>
        													</td>
        												</tr>
        										</tbody>
        									</table>

    ';
    return $html;
  }

  /**
   * HTML for header of the email
   * @param array option answered
   * @param string hexdec $color principal
   * @param string hexdec $colordark is a darker color
   */
  protected static function getMessages ($option, $color, $colordark) {
    $msg =
      '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: ' . esc_attr( $color ) . '; color: ' . esc_attr( $colordark ) . '; border-radius:5px; padding: 5px 25px; border-bottom: #3c495550 2px solid; margin-bottom: 1px;">
        <tbody>
            <tr>
              <td align="center" style="text-align: left; font-size:1.2em; color: ' . esc_attr( $colordark ) . '; mso-line-height-rule: exactly; line-height:1.6em;">
                ' . esc_attr( $option['question'] ) . ' :<br>
              </td>
            </tr>
            <tr>
              <td align="center" style="text-align: left; font-size:1.2em; color:#FFF; mso-line-height-rule: exactly; line-height:1.2em;">
                ' . esc_attr( $_POST[$option['label_for']] ) . '<br>
              </td>
            </tr>
        </tbody>
      </table>';
      return $msg;
  }

  /**
   * HTML for footer of the email
   * @param string hexdec $color principal
   * @param string hexdec $colordark is a darker color
   */
  protected static function getFooterEmail( $color, $colordark ) {
    $html = '
                          <table style="background-color: ' . esc_attr( $colordark ) . '; color: ' . esc_attr( $color ) . '; text-align: center;" width="100%"  align="center" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                  <td align="center" width="60">
                                    <br>© <a href="' . home_url( $path = '/', $scheme = 'https' ) . '" style="color: ' . esc_attr( $color ) . ';">' . esc_attr( get_bloginfo( 'name' ) ) . '</a><br><br>
                                  </td>
                                </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td height="10" style="font-size:10px; line-height:10px;">
                          &nbsp;
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </body>
      </html>
    ';
    return $html;
  }

  /**
   * HTML Style for the form
   */
  public static $FormStyle = '
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
      input[type="tel"] {
      	color: #8a8a8a;
      	background-color: #ffffff;
        border-color: #e3e0dc;
      }
      input[type="tel"] {
      	-webkit-appearance: none;
      	outline: none;
      	resize: none;
      	padding: 0.45em 0.5em;
      	border:1px solid #e3e0dc;
          -webkit-border-radius: 2px;
          -moz-border-radius: 2px;
          border-radius: 2px;
      	-webkit-box-sizing: border-box;
      	   -moz-box-sizing: border-box;
      	        box-sizing: border-box;
      	-webkit-transition: all ease .3s;
      	   -moz-transition: all ease .3s;
      	    -ms-transition: all ease .3s;
      	     -o-transition: all ease .3s;
      	        transition: all ease .3s;
      }
      input[type="tel"]:focus {
      	color: #232a34;
      	background-color: #ffffff;
        border-color: #776c6c;
      }
    </style>
  ';

}
