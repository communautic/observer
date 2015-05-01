<table width="100%" class="title">
	<tr>
        <td class="tcell-left">Kalender</td>
        <td><strong><?php echo $title;?></strong></td>
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
	$calendarName = $this->model->getCalendarName($row['calendarid']);
	
	echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="5%">&nbsp;</td><td width="40%">' . $title . '</td><td class="smalltext grey" valign="middle" width="20%">' . $start . ' ' . $end . '</td><td class="smalltext grey" valign="middle">' . $calendarName . '</td></tr></table>';
	$i++;
}?>