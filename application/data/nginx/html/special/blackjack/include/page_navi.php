
<?php
	$prev = $n - 1;
	$next = $n + 1;
	$keys = array_keys($episodes[$lang][$prev]);
	foreach( $keys as $key ) {
			$prev_first_epi[] = $key;
	}
	$keys = array_keys($episodes[$lang][$next]);
	foreach( $keys as $key ) {
			$next_first_epi[] = $key;
	}
?>

<div class="page_navi">
	<div style="float: left;">
		<?php if( $prev > -1 ) { ?>
		<!--
			<a href="<?php echo $baseUrl ?>?n=<?php echo $prev ?>&epi=<?php echo $episodes[$lang][$prev][0] ?>&lang=<?php echo $lang ?>">←　<?php echo get_volume_presentation($lang, $prev) ?>（全<?php echo count( $episodes[$lang][$prev] ) ?>話）</a>
		-->
			<a href="<?php echo $baseUrl ?>?n=<?php echo $prev ?>&epi=<?php echo $prev_first_epi[0] ?>&lang=<?php echo $lang ?>">←　<?php echo get_volume_presentation($lang, $prev) ?></a>
		<?php } ?>
	</div>

	<div style="float: right;">
		<?php if( $next < 13 ) { ?>
		<!--
			<a href="<?php echo $baseUrl ?>?n=<?php echo $next ?>&epi=<?php echo $episodes[$lang][$next] ?>&lang=<?php echo $lang ?>"><?php echo get_volume_presentation($lang, $next) ?>（全<?php echo count( $episodes[$lang][$next] ) ?>話）→</a>
		-->
			<a href="<?php echo $baseUrl ?>?n=<?php echo $next ?>&epi=<?php echo $next_first_epi[0] ?>&lang=<?php echo $lang ?>"><?php echo get_volume_presentation($lang, $next) ?>　→</a>
		<?php } ?>
	</div>
<div class="clear"></div>
</div>



