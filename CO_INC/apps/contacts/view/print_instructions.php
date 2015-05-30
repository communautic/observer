<table width="100%" class="title">
	<tr>
		<td class="tcell-left">Kontakt</td>
		<td><strong><?php echo($contact->lastname);?> <?php echo $lang['CONTACTS_FIRSTNAME'];?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">&nbsp;</td>
    <td><p>Nachdem der Kalender aktiviert wurde, haben Sie folgende Möglichkeiten den Physio Observer Kalender für externe Geräte zu nutzen.</p></td>
  </tr>
</table>
<?php 

function splitcalURL($url) {
	$url = explode('caldav/',$url);
	return $url[0] . 'caldav/<br />' . $url[1];
}

?>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Outlook Kalender</td>
    <td><p>Integration in einen Outlook Kalender:<br />
Kalender hinzufügen <strong>>></strong> Aus dem Internet <strong>>></strong> Speicherort angeben:<br />
<a style="color: #4ca1d7" href="<?php echo $contact->outlook_caldavurl;?>"><?php echo splitcalURL($contact->outlook_caldavurl);?></a><br />
<strong>>></strong> den Internetkalender hinzufügen und abonnieren <strong>>></strong> Eingabe des
bestehenden Physio Observer Benutzernamens und Kennwortes</p></td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Apple</td>
    <td><p>Integration in Apple (IOS) Systeme:<br />
Einstellungen <strong>>></strong> Mail, Kontakte, Kalender <strong>>></strong> Account hinzufügen <strong>>></strong> Andere <strong>>></strong> Kalender (CalDAV - Account hinzufügen) <strong>>></strong> unter „Server“ folgende Adresse einfügen:<br />
<a style="color: #4ca1d7" href="<?php echo $contact->ios_caldavurl;?>"><?php echo splitcalURL($contact->ios_caldavurl);?></a><br />
<strong>>></strong> Eingabe des Physio Observer Benutzernamens und Kennwortes / Passwortes, weiter und sichern</p></td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Andere/Caldav</td>
    <td><p>Integration für CalDAV Kalender:<br />
Die Vorgehensweise für generelle calDav fähige Kalenderprogramme (z.B. Android, Mozilla Sunbird) entspricht in etwa den vorher angeführten Arbeitsschritten. Die einzugebende Adresse lautet:<br />
<a style="color: #4ca1d7" href="<?php echo $contact->caldavurl;?>"><?php echo splitcalURL($contact->caldavurl);?></a><br /></p>
</td>
  </tr>
</table>
&nbsp;
<p>&nbsp;</p>
<table width="100%" class="standard">
    <tr>
        <td class="tcell-left">&nbsp;</td>
        <td><p>Der Gemeinschaftskalender muss (außer bei IOS Systemen) separat eingefügt
            werden.</p>
    </td>
    </tr>
</table>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Outlook Kalender</td>
    <td><p>Kalender hinzufügen <strong>>></strong> Aus dem Internet <strong>>></strong> Speicherort angeben:<br />
<a style="color: #4ca1d7" href="<?php echo $contact->all_outlook_caldavurl;?>"><?php echo splitcalURL($contact->all_outlook_caldavurl);?></a><br />
<strong>>></strong> den Internetkalender hinzufügen und abonnieren <strong>>></strong> Eingabe des
bestehenden Physio Observer Benutzernamens und Kennwortes</p></td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Andere/Caldav</td>
    <td><p>Die Vorgehensweise für generelle calDav fähige Kalenderprogramme (z.B. Android, Mozilla Sunbird) entspricht in etwa den vorher angeführten Arbeitsschritten. Die einzugebende Adresse lautet:<br />
<a style="color: #4ca1d7" href="<?php echo $contact->all_caldavurl;?>"><?php echo splitcalURL($contact->all_caldavurl);?></a><br /></p>
</td>
  </tr>
</table>
&nbsp;
<p>&nbsp;</p>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">&nbsp;</td>
    <td><p style="color: #ff6633">ACHTUNG: Der PO Kalender kann aus Sicherheitsgründen auf externen Geräten nur gelesen, aber nicht manipuliert, verändert werden.</p>
    </td>
  </tr>
</table>
