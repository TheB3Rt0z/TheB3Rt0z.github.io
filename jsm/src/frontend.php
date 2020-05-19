<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com and you will be sent a copy immediately.
 *
 * PHP version 7.2.18
 *
 * @category Frontend
 * @package  JSM
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License 3.0
 * @link     https://github.com/TheB3Rt0z
 */

require_once '../vendor/autoload.php';
require_once './frontend/constants.php';

$html = file_get_contents('./template.html');

$conf = json_decode(file_get_contents('../conf.json'), true);
$localConf = json_decode(@file_get_contents('../local/conf.json'), true) ?: [];
$conf = array_replace_recursive($conf, $localConf);

setConfConstants($conf);

$cons = get_defined_constants(true);//var_dump($cons['user']); // debug

$html = str_replace(
    array_map(
        function ($value) {
                            return '[' . $value . ']';
        },
        array_keys($cons['user'])
    ),
    $cons['user'],
    $html
);

if (JSM_DEV_FRONTEND_CONSOLE) {
    include_once './frontend/console/script.phtml';
}

echo str_replace(JSM_APP_SKIN_PATH, '../' . JSM_APP_SKIN_PATH, $html);

if (JSM_DEV_OUTPUT_COMPRESSION) {
    $html = str_replace(
        ["  ", "\t", "\n", "\r"],
        '',
        $html
    );
}

file_put_contents('../index.html', $html);

if (JSM_DEV_FRONTEND_CONSOLE) {
    include_once './frontend/console.phtml';
}

/*
https://help.github.com/en/github/working-with-github-pages/about-github-pages
https://dev.w3.org/html5/html-author/charref
*/
