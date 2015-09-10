<?php
/**
 * RecaptchaHelperTest
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Test\TestCase\View\Helper;

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Recaptcha\View\Helper\RecaptchaHelper;

/**
 * Recaptcha\View\Helper\RecaptchaHelper Test Case
 */
class RecaptchaHelperTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Recaptcha = new RecaptchaHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recaptcha);

        parent::tearDown();
    }

    /**
     * testConstruct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $expected = [
            // If no language is found anywhere
            'lang' => 'en',
            // If no theme is found anywhere
            'theme' => 'light',
            // If no type is found anywhere
            'type' => 'image'
        ];
        $this->assertEquals($expected, $this->Recaptcha->config());
    }

    /**
     * Test StartupWithNonExistingConfigFile
     *
     * @return void
     */
    public function testStartupWithNonExistingConfigFile()
    {
        Configure::config('default', new PhpConfig(PATH_TO_CONFIG_FILES));

        try {
            Configure::load('nonExistingFile', 'default', false);
        } catch (\Cake\Core\Exception\Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test StartupWithExistingConfigFile
     *
     * @return void
     */
    public function testStartupWithExistingConfigFile()
    {
        Configure::config('default', new PhpConfig(PATH_TO_CONFIG_FILES));
        Configure::load('recaptchaWithExistingKeys', 'default', false);

        // check that configs are well imported
        $this->assertEquals('goodkey', Configure::read('Recaptcha.sitekey'));
        $this->assertEquals('goodsecret', Configure::read('Recaptcha.secret'));
        $this->assertEquals('en', Configure::read('Recaptcha.lang'));
        $this->assertEquals('light', Configure::read('Recaptcha.theme'));
        $this->assertEquals('image', Configure::read('Recaptcha.type'));
    }

    /**
     * Test StartupWithEmptyOptions
     *
     * @return void
     */
    public function testStartupWithEmptyOptions()
    {
        Configure::config('default', new PhpConfig(PATH_TO_CONFIG_FILES));
        Configure::load('recaptchaWithEmptyOptions', 'default', false);

        $this->assertEquals('goodkey', Configure::read('Recaptcha.sitekey'));
        $this->assertEquals('goodsecret', Configure::read('Recaptcha.secret'));
        $this->assertEquals('', Configure::read('Recaptcha.lang'));
        $this->assertEquals('', Configure::read('Recaptcha.theme'));
        $this->assertEquals('', Configure::read('Recaptcha.type'));
    }

    public function testDisplay()
    {
        $options = [
            'lang' => 'fr',
            'sitekey' => 'goodkey',
            'theme' => 'light',
            'type' => 'image'
        ];

        $expected = '<div class="g-recaptcha" data-sitekey="goodKey" data-theme="light" data-type="image"></div>
        <script type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl=fr">
        </script>';

        // $this->assertEquals($expected, $this->Recaptcha->display($options));
    }

    public function testDisplayWithEmptyValues()
    {
        $options = [];

        $expected = '<div class="g-recaptcha" data-sitekey="" data-theme="light" data-type="image"></div>
        <script type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl=en">
        </script>';

        // $this->assertEquals($expected, $this->Recaptcha->display($options));
    }

    // public function testMultipleWidgets()
    // {
    //     $id = 1;
    //     $siteKey = '';
    //     $options = [
    //         'theme' => '',
    //         'type' => '',
    //         'lang' => '',
    //         'callback' => '',
    //         'action' => ''
    //     ];
    //
    //     $expected = '
    //     <form action="javascript:alert(grecaptcha.getResponse(widgetId1));">
    //       <div id="example1"></div>
    //       <br>
    //       <input type="submit" value="getResponse">
    //     </form>
    //     <br>
    //     <form action="javascript:grecaptcha.reset(widgetId2);">
    //       <div id="example2"></div>
    //       <br>
    //       <input type="submit" value="reset">
    //     </form>
    //     <br>
    //     <form action="?" method="POST">
    //       <div id="example3"></div>
    //       <br>
    //       <input type="submit" value="Submit">
    //     </form>
    //     <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';
    //
    //     $actual = $this->Recaptcha->display($id, $siteKey, $options);
    //
    //     //$this->assertEquals($expected, $actual);
    // }
    //
    // public function testMultipleWidgetsHeadScript()
    // {
    //     // add widget
    //     $id = 1;
    //     $siteKey = '';
    //     $options = [
    //         'theme' => '',
    //         'type' => '',
    //         'lang' => '',
    //         'callback' => '',
    //         'action' => ''
    //     ];
    //     $this->Recaptcha->display($id, $siteKey, $options);
    //
    //     $expected = '';
    //
    //     $actual = $this->Recaptcha->script();
    //
    //     //$this->assertEquals($expected, $actual);
    // }
}
