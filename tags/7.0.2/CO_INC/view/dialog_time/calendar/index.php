<?php
include_once(CO_INC . "/classes/ajax_header.inc");
include_once(CO_INC . "/apps/projects/lang/" . $session->userlang . ".php");
$field = $_GET["field"];
$time = $_GET["time"];
?>
<div aria-live="off" id="coTime--field2" class="coTime-pkr">
  <div style="width: 152px; height: 241px;" class="coTime-body">
    <div style="width: 141px; height: 241px;" class="coTime-time">
      <div class="coTime-hrs">
        <h6 class="coTime-lbl coTime-lbl-hr">Stunde</h6>
        <ul class="coTime-hrs-am">
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr0-btn ui-state-default" title="<?php echo($field);?>">00</a>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr1-btn ui-state-default" title="<?php echo($field);?>">01</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr2-btn ui-state-default" title="<?php echo($field);?>">02</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr3-btn ui-state-default" title="<?php echo($field);?>">03</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr4-btn ui-state-default" title="<?php echo($field);?>">04</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr5-btn ui-state-default" title="<?php echo($field);?>">05</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr6-btn ui-state-default" title="<?php echo($field);?>">06</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr7-btn ui-state-default" title="<?php echo($field);?>">07</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr8-btn ui-state-default" title="<?php echo($field);?>">08</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr9-btn ui-state-default" title="<?php echo($field);?>">09</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr10-btn ui-state-default" title="<?php echo($field);?>">10</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr11-btn ui-state-default" title="<?php echo($field);?>">11</li>
        </ul>
        <ul class="coTime-hrs-pm">
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr12-btn ui-state-default" title="<?php echo($field);?>">12</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr13-btn ui-state-default" title="<?php echo($field);?>">13</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr14-btn ui-state-default" title="<?php echo($field);?>">14</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr15-btn ui-state-default" title="<?php echo($field);?>">15</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr16-btn ui-state-default" title="<?php echo($field);?>">16</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr17-btn ui-state-default" title="<?php echo($field);?>">17</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr18-btn ui-state-default" title="<?php echo($field);?>">18</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr19-btn ui-state-default" title="<?php echo($field);?>">19</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr20-btn ui-state-default" title="<?php echo($field);?>">20</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr21-btn ui-state-default" title="<?php echo($field);?>">21</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr22-btn ui-state-default" title="<?php echo($field);?>">22</li>
          <li class="coTime-btn coCalendarTime-hr-btn coTime-hr23-btn ui-state-default" title="<?php echo($field);?>">23</li>
        </ul>
      </div>
      <div class="coTime-mins">
        <h6 class="coTime-lbl coTime-lbl-min">Minute</h6>
        <ul class="coTime-mins-tens">
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min00-btn ui-state-default" title="<?php echo($field);?>">0</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min10-btn ui-state-default" title="<?php echo($field);?>">1</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min20-btn ui-state-default" title="<?php echo($field);?>">2</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min30-btn ui-state-default" title="<?php echo($field);?>">3</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min40-btn ui-state-default" title="<?php echo($field);?>">4</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min50-btn ui-state-default" title="<?php echo($field);?>">5</li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min60-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min70-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min80-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min90-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min100-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-ten-btn coTime-min110-btn ui-state-default coTime-min-ten-btn-empty ui-state-disabled"> </li>
        </ul>
        <ul class="coTime-mins-ones">
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min0-btn ui-state-default" title="<?php echo($field);?>">0</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min1-btn ui-state-default" title="<?php echo($field);?>">1</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min2-btn ui-state-default" title="<?php echo($field);?>">2</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min3-btn ui-state-default" title="<?php echo($field);?>">3</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min4-btn ui-state-default" title="<?php echo($field);?>">4</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min5-btn ui-state-default" title="<?php echo($field);?>">5</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min6-btn ui-state-default" title="<?php echo($field);?>">6</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min7-btn ui-state-default" title="<?php echo($field);?>">7</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min8-btn ui-state-default" title="<?php echo($field);?>">8</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min9-btn ui-state-default" title="<?php echo($field);?>">9</li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min100-btn ui-state-default coTime-min-one-btn-empty ui-state-disabled"> </li>
          <li class="coTime-btn coCalendarTime-min-one-btn coTime-min110-btn ui-state-default coTime-min-one-btn-empty ui-state-disabled"> </li>
        </ul>
      </div>
    </div>
  </div>
</div>
