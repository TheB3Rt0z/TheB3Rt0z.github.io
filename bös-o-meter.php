<?php

$settings = [
	'title' => 'Bös-o-Meter | Ver. 0.0.1',
	'max-height' => '768px',
	'max-width' => '1024px',
	'min-width' => '354px',
];

function getKarma($data) {

	return 50 + (($data['engagement'] - $data['badness']) / 2);
}

function getMarkLeft($badness) {

	$output = $badness - .875;

	if ($output < .75)
		$output = .75;
	elseif ($output > 97.75)
		$output = 97.75;

	return $output;
}

function getMarkTop($engagement) {

	$output = $engagement + .875;

	if ($output < 2.5)
		$output = 2.5;
	elseif ($output > 99)
		$output = 99;

	return 100 - $output;
}

function getPerformance($karma, $power) {

	return ($karma * 1.333 + $power * 1.333) / 2;
}

function getPower($data) {

	return ($data['engagement'] + $data['badness']) / 2;
}

function getReport($data) {

	$output['Total Elements'] = count($data);

	$karmas = array();
	$powers = array();
	$performances = array();
	foreach ($data as $id => $values) {
		$karma = getKarma($values);
		$power = getPower($values);
		$karmas[] = $karma;
		$powers[] = $power;
		$performances[] = getPerformance($karma, $power);
	}
	$output['Overall Karma'] = number_format(array_sum($karmas) / count($karmas), 2) . '%';
	$output['Overall Power'] = number_format(array_sum($powers) / count($powers), 2) . '%';
	$output['Overall Performance'] = number_format(array_sum($performances) / count($performances), 2) . '%';

	return $output;
}

$data = array(
	'andrea' => array(
		'title' => 'Andrea',
		'badness' => 37.5,
		'engagement' => 62.5,
	),
	'andre' => array(
		'title' => 'André',
		'badness' => 37.5,
		'engagement' => 37.5,
	),
	'ankica' => array(
		'title' => 'Ankica',
		'badness' => 87.5,
		'engagement' => 87.5,
	),
	'arturas' => array(
		'title' => 'Arturas',
		'badness' => 75,
		'engagement' => 25,
	),
	'ben' => array(
		'title' => 'Benjamin',
		'badness' => 50,
		'engagement' => 75,
	),
	'der-dirk' => array(
		'title' => 'Der Dirk',
		'badness' => 62.5,
		'engagement' => 87.5,
	),
	'der-kosack' => array(
		'title' => 'Der Kosack',
		'badness' => 100,
		'engagement' => 0,
	),
	'dirk' => array(
		'title' => 'Dirk',
		'badness' => 56.25,
		'engagement' => 56.25,
	),
	'florian' => array(
		'title' => 'Florian',
		'badness' => 62.5,
		'engagement' => 62.5,
	),
	'gilang' => array(
		'title' => 'Gilang',
		'badness' => 25,
		'engagement' => 75,
	),
	'ivk' => array(
		'title' => 'I.v.K.',
		'badness' => 87.5,
		'engagement' => 62.5,
	),
	'janine' => array(
		'title' => 'Janine',
		'badness' => 62.5,
		'engagement' => 37.5,
	),
	'jordan' => array(
		'title' => 'Jordan',
		'badness' => 37.5,
		'engagement' => 75,
	),
	'karsten' => array(
		'title' => 'Karsten',
		'badness' => 68.75,
		'engagement' => 68.75,
	),
	'krishna' => array(
		'title' => 'Krishna',
		'badness' => 0,
		'engagement' => 100,
	),
	'peggy' => array(
		'title' => 'Peggy',
		'badness' => 43.75,
		'engagement' => 43.75,
	),
	'robert' => array(
		'title' => 'Robert',
		'badness' => 62.5,
		'engagement' => 68.75,
	),
	'rvk' => array(
		'title' => 'R.v.K.',
		'badness' => 0,
		'engagement' => 0,
	),
	'sergey' => array(
		'title' => 'Sergey',
		'badness' => 75,
		'engagement' => 37.5,
	),
	'svk' => array(
		'title' => 'S.v.K.',
		'badness' => 75,
		'engagement' => 50,
	),
	'theb3rt0z' => array(
		'title' => 'TheB3Rt0z',
		'badness' => 75,
		'engagement' => 75,
	),
	'valeri' => array(
		'title' => 'Valeri',
		'badness' => 68.75,
		'engagement' => 62.5,
	),
	'yasha' => array(
		'title' => 'Yasha',
		'badness' => 50,
		'engagement' => 50,
	),
);

if (ob_start()) {
	?>
    <html>
    	<head>
    		<title><?php echo $settings['title'] ?></title>
    		<meta charset="UTF-8" />
    		<link rel="shortcut icon" href="//x.doitiways.online/wp-content/uploads/2016/09/i-ways-fav.png">
    		<style type="text/css">
    			body {
    				font-family: monospace;
    				font-size: 10px;
    				margin: 0;
    				padding: 0;
    			}
    			body > div {
    				background-color: rgba(0, 0, 0, .125);
    				background-image: linear-gradient(white 1px, transparent 1px),
    				                  linear-gradient(90deg, white 1px, transparent 1px),
    				                  linear-gradient(rgba(255, 255, 255, .25) 1px, transparent 1px),
    				                  linear-gradient(90deg, rgba(255, 255, 255, .25) 1px, transparent 1px);
    				background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px;
    				background-position: center center;
    				border: solid 1px rgba(0, 0, 0, .5);
    				border-radius: 10px;
    				box-shadow: 0 0 10px rgba(0, 0, 0, .5);
    				float: left;
    				height: 92.5%;
    				margin: 1%;
    				max-height: <?php echo $settings['max-height'] ?>;
    				max-width: <?php echo $settings['max-width'] ?>;
    				min-width: <?php echo $settings['min-width'] ?>;
    				position: relative;
    			}

    			body > div > span {
    				position: absolute;
    			}

    			body > div > span.layer {
    				background-color: transparent;
    				border-radius: 10px;
    				height: 100%;
    				width: 100%;
    			}
    			body > div > span.layer#badness-gradient {
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3f00ff+0,ff0000+100&0+0,0.5+100 */
    background: -moz-linear-gradient(left,  rgba(63,0,255,0) 0%, rgba(255,0,0,0.5) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(left,  rgba(63,0,255,0) 0%,rgba(255,0,0,0.5) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to right,  rgba(63,0,255,0) 0%,rgba(255,0,0,0.5) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#003f00ff', endColorstr='#80ff0000',GradientType=1 ); /* IE6-9 */
    			}
    			body > div > span.layer#engagement-gradient {
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3fffff+0,3f00ff+100&0.5+0,0+50 */
    background: -moz-linear-gradient(top,  rgba(63,255,255,0.5) 0%, rgba(63,128,255,0) 50%, rgba(63,0,255,0) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top,  rgba(63,255,255,0.5) 0%,rgba(63,128,255,0) 50%,rgba(63,0,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom,  rgba(63,255,255,0.5) 0%,rgba(63,128,255,0) 50%,rgba(63,0,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#803fffff', endColorstr='#003f00ff',GradientType=0 ); /* IE6-9 */
    }
    			body > div > span.layer#performance-gradient {
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#3f00ff+0,3f00ff+100&0+0,0.5+25,0.5+50,0+100 */
    background: -moz-linear-gradient(-45deg,  rgba(63,0,255,0) 0%, rgba(63,0,255,0.5) 25%, rgba(63,0,255,0.5) 50%, rgba(63,0,255,0) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(-45deg,  rgba(63,0,255,0) 0%,rgba(63,0,255,0.5) 25%,rgba(63,0,255,0.5) 50%,rgba(63,0,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(135deg,  rgba(63,0,255,0) 0%,rgba(63,0,255,0.5) 25%,rgba(63,0,255,0.5) 50%,rgba(63,0,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#003f00ff', endColorstr='#003f00ff',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
    			}
    			body > div > span.layer#average-gradient {
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,ffffff+100&0.5+0,0+100 */
    background: -moz-radial-gradient(center, ellipse cover,  rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%); /* FF3.6-15 */
    background: -webkit-radial-gradient(center, ellipse cover,  rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%); /* Chrome10-25,Safari5.1-6 */
    background: radial-gradient(ellipse at center,  rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#80ffffff', endColorstr='#00ffffff',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
    			}

    			body > div > span.line {
    				background-color: white;
    				height: .5%;
    				opacity: .25;
    				width: .5%;
    			}
    			body > div > span.line.thin {
    				background-color: white;
    				height: .25%;
    				width: .25%;
    			}
    			body > div > span.line#centering-vertical {
    				height: 100%;
    				left: 49.75%;
    			}
    			body > div > span.line#centering-horizontal {
    				width: 100%;
    				top: 49.75%;
    			}

    			body > div > span.line#humanity-left {
    				height: 100%;
    				left: 18.5%;
    			}
    			body > div > span.line#humanity-right {
    				height: 100%;
    				left: 81%;
    			}
    			body > div > span.line#stakanovism-top {
    				width: 100%;
    				top: 18.5%;
    			}
    			body > div > span.line#stakanovism-bottom {
    				width: 100%;
    				top: 81%;
    			}

    			body > div > span.text {
    				color: white;
    				font-size: 14px;
    				height: auto;
    				max-height: <?php echo $settings['max-height'] ?>;
    				max-width: <?php echo $settings['max-width'] ?>;
    				min-width: <?php echo $settings['min-width'] ?>;
    				text-align: center;
    				text-shadow: 0 0 5px rgba(0, 0, 0, .5);
    				width: 100%;
    			}
    			body > div > span.text.rotated {
    			    transform: rotate(270deg);
    				-webkit-transform: rotate(270deg);
    				-moz-transform: rotate(270deg);
    				-o-transform: rotate(270deg);
    				writing-mode: lr-tb;
    			}
    			body > div > span.text.sector {
    			    font-size: 40px;
    			    opacity: .125;
    				width: 50%;
    			}

    			body > div > span.text#badness-top {
    				top: 1%;
    			}
    			body > div > span.text#badness-bottom {
    				top: 97%;
    			}
    			body > div > span.text#engagement-left {
    				left: -48.5%;
    				top: 50%;
    			}
    			body > div > span.text#engagement-right {
    				left: 48.5%;
    				top: 50%;
    			}

    			body > div > span.text#heavenly-creatures {
    				left: 0;
    				top: 22.5%;
    			}
    			body > div > span.text#top-players {
    				left: 50%;
    				top: 22.5%;
    			}
    			body > div > span.text#meat-nor-fish {
    				left: 0;
    				top: 72.5%;
    			}
    			body > div > span.text#criminal-minds {
    				left: 50%;
    				top: 72.5%;
    			}

    			body > div > span.mark {
    				background-color: grey;
    				border: solid 1px white;
    				border-radius: 5px;
    				box-shadow: 0 0 5px rgba(0, 0, 0, .5);
    				cursor: pointer;
    				height: 11px;
    				overflow: hidden;
    				transition: .125s;
    				white-space: nowrap;
    				width: 14px;
    			}
    			body > div > span.mark:hover {
    				background-color: white;
    				height: auto;
    				padding: 5px;
    				width: auto;
    			}
    			body > div > span.mark:hover > small {
    				display: none;
    			}
    			body > div > span.mark > small {
    				color: white;
    				font-size: 8px;
    			}

    			body > div > div {
    				font-size: 12px;
    				line-height: 15px;
    				padding: 8px;
    			}

    			body > p {
    				clear: both;
    				margin: 1%;
    				text-align: center;
    			}
    		</style>
    	</head>
    	<body>
    		<div style="width:98%">
    			<span class="layer" id="badness-gradient"></span>
    			<span class="layer" id="engagement-gradient"></span>
    			<span class="layer" id="performance-gradient"></span>
    			<span class="layer" id="average-gradient"></span>

    			<span class="line" id="centering-vertical"></span>
    			<span class="line" id="centering-horizontal"></span>
    			<span class="line thin" id="humanity-left"></span>
    			<span class="line thin" id="humanity-right"></span>
    			<span class="line thin" id="stakanovism-top"></span>
    			<span class="line thin" id="stakanovism-bottom"></span>

    			<span class="text" id="badness-top">&raquo; Badness &raquo;</span>
    			<span class="text" id="badness-bottom">&raquo; Badness &raquo;</span>
    			<span class="text rotated" id="engagement-left">&raquo; Engagement &raquo;</span>
    			<span class="text rotated" id="engagement-right">&raquo; Engagement &raquo;</span>
    			<span class="text sector" id="heavenly-creatures">Heavenly Creatures</span>
    			<span class="text sector" id="top-players">Top Players</span>
    			<span class="text sector" id="meat-nor-fish">Meat nor Fish</span>
    			<span class="text sector" id="criminal-minds">Criminal Minds</span>

    			<?php
    			foreach ($data as $id => $values) {
    				$karma = number_format(getKarma($values), 2);
    				$power = number_format(getPower($values), 2);
    				?>
    				<span class="mark" id="<?php echo $id ?>" title="<?php echo $karma . '% / ' . $power . '%' ?>"
    				      style="left:<?php echo getMarkLeft($values['badness']) ?>%;top:<?php echo getMarkTop($values['engagement']) ?>%">
    					<small>(<?php echo substr($values['title'], 0, 1) ?>)</small>
    					<?php echo $values['title'] . ' (' . number_format(getPerformance(getKarma($values), getPower($values)), 2) . '%)' ?>
    				</span>
    		        <?php
    		    }
    		    ?>
    		</div>
    		<div style="z-index:-1">
    			<div>
    				<u>Overall report</u>:<br />
    				<br />
    				<?php
    				foreach (getReport($data) as $label => $value)
    					echo $label . ': ' . $value . '<br />';
    				?>
    				<br />
    				<hr />
    				<br />
    				<u>Settings</u>:<br />
    				<br />
    				<?php
    				foreach ($data as $id => $values)
    					echo '<input name="' . $id . '" type="checkbox" /> ' . $values['title']
    					   . ' (' . number_format(getPerformance(getKarma($values), getPower($values)), 2) . '%)<br />';
    				?>
    			</div>
    		</div>
    		<p>The incredible <?php echo $settings['title'] ?> | Copyright &copy; 2017 TheB3Rt0z für i-ways GmbH</p>
    	</body>
    </html>
    <?php
    file_put_contents('./' . basename(__FILE__, '.php') . '.htm', ob_get_contents());
	ob_end_flush();
}

