<?php
(defined('BASEPATH') || defined('SYSPATH')) or die('No direct access allowed.');

require_once('MailboxValidator/SingleValidation.php');

class MailboxValidator {

	public function __construct() {
		$CI = &get_instance();
		$this->mbv = new \MailboxValidator\SingleValidation($CI->config->item('mbv_api_key'));
	}

	public function get_single_result($email) {
		if ($email != ''){
			return $this->mbv->ValidateEmail($email);
		}
	}
	
	public function is_email_free($email) {
		if ($email != ''){
			$result = $this->mbv->FreeEmail($email);
			if ($result != false) {
				if ($result->is_free == 'True') {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function is_email_disposable($email) {
		if ($email != ''){
			$result = $this->mbv->DisposableEmail($email);
			if ($result != false) {
				if ($result->is_disposable == 'True') {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}
?>