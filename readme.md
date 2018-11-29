# MailboxValidator CodeIgniter Email Validation Package

MailboxValidator CodeIgniter Email Validation Package provides an easy way to call the MailboxValidator API which validates if an email address is valid.



## Installation

Upload the ``libraries`` folder to your CodeIgniter ``application`` folder



## Dependencies

An API key is required for this module to function.

Go to https://www.mailboxvalidator.com/plans#api to sign up for FREE API plan and you'll be given an API key.

After you get your API key, open your ``application/config/config.php`` and add the following line:
```php
$config['mbv_api_key'] = 'PASTE_YOUR_API_KEY_HERE';
```



## Usage

### Form Validation

To use this library in form validation, first create a new file under ``application/libraries`` called ``MY_Form_validation.php``.

After that, copy the following sample code into ``MY_Form_validation.php``:
```php
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	protected $CI;
	public function __construct(){
    
        $this->CI = &get_instance();
		$this->CI->load->library('MailboxValidator');
		$this->CI->MailboxValidator = new MailboxValidator();
	}

    public function disposable($email) {
		return $this->CI->MailboxValidator->get_disposable_result($email);
	}

    public function free($email) {
		return $this->CI->MailboxValidator->get_free_result($email);
	}

}

?>
```

Next, in your form controller, add the function name into the ``set_rules`` array. For example, if you want to use the ``disposable`` function to validate email, just add the ``disposable`` into the ``set_rules`` array like this:

```php
$this->form_validation->set_rules('email', 'Email', 'required|disposable', array('disposable' => 'A disposable email address is detected.'));
```

Noted that you will be required to add a custom error message for it. Now you can open your form and try to enter a disposable email address to see the outcome. The form should return the error message for the disposable email.





## Errors

| error_code | error_message         |
| ---------- | --------------------- |
| 100        | Missing parameter.    |
| 101        | API key not found.    |
| 102        | API key disabled.     |
| 103        | API key expired.      |
| 104        | Insufficient credits. |
| 105        | Unknown error.        |



## Copyright

Copyright (C) 2018 by MailboxValidator.com, support@mailboxvalidator.com