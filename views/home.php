
        <div class="main">
          <h1 class="page-header">AWS Visual Alerts <img src="images/ajax-loader.gif" class="loader" /></h1>
          <div class="row placeholders">
          <?php
            $i = 1;
            foreach( $data['display_services'] AS $service => $service_info ) {
            ?>
            <div class="col-xs-6 col-sm-4 placeholder">
              <img data-src="js/holder.js/100x100/auto/#333:#fff/text:<?= $service_info['namespace']; ?>" data-service="<?= $service_info['namespace']; ?>" class="img-responsive service <?= $service_info['namespace']; ?> OK">
              <div class="clearfix nodes">
                  <?php foreach( $service_info['nodes'] AS $node ) { ?>

                    <img data-src="js/holder.js/50x50/auto/#333:#fff/text:<?= $node; ?>" data-node="<?= $node; ?>" class="img-responsive node <?= $node; ?> OK node">

                  <?php } ?>
              </div>
            </div>
            <?php
            if ( $i % 3 == 0 )
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
