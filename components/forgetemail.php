<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

 $mail = new PHPMailer(true);
 $link = "http://localhost/hotelbahia/resetpass.php?email=$email";
 
 try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hotelbahiasubic00@gmail.com';
    $mail->Password = 'tmdwkeufaywvgbdo';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, 'Hotel Bahia');
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset';
    $mail->Body = "
    <html>
    <head>
      <meta charset=\"utf-8\">
      <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
      <title>Password Reset</title>
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
      <style type=\"text/css\">
      /**
       * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
       */
      @media screen {
        @font-face {
          font-family: 'Source Sans Pro';
          font-style: normal;
          font-weight: 400;
          src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
        }
        @font-face {
          font-family: 'Source Sans Pro';
          font-style: normal;
          font-weight: 700;
          src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
        }
      }
      /**
       * Avoid browser level font resizing.
       * 1. Windows Mobile
       * 2. iOS / OSX
       */
      body{
        background: url(https://i.ibb.co/CQpdCwh/admin.png);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
      }
    
      body,
      table,
      td,
      a {
        -ms-text-size-adjust: 100%; /* 1 */
        -webkit-text-size-adjust: 100%; /* 2 */
      }
      /**
       * Remove extra space added to tables and cells in Outlook.
       */
      table,
      td {
        mso-table-rspace: 0pt;
        mso-table-lspace: 0pt;
      }
      /**
       * Better fluid images in Internet Explorer.
       */
      img {
        -ms-interpolation-mode: bicubic;
      }
      /**
       * Remove blue links for iOS devices.
       */
      a[x-apple-data-detectors] {
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        color: inherit !important;
        text-decoration: none !important;
      }
      /**
       * Fix centering issues in Android 4.4.
       */
      div[style*=\"margin: 16px 0;\"] {
        margin: 0 !important;
      }
      body {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      /**
       * Collapse table borders to avoid space between cells.
       */
      table {
        border-collapse: collapse !important;
      }
      img {
        height: auto;
        line-height: 100%;
        text-decoration: none;
        border: 0;
        outline: none;
      }
      a {
        color:rgb(255, 128, 0);
        text-decoration: none;
      }
      .contact a i{
       color:rgb(238, 107, 107);
       transition: .1s linear;
      }
      
      </style>
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css\">
    </head>
    <body style=\"background-color: #e9ecef;\">
    
      <!-- start preheader -->
      <div class=\"preheader\" style=\"display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;\">
        Hotel Bahia Email verification&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </div>
      <!-- end preheader -->
    
      <!-- start body -->
      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
    
        <!-- start logo -->
        <tr>
          <td align=\"center\">
            <!--[if (gte mso 9)|(IE)]>
            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">
            <tr>
            <td align=\"center\" valign=\"top\" width=\"600\">
            <![endif]-->
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
              <tr>
                <td align=\"center\" valign=\"top\" style=\"padding: 36px 24px;\">
                  </a>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
          </td>
        </tr>
        <!-- end logo -->
    
        <!-- start hero -->
        <tr>
          <td align=\"center\">
            <!--[if (gte mso 9)|(IE)]>
            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">
            <tr>
            <td align=\"center\" valign=\"top\" width=\"600\">
            <![endif]-->
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
              <tr>
                <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;\">
                  <h1 style=\"text-align:center; margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;\">Password Reset</h1>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
          </td>
        </tr>
        <!-- end hero -->
    
        <!-- start copy block -->
        <tr>
          <td align=\"center\">
            <!--[if (gte mso 9)|(IE)]>
            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">
            <tr>
            <td align=\"center\" valign=\"top\" width=\"600\">
            <![endif]-->
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
    
              <!-- start copy -->
              <tr>
                <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;\">
                  <p style=\"margin: 0;\">Tap the button below to reset your password. If you didn't forgot your password on <a href=\"hotelbahia.com\">HotelBahia</a>, you can safely delete this email.</p>
                </td>
              </tr>
              <!-- end copy -->
    
              <!-- start button -->
              <tr>
                <td align=\"left\" bgcolor=\"#ffffff\">
                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                    <tr>
                      <td align=\"center\" bgcolor=\"#ffffff\" style=\"padding: 12px;\">
                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                          <tr>
                            <td align=\"center\" bgcolor=\"#1a82e2\" style=\"border-radius: 6px;\">
                              <a href=\"$link\" target=\"_blank\" style=\"background-color:rgb(216, 83, 83); display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;\">Reset</a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!-- end button -->
    
              <!-- start copy -->
              <tr>
                <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;\">
                  <p style=\"margin: 0;\">If that doesn't work, copy and paste the following link in your browser:</p>
                  <p style=\"margin: 0;\"><a href=\"$link\" target=\"_blank\">$link</a></p>
                </td>
              </tr>
              <!-- end copy -->
    
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
          </td>
        </tr>
        <!-- end copy block -->
    
        <!-- start footer -->
        <tr>
          <td align=\"center\"style=\"padding: 24px;\">
            <!--[if (gte mso 9)|(IE)]>
            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">
            <tr>
            <td align=\"center\" valign=\"top\" width=\"600\">
            <![endif]-->
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">
    
              <!-- start permission -->
              <tr>
                <td class=\"contact\" align=\"center\" style=\"padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;\">
                  <p style=\"margin: 0;\">You received this email because you want to reset your password into our website Hotel Bahia Online. If you didn't forgot it you can safely delete this email.</p>
                </td>
              </tr>
              <!-- end permission -->
    
              <!-- start unsubscribe -->
              <tr>
                <td class=\"contact\" align=\"center\" style=\"padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;\">
                  <p style=\"margin: 0;\">Follow Us</p>
                  <p style=\"margin: 0;\"><a href=\"https://www.facebook.com/hotelbahiasubicbay\"><i class=\"fab fa-facebook-f\"></i> Facebook</a></p>
                </td>
              </tr>
              <!-- end unsubscribe -->
    
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
          </td>
        </tr>
        <!-- end footer -->
    
      </table>
      <!-- end body -->
    
    </body>
    </html>";
    
$mail->send();

$success_msg[] = "Check your email for password reset";
} catch (Exception $e) {
   $erro_msg[] = $mail->ErrorInfo;
}

?>