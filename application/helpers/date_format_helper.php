<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Helper: DateFormat Handlers
 *
 *
 */

if ( ! function_exists('ct_format_date'))
{

    function ct_format_date($tformat, $tstamp, $tz=0)  {
    	if($tz>=0) $tz = '+'.$tz;
    	$dt = new DateTime("now", new DateTimeZone("GMT".$tz));
		$dt->setTimestamp($tstamp);
        return $dt->format($tformat);
    }
}


if ( ! function_exists('ct_format_get_weekly_date'))
{

    function ct_format_get_weekly_date($tstamp, $prije, $tz=0)  {
            return ct_format_date("M d",$prije,$tz). ' - '. ct_format_date("M d, Y",$tstamp,$tz);
    }
}

if ( ! function_exists('ct_format_get_date'))
{

    function ct_format_get_date($tstamp, $tz=0)  {
            return ct_format_date("M d, Y",$tstamp,$tz);
    }
}
if ( ! function_exists('ct_format_nice_date'))
{

    function ct_format_nice_date($tstamp, $tz=0)  {
            return ct_format_date("M d, Y",$tstamp,$tz);
    }
}
if ( ! function_exists('ct_format_nice_time'))
{

    function ct_format_nice_time($tstamp, $tz=0)  {
            return ct_format_date("M d, Y h:i:sa",$tstamp,$tz);
    }
}


if ( ! function_exists('ct_format_nice_str'))
{

    function ct_format_nice_str($strtime, $tz=0)  {
            return ct_format_date("M d, Y - h:i:sa",strtotime($strtime),$tz);
    }
}

if ( ! function_exists('ct_format_sms_str'))
{

    function ct_format_sms_str($strtime, $tz=0)  {
            return ct_format_date("h:i:sa - M d",strtotime($strtime),$tz);
    }
}