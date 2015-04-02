<div class="prelate">
    <div class="group">
        <h4>
            <span><a href="/tivi-toshiba" title="Tivi Toshiba">Tivi Toshiba</a> tương tự:</span>
            <span class="bdr"></span>
        </h4>
        <?php
            foreach ($this->spTuongTu as $key => $val){
        ?>
        <div class="prod">
            <a href="/tivi/led-toshiba-32p2400">
                <img width="150" height="150" class="lazy" src="<?php echo $this->baseUrl()?>/public/files/products/images450x450/<?php echo $val['picture'] ?>" style="display: block; opacity: 1;">
                <h3 title="Tên Nệm"><?php echo $val['name']?></h3>
                <strong>Giá: <?php echo $val['price'] ?></strong>
            </a>
            <a class="btncompare " href="/tivi/led-toshiba-32l5450-vs-led-toshiba-32p2400">So sánh</a>
        </div>
        <?php
            }
        ?>
    </div>
</div>
