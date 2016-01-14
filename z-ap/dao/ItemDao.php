<?php
require_once 'J:/enrlprc/html/kura/z-ap/ItemDto.php';

/**
 * DatabaseAccessObject
 *
 * @author kurata
 *
 */
class ItemDao
{

    private $pdo = null;

    /**
     * コンストラクタ、PDOによるmysqlへの接続を開始します
     */
    public function __construct()
    {
        $this->pdoConnect();
    }

    private function pdoConnect()
    {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=sampledb000;host=localhost;charset=utf8', 'root',
                'kura',
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
                ));
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }

    /**
     * 文字列をSQL Injection対策のエスケープ処理します。
     *
     * @param String $str
     *            エスケープ処理をする文字列
     * @return mixed 加工後の文字列
     */
    public function esc_str($str)
    {
        return preg_replace('/(?=[!_%])/', '!', $str);
    }

    /**
     * ItemDtoからテーブルitemをselect検索します。
     * 在庫数qtyと値段priceは以上以下の選択ができます。
     *
     * @param ItemDto $item
     *            検索するitemのオブジェクト
     * @param int $priCd
     *            値段コード、0=以上,1=以下
     * @param int $qtyCd
     *            在庫数コード、0=以上,1=以下
     */
    public function getItem($item, $priCd, $qtyCd)
    {
        $code = $item->getCode();
        if (empty($code)) {
            $code = '%';
        }
        $name = $item->getName();
        $price = $item->getPrice();
        $detail = $item->getDetail();
        $qty = $item->getQty();

        $sql = 'select code, name, price, detail, qty
         from item
         where code like ?
         and name like ? ';

        switch ($priCd) {
            case 0:
                $sql .= 'and price >= ? ';
                break;
            case 1:
                $sql .= 'and price <= ? ';
                break;
        }

        switch ($qtyCd) {
            case 0:
                $sql .= 'and qty >= ? ';
                break;
            case 1:
                $sql .= 'and qty <= ? ';
                break;
        }

        if (! empty($detail)) {
            $sql .= 'and detail like ? ';
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $code, PDO::PARAM_INT);
            $stmt->bindValue(2, '%' . $this->esc_str($name) . '%',
                PDO::PARAM_STR);
            $stmt->bindValue(3, $price, PDO::PARAM_INT);
            $stmt->bindValue(4, $qty, PDO::PARAM_INT);
            $stmt->bindValue(5, '%' . $this->esc_str($detail) . '%',
                PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }

        $rItems = array();
        foreach ($stmt as $row) {
            $rItem = new ItemDto();
            $rItem->setCode($row['code']);
            $rItem->setName($row['name']);
            $rItem->setPrice($row['price']);
            $rItem->setDetail($row['detail']);
            $rItem->setQty($row['qty']);
            array_push($rItems, $rItem);
        }
        return $rItems;
    }

    /**
     * Itemテーブルからレコードを削除します。
     *
     * @param int $code
     *            削除対象のコード
     * @return number 削除に成功したレコード数
     */
    public function deleteItem($code)
    {
        $sql = 'delete from item where code = ? ';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $code, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
        return $stmt->rowCount();
    }

    /**
     * itemテーブルにレコードを追加します。
     *
     * @param ItemDto $item
     *            追加したいItemDtoオブジェクト
     * @return int 追加に成功したレコードの数
     */
    public function insertItem($item)
    {
        $code = $item->getCode();
        $name = $item->getName();
        $price = $item->getPrice();
        $qty = $item->getQty();
        $detail = $item->getDetail();

        $sql = 'insert into item (code, name, price, qty, detail) values(?, ?, ?, ?, ?) ';

        try {

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $code, PDO::PARAM_INT);
            $stmt->bindValue(2, $this->esc_str($name), PDO::PARAM_STR);
            $stmt->bindValue(3, $price, PDO::PARAM_INT);
            $stmt->bindValue(4, $qty, PDO::PARAM_INT);
            $stmt->bindValue(5, $this->esc_str($detail), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
        return $stmt->rowCount();
    }

    /**
     * itemテーブルのレコードを上書きします。
     *
     * @param int $beforeCode
     *            変更したい商品のコード
     * @param ItemDto $item
     *            上書きする商品の内容
     * @return int 更新に成功したレコード数
     */
    public function updateItem($beforeCode, $item)
    {
        $code = $item->getCode();
        $name = $item->getName();
        $price = $item->getPrice();
        $qty = $item->getQty();
        $detail = $item->getDetail();

        $sql = 'update item
             set code = ?,
            name = ?,
            price = ?,
            qty = ?,
            detail = ?
            where code = ? ';

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $code, PDO::PARAM_INT);
            $stmt->bindValue(2, $this->esc_str($name), PDO::PARAM_STR);
            $stmt->bindValue(3, $price, PDO::PARAM_INT);
            $stmt->bindValue(4, $qty, PDO::PARAM_INT);
            $stmt->bindValue(5, $this->esc_str($detail), PDO::PARAM_STR);
            $stmt->bindValue(6, $beforeCode, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
        return $stmt->rowCount();
    }
}