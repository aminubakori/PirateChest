<?php

/**
 * PirateChest
 *
 * @package PirateChest
 * @author Aminu Ibrahim Bakori <aminuibakori@live.com>
 * @link https://github.com/aminubakori/PirateChest/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require 'application/libs/application.php';
require 'application/libs/class.db.php';
require 'application/libs/controller.php';

// start the application
$app = new Application();