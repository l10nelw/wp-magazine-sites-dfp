<?
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
	// Skinner:
	googletag.pubads().addEventListener('slotRenderEnded', function(event) {
		if (event.slot.A.indexOf('Skinner') != -1 && !event.isEmpty) window.onload = skinner;
	});
});
// Skinner code adapted from Henry Wan
function skinner(){
	document.body.style.backgroundImage="url('<? printf($skinnerurl, 'ad') ?>')";
	document.body.style.backgroundRepeat="no-repeat";
	document.body.style.backgroundPosition="50% 0px";
	document.body.style.backgroundAttachment="fixed";
	document.body.onclick=handleClick;
	document.body.onmouseover=handleMouseOver;
}
function handleClick(e){
	e = e || event;
	var target = e.srcElement || e.target;
	if (document.body == target)
		window.open('<? printf($skinnerurl, 'jump') ?>','_blank');
}
function handleMouseOver(e){
	e=e || event;
	var target=e.srcElement || e.target;
	document.body.style.cursor = (document.body == target) ? 'pointer' : 'default';
}
</script>
