<?php
(defined('BASEPATH') || defined('SYSPATH')) or die('No direct access allowed.');

require_once('MailboxValidator/SingleValidation.php');

class Mailboxvalidator {

	protected $mbv;
	
	public function __construct($params = '') {
		$CI = &get_instance();

		if ($params != '') {
			$key = $params['mbv_api_key'];
			$this->mbv = new \MailboxValidator\SingleValidation($key);
		} else {
			$this->mbv = new \MailboxValidator\SingleValidation($CI->config->item('mbv_api_key'));
		}
		log_message('debug', "Mailboxvalidator Class Initialized.");
	}

	public function get_single_result($email) {
		if ($email != ''){
			return $this->mbv->ValidateEmail($email);
		}
	}
	
	public function is_email_free($email) {
		if ($email != ''){
			$result = $this->mbv->FreeEmail($email);
			if ($result != false && $result->error_code == '') {
				if ($result->is_free == 'True') {
					return true;
				} else {
					return false;
				}
			} else {
				log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
				return false;
			}
		} else {
			return false;
		}
	}

	public function is_email_disposable($email) {
		if ($email != ''){
			$result = $this->mbv->DisposableEmail($email);
			if ($result != false && $result->error_code == '') {
				if ($result->is_disposable == 'True') {
					return true;
				} else {
					return false;
				}
			} else {
				log_message('error', 'MBV API Error: ' . $result->error_code .'-' . $result->error_message);
				return false;
			}
		} else {
			return false;
		}
	}

}
?>