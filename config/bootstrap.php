<?php
/**
 * Bootstrap
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Recaptcha\Validation\ConfigValidator;

// Pass the config data from config/recaptcha.php to Configure Class
Configure::load('recaptcha');

// Validate the Configure Data
$validator = new ConfigValidator();

$errors = $validator->errors(Configure::read('Recaptcha'));

if (!empty($errors)) {
    $message = '';
    foreach ($errors as $errorName => $errorArray) {
        $message .= '<br>- ' . $errorName . '<br>' . implode('<br>', $errorArray);
    }
    throw new \Exception(__d('recaptcha', 'At least One of your recaptcha config value is incorrect: {0}', $message));
}
