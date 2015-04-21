<div class="container">
		<div class="all-tem">
			<div class="tem-left">
				<div class="tem-left-top">
					<div class="tem-left-top-ct">
						<img title="" src="<?php echo $this->imgUrl ?>/nem-hinh-thu-175.jpg" align="" width="150px" height="150px"/>
						<h4>Êm ái và mịn màng</h4>
					</div>
				</div>
				<div class="tem-left-top">
					<div class="tem-left-top-ct">
						<img title="" src="<?php echo $this->imgUrl ?>/kymdan-kid.jpg" align="" width="150px" height="150px"/>
						<h4>Hạnh phúc ấm êm</h4>
					</div>
				</div>
			</div>
			<div class="tem-center">
				<img src="<?php echo $this->imgUrl ?>/14275068283765332267.jpg" width="340px" height="420px">
			</div>
			<div class="tem-right">
				<ul>
                                    <?php
                                        foreach ($this->Items as $key => $val){
                                    ?>
					<li>
						<a href="#"><?php echo $val['name']?></a>
						<p>Bảo hành tới <?php echo $val['warranty']?></p>
                                                <span><?php echo number_format($val['price'],0) .'đ'?></span><br /><br />
						<img src="<?php echo FILES_URL. '/products/images115x115/'. $val['picture']?>" title="" alt="" width="140px" height="110px" />
					</li>
                                    <?php
                                        }
                                    ?>
				</ul>
			</div>
		</div>
	</div>