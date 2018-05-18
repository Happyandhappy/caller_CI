<?php // make an associative array of callers we know, indexed by phone number
	// now greet the caller
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<?php if( !empty($voicemailtext) ) { ?>
<Response>
	<?php if($voicemailurl && $voicemailurl!=''): ?>
    <Play><?php echo $voicemailurl; ?></Play>
	<?php else: ?>
	<Say><?php echo $voicemailtext; ?></Say>
	<?php endif ?>
  <Record timeout="60" action="<?php echo base_url().'base/save_voicemail/'.$clid.'/'.urlencode($cphone); ?>" />  
</Response>
<?php } else { ?>
<Response></Response>
<?php } ?>