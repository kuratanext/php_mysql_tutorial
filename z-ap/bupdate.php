<?php
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/ItemDto.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/dao/ItemDao.php';
require_once '/export/home/g2sn/enrlprc/html/kura/z-ap/Util.php';

try {
    $dao = new ItemDao();
    $item = new ItemDto();
    $util = new Util();

    $bcode = $_POST['code'];

    $item->setCode($bcode);
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
<?php foreach  ($items as $item){ ?>
	<form action="update.php" method="post">
			<input type="hidden" name="bcode" value="<?=$bcode ?>" />
			商品コード：
			<input type="text" name="code"
				value="<?=$util->h($item->getCode())?>" />
			<br>
			名前：
			<input type="text" name="name"
				value="<?=$util->h($item->getName())?>" />
			<br>
			値段：
			<input type="text" name="price"
				value="<?=$util->h($item->getPrice())?>" />
			<br>
			在庫数：
			<input type="text" name="qty" value="<?=$util->h($item->getQty())?>" />
			<br>
			<br>
			詳細
			<br>
			<textarea name="detail" cols="40" rows="5"><?=$util->h($item->getDetail())?></textarea>
			<br>
			<input type="submit" value="&nbsp;変&nbsp;&nbsp;更&nbsp;"
				class="update" />
			<input type="reset" value="リセット" />
		</form>
<?php } ?>

	<a href="menu.html" class="btn_menu">メニュー</a>
<?php } ?>


</body>
</html>