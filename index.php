<?php
include_once "./env.php";
$url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=" . $channelId . "&redirect_uri=
" . $redirectUri . "&state=" . rand() . "&scope=profile%20openid%20email";

?>
<a href="<?= $url ?>"><img src="./btn_login_base.png" alt=""></a>