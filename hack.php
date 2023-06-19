<?php
	include("lib.php");
	define("PAGENAME", "Suporte");
	$player = check_user($secret_key, $db);
	include("templates/private_header.php");

if ($player->gm_rank > 75)
{
	if ($_GET['ignore']){
	$db->execute("update `players` set `hack`='f' where `id`=?", array($_GET['ignore']));
	echo "" . $_GET['name'] . " marcado como n�o hackeado.";
	include("templates/private_footer.php");
	exit;
	}

	$query = $db->execute("select `id`, `username`, `gold`, `bank`, `level` from `players` where `hack`='t' order by `level` desc");

	if($query->recordcount() == 0){
	echo "Ningu�m Hackeado =)";
	include("templates/private_footer.php");
	exit;
	}

	while($member = $query->fetchrow())
	{
	echo "<b>Nome:</b> " . $member['username'] . " | <b>N�vel:</b> " . $member['level'] . " | <b>Ouro:</b> " . ($member['gold'] + $member['bank']) . " | <a href=\"hack.php?ignore=" . $member['id'] . "&name=" . $member['username'] . "\">Ignorar</a> - <a href=\"backitens.php?from=" . $member['username'] . "\">Procurar Itens</a><br/>";
	}

	include("templates/private_footer.php");
	exit;
}else{


	if ($_POST['submit']){
	$db->execute("update `players` set `hack`='t' where `username`=?", array($player->username));
	echo "Ok, agora sabemos que voc� precisa de ajuda, mas n�o podemos prometer que voc� ter� seus itens devolta.";
	include("templates/private_footer.php");
	exit;
	}

	echo "Esta p�gina � destinada � usu�rios que tiveram <b>itens ou ouro roubados nos �ltimos 10 dias</b>.<br/>";
	echo "Se voc� <b>n�o passou sua conta</b> para ningu�m, e quer seus itens devolta, clique em \"Fui hackeado\" abaixo.<br/>";
	echo "<u>Lembre-se, isto n�o � brincadeira, se voc� deu sua senha para alguem ou n�o teve seus itens roubados, ser� marcado como mentiroso e ser� punido.</u><br/><br/>";
	echo "<form action=\"hack.php\" method=\"post\"><center><input type=\"submit\" name=\"submit\" value=\"Fui hackeado\" /></center><br/><br/><b>OBS:</b> Se faz mais de 10 dias que voc� foi hackeado, n�o clique em \"Fui Hackeado\", pois os nossos logs se apag�o depois deste tempo e voc� s� vai gastar o tempo da nossa equipe.</form>";
	include("templates/private_footer.php");

}
?>