<?php

include("lib.php");
define("PAGENAME", "F�rum");
$player = check_user($secret_key, $db);

include("templates/private_header.php");

if (!$_GET['player'])
{
	echo "Nenhum usu�rio foi selecionado! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}elseif ($player->gm_rank < 3)
	{
	echo "Voc� n�o pode acessar esta p�gina! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}elseif ($player->alert > 99)
	{
	echo "Este usu�rio est� banido! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
	}else{

$user = $db->execute("select `username`, `gm_rank` from `players` where `id`=?", array($_GET['player']));
if ($user->recordcount() == 0) {
	echo "Este usu�rio n�o existe! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}

    $user2 = $user->fetchrow();

if(isset($_POST['alert']))
{

if (!$_POST['motivo'])
{
	echo "Voc� precisa digitar o motivo do alerta! <a href=\"forum_alert.php?player=" . $_GET['player'] . "\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}

if (!$_POST['days'])
{
	echo "Voc� precisa digitar o tempo do alerta! <a href=\"forum_alert.php?player=" . $_GET['player'] . "\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}

if (!$_POST['days'])
{
	echo "O numero de dias digitado n�o � v�lido! <a href=\"forum_alert.php?player=" . $_GET['player'] . "\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}
if ($player->gm_rank <= $user2['gm_rank']){
	echo "Voc� n�o pode alertar Moderadores/Administradores! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}



$ban = $db->execute("update `players` set `alerts`=`alerts`+? where `id`=?", array($_POST['days'], $_GET['player']));
	$logmsg = "Voc� foi alertado no f�rum em " . strip_tags($_POST['days']) . "%.<br/><b>Motivo:</b> " . strip_tags($_POST['motivo']) . "";
	addlog($_GET['player'], $logmsg, $db);

	$logalert2 = "" . $user2['username'] . " foi alertado em " . strip_tags($_POST['days']) . "% pelo moderador <b>" . $player->username . "</b><br/><b>Motivo:</b> " . strip_tags($_POST['motivo']) . "";
	forumlog($logalert2, $db);

	echo "" . $user2['username'] . " foi alertado em " . strip_tags($_POST['days']) . "%! <a href=\"select_forum.php\">Voltar</a>.";
	include("templates/private_footer.php");
	exit;
}

	
	echo "<form method=\"POST\" action=\"forum_alert.php?player=" . $_GET['player'] . "\">";
	echo "<b>Deseja alertar " . $user2['username'] . "?</b><br/>";
	echo "<b>Alertar em:</b> <input type=\"text\" name=\"days\" size=\"5\"/>%. <font size=1>(Ao atingir 100% ele ser� banido).</font><br/>";
	echo "<b>Motivo:</b> <input type=\"text\" name=\"motivo\" size=\"40\"/> ";
	echo " <input type=\"submit\" name=\"alert\" value=\"Alertar!\"><br/>(<b>OBS:</b> O alerta de cada usu�rio desce 1% por dia!)</form>";
	include("templates/private_footer.php");
	exit;
	
}
include("templates/private_footer.php");
?>