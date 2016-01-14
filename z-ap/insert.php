<?php
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/ItemDto.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/dao/ItemDao.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/Util.php';

try {
    $dao = new ItemDao();
    $item = new ItemDto();
    $util = new Util();

    $code = $_POST['code'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $detail = $_POST['detail'];

    $item->setCode($code);
    $item->setName($name);
    $item->setPrice($price);
    $item->setQty($qty);
    $item->setDetail($detail);

    $result = $dao->insertItem($item);
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
<title>登録結果</title>
</head>
<body>
<?php if (isset($error)){ ?>
  <p><?=$util->h($error)?></p>
<?php }else{ ?>
<p>
		&nbsp;<b><?=$result?></b>&nbsp;行追加しました。
	</p>
	<form action="" class="hidform" method="POST">
		<input type="hidden" value="" class="code" name="code">
	</form>
	<a href="menu.html" class="btn_menu">メニュー</a>
<?php } ?>


</body>
</html>