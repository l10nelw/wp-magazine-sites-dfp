<?
/* DFP */

global $ADUNITS, $ADCODEHEAD, $ADCATS;

// a full ad unit code looks like: /110430332/ZineTitle_fashion_HalfPage
$ADCODEHEAD = '/110430332/ZineTitle';
$ADCATS = explode(' ', 'fashion beauty relationships food travel'); // ad targetable categories

// size names
$ADUNITS['HalfPage']    = ['width' =>  300, 'height' => 600];
$ADUNITS['Leaderboard'] = ['width' =>  728, 'height' =>  90];
$ADUNITS['MediumRect']  = ['width' =>  300, 'height' => 250];
$ADUNITS['Skinner']     = ['width' => 1580, 'height' => 700];

// return category of current page if ad targetable, otherwise return 'default'
function ad_category() {
	if(is_home()) return 'default';
	global $ADCATS;
	foreach(get_the_category() as $cat) {
		if(in_array($cat->slug, $ADCATS)) return $cat->slug;
	}
	return 'default';
}

// shortcode [ad unit="size name"]
function ad_shortcode($atts) {
	global $ADUNITS, $ADCODEHEAD, $adcat;
	
	$sizename = shortcode_atts(['unit' => ''], $atts)['unit'];
	if(!array_key_exists($sizename, $ADUNITS)) return; // return "Ad unit size name not found";
	
	$id = "{$adcat}_{$sizename}";
	$width = $ADUNITS[$sizename]['width'];
	$height = $ADUNITS[$sizename]['height'];
	
	return	"<!-- {$ADCODEHEAD}_{$id} -->
			<div id='{$id}' class='{$sizename}' style='width:{$width}px;height:{$height}px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('{$id}'); });
			</script></div>";
}
add_shortcode('ad', 'ad_shortcode');

// ad initialization and skinner ad
function ad_head() {
	global $ADUNITS, $ADCODEHEAD, $adcat;
	$adcat = ad_category();
	$defineslot = "googletag.defineSlot('{$ADCODEHEAD}_{$adcat}_%1\$s', [%2\$d, %3\$d], '{$adcat}_%1\$s').addService(googletag.pubads());\n";
	$skinnerurl= "http://pubads.g.doubleclick.net/gampad/%s?iu={$ADCODEHEAD}_{$adcat}_Skinner&sz=1580x700&c=" . rand(0, 99999);
	?>
	<script type='text/javascript'>
	// DFP initialize
	var googletag = googletag || {};
	googletag.cmd = googletag.cmd || [];
	(function() {
		var gads = document.createElement('script');
		gads.async = true;
		gads.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(gads, node);
	})();
	googletag.cmd.push(function() {
		<? foreach($ADUNITS as $sizename => $ad) printf($defineslot, $sizename, $ad['width'], $ad['height']); ?>
		googletag.pubads().enableSingleRequest();
		googletag.pubads().collapseEmptyDivs();
		googletag.enableServices();
		// skinner:
		googletag.pubads().addEventListener('slotRenderEnded', function(event) {
			if (event.slot.A.indexOf('Skinner') != -1 && !event.isEmpty) window.onload = skinner;
		});
	});
	function skinner(){
		document.body.style.backgroundImage = "url('<? printf($skinnerurl, 'ad') ?>')";
		document.body.style.backgroundRepeat = "no-repeat";
		document.body.style.backgroundPosition = "50% 0px";
		document.body.style.backgroundAttachment = "fixed";
		document.body.onclick = handleClick;
		document.body.onmouseover = handleMouseOver;
	}
	function handleClick(e){
		e = e || event;
		var target = e.srcElement || e.target;
		if (document.body == target)
			window.open('<? printf($skinnerurl, 'jump') ?>','_blank');
	}
	function handleMouseOver(e){
		e = e || event;
		var target = e.srcElement || e.target;
		document.body.style.cursor = (document.body == target) ? 'pointer' : 'default';
	}
	</script>
	<?
}
add_action('wp_head', 'ad_head');

