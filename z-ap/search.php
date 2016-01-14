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
    $priCd = $_POST['priCd'];
    $qtyCd = $_POST['qtyCd'];

    $item->setCode($code);
    $item->setName($name);
    $item->setPrice($price);
    $item->setQty($qty);
    $item->setDetail($detail);

    $items = array();
    $items = $dao->getItem($item, $priCd, $qtyCd);
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
<title>検索結果</title>
</head>
<body>

<?php if (isset($error)){ ?>
  <p><?=$util->h($error)?></p>
<?php }else{ ?>
<table border="1">
		<tr>
			<td>商品コード</td>
			<td>名前</td>
			<td>値段</td>
			<td>在庫数</td>
			<td>詳細</td>
		</tr>
<?php foreach  ($items as $item){ ?>
		<tr>
			<td><?=$util->h($item->getCode())?></td>
			<td><?=$util->h($item->getName())?></td>
			<td><?=$util->h($item->getPrice())?></td>
			<td><?=$util->h($item->getQty())?></td>
			<td><?=$util->h($item->getDetail())?></td>
			<td><button class="update" >変更</button></td>
			<td><button class="delete" >削除</button></td>
		</tr>
<?php } ?>
	</table>
	<form action="" class="hidform" method="POST">
		<input type="hidden" value="" class="code" name="code">
	</form>
	<a href="menu.html" class="btn_menu">メニュー</a>
<?php } ?>


</body>
</html>