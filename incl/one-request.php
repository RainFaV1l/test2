<?php
$sql = "SELECT product.name AS name, product.price AS price, product.unit AS unit
        FROM request_product
        JOIN product ON request_product.product_id = product.id
        WHERE request_product.request_id = :id";
$params = [
    'id' => $_GET['id']
];

$prepareProduct = $conn->prepare($sql);
$prepareProduct->execute($params);

$sql = "SELECT user.fio AS fio, request.create_date AS create_date, request.id AS id
        FROM request
        JOIN user ON request.user_id = user.id
        WHERE request.id = :id";
$prepare = $conn->prepare($sql);
$prepare->execute($params);
$info = $prepare->fetch(PDO::FETCH_ASSOC);
?>
<div class="page__status status">
    <div class="status__container container">
        <h1 class="title__status">Заявка</h1>
        <div class="ddd">
            <div class="info__name">Код заявки:</div>
            <div class="info__target"><?= $info['id'] ?></div>
        </div>
        <div class="ddd">
            <div class="info__name">ФИО:</div>
            <div class="info__target"><?= $info['fio'] ?></div>
        </div>
        <div class="ddd">
            <div class="info__name">Дата отправки:</div>
            <div class="info__target"><?= date('d.m.Y', $info['create_date']) ?></div>
        </div>
        <h2 style="margin-bottom: 20px">Список услуг</h2>
        <div class="cataloge__list list">
        <?php
            while ($product = $prepareProduct->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="cataloge__item">

                <h4 class="cataloge-item__name"><?= $product['name'] ?></h4>

                <div class="cataloge__price-add">

                    <div class="cataloge-item__price-text">

                        <p class="cataloge-item__price"><?= $product['price'] ?> ₽</p>

                        <p class="cataloge-item__text">за 1 <?= $product['unit'] ?></p>

                    </div>

                </div>

                </div>
                <?php
            }

            ?>
        </div>

    </div>
</div>

<style>
    .ddd {
        display: flex;
        align-items: center;
        justify-content: start;
        gap: 10px;
        margin-bottom: 20px;
    }

    .info__target {
        font-size: 18px;
        font-weight: 700;
    } 
</style>