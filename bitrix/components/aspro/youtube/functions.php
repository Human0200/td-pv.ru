<?
function numberPrepare($number) {
	if((int)$number >= 1000000) {
		return (int)($number/1000000).'M';
	} else if((int)$number >= 1000) {
		return (int)($number/1000).'K';
	} else if((int)$number < 1000) {
		return (int)($number);
	}
}
?>