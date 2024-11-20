<?php
/*
 * index.php - SSI NEWSLETTER: Startseite und mit den neuesten News
 *
 * @author Martin Mollay
 * @last-changed 2018-10-09 MM
 *
 */

$setContent = '
<br><br><br>
<div align=center>		
	<img src="images/logo.png">
	<br><br><br>
	
	<div style="max-width:900px">
		
<div class="message large ui">
		<label class="ui label right corner green"><i class="icon refresh"></i></label>				
			<div class="header ui green">Newsletter 6.3 <div class="label basic ui">28.09.2020</div></div>
	  		<ul class="list">
				<li>Erweiterte Importmöglichkeiten</li>
				<li>Abschlankter und verbesserter Quellcode</li>
				<li>Detailierte Infos nach Versand von Testmails</li> 
			</ul>
		</div>
	</div>
</div>
';

echo $setContent;

// <div class="message large ui">
// <div class="header ui green">Newsletter 5.6  <div class="label basic ui">10.03.2018</div></div>
// <ul class="list">
// <li>Mistkübel statt löschen zu Wiederherstellen der Newsletter</li>
// <li>Weites Import-Format für Kontakte</li>

// </ul>
// </div>