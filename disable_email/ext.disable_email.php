<?php
/**
 * This source file is part of an open source project
 * for an add-on for ExpressionEngine (https://expressionengine.com)
 *
 * @link      https://expressionengine.com/
 * @copyright Copyright (c) 2019, EllisLab Corp. (https://ellislab.com)
 * @license   https://expressionengine.com/license Licensed under Apache License, Version 2.0
 */

 /**
 * Email disabling extension class
 */
class Disable_email_ext
{
	public $settings;
	public $version;

	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->settings = $settings;

		$addon = ee('Addon')->get('disable_email');
		$this->version = $addon->getVersion();
	}

	/**
	 * Filter Email
	 *
	 * Email sent from EE will get sent here where the recipients will
	 * ultimately be judged and possibly removed from emails.
	 *
	 * @param string $headers Email headers, including CC
	 * @param string $recipients Regular recipients
	 * @param string $bcc_array  BCC recipients
	 * @param string $final_body Body of email
	 * @return bool If we end up not having any recipients to send email to,
	 *		we'll return TRUE and set end_script to TRUE to stop EE from
	 *		sending the email
	 */
	function filter_email($email)
	{
		$headers = &$email['headers'];
		$header_str = &$email['header_str'];
		$recipients = &$email['recipients'];
		$cc_array = &$email['cc_array'];
		$bcc_array = &$email['bcc_array'];
		$subject = &$email['subject'];

		// Purge emails from the normal arrays and strings that we can
		$this->_purge_emails($headers['Cc']);
		$this->_purge_emails($recipients);
		$this->_purge_emails($cc_array);
		$this->_purge_emails($bcc_array);

		// If batch_bcc_send() is used, Bcc gets unset from this array
		if (isset($headers['Bcc']))
		{
			$this->_purge_emails($headers['Bcc']);
		}

		// Since we probably changed our headers array, we need to
		// regenerate the headers string that is ultimately use by the
		// mail protocols to send the message
		if ($subject != '')
		{
			$headers['Subject'] = $subject;
		}

		ee()->email->build_message();

		// If we end up with no recipients at all, don't send the email
		if (empty($headers['Cc']) &&
			empty($headers['Bcc']) &&
			empty($recipients) &&
			empty($cc_array) &&
			empty($bcc_array))
		{
			ee()->extensions->end_script = TRUE;
			return TRUE;
		}
	}
	/**
	 * Purge Emails
	 *
	 * Given a string or array of emails, filters out the ones we don't want
	 * to send email to
	 *
	 * @param mixed $emails String or array of email addresses, by reference for brevity
	 * @return void
	 */
	private function _purge_emails(&$emails)
	{
		// Convert $emails to an array if needed
		if (($was_array = is_array($emails)) === FALSE)
		{
			$emails = explode(',', $emails);
		}

		foreach ($emails as $key => &$email)
		{
			// Trim excess space around email in case it was delimited by ', '
			$email = trim($email);

			// If email address does not contain our approved domain,
			// remove it from emails array
			if ( ! strstr($email, $this->settings['approved_domain']))
			{
				unset($emails[$key]);
			}
		}

		// If we weren't originally passed an array, convert back to string
		if ( ! $was_array)
		{
			$emails = implode(', ', $emails);
		}
	}

	/**
	 * Settings
	 *
	 * @return array Array of abstracted settings
	 */
	public function settings()
	{
		$settings = [];
		$settings['approved_domain'] = ['i', '', '@example.com'];
		return $settings;
	}

	/**
	 * Activate Extension
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		$hooks = array(
			'email_send' => 'filter_email'
		);

		foreach ($hooks as $hook => $method)
		{
			ee('Model')->make('Extension', [
				'class'    => __CLASS__,
				'method'   => $method,
				'hook'     => $hook,
				'settings' => [],
				'version'  => $this->version,
				'enabled'  => TRUE,
			])->save();
		}
	}

	/**
	 * Disable Extension
	 *
	 * @return void
	 */
	function disable_extension()
	{
		ee('Model')->get('Extension')
			->filter('class', __CLASS__)
			->delete();
	}

	/**
	 * Update Extension
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}
}
// END CLASS

// EOF
