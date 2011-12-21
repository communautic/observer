<?php
// api url http://dev.companyobserver.com/?path=api/apps/publishers/menues&request=printDetails&id=1

include_once("config.php");
include(CO_INC . "/classes/session.php");
/*include(CO_INC . "/classes/database.php");
include(CO_INC . "/classes/users.php");
include(CO_INC . "/classes/system.php");
include(CO_INC . "/classes/date.php");*/

include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . CO_DEFAULT_LANGUAGE . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}


include_once(CO_INC . "/apps/publishers/modules/menues/config.php");
include_once(CO_INC . "/apps/publishers/modules/menues/lang/" . CO_DEFAULT_LANGUAGE . ".php");
include_once(CO_INC . "/apps/publishers/modules/menues/model.php");
include_once(CO_INC . "/apps/publishers/modules/menues/controller.php");
$publishersMenues = new PublishersMenues("menues");

// select current order
$q = "SELECT id FROM " . CO_TBL_PUBLISHERS_MENUES . " where status = '1' and bin ='0'";
$result = mysql_query($q);
while($row = mysql_fetch_array($result)) {
	$id = $row['id'];
}

$t = "pdf"; // options: pdf, html
echo($publishersMenues->printMenue($id,$t));

?>