<?php /**/ ?>
<script>
var hpmodel = {
    copy: {
        <?php if ($replace_desc) { ?>
        '#tab-description': '',
        <?php } ?>
        <?php if ($replace_att) { ?>
        '#tab-specification': '',
        <?php } ?>
        <?php if ($replace_image) { ?>
        '#content ul.thumbnails': '',
        <?php } ?>
        <?php if ($replace_h1) { ?>
        'h1': '',
        '.breadcrumb': '',
        <?php } ?>
        '#product': '',
        '#content ul.list-unstyled:eq(0)': '',
        '#content ul.list-unstyled:eq(1)': '',
        '#content .btn-group:eq(0)': '',
    },
    rest: {
        <?php if ($replace_att) { ?>
        '.product_informationss > ul .rating': '',
        <?php } ?>
    },
    input: {
        '#product input[name="quantity"]': 'change',
    },
};
function hmodel_onchange() {
}
</script>
