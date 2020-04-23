<?php print('<p>PREPARATION</p>');

define('GA_PROPERTY_ID', "UA-156063606-1");
define('USER_LANGUAGE', "de");
define('DOCUMENT_HOSTNAME', "https://ebay-auctions.i-ways-network.org");

function sendGaEvent (
    $userId,
    $category,
    $action,
    $label = '', // event's label is optional,
    $transactionId = false
) {
    $cookies = '';
    foreach ($_COOKIE as $key => $value) {
        $cookies .= $key . '=' . $value . '; ';
    }

    $fields = [
        'v' => 1, // version, ATM only one..
        'tid' => GA_PROPERTY_ID,
        'cid' => $userId, // anonymous client ID
        'uip' => $_SERVER['REMOTE_ADDR'],
        'dh' => DOCUMENT_HOSTNAME,
        //'dp' => ???, // relative URL
        //'dt' => ???, // page title
        'ul' => USER_LANGUAGE,
        't' => 'event', // hit type
        'ec' => urlencode($category), // event category, required
        'ea' => urlencode($action), // event action, required
        'el' => urlencode($label), // event label
        'ev' => 0, // event value
        'cn' => 'direct', // campaign name
        'cs' => 'organic', // campaign source
        'cm' => 'organic' // campaign medium
    ];

    if ($transactionId) { // ecommerce purchase tracking
        $revenue = 0;
        for ($i = 1; $i <= 3; $i++) {
            $price = $i + $i / 10;
            $sum = $price * $i; // quantity..
            $fields['pr' . $i . 'id'] = "PRODUCT_' . $i . '_ID";
            $fields['pr' . $i . 'nm'] = "PRODUCT_' . $i . '_NAME";
            $fields['pr' . $i . 'qt'] = $i;
            $fields['pr' . $i . 'pr'] = $price;
            $revenue += $sum;
        }

        $fields['pa'] = 'purchase'; // product action, required
        $fields['ti'] = $transactionId; // transaction ID, required
        $fields['tr'] = $revenue;
        $fields['tt'] = $revenue * .19; // tax
        $fields['ts'] = 4.95; //shippung
    };

    $payload = '';
    foreach ($fields as $key => $value) {
        $payload .= $key . '=' . $value . '&';
    }
    rtrim($payload, '&');

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, count($fields));
    curl_setopt($curl, CURLOPT_POSTFIELDS, utf8_encode($payload));
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_URL,"https://ssl.google-analytics.com/collect");
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded']);
    curl_setopt($curl, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_COOKIE, $cookies);
    curl_exec($curl);
    curl_close($curl);

    print_r($fields);
}

print('<p>Test START</p><pre>');

sendGaEvent(
    time(),
    'liveStream',
    'actionItem',
    'won',
    't' . str_replace(' ', '.', microtime())
);

print('</pre><p>Test ENDED</p>');

/*
https://stackoverflow.com/questions/28806944/google-analytics-php-sending-information
https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide#measuring-purchases#
https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters

