
        <div class="main">
          <div class="row placeholders">
          <?php
            $i = 1;
            foreach( $data['display_services'] AS $service => $service_info ) {
            $span = count($service_info['nodes']) > 15 ? 3 : 2;
            ?>
            <div class="col-xs-6 col-sm-<?= $span; ?> placeholder">
              <img data-src="js/holder.js/100x100/auto/#262626:#999/text:<?= $service_info['namespace']; ?>" data-service="<?= $service_info['namespace']; ?>" class="img-responsive service <?= $service_info['namespace']; ?> OK">
              <div class="clearfix nodes">
                  <?php foreach( $service_info['nodes'] AS $node ) { ?>

                    <img data-src="js/holder.js/50x50/auto/#262626:#999/text:<?= $node; ?>" data-node="<?= $node; ?>" class="img-responsive node <?= $node; ?> OK node">

                  <?php } ?>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>
