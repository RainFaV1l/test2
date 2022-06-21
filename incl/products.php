<?php
include 'service.php';

function validate() {
    if (empty($_POST['name'])) {
        return 'Введите название';
    }

    if (empty($_POST['price'])) {
        return 'Введите цену';
    }

    if (!is_numeric($_POST['price'])) {
        return 'Цена должа быть числом';
    }

    if (empty($_POST['unit'])) {
        return 'Введите единицу измерения';
    }
}

if (isset($_GET['del'])) {
    $sql = "DELETE FROM product WHERE id = :id";
    $params = [
        'id' => $_GET['del']
    ];

    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
}

if (isset($_POST['add_item'])) {
    $msg = validate();

    if (!isset($msg)) {
        $params = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'category_id' => $_GET['c'],
            'unit' => $_POST['unit']
        ];

        insertPDO('product', $params);
        echo "<script>location.href='?p=cataloge'</script>";
    }
}

if (isset($_POST['edit_item'])) {
    $msg = validate();

    if (!isset($msg)) {
        $params = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'unit' => $_POST['unit'],
            'id' => $_GET['id']
        ];

        $sql = "UPDATE product SET name=:name, price=:price, unit=:unit WHERE id = :id";

        $prepare = $conn->prepare($sql);
        $prepare->execute($params);
        echo "<script>location.href='?p=cataloge'</script>";
    }
}

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM product WHERE id = :id";
    $params = [
        'id' => $_GET['id']
    ];

    $prepare = $conn->prepare($sql);
    $prepare->execute($params);
    $item = $prepare->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM product WHERE category_id = :category_id";
$params = [
    'category_id' => $_GET['c']
];

$prepareProduct = $conn->prepare($sql);
$prepareProduct->execute($params)


?>

<div class="page__cataloge cataloge">

    <div class="cataloge__container container">

        <div class="title__row">

            <h1 class="cataloge__title"><?= $service[$_GET['c'] - 1] ?></h1>

            <?php
            if ($_SESSION['role'] == 2) {
              ?>
              <a href="#add_modal" class="start__button button">Добавить</a>
              <?php
            }
            ?>

            

        </div>

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

                    <div class="cataloge__icon-list">

                        <?php

                        if ($_SESSION['role'] == 1) {
                            ?>
                            <a href="?p=cart&id=<?= $product['id'] ?>" class="cataloge-item__add-to-cart">

                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                            width="20px" height="20px" viewBox="0 0 512.000000 512.000000"

                            preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                fill="#FE495A" stroke="none">

                                    <path d="M132 5109 c-47 -14 -109 -80 -123 -131 -23 -89 12 -182 88 -229 36

                                    -23 50 -24 233 -29 211 -6 228 -10 282 -67 15 -15 31 -40 37 -56 6 -15 114

                                    -607 241 -1315 127 -708 233 -1296 236 -1307 4 -16 -7 -26 -53 -50 -87 -44

                                    -201 -162 -247 -255 -63 -129 -80 -259 -51 -395 40 -190 179 -356 363 -431 31

                                    -13 56 -29 55 -36 -1 -7 -8 -44 -17 -83 -31 -137 -11 -281 56 -408 42 -81 164

                                    -203 245 -245 133 -70 286 -88 427 -52 113 29 190 73 276 160 151 150 208 341

                                    165 545 -8 38 -15 71 -15 72 0 2 284 3 630 3 347 0 630 -1 630 -3 0 -1 -7 -34

                                    -15 -72 -29 -139 -9 -282 57 -408 42 -81 164 -203 245 -245 133 -70 286 -88

                                    427 -52 113 29 190 73 277 160 164 162 219 392 147 606 l-24 71 26 38 c20 32

                                    25 51 25 105 0 55 -4 73 -27 107 -15 22 -44 51 -65 64 l-38 24 -1666 5 -1665

                                    5 -41 27 c-63 41 -88 90 -88 169 0 54 5 72 27 106 15 22 44 51 65 64 l38 24

                                    1470 5 1470 5 65 22 c153 52 287 168 354 305 50 103 455 1635 463 1754 12 170

                                    -50 329 -176 454 -87 87 -164 131 -277 160 -75 20 -117 20 -1815 20 l-1737 0

                                    -6 28 c-3 15 -15 81 -27 147 -29 171 -46 231 -85 305 -69 131 -190 236 -334

                                    287 -71 26 -86 27 -285 30 -119 1 -224 -2 -243 -8z m4491 -1218 c21 -13 49

                                    -40 63 -61 52 -78 54 -62 -169 -911 -113 -427 -213 -793 -222 -813 -21 -45

                                    -66 -80 -120 -95 -29 -9 -391 -11 -1344 -9 l-1305 3 -167 935 c-92 514 -170

                                    945 -172 958 l-4 22 1701 -2 1701 -3 38 -24z m-2753 -3125 c59 -39 85 -89 85

                                    -166 0 -78 -26 -127 -88 -168 -56 -37 -153 -39 -210 -3 -76 47 -111 140 -88

                                    229 14 51 75 117 123 131 53 16 135 6 178 -23z m2400 0 c59 -39 85 -89 85

                                    -166 0 -78 -26 -127 -88 -168 -56 -37 -153 -39 -210 -3 -76 47 -111 140 -88

                                    229 14 51 75 117 123 131 53 16 135 6 178 -23z"/>

                                    <path d="M2892 3549 c-45 -13 -108 -80 -121 -126 -6 -21 -11 -88 -11 -150 l0

                                    -111 -133 -4 c-125 -3 -136 -5 -174 -30 -63 -41 -88 -90 -88 -169 0 -54 5 -72

                                    27 -106 15 -22 44 -51 65 -64 34 -21 52 -24 170 -27 l131 -4 4 -131 c3 -118 6

                                    -136 27 -170 13 -21 42 -50 64 -65 34 -23 52 -27 107 -27 55 0 73 4 107 27 22

                                    15 51 44 64 65 21 34 24 52 27 170 l4 131 131 4 c118 3 136 6 170 27 21 13 50

                                    42 65 64 22 34 27 52 27 106 0 79 -25 128 -88 169 -38 25 -49 27 -173 30

                                    l-132 4 -4 131 c-3 118 -6 136 -27 170 -47 76 -151 113 -239 86z"/>

                                </g>

                            </svg>

                            </a>
                            <?php
                        }

                        if ($_SESSION['role'] == 2) {
                            ?>
                            <a href="?p=products&c=<?= $_GET['c'] ?>&id=<?= $product['id'] ?>#edit_modal" class="cataloge-item__add-to-cart">

                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                            width="20px" height="20px" viewBox="0 0 512.000000 512.000000"

                            preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                fill="#FE495A" stroke="none">

                                    <path d="M4395 5107 c-22 -8 -58 -23 -80 -35 -25 -13 -487 -469 -1206 -1189

                                    l-1166 -1168 -78 -390 c-67 -340 -75 -394 -66 -426 13 -43 67 -94 109 -104 20

                                    -4 152 18 389 65 197 39 374 75 393 80 28 8 266 241 1206 1182 1317 1319 1219

                                    1209 1219 1368 -1 137 -20 169 -238 387 -147 147 -193 187 -240 208 -69 32

                                    -181 42 -242 22z m269 -446 c136 -136 158 -162 153 -182 -4 -13 -47 -64 -97

                                    -114 l-90 -90 -178 178 -177 177 96 95 c54 53 104 95 115 95 11 0 84 -64 178

                                    -159z m-424 -426 l175 -175 -919 -919 -919 -919 -214 -42 c-117 -24 -216 -40

                                    -220 -37 -3 4 13 102 36 219 l42 213 917 918 c504 504 919 917 922 917 3 0 84

                                    -79 180 -175z"/>

                                    <path d="M445 4290 c-194 -40 -352 -179 -417 -368 l-23 -67 0 -1705 0 -1705

                                    23 -66 c57 -166 185 -294 350 -351 l67 -23 1705 0 1705 0 67 23 c163 57 286

                                    178 350 348 l23 59 3 1172 c2 1163 2 1173 -18 1213 -23 45 -80 80 -130 80 -50

                                    0 -107 -35 -130 -80 -20 -39 -20 -56 -20 -1173 0 -1274 5 -1193 -75 -1272 -81

                                    -81 63 -75 -1775 -75 -1838 0 -1694 -6 -1775 75 -81 81 -75 -63 -75 1775 0

                                    1838 -6 1694 75 1775 79 80 -2 75 1272 75 1117 0 1134 0 1173 20 45 23 80 80

                                    80 130 0 50 -35 107 -80 130 -39 20 -55 20 -1187 19 -631 -1 -1166 -5 -1188

                                    -9z"/>

                                </g>

                            </svg>

                            </a>

                            <a href="?p=products&c=<?= $_GET['c'] ?>&del=<?= $product['id'] ?>" class="cataloge-item__add-to-cart">

                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"

                            width="20px" height="20px" viewBox="0 0 512.000000 512.000000"

                            preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"

                                fill="#FE495A" stroke="none">

                                    <path d="M1931 5109 c-77 -15 -182 -72 -240 -130 -97 -97 -140 -221 -141 -401

                                    l0 -78 -302 0 c-341 0 -416 -8 -506 -50 -81 -38 -178 -134 -215 -213 -84 -178

                                    -48 -384 90 -521 48 -48 161 -116 192 -116 8 0 11 -422 13 -1542 l3 -1543 27

                                    -80 c38 -111 92 -196 168 -269 79 -74 162 -120 266 -146 75 -19 115 -20 1274

                                    -20 1159 0 1199 1 1274 20 243 62 418 264 456 527 6 42 10 639 10 1560 l0

                                    1491 38 13 c143 46 267 199 293 359 27 169 -57 358 -202 451 -109 69 -126 72

                                    -510 77 l-346 4 -6 117 c-7 129 -28 204 -77 282 -67 104 -188 186 -309 209

                                    -66 12 -1186 12 -1250 -1z m1264 -251 c90 -49 126 -118 133 -255 l5 -103 -773

                                    0 -772 0 3 108 c4 95 7 112 32 154 15 26 41 57 58 69 69 49 66 49 694 46 528

                                    -2 593 -4 620 -19z m1080 -625 c51 -27 80 -58 101 -108 38 -92 6 -203 -75

                                    -260 l-43 -30 -1676 -3 c-1171 -2 -1688 0 -1714 8 -100 29 -164 144 -138 249

                                    19 79 82 141 165 162 17 4 775 6 1685 6 l1655 -2 40 -22z m-217 -2118 c2

                                    -1003 -1 -1492 -8 -1540 -21 -138 -93 -240 -208 -297 l-67 -33 -1189 -3

                                    c-1290 -3 -1256 -4 -1343 51 -82 52 -150 153 -172 255 -8 38 -11 479 -11 1548

                                    l0 1494 1498 -2 1497 -3 3 -1470z"/>

                                    <path d="M1772 3231 c-16 -17 -32 -44 -36 -62 -3 -17 -6 -542 -6 -1166 0

                                    -1209 -1 -1172 47 -1216 31 -27 84 -32 126 -12 71 34 67 -47 67 1240 0 1255 3

                                    1191 -54 1229 -14 9 -45 16 -70 16 -36 0 -50 -6 -74 -29z"/>

                                    <path d="M2488 3237 c-14 -12 -31 -32 -37 -44 -8 -15 -11 -361 -11 -1178 0

                                    -1287 -4 -1206 67 -1240 42 -20 95 -15 126 12 48 44 47 7 47 1216 0 624 -3

                                    1149 -6 1166 -4 18 -20 45 -36 62 -38 38 -109 41 -150 6z"/>

                                    <path d="M3184 3226 l-34 -34 0 -1171 c0 -1007 2 -1176 15 -1200 15 -31 69

                                    -61 108 -61 37 0 90 41 104 80 16 46 18 2276 3 2332 -15 54 -61 88 -117 88

                                    -38 0 -50 -5 -79 -34z"/>

                                </g>

                            </svg>

                            </a>
                            <?php
                        }

                        ?>
                    </div>

                </div>

                </div>
                <?php
            }

            ?>

            

        </div>

    </div>

</div>