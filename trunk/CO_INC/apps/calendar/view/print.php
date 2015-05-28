<table width="100%" class="title">
	<tr>
        <td class="tcell-left" style="width: 119px">Kalender</td>
        <td><strong><?php echo $calendarName;?></strong></td>
        <td align="right" style="padding-right: 5px; padding-top: 4px;" class="smalltext">von <?php 
		date_default_timezone_set($session->timezone);
		echo date('d.m.Y',$start);?> bis <?php echo date('d.m.Y',strtotime('-1 day',$end));?></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php 
$i = 0;
$curDay = '';
$patientsModel = new PatientsModel();
foreach($output as $key => $row) {
	$date = date_create($row['start']);
	$day = date_format($date, 'd.m.Y');
	if($day != $curDay) {
		$curDay = $day;
		if($i > 0) {
			echo '</td></tr></table>';
		}
		echo '<table width="100%" class="standard" style="margin-left: -30px; margin-right: -20px; border:1px solid #ccc;"><tr><td class="smalltext" style="border-right:1px solid #ccc; padding: 6px; width: 100px;">' . $day . '</td><td>';
	}
	
	
	$start = date_format($date, 'H:i');
	$enddate = date_create($row['end']);
	$end = date_format($enddate, 'H:i');
	
	$title = $row['title'];
	if($row['patientid'] != 0) {
		$title = $patientsModel->getPatientTitle($row['patientid']);
	}
	
	echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="20px">&nbsp;</td><td width="72%">' . $title . '</td><td class="smalltext grey" valign="middle">' . $start . ' - ' . $end . '</td></tr></table>';
	$i++;
}?>