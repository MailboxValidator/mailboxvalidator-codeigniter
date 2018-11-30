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

You can also set you api key in controller during calling library. Just do like this:

```php
$params = array('mbv_api_key' => 'PASTE_YOUR_API_KEY_HERE');
$this->CI->load->library('mailboxvalidator',$params);
```



## Methods

Below are the methods supported in this library.

| Method Name         | Description                                                  |
| ------------------- | ------------------------------------------------------------ |
| get_single_result   | Return the validation result of an email address. Please visit [MailboxValidator](https://www.mailboxvalidator.com/api-single-validation) for the list of the response parameters. |
| is_email_free       | Check whether the email address is belongs to a free email provider or not. Return Values: True, False |
| is_email_disposable | Check whether the email address is belongs to a disposable email provider or not. Return Values: True, False |



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
		$this->CI->load->library('mailboxvalidator');
	}

    public function disposable($email) {
		if ($this->CI->mailboxvalidator1->is_email_disposable($email) == true) {
			// If is_email_disposable return true, means the email is disposable email
			return false;
		} else {
			return true;
		}
	}

    public function free($email) {
		if ($this->CI->mailboxvalidator1->is_email_free($email) == true) {
			// If is_email_free return true, means the email is free email
			return false;
		} else {
			return true;
		}
	}

}

?>
```

Next, in your form controller, add the function name into the ``set_rules`` array. For example, if you want to use the ``disposable`` function to validate email, just add the ``disposable`` into the ``set_rules`` array like this:

```php
$this->form_validation->set_rules('email', 'Email', 'required|disposable', array('disposable' => 'A disposable email address is detected.'));
```

Noted that you will be required to add a custom error message for it. Now you can open your form and try to enter a disposable email address to see the outcome. The form should return the error message for the disposable email.

### Email Validation

To use this library to get validation result for an email address, firstly load the library in your controller like this:
```php
$this->load->library('mailboxvalidator');
```
After that, you can get the validation result for the email address like this:
```php
$result = $this->mailboxvalidator->get_single_result('test@example.com');
```
To pass the result to the view, just simply add the $result to your view loader like this:
```php
$this->load->view('YOUR_VIEW_NAME',$result);
```
And then in your view file, call the validation results. For example:
```php
echo $email_address;
```
You can refer the full list of response parameters available at [here](https://www.mailboxvalidator.com/api-single-validation).




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