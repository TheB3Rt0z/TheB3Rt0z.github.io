<?php include_once '../vendor/autoload.php';

// https://help.github.com/en/github/working-with-github-pages/about-github-pages
// https://dev.w3.org/html5/html-author/charref


$html = file_get_contents('./template.html');

$conf = json_decode(file_get_contents('../conf.json'), true);
$localConf = json_decode(file_get_contents('../local/conf.json'), true) ?? [];
$conf = array_replace_recursive($conf, $localConf);//var_dump($conf); // debug

function setConfigurationConstants ($value, $path = ['JSM'])
{
    if (is_array($value)) {
        foreach ($value as $key => $value) {
            setConfigurationConstants($value, array_merge($path, [strtoupper($key)]));
        }
    } else {
        $constantName = implode('_', $path);
        define($constantName, $value);
        if ($constantName == 'JSM_APP_SKIN') {
            define('JSM_APP_SKIN_PATH', 'skins/' . ($value ? $value . '/' : ''));
        }
    }
}
setConfigurationConstants($conf);

$cons = get_defined_constants(true);//var_dump($cons['user']); // debug

$html = str_replace(array_map(function ($value)
                        {
                            return '[' . $value . ']';
                        }, array_keys($cons['user'])),
                    $cons['user'],
                    $html);

if (JSM_DEV_FRONTEND_CONSOLE) {
    require_once './frontend/console/script.phtml';
}

echo str_replace(JSM_APP_SKIN_PATH, '../' . JSM_APP_SKIN_PATH, $html);

if (JSM_DEV_OUTPUT_COMPRESSION) {
    $html = str_replace(["  ", "\t", "\n", "\r"],
                        '',
                        $html);
}

file_put_contents('../index.html', $html);

if (JSM_DEV_FRONTEND_CONSOLE) {
    require_once './frontend/console.phtml';
}
