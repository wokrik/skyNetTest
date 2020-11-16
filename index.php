<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div id="app">
        <?
        require_once(dirname(__FILE__).'/functions.php');
        
        $speedUnits = " Мбит/с";
        $currency = " &#8381"; // ruble sign
        $jsonUrl = 'http://sknt.ru/job/frontend/data.json';
        
        $data = parseJson($jsonUrl); // parsed json
        
        // loop through all tarif's periods to calculate range of prices
        forEach(($data -> tarifs) as $key => $tarif) { 
            $prices = []; // stores each period's price
            forEach(($tarif -> tarifs) as $item) {
                $prices[] = $item -> price / $item -> pay_period;
            }
    ?>
        <div class="group" data-content="group">
            <div class="tarif" data-content="tarif">
                <div data-action="show-periods">
                    <h2 class="tarif__name">Тариф "<?echo($tarif -> title)?>"</h2>
                <div class="tarif__info" data-tariff_id="<?echo($key + 1)?>">
                    <div class="tarif__speed <?echo(tarifNameToColor($tarif -> title))?>">
                        <?echo($tarif -> speed . $speedUnits)?>
                    </div>
                    <div class="tarif__prices">
                        <?echo(min($prices))?> &#8213 <?echo(max($prices) . $currency . "/мес")?>
                    </div>
                    <div class="tarif__options">
                        <?if($tarif -> free_options){
                            foreach($tarif -> free_options as $freeOption){?>
                                <div class="option"><?echo($freeOption)?></div>
                            <?}
                        }?>
                    </div>
                    <i class="tarif__next-screen-btn arrow arrow_right"></i>
                </div>
                </div>
                <div class="tarif__more-info">
                    <a href="<?echo($tariffGroup -> link)?>" target="_blank" class="tarif__link">узнать подробнее на сайте www.sknt.ru</a>
                </div>
            </div>
            <div class="all-periods hidden" data-content="periods">
                <div class="header">
                    <i class="arrow arrow_left" data-action="show-tarifs"></i>
                    <h2>Тариф "<?echo($tarif -> title)?>"</h2>
                </div>
                <div class="periods">
        <?  // tarifs asc sorting by pay period
            usort($tarif -> tarifs,function($first,$second){
                return intval($first -> pay_period) > intval($second -> pay_period);
            });
            $maxPrice = $tarif -> tarifs[0] -> price;
            forEach(($tarif -> tarifs) as $key => $item) { 
                $monthPrice = $item -> price / $item -> pay_period;
            ?>
                <div class="period" data-action="show-details" data-period_id="<?echo($key + 1)?>" data-content="period">
                    <div class="period__duration"><?echo($item -> pay_period . getMonthsDeclension(intval($item -> pay_period)))?></div>
                    <div class="period__info">
                        <div class="period__price"><?echo($monthPrice) . $currency . "/мес"?></div>
                        <div class="period__bill">разовый платеж &#8213 <?echo($item -> price . $currency . "/мес")?></div>
                        <?
                            $discount = ($maxPrice - $monthPrice) * $item -> pay_period;
                            if($discount > 0) {?>
                                <div class="period__discount">скидка &#8213 <?echo($discount . $currency)?></div>
                            <?}
                        ?>
                        <i class="tarif__next-screen-btn arrow arrow_right"></i>
                    </div>
                </div>
            <? }
        ?>
        </div>
            </div>
            <div class="detailsField hidden" data-content="details_field">
                <div class="header">
                    <span class="arrow arrow_left" data-action="show-periods"></span>
                    <h2>Выбор тарифа</h2>
                </div>
            <?forEach(($tarif -> tarifs) as $key => $item){
                ?>
                <div class="details hidden" data-content="details" data-details_id="<?echo($key + 1)?>">
                    <div class="details__header">
                        <h2>Тариф <?echo($item -> title)?></h2>
                    </div>
                    <div class="details__info">
                        <div class="details__duration">
                            Период оплаты &#8213 <?echo($item -> pay_period . getMonthsDeclension(intval($item -> pay_period)))?>
                        </div>
                        <div class="details__price"><?echo($maxPrice) . $currency . "/мес"?></div>
                        <div class="details__bill-info">
                            <div>разовый платеж &#8213 <?echo($item -> price) . $currency?></div>
                            <div>со счета спишется &#8213 <?echo($item -> price) . $currency?></div>
                        </div>
                        <div class="details__dates">
                            <div class="details__start-date">вступит в силу &#8213 сегодня</div>
                            <span>активно до &#8213 <?echo(date('d.m.Y', $item -> new_payday))?></span>
                        </div>
                    </div>
                    <div class="details__select-btn btn">Выбрать</div>
                </div>
                <?
            }?>
            </div>
        </div>
    <?}
?>
</div>
<script src="main.js"></script>
</body>
</html>