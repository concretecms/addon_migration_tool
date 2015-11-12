<?php
/**
 * @author Andrew Embler
 */

// testing credentials

use Concrete\Core\Config\Repository\Repository;

// error reporting
PHPUnit_Framework_Error_Notice::$enabled = false;

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__)));

require_once('MigrationToolTestCase.php');

define('DIR_TEST_FIXTURES', realpath(dirname(__FILE__) . '/fixtures'));
define('DIR_BASE', realpath(dirname(__FILE__) . '/../../web'));
$DIR_BASE_CORE = realpath(dirname(__FILE__) . '/../../web/concrete');

require $DIR_BASE_CORE . '/bootstrap/configure.php';

/**
 * Include all autoloaders
 */
require $DIR_BASE_CORE . '/bootstrap/autoload.php';

/**
 * Begin concrete5 startup.
 */
$cms = require $DIR_BASE_CORE . '/bootstrap/start.php';

/**
 * Test more strictly than core settings
 */
error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);

/**
 * Kill this because it plays hell with phpunit.
 */
unset($cms);
