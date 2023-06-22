<?php

/**
 * @package hsc_my_portfolio
 *
 * @wordpress-plugin
 * Plugin Name: HSC My Portfolio
 * Description: Add portfolio data as projects with c
 * Version: 1.0.0
 * Author: Hunter Cox
 * Author URI: www.huntercox.dev
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: hsc-my-portfolio
 */

require_once __DIR__ . '/vendor/autoload.php';

define('MY_PORTFOLIO_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('MY_PORTFOLIO_PLUGIN_DIR_PATH', untrailingslashit(plugin_dir_path(__FILE__)));

new MyPortfolio\MyPortfolio();
