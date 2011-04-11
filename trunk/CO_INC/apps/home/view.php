<div id="home" class="app">
<input name="home-current" id="home-current" type="hidden" value="home" />
<div class="topbar"><img src="../../data/recheis.png" style="margin: 2px 0 0 31px;"/></div>
 <!-- <p>HOME </p>
  <p>Let's go to <a href="#" class="loadModule1" rel="1"> Grossprojekt 7</a> from here<br />
  </p>-->
  <div id="columns" class="scroll-pane">
    <ul  id="column1" class="column">
        <li class="widget widget-home">
        	<div class="widget-head"><a class="collapse" href="#">COLLAPSE</a><h3>platform/status</h3></div>
        	<div class="widget-content"><!--<img src="apps/home/col_1_1.jpg" width="321" height="256" />-->
            <?php $home->getChart();?><img src="/data/charts/some_chart_image.png" />
            </div>
        </li>
        <li class="widget widget-home">
        	<div class="widget-head widget-home"><a class="collapse" href="#">COLLAPSE</a><h3>service information</h3></div>
        	<div class="widget-content widget-home"><img src="CO_INC/apps/home/col_1_2.jpg" width="321" height="249" /></div>
        </li>
    </ul>
    
    <ul id="column2" class="column">
        <li class="widget widget-notes">
        	<div class="widget-head"><a class="collapse" href="#">COLLAPSE</a><h3>notes</h3></div>
        	<div class="widget-content widget-notes-inner">NOTE: Here you can see notes, which either were written by another user (for your attention) or which you wrote to yourself as reminders.</div>
        </li>
    </ul>
    
    <ul id="column3" class="column">
        <li class="widget widget-projects">
        	<div class="widget-head"><a class="collapse" href="#">COLLAPSE</a><h3>project information</h3></div>
        	<div class="widget-content widget-projects-inner">NOTE: Here you can see notifications, which either were written by another project administrator (for your attention) or milestone informations which are important not to be forgotten about</div>
        </li>
        <li class="widget widget-email">
        	<div class="widget-head"><a class="collapse" href="#">COLLAPSE</a><h3>email information</h3></div>
        	<div class="widget-content widget-email-inner">NOTE: Here you can get information about your  incoming mails</div>
        </li>
    </ul>
    
    <ul id="column4" class="column">
        <li class="widget widget-home">
        	<div class="widget-head"><a class="collapse" href="#">COLLAPSE</a><h3>today's tasks</h3></div>
        	<div class="widget-content widget-home-inner">
            <div id="calendar-widget"></div>
            <img src="CO_INC/apps/home/col_4_1.jpg" width="321" height="563" /></div>
        </li>
    </ul>
</div>
</div>