<?php
class DateTimeCus extends DateTime
{
	
	function formatDate($date, $format = 'Y-m-d H:i:s') {
		global $session;
		$tz = $session->timezone;
		$dtzone = new DateTimeZone($tz);
		$dtime = new DateTime($date);
		$dtime->setTimeZone($dtzone);
		$time = ($date !== false && $date != '' && $date != '0000-00-00' && $date != '0000-00-00 00:00:00') ? $dtime->format($format) : null;
		return $time;
	}


	function formatDateGMT($date, $format = 'Y-m-d H:i:s') {
		global $session;
		$tz = $session->timezone;
		$dtime = new DateTime($date, new DateTimeZone($tz));
		$dtime->setTimezone(new DateTimeZone('GMT'));
		$time = $dtime->format("Y-m-d H:i:s");
		return $time;
	}


	// Move date by +- X days
	function moveDate($date, $days) {
		if($days > 0) {
			$days = "+".$days;
		}
		$newdate = date("Y-m-d", strtotime($date . " " . $days . " days"));
		return $newdate;
	}


	// add days
	function addDays($day, $days) {
		$date = new DateTime($day);
		$date->modify("+$days day");
		return $date->format("Y-m-d");
	}


	// days between 2 dates
	function dateDiff($dt1, $dt2, $timeZone = 'GMT') {
		$tZone = new DateTimeZone($timeZone);
		$dt1 = new DateTime($dt1, $tZone);
		$dt2 = new DateTime($dt2, $tZone);
		$ts1 = $dt1->format('Y-m-d');
		$ts2 = $dt2->format('Y-m-d');
		$diff = abs(strtotime($ts1)-strtotime($ts2));
		$diff/= 3600*24;
		return round($diff);
	}


}

$date = new DateTimeCus();
?>