<?php
				$sdf = intval(rand(0, 10));
				if ($sdf < 6){
				$_SESSION['ataques'] .= "Voc� tentou fugir mas falhou.<br/>";
				$morreu = 5;
				}else{
				$fugir = 5;
				}
?>
