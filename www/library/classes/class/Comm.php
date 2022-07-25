<?php

require_once 'SendGrid/Response.php';
require_once 'SendGrid/Client.php';
require_once 'SendGrid/SendGrid.php';
require_once 'SendGrid/Mail.php';
require_once 'SendGrid/Attachment.php';

class Comm
{
 /**
 * Send out an email 
 * @param string 
 * @return object
 */
	public function sendEmail($recepient, $template, $subject) {

		$file = $_SERVER['DOCUMENT_ROOT'].'/media/'.$template;

		$html = file_get_contents($file);
		/* Other details. */
		$html = str_replace('[date]', date("F j, Y, g:i a"), $html);
		/* Body */
		foreach($recepient as $key => $value) {
			if(!is_array($value)) $html = str_replace("[$key]", $value, $html);
		}
		$html = str_replace('[site]', $_SERVER['HTTP_HOST'], $html);	
		/* Setup email. */
		$email_from = new Email($recepient['recipient_from_name'], $recepient['recipient_from_email']);
		$email_to = new Email($recepient['recipient_name'], $recepient['recipient_email']);
		$email_content = new Content("text/html", $html);

		$mail 			= new Mail($email_from, $subject, $email_to, $email_content);
  /*
   * There is no data on this account, the returned code will be 202 because I have not loaded
   * on sendgrid website.
   */
		$email_sendgrid	= new SendGrid('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');
		/* Send email. */
		$response = $email_sendgrid->client->mail()->send()->post($mail);
		/* Send the email. */
  echo $response->statusCode(); exit;
		if((int)$response->statusCode() >= 200 && (int)$response->statusCode() <= 299) {
			return 1;
		} else {
			return 0;
		}
	}
}
?>