<?
/* dfp */

global $ADUNITS, $ADCODEHEAD;

$ADCODEHEAD = '/110430332/Female';

// build $ADCATS array: wp category slug => dfp ad unit category
function dashes_to_camelcase($s) { return str_replace('-', '', ucwords($s, '-')); }
foreach(['fashion', 'beauty', 'relationships-sex', 'food', 'travel'] as $cat) $ADCATS[$cat] = dashes_to_camelcase($cat);

// size names
$ADUNITS['HalfPage']    = ['width' =>  300, 'height' => 600];
$ADUNITS['Leaderboard'] = ['width' =>  728, 'height' =>  90];
$ADUNITS['MediumRect']  = ['width' =>  300, 'height' => 250];
$ADUNITS['Skinner']     = ['width' => 1580, 'height' => 700];

// return dfp ad unit category of current page, otherwise return 'Default'
function ad_category() {
	if(is_home()) return 'Default';
	global $ADCATS;
	foreach(get_the_category() as $cat)
		if(in_array($cat->slug, array_keys($ADCATS))) return $ADCATS[$cat->slug];
	return 'Default';
}

// [ad unit="size name"]
function ad_shortcode($atts) {
	global $ADUNITS, $ADCODEHEAD, $adcat;
	
	$sizename = shortcode_atts(['unit' => ''], $atts)['unit'];
	if(!array_key_exists($sizename, $ADUNITS)) return "Ad unit size name not found";
	
	$id = "{$adcat}_{$sizename}";
	$width = $ADUNITS[$sizename]['width'];
	$height = $ADUNITS[$sizename]['height'];
	
	return	"<!-- {$ADCODEHEAD}_{$id} -->
			<div id='{$id}' class='{$sizename}' style='height:{$height}px; width:{$width}px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('{$id}'); });
			</script></div>";
}
add_shortcode('ad', 'ad_shortcode');
