<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27" style="background-color: #e5e5e5;" class="text11">Feedback zur Veranstaltung</td>
    <td  style="background-color: #e5e5e5;"><b>&bdquo;<?php echo $training->title;?>&ldquo;</b></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="22" class="text11">Veranstaltungsdaten</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
  <tr>
    <td height="22" class="text11">Trainingsanbieter</td>
    <td><?php echo $training->company;?></td>
  </tr>
  <tr>
    <td height="22" class="text11">TrainerIn</td>
    <td><?php echo $training->team;?><?php echo $training->team_ct;?></td>
  </tr>
  <tr>
    <td height="22" class="text11">Trainingsart</td>
    <td><?php echo $training->training;?></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="22" class="text11-full">Beurteilen Sie zum Abschluss bitte die Qualit&auml;t der Trainingsveranstaltung durch das Anw&auml;hlen einer jeweiligen Kategorie pro Fragestellung (von 0 - Unzureichend bis 5 - Ausgezeichnet). Unter Punkt 6 finden Sie weiters die M&ouml;glichkeit, pers&ouml;nlich gehaltene Bemerkungen abzugeben. Danke f&uuml;r Ihre Meinung, sie ist uns wichtig!</td>
    </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27" align="right">Zufriedenheit &nbsp; &nbsp; </td>
    <td width="170"><table width="170" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center">0</td>
        <td align="center">1</td>
        <td align="center">2</td>
        <td align="center">3</td>
        <td align="center">4</td>
        <td align="center">5</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">1</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
    <td width="170"  style="background-color: #e5e5e5;"><div class="feedback-outer">
<span rel="q1" v="0"><div></div></span>
<span rel="q1" v="1"><div></div></span>
<span rel="q1" v="2"><div></div></span>
<span rel="q1" v="3"><div></div></span>
<span rel="q1" v="4"><div></div></span>
<span rel="q1" v="5"><div></div></span>
</div></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">2</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
    <td width="170"  style="background-color: #e5e5e5;"><div class="feedback-outer">
<span rel="q2" v="0"><div></div></span>
<span rel="q2" v="1"><div></div></span>
<span rel="q2" v="2"><div></div></span>
<span rel="q2" v="3"><div></div></span>
<span rel="q2" v="4"><div></div></span>
<span rel="q2" v="5"><div></div></span>
</div></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">3</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
    <td width="170"  style="background-color: #e5e5e5;"><div class="feedback-outer">
<span rel="q3" v="0"><div></div></span>
<span rel="q3" v="1"><div></div></span>
<span rel="q3" v="2"><div></div></span>
<span rel="q3" v="3"><div></div></span>
<span rel="q3" v="4"><div></div></span>
<span rel="q3" v="5"><div></div></span>
</div></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">4</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
    <td width="170"  style="background-color: #e5e5e5;"><div class="feedback-outer">
<span rel="q4" v="0"><div></div></span>
<span rel="q4" v="1"><div></div></span>
<span rel="q4" v="2"><div></div></span>
<span rel="q4" v="3"><div></div></span>
<span rel="q4" v="4"><div></div></span>
<span rel="q4" v="5"><div></div></span>
</div></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">5</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
    <td width="170"  style="background-color: #e5e5e5;"><div class="feedback-outer">
<span rel="q5" v="0"><div></div></span>
<span rel="q5" v="1"><div></div></span>
<span rel="q5" v="2"><div></div></span>
<span rel="q5" v="3"><div></div></span>
<span rel="q5" v="4"><div></div></span>
<span rel="q5" v="5"><div></div></span>
</div></td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="num">6</td>
    <td height="27" style="background-color: #e5e5e5;"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_6"];?></td>
    <td width="170"  style="background-color: #e5e5e5;">&nbsp;</td>
  </tr>
</table>
<br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50">&nbsp;</td>
    <td>
      <form name="feedback" id="feedback" action="<?php echo CO_PATH_URL;?>/?path=api/apps/trainings" method="POST">
      <input type="hidden" name="request" value="feedback_response" />
      <input type="hidden" name="key" value="<?php echo $key;?>" />
      <input type="hidden" name="q1" id="q1" />
      <input type="hidden" name="q2" id="q2" />
      <input type="hidden" name="q3" id="q3" />
      <input type="hidden" name="q4" id="q4" />
      <input type="hidden" name="q5" id="q5" />
      <input type="hidden" name="q6" id="q6" />
      <textarea name="feedback_text" cols="30" rows="3" style="height: 90px; width: 100%; border: 1px solid #666; margin-bottom: 19px; resize: none;"></textarea>
      </form></td>
  </tr>
</table>
<div style="text-align: center;"><img id="feedbackSubmit" src="<?php echo CO_FILES . "/img/" . $lang["TRAINING_BUTTON_FEEDBACK_SUBMIT"];?>" alt="Feedback abschicken" width="130" height="26" /></div>