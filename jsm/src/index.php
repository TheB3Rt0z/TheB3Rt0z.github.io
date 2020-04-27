<?php

$html = file_get_contents('./template.html');

$conf = json_decode(file_get_contents('../conf.json'), true);
$localConf = json_decode(file_get_contents('../local/conf.json'), true);
$conf = array_replace_recursive($conf, $localConf);var_dump($conf); // debug

function setConfigurationConstants ($value, $path = ['JSM'])
{
    if (is_array($value)) {
        foreach ($value as $key => $value) {
            setConfigurationConstants($value, array_merge($path, [strtoupper($key)]));
        }
    } else {
        define(implode('_', $path), $value);
    }
}
setConfigurationConstants($conf);

$cons = get_defined_constants(true);var_dump($cons['user']); // debug

$html = str_replace(array_map(function ($value)
                        {
                            return '[' . $value . ']';
                        }, array_keys($cons['user'])),
                    $cons['user'],
                    $html);

file_put_contents('../index.html', $html);

echo $html;
