<?php

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
        define(implode('_', $path), $value);
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

echo $html;

if (JSM_DEV_OUTPUT_COMPRESSION) {
    $html = str_replace(["  ", "\t", "\n", "\r"],
                        '',
                        $html);
}

file_put_contents('../index.html', $html);

?>
<style>
    body {
        margin: 0 !important;
    }
    #jsm-console {
        background-color: rgba(0, 32, 64, .96);
        border-radius: 12px 0 0 0;
        box-shadow: 0 0 12px rgba(0, 16, 32, .96);
        color: white;
        font-family: "Lucida Console", Monaco, monospace;
        font-size: 10pt;
        height: calc(100% - 32px);
        margin: 0;
        overflow-x: visible;
        overflow-y: scroll;
        padding: 10px;
        position: fixed;
        right: -400px;
        text-shadow: 0 0 6px rgba(0, 32, 64, .96);
        top: 12px;
        transition: .125s;
        width: 380px;
    }
    #jsm-console.active {
        right: 0;
    }
    #jsm-console .toggle-button {
        background-color: rgba(0, 32, 64, .96);
        border-radius: 12px 0 0 12px;
        box-shadow: 0 0 12px rgba(0, 16, 32, .96);
        cursor: pointer;
        display: block;
        font-size: 24px;
        height: 32px;
        padding-right: 6px;
        position: fixed;
        right: 0;
        text-align: center;
        top: 17px;
        transition: .125s;
        width: 32px;
    }
    #jsm-console.active .toggle-button {
        background-color: transparent;
        border-radius: 0;
        box-shadow: none;
        top: 15px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
    }
    #jsm-console .toggle-button:hover {
        text-shadow: 0 0 6px white;
    }
</style>
<div id="jsm-console">
    <span class="toggle-button">&oplus;</span>
    <strong>User defined costants</strong>:
    <p>
        <?php
        foreach ($cons['user'] as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            } else if (is_string($value)) {
                $value = '"' . $value .'"';
            }
            echo $key . ': <strong>' . $value . '</strong><br />';
        }
        ?>
    </p>
    <br />
    <br />
</div>
<script>
    $(function() {
        var jsm_console = $('#jsm-console'),
            jsm_console_toggle_button = jsm_console.children('.toggle-button');
        jsm_console_toggle_button.on('click', function(e)
        {
            jsm_console.toggleClass('active');
        });
    });
</script>
