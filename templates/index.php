<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php
        foreach($vid as $newl)
        {?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?=$newl?></a>
            </li>
        <?php } ?>

    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php
        foreach($info as $newI)
        { ?>

            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$newI["URL"]?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$newI["Cat"]?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=$newI["Name"]?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=$newI["Price"]?></span>
                            <span class="lot__cost"><?=format_sum($newI['Price'])?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?= timer()?>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>
