<?php // make an associative array of callers we know, indexed by phone number
	// now greet the caller
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Say>This call is being recorded.</Say>
</Response>