<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if($information_id !== 15){ ?>
<div class="wrapper">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> info_page"><?php echo $content_top; ?>
        <?php echo $description; ?><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script>
  $(document).ready(function(){
    $('.accardion_items__title, .leftbar_accordion__title').click(function(){
      $(this).parent().toggleClass('open');
    });

  })
</script>
<script>

$(document).ready(function(){
      $('#link_watch_here').click(function () {
        var positionTable = $('.table_couries_sz').offset();
        console.log(positionTable.top);
        if (window.matchMedia('(max-width: 767px)').matches) {
          $('body,html').animate({scrollTop: positionTable.top - 50}, 800);
        }else{
          $('body,html').animate({scrollTop: positionTable.top - 170}, 800);
      }
        return false;
      });

  });
</script>
<?php } else { ?>
  <?php echo $description; ?>
<?php } ?>

<?php echo $footer; ?>
