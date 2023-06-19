<?php
	include("lib.php");
	define("PAGENAME", "Batalhar");
	$player = check_user($secret_key, $db);
	include("checkbattle.php");
	include("checkhp.php");
	include("checkwork.php");

	include("templates/private_header.php");

if (($player->stat_points > 0) and ($player->level < 15))
{
	echo "<div style=\"background-color:#45E61D; padding:5px; border: 1px solid #DEDEDE; margin-bottom:10px\">Antes de batalhar, utilize seus <b>" . $player->stat_points . "</b> pontos de status dispon�veis, assim voc� fica mais forte! <a href=\"stat_points.php\">Clique aqui para utiliza-los!</a></div>";
}

$query = $db->execute("select * from `items` where `player_id`=? and `status`='equipped'", array($player->id));
if (($query->recordcount() < 2) and ($player->level > 4) and ($player->level < 20))
{
	echo "<div style=\"background-color:#45E61D; padding:5px; border: 1px solid #DEDEDE; margin-bottom:10px\">J� est� na hora de voc� comprar seus pr�pios itens. <a href=\"shop.php\">Clique aqui e visite o ferreiro</a>.</div>";
}
?>

<fieldset><legend><b>Batalhar</b></legend>
<b>Ajudante: </b>
<i>Ol�, voc� deseja lutar contra <a href="monster.php">monstros</a> ou lutar contra os outros <a href="battle.php">jogadores</a>?</i>

</fieldset>
<?php
	include("templates/private_footer.php");
?>