# MailboxValidator CodeIgniter Email Validation Package

MailboxValidator CodeIgniter Email Validation Package enables user to easily validate if an email address is valid, a type of disposable email or free email.

This package can be useful in many types of projects, for example

 - to validate an user's email during sign up
 - to clean your mailing list prior to email sending
 - to perform fraud check
 - and so on



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



## Functions

### get_single_result (email_address)

Performs email validation on the supplied email address.

#### Return Fields

| Field Name | Description |
|-----------|------------|
| email_address | The input email address. |
| domain | The domain of the email address. |
| is_free | Whether the email address is from a free email provider like Gmail or Hotmail. Return values: True, False |
| is_syntax | Whether the email address is syntactically correct. Return values: True, False |
| is_domain | Whether the email address has a valid MX record in its DNS entries. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_smtp | Whether the mail servers specified in the MX records are responding to connections. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_verified | Whether the mail server confirms that the email address actually exist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_server_down | Whether the mail server is currently down or unresponsive. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_greylisted | Whether the mail server employs greylisting where an email has to be sent a second time at a later time. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_disposable | Whether the email address is a temporary one from a disposable email provider. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_suppressed | Whether the email address is in our blacklist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_role | Whether the email address is a role-based email address like admin@example.net or webmaster@example.net. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_high_risk | Whether the email address contains high risk keywords. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_catchall | Whether the email address is a catch-all address. Return values: True, False, Unknown, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| mailboxvalidator_score | Email address reputation score. Score > 0.70 means good; score > 0.40 means fair; score <= 0.40 means poor. |
| time_taken | The time taken to get the results in seconds. |
| status | Whether our system think the email address is valid based on all the previous fields. Return values: True, False |
| credits_available | The number of credits left to perform validations. |
| error_code | The error code if there is any error. See error table in the below section. |
| error_message | The error message if there is any error. See error table in the below section. |



#### is_email_disposable (email_address)

Check whether the email address is belongs to a disposable email provider or not. Return Values: True, False



#### is_email_free (email_address)

Check whether the email address is belongs to a free email provider or not. Return Values: True, False



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
You can refer the full list of response parameters at above table.


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

Copyright (C) 2018-2020 by MailboxValidator.com, support@mailboxvalidator.com