<?php
/*************************************/
/*           ezRPG script            */
/*         Written by Zeggy          */
/*  http://code.google.com/p/ezrpg   */
/*    http://www.ezrpgproject.com/   */
/*************************************/

include("lib.php");
define("PAGENAME", "Hospital");
$player = check_user($secret_key, $db);
include("checkbattle.php");

$query = $db->execute("update `players` set `last_active`=? where `id`=?", array(time(), $player->id));

include("checkwork.php");

if ($_POST['submit']) {


	if (!is_numeric($_POST['sellhp'])){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>O valor que voc� inseriu n�o � valido.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}


	if (!is_numeric($_POST['sellbhp'])){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>O valor que voc� inseriu n�o � valido.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	if (!is_numeric($_POST['sellep'])){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>O valor que voc� inseriu n�o � valido.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	if (!is_numeric($_POST['sellmp'])){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>O valor que voc� inseriu n�o � valido.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	$query = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=136 and `mark`='f' order by rand()", array($player->id));
	$numerodepocoes = $query->recordcount();

	$query2 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=137 and `mark`='f' order by rand()", array($player->id));
	$numerodepocoes2 = $query2->recordcount();

	$query3 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=148 and `mark`='f' order by rand()", array($player->id));
	$numerodepocoes3 = $query3->recordcount();

	$query4 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=150 and `mark`='f' order by rand()", array($player->id));
	$numerodepocoes4 = $query4->recordcount();

	$pocoesdevida = floor($_POST['sellhp']);
	if ($pocoesdevida > $numerodepocoes){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� n�o possui " . $pocoesdevida . " po��es de vida.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	$bigpocoesdevida = floor($_POST['sellbhp']);
	if ($bigpocoesdevida > $numerodepocoes3){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� n�o possui " . $bigpocoesdevida . " po��es grandes de vida.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	$pocoesdeenergia = floor($_POST['sellep']);
	if ($pocoesdeenergia > $numerodepocoes2){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� n�o possui " . $pocoesdeenergia . " po��es de energia.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	$pocoesdemana = floor($_POST['sellmp']);
	if ($pocoesdemana > $numerodepocoes4){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� n�o possui " . $pocoesdeenergia . " po��es de mana.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	$ganha = ($pocoesdevida * 1250);
	$ganha2 = ($bigpocoesdevida * 2000);
	$ganha22 = ($pocoesdeenergia * 2000);
	$ganha222 = ($pocoesdemana * 1000);
	$ganha3 = $ganha + $ganha2 + $ganha22 + $ganha222;

	$numerohp = $pocoesdevida;
	$numerobhp = $bigpocoesdevida;
	$numeroep = $pocoesdeenergia;
	$numeromp = $pocoesdemana;

	$query = $db->execute("delete from `items` where `item_id`=? and `player_id`=? limit $numerohp", array(136, $player->id));
	$query = $db->execute("delete from `items` where `item_id`=? and `player_id`=? limit $numeroep", array(137, $player->id));
	$query = $db->execute("delete from `items` where `item_id`=? and `player_id`=? limit $numerobhp", array(148, $player->id));
	$query = $db->execute("delete from `items` where `item_id`=? and `player_id`=? limit $numeromp", array(150, $player->id));
	$query = $db->execute("update `players` set `gold`=? where `id`=?", array($player->gold + $ganha3, $player->id));

	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� vendeu " . $pocoesdevida . " po��es de vida por " . $ganha . " de ouro.<br/></i>";
	echo "<i>Voc� vendeu " . $bigpocoesdevida . " po��es grandes de vida por " . $ganha2 . " de ouro.<br/></i>";
	echo "<i>Voc� vendeu " . $pocoesdeenergia . " po��es de energia por " . $ganha22 . " de ouro.<br/></i>";
	echo "<i>Voc� vendeu " . $pocoesdemana . " po��es de mana por " . $ganha222 . " de ouro.<br/></i>";
	echo "<i>Voc� faturou: " . $ganha3 . " de ouro.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;


}


	//Add possibility of PARTIAL healing in next version?

	$heal = $player->maxhp - $player->hp;

		if($player->level < 36){
		$cost = ceil($heal * 1);
		}
		else if (($player->level > 35) and ($player->level < 90)){
		$cost = ceil($heal * 1.45);
		}else{
		$cost = ceil($heal * 1.8);
		}
	
if ($_GET['act'])
{

	if($_GET['act'] == sell){
	$query = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=136 and `mark`='f'", array($player->id));
	$numerodepocoes = $query->recordcount();

	$query2 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=137 and `mark`='f'", array($player->id));
	$numerodepocoes2 = $query2->recordcount();

	$query3 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=148 and `mark`='f'", array($player->id));
	$numerodepocoes3 = $query3->recordcount();

	$query4 = $db->execute("select `id` from `items` where `player_id`=? and `item_id`=150 and `mark`='f'", array($player->id));
	$numerodepocoes4 = $query4->recordcount();

	$total = $numerodepocoes + $numerodepocoes2 + $numerodepocoes3 + $numerodepocoes4;
	if ($total < 1){
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� n�o possui po��es para vender.<br/></i>";
	echo "</fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}

	include("templates/private_header.php");
	echo "<fieldset><legend><b>Vender po��es</b></legend>\n";
	echo "<i>Voc� possui <b>" . $numerodepocoes . " po��es de vida</b> e <b>" . $numerodepocoes2 . " po��es de energia</b>.<br/></i>";
	echo "<form method=\"POST\" action=\"hospt.php\">";
	echo "Quero vender: <input type=\"text\" name=\"sellhp\" size=\"3\" value=\"0\"> po��es de vida. (1250 de ouro cada)<br/>";
	echo "Quero vender: <input type=\"text\" name=\"sellbhp\" size=\"3\" value=\"0\"> po��es grandes de vida. (2000 de ouro cada)<br/>";
	echo "Quero vender: <input type=\"text\" name=\"sellep\" size=\"3\" value=\"0\"> po��es de energia. (2000 de ouro cada)<br/>";
	echo "Quero vender: <input type=\"text\" name=\"sellmp\" size=\"3\" value=\"0\"> po��es de mana. (1000 de ouro cada)";
	echo "<br/><br/><input type=\"submit\" name=\"submit\" value=\"Vender\">";
	echo "</form></fieldset>\n";
	echo '<a href="inventory.php">Voltar ao invent�rio.</a>';
	include("templates/private_footer.php");
	exit;
	}


	if ($_GET['act'] == heal){
if ($player->hp == $player->maxhp)
{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Hospital</b></legend>\n";
	echo "<b>Enfermeira: </b>\n";
	echo "<i>Voc� esta com a vida cheia! Voc� n�o precisa ser curado.</i><br/>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
}

		if ($player->gold < $cost)
		{
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� n�o possui ouro suficiente!</i><br>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
		}
		else
		{
			$query = $db->execute("update `players` set `gold`=?, `hp`=? where `id`=?", array($player->gold - $cost, $player->maxhp, $player->id));
			$player = check_user($secret_key, $db); //Get new stats
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� acaba de ser curado!<br/></i>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
		}
	}else if($_GET['act'] == potion){
		if (!$_GET['pid']){
		include("templates/private_header.php");
		echo "<fieldset><legend><b>Erro</b></legend>\n";
		echo "<i>Um erro desconhecido ocorreu. Contate o administrador.<br/></i>\n";
		echo '<a href="hospital.php">Retornar ao Hospital.</a>';
		echo "</fieldset>\n";
		include("templates/private_footer.php");
		exit;
		}

		$query = $db->execute("select * from `items` where `id`=? and `player_id`=?", array($_GET['pid'], $player->id));
		if ($query->recordcount() == 0)
		{
		include("templates/private_header.php");
		echo "<fieldset><legend><b>Erro</b></legend>\n";
		echo "<i>Voc� n�o pode usar esta po��o.<br/></i>\n";
		echo '<a href="hospital.php">Retornar ao Hospital.</a>';
		echo "</fieldset>\n";
		include("templates/private_footer.php");
		exit;
		}

		$potion = $query->fetchrow();
		
    		if ($potion['mark'] == t){
		include("templates/private_header.php");
		echo "<fieldset><legend><b>Erro</b></legend>\n";
		echo "<i>Voc� n�o pode usar um item que est� a venda no mercado.<br/></i>\n";
		echo '<a href="hospital.php">Retornar ao Hospital.</a>';
		echo "</fieldset>\n";
		include("templates/private_footer.php");
		exit;
		}

    		if (($potion['item_id'] != 136) and ($potion['item_id'] != 137) and ($potion['item_id'] != 148) and ($potion['item_id'] != 150)){
		include("templates/private_header.php");
		echo "<fieldset><legend><b>Erro</b></legend>\n";
		echo "<i>Este item n�o � uma po��o.<br/></i>\n";
		echo '<a href="hospital.php">Retornar ao Hospital.</a>';
		echo "</fieldset>\n";
		include("templates/private_footer.php");
		exit;
		}

			if ($potion['item_id'] == 136){
	if ($player->hp == $player->maxhp)
	{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Hospital</b></legend>\n";
	echo "<b>Enfermeira: </b>\n";
	echo "<i>Voc� esta com a vida cheia! Voc� n�o precisa ser curado.</i><br/>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
	}
			$pocaoajuda = $player->hp + 5000;
			if ($pocaoajuda < $player->maxhp){
			$query = $db->execute("update `players` set `hp`=? where `id`=?", array($player->hp + 5000, $player->id));
			$palavra = "parte de";
			}else{
			$query = $db->execute("update `players` set `hp`=? where `id`=?", array($player->maxhp, $player->id));
			$palavra = "toda";
			}
			$query = $db->execute("delete from `items` where `id`=?", array($potion['id']));
			$player = check_user($secret_key, $db); //Get new stats
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� usou sua po��o e recuperou " . $palavra . " sua vida.<br/></i>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
			}



			if ($potion['item_id'] == 148){
	if ($player->hp == $player->maxhp)
	{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Hospital</b></legend>\n";
	echo "<b>Enfermeira: </b>\n";
	echo "<i>Voc� esta com a vida cheia! Voc� n�o precisa ser curado.</i><br/>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
	}
			$pocaoajuda = $player->hp + 10000;
			if ($pocaoajuda < $player->maxhp){
			$query = $db->execute("update `players` set `hp`=? where `id`=?", array($player->hp + 10000, $player->id));
			$palavra = "parte de";
			}else{
			$query = $db->execute("update `players` set `hp`=? where `id`=?", array($player->maxhp, $player->id));
			$palavra = "toda";
			}
			$query = $db->execute("delete from `items` where `id`=?", array($potion['id']));
			$player = check_user($secret_key, $db); //Get new stats
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� usou sua po��o e recuperou " . $palavra . " sua vida.<br/></i>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
			}



			if ($potion['item_id'] == 137){
if ($player->energy == $player->maxenergy)
{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Hospital</b></legend>\n";
	echo "<b>Enfermeira: </b>\n";
	echo "<i>Voc� esta com a energia m�xima! Voc� n�o precisa desta po��o.</i><br/>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
}

				if (($player->energy + $setting->energy_potion) > $player->maxenergy){
				$query = $db->execute("update `players` set `energy`=? where `id`=?", array($player->maxenergy, $player->id));
				$palavra = "parte de";
				}else{
				$query = $db->execute("update `players` set `energy`=? where `id`=?", array($player->energy + $setting->energy_potion, $player->id));
				$palavra = "toda";
				}
			$query = $db->execute("delete from `items` where `id`=?", array($potion['id']));
			$player = check_user($secret_key, $db); //Get new stats
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� usou sua po��o e recuperou " . $palavra . " sua energia.<br/></i>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
			}


			if ($potion['item_id'] == 150){
if ($player->mana == $player->maxmana)
{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Hospital</b></legend>\n";
	echo "<b>Enfermeira: </b>\n";
	echo "<i>Voc� esta com a mana ao m�ximo! Voc� n�o precisa desta po��o.</i><br/>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
}

				if (($player->mana + 500) > $player->maxmana){
				$query = $db->execute("update `players` set `mana`=`maxmana` where `id`=?", array($player->id));
				$palavra = "parte de";
				}else{
				$query = $db->execute("update `players` set `mana`=`mana`+500 where `id`=?", array($player->id));
				$palavra = "toda";
				}

			$query = $db->execute("delete from `items` where `id`=?", array($potion['id']));
			$player = check_user($secret_key, $db); //Get new stats
			include("templates/private_header.php");
			echo "<fieldset><legend><b>Hospital</b></legend>\n";
	                echo "<b>Enfermeira: </b>\n";
			echo "<i>Voc� usou sua po��o e recuperou " . $palavra . " sua mana.<br/></i>\n";
			echo '<a href="hospital.php">Retornar ao Hospital.</a>';
                        echo "</fieldset>\n";
			include("templates/private_footer.php");
			exit;
			}


	}else{
	include("templates/private_header.php");
	echo "<fieldset><legend><b>Erro</b></legend>\n";
	echo "<i>Um erro desconhecido ocorreu. Contate o administrador.<br/></i>\n";
	echo '<a href="hospital.php">Retornar ao Hospital.</a>';
	echo "</fieldset>\n";
	include("templates/private_footer.php");
	exit;
	}
}

	
	include("templates/private_header.php");
	//Add option to change price of hospital (life to heal * set number chosen by GM in admin panel)
?>
<fieldset><legend><b>Hospital</b></legend>
<b>Enfermeira: </b>
<i>Para recuperar toda sua vida, ir� custar <b><?=$cost?></b> de ouro.</i><br />
<a href="hospt.php?act=heal">Curar!</a>
</fieldset>
<?php
include("templates/private_footer.php");
?>