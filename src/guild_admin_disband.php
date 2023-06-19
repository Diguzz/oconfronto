<?php

/*************************************/
/*           ezRPG Script            */
/*         Written by Khashul        */
/*  http://code.google.com/p/ezrpg   */
/*    http://www.bbgamezone.com/     */
/*************************************/

include("lib.php");
define("PAGENAME", "Desfazer Cl�");
$player = check_user($secret_key, $db);
include("checkbattle.php");
include("checkguild.php");

//Populates $guild variable
$query = $db->execute("select * from `guilds` where `id`=?", array($player->guild));

if ($query->recordcount() == 0) {
    header("Location: home.php");
} else {
    $guild = $query->fetchrow();
}

include("templates/private_header.php");

//Guild Leader Admin check
if ($player->username != $guild['leader']) {
    echo "<p />Voc� n�o pode acessar esta p�gina.<p />";
    echo "<a href=\"home.php\">Home</a><p />";
} else {

if ($_GET['act'] == "go") {
		$query4 = $db->execute("select `id` from `players` where `guild`=?", array($guild['id']));
		while($member = $query4->fetchrow()) {
		$logmsg = "A gangue " . $guild['name'] . " foi deletada pelo lider do cl�.";
		addlog($member['id'], $logmsg, $db);
		}
        $query = $db->execute("delete from `guilds` where `id`=?", array($player->guild));
        $query = $db->execute("update `players` set `guild`=? where `guild`=?", array(NULL, $guild['id']));
        echo "<p />Seu cl� foi excluido com sucesso.<p />";
        echo "<a href=\"home.php\">Principal</a><p />";
} else {
echo "<p />Voc� tem certeza que quer excluir o cl�: " . $guild['name'] . "?<p />";
echo "<a href=\"guild_admin_disband.php?act=go\">Desfazer Cl�</a><p />";
}

}
include("templates/private_footer.php");
?>