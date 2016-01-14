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

    $items = array();
    $items = $dao->getItem($item, 0, 0);
} catch (Exception $e) {
    $error = $e->getMessage();
}

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>変更情報入力</title>
</head>
<body>
<?php if (isset($error)){ ?>
  <p><?=$util->h($error)?></p>
<?php }else{ ?>
<p>以下のデータを削除しますか？？</p>
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
		</tr>
<?php } ?>
	</table>
	<form action="delete.php" method="post">
		<input type="hidden" name="code" value="<?=$code?>" />
		<input type="submit" value="削除">
	</form>

	<a href="menu.html" class="btn_menu">メニュー</a>
<?php } ?>

</body>
</html>