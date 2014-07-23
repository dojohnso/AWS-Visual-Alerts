
        <div class="main">
          <h1 class="page-header">AWS Visual Alerts <img src="images/ajax-loader.gif" class="loader" /></h1>
          <div class="row placeholders">
          <?php
            $i = 1;
            foreach( $data['services'] AS $service => $nodes ) {
            ?>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img data-src="js/holder.js/100x100/auto/#333:#fff/text:<?= $service; ?>" class="img-responsive <?= $service; ?> OK">
              <div class="clearfix"></div>
              <?php foreach( $nodes AS $node ) { ?>

                <img data-src="js/holder.js/50x50/auto/#333:#fff/text:<?= $node; ?>" class="img-responsive <?= $node; ?> OK node">

              <?php } ?>
            </div>
            <?php
            if ( $i % 4 == 0 )
            {
            ?>
                <div class="clearfix"></div>
            <?php
            }
            $i++;

            ?>
          <?php } ?>
          </div>
        </div>
