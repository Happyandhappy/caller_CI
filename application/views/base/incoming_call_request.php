<?php // make an associative array of callers we know, indexed by phone number
	// now greet the caller
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	if(substr($call_forward_no, 0, 1) !== '+')  {
        $call_forward_no_clean = str_replace(array(
            '(',
            ')',
            '-',
            ' '
        ), '', $call_forward_no);
		$vmp = '+1'.$call_forward_no_clean; 
	}
	else  
		$vmp = $call_forward_no;
	if($voice_timeout<=0)
		$voice_timeout=1;
?>
<?php if( !empty($call_forward_no) ) { ?>
<Response>
	<?php if ($flag_whisper_calls && $flag_record_calls): ?><?php if ('' != trim($txt_whisper_calls)) echo '<Say>'.$txt_whisper_calls.'</Say>'; else echo '<Play>'.base_url().'uploads/whisper.mp3'.'</Play>'; ?><?php endif ?>
	<Dial <?php if ($flag_record_calls): ?>record="record-from-answer-dual"<?php endif ?><?php if ($hasVoicemail && $voice_timeout) echo ' action="'.base_url().'base/call_voicemail/'.urlencode($called_who).'" timeout="'.$voice_timeout.'" '; ?>><Number><?php echo $vmp; ?></Number><?php if ($multi_forw!=''): $koji = explode(",",$multi_forw); foreach($koji as $br): ?><Number><?php if(substr($br, 0, 1) !== '+') {
		            $call_forward_no_clean = str_replace(array(
		                '(',
		                ')',
		                '-',
		                ' '
		            ), '', $br);
		             echo '+1'.$call_forward_no_clean;} else echo $br; ?></Number><?php endforeach; endif; ?></Dial></Response>
<?php } else { ?>
<Response></Response>
<?php } ?>