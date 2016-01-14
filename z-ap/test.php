<?php
require_once 'J:/enrlprc/html/kura/z-ap/ItemDto.php';
require_once 'J:/enrlprc/html/kura/z-ap/dao/ItemDao.php';

$dao = new ItemDao();
$item = new ItemDto();

echo "--------検索----------\n";

$item->setCode("");
$item->setName("");
$item->setPrice(0);
$item->setQty(0);
$item->setDetail("");

$items = array();
$items = $dao->getItem($item, 0, 0);

foreach ($items as $item) {
    echo"---------------------------------\n";
    echo 'code==>' . $item->getCode()."\n";
    echo 'name==>' . $item->getName()."\n";
    echo 'price==>' . $item->getPrice()."\n";
    echo 'qty==>' . $item->getQty()."\n";
    echo 'detail==>' . $item->getDetail()."\n";
    echo"---------------------------------\n";
}

echo "--------削除----------\n";

$result = $dao->deleteItem(8888);
var_dump($result);


$item->setCode(8888);
$item->setName("");
$item->setPrice(0);
$item->setQty(0);
$item->setDetail("");

$items = $dao->getItem($item, 0, 0);

foreach ($items as $item) {
    echo"---------------------------------\n";
    echo 'code==>' . $item->getCode()."\n";
    echo 'name==>' . $item->getName()."\n";
    echo 'price==>' . $item->getPrice()."\n";
    echo 'qty==>' . $item->getQty()."\n";
    echo 'detail==>' . $item->getDetail()."\n";
    echo"---------------------------------\n";
}

echo "--------追加----------\n";

$item->setCode(8888);
$item->setName("");
$item->setPrice(0);
$item->setQty(0);
$item->setDetail("");

$result = $dao->insertItem($item);
var_dump($result);

$items = $dao->getItem($item, 0, 0);

foreach ($items as $item) {
    echo"---------------------------------\n";
    echo 'code==>' . $item->getCode()."\n";
    echo 'name==>' . $item->getName()."\n";
    echo 'price==>' . $item->getPrice()."\n";
    echo 'qty==>' . $item->getQty()."\n";
    echo 'detail==>' . $item->getDetail()."\n";
    echo"---------------------------------\n";
}


echo "--------変更----------\n";

$item->setCode(8888);
$item->setName("ダークマター");
$item->setPrice(999999);
$item->setQty(0);
$item->setDetail("存在しないもの");

$result = $dao->updateItem(8888, $item);
var_dump($result);

$items = $dao->getItem($item, 0, 0);

foreach ($items as $item) {
    echo"---------------------------------\n";
    echo 'code==>' . $item->getCode()."\n";
    echo 'name==>' . $item->getName()."\n";
    echo 'price==>' . $item->getPrice()."\n";
    echo 'qty==>' . $item->getQty()."\n";
    echo 'detail==>' . $item->getDetail()."\n";
    echo"---------------------------------\n";
}


