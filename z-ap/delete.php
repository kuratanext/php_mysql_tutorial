<?php
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/ItemDto.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/dao/ItemDao.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/Util.php';

try {
    $dao = new ItemDao();
    $item = new ItemDto();
    $util = new Util();

    $code = $_POST['code'];

    $item->setCode($code);
    $item->setName("");
    $item->setPrice(0);
    $item->setQty(0);
    $item->setDetail("");

    $result = $dao->deleteItem($code);
} catch (Exception $e) {
    $error = $e->getMessage();
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript"
	src="../javascript/jquery/jquery-2.1.4.js"></script>
<script type="text/javascript" src="zapp.js"></script>
<title>削除結果</title>
</head>
<body>
<?php if (isset($error)){ ?>
  <p><?=$util->h($error)?></p>
<?php }else{ ?>
<p>
		&nbsp;<b><?=$result?></b>&nbsp;行削除しました。
	</p>
	<form action="" class="hidform" method="POST">
		<input type="hidden" value="" class="code" name="code">
	</form>
	<a href="menu.html" class="btn_menu">メニュー</a>
<?php } ?>


</body>
</html>