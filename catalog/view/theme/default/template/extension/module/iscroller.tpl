<?php
/**
 * iScroller 1.2.1, September 20, 2017
 * Copyright 2014-2017 Igor Bukin / egozza88@gmail.com
 * License: Commercial. Reselling of this software or its derivatives is not allowed. You may use this software for one website ONLY including all its subdomains if the top level domain belongs to you and all subdomains are parts of the same OpenCart store.
 * Support: oc.iscroller@gmail.com
 */
$selectors = explode(',', $settings['infScroll']['containerSelector']);
// product container fix
foreach ($selectors as $i => $sel) {
    $selectors[$i] = trim($sel) . ':after';
}
?>
<script type='text/javascript'>
    jQuery(document).on('ready', function() {
        <?php if ($settings['infScroll']['customJsCode']) : ?>
        IScroller.onAfterPageLoadCustom = function(items){
            <?php echo $settings['infScroll']['customJsCode']; ?>
        };
        <?php endif; ?>
        try {
            (function($) {
                var iscroller = new IScroller($);
                iscroller.init(<?php echo json_encode($settings); ?>);
            })(jQuery);
        } catch (e) {
            if (e.stack)
                console.error(e.stack);
            else
                console.error(e);
        }
    });
</script>
<style> 
<?php echo implode(',', $selectors); ?> {
    content: " ";
    display: block;
    clear: both;
}
<?php echo $settings['infScroll']['customCssCode']; ?>
</style>
