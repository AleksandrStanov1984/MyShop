<?php
class ControllerExtensionModuleCatalogQuickEdit extends Controller {
	private $error = array();
	protected $alert = array(
		'error'     => array(),
		'warning'   => array(),
		'success'   => array(),
		'info'      => array()
	);

	private static $config_defaults = array(
		'module_catalog_quick_edit_status'                                    => 0,
		'module_catalog_quick_edit_override_menu_entry'                       => 0,
		'module_catalog_quick_edit_match_anywhere'                            => 0,
		'module_catalog_quick_edit_alternate_row_colour'                      => 0,
		'module_catalog_quick_edit_row_hover_highlighting'                    => 0,
		'module_catalog_quick_edit_highlight_status'                          => 0,
		'module_catalog_quick_edit_highlight_actions'                         => 0,
		'module_catalog_quick_edit_interval_filter'                           => 0,
		'module_catalog_quick_edit_batch_edit'                                => 0,
		'module_catalog_quick_edit_quick_edit_on'                             => 'click',
		'module_catalog_quick_edit_list_view_image_width'                     => 40,
		'module_catalog_quick_edit_list_view_image_height'                    => 40,
		'module_catalog_quick_edit_single_language_editing'                   => 0,
		'module_catalog_quick_edit_catalog_categories_status'                 => 0,
		'module_catalog_quick_edit_catalog_categories_default_sort'           => 'name',
		'module_catalog_quick_edit_catalog_categories_default_order'          => 'ASC',
		'module_catalog_quick_edit_catalog_products_status'                   => 0,
		'module_catalog_quick_edit_catalog_products_filter_sub_category'      => 0,
		'module_catalog_quick_edit_catalog_products_default_sort'             => 'pd.name',
		'module_catalog_quick_edit_catalog_products_default_order'            => 'ASC',
		'module_catalog_quick_edit_catalog_filters_status'                    => 0,
		'module_catalog_quick_edit_catalog_filters_default_sort'              => 'fgd.name',
		'module_catalog_quick_edit_catalog_filters_default_order'             => 'ASC',
		'module_catalog_quick_edit_catalog_attributes_status'                 => 0,
		'module_catalog_quick_edit_catalog_attributes_default_sort'           => 'ad.name',
		'module_catalog_quick_edit_catalog_attributes_default_order'          => 'ASC',
		'module_catalog_quick_edit_catalog_attribute_groups_status'           => 0,
		'module_catalog_quick_edit_catalog_attribute_groups_default_sort'     => 'agd.name',
		'module_catalog_quick_edit_catalog_attribute_groups_default_order'    => 'ASC',
		'module_catalog_quick_edit_catalog_options_status'                    => 0,
		'module_catalog_quick_edit_catalog_options_default_sort'              => 'od.name',
		'module_catalog_quick_edit_catalog_options_default_order'             => 'ASC',
		'module_catalog_quick_edit_catalog_manufacturers_status'              => 0,
		'module_catalog_quick_edit_catalog_manufacturers_default_sort'        => 'm.name',
		'module_catalog_quick_edit_catalog_manufacturers_default_order'       => 'ASC',
		'module_catalog_quick_edit_catalog_downloads_status'                  => 0,
		'module_catalog_quick_edit_catalog_downloads_default_sort'            => 'dd.name',
		'module_catalog_quick_edit_catalog_downloads_default_order'           => 'ASC',
		'module_catalog_quick_edit_catalog_reviews_status'                    => 0,
		'module_catalog_quick_edit_catalog_reviews_default_sort'              => 'r.date_added',
		'module_catalog_quick_edit_catalog_reviews_default_order'             => 'DESC',
		'module_catalog_quick_edit_catalog_information_status'                => 0,
		'module_catalog_quick_edit_catalog_information_default_sort'          => 'id.title',
		'module_catalog_quick_edit_catalog_information_default_order'         => 'ASC',
	);

	private static $column_defaults = array(
		'module_catalog_quick_edit_catalog_products'  => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'p.product_id'    , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'category'          => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>     'cat_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'manufacturer'      => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' => 'manufac_qe', 'sort' => 'm.name'          , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' => 'pd.name'         , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'name', 'value' => 'product_id')))),
			'tag'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>     'tag_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'model'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.model'         , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'model', 'value' => 'product_id')))),
			'price'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  70, 'align' =>  'text-right', 'type' =>   'price_qe', 'sort' => 'p.price'         , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'quantity'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  80, 'align' =>  'text-right', 'type' =>     'qty_qe', 'sort' => 'p.quantity'      , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'sku'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  90, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.sku'           , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'sku', 'value' => 'product_id')))),
			'upc'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 100, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.upc'           , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'upc', 'value' => 'product_id')))),
			'ean'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 110, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.ean'           , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'ean', 'value' => 'product_id')))),
			'jan'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 120, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.jan'           , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'jan', 'value' => 'product_id')))),
			'isbn'              => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 130, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.isbn'          , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'isbn', 'value' => 'product_id')))),
			'mpn'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 140, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.mpn'           , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'mpn', 'value' => 'product_id')))),
			'location'          => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 150, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.location'      , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'location', 'value' => 'location')))),
			'seo'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 160, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' => 'seo'             , 'rel' => array('view_in_store'),'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'seo', 'value' => 'product_id')))),
			'tax_class'         => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 170, 'align' =>   'text-left', 'type' => 'tax_cls_qe', 'sort' => 'tc.title'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'minimum'           => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 180, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.minimum'       , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'subtract'          => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 190, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.subtract'      , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'stock_status'      => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 200, 'align' =>   'text-left', 'type' =>   'stock_qe', 'sort' => 'ss.name'         , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'requires_shipping' => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 210, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.shipping'      , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'date_added'        => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 215, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_added'    , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_available'    => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 220, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' => 'p.date_available', 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_modified'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' => 230, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_modified' , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'length'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 240, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.length'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'width'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 250, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.width'         , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'height'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 260, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.height'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'weight'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 270, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.weight'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'length_class'      => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 280, 'align' =>   'text-left', 'type' =>  'length_qe', 'sort' => 'lc.title'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'weight_class'      => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 290, 'align' =>   'text-left', 'type' =>  'weight_qe', 'sort' => 'wc.title'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'points'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 300, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.points'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'filter'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 310, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'download'          => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 320, 'align' =>   'text-left', 'type' =>      'dl_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 330, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' => 340, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.sort_order'    , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' => 350, 'align' => 'text-center', 'type' =>  'status_qe', 'sort' => 'p.status'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'viewed'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' => 360, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.viewed'        , 'rel' => array(),               'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' => 370, 'align' =>   'text-left', 'type' =>           '', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' => 380, 'align' =>  'text-right', 'type' =>           '', 'sort' => ''                , 'rel' => array(),               'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_products_actions' => array(
			'attributes'        => array('display' => 0, 'index' =>  0, 'short' => 'attr',  'type' =>    'attr_qe', 'class' =>            '', 'rel' => array()),
			'discounts'         => array('display' => 0, 'index' =>  1, 'short' => 'dscnt', 'type' =>   'dscnt_qe', 'class' =>            '', 'rel' => array()),
			'images'            => array('display' => 0, 'index' =>  2, 'short' => 'img',   'type' =>  'images_qe', 'class' =>            '', 'rel' => array()),
			'filters'           => array('display' => 0, 'index' =>  3, 'short' => 'fltr',  'type' => 'filters_qe', 'class' =>            '', 'rel' => array('filter')),
			'options'           => array('display' => 0, 'index' =>  4, 'short' => 'opts',  'type' =>  'option_qe', 'class' =>            '', 'rel' => array()),
			'recurrings'        => array('display' => 0, 'index' =>  5, 'short' => 'rec',   'type' =>   'recur_qe', 'class' =>            '', 'rel' => array()),
			'related'           => array('display' => 0, 'index' =>  6, 'short' => 'rel',   'type' => 'related_qe', 'class' =>            '', 'rel' => array()),
			'downloads'         => array('display' => 0, 'index' =>  7, 'short' => 'dls',   'type' =>     'dls_qe', 'class' =>            '', 'rel' => array('download')),
			'specials'          => array('display' => 0, 'index' =>  8, 'short' => 'spcl',  'type' => 'special_qe', 'class' =>            '', 'rel' => array('price')),
			'keywords'          => array('display' => 0, 'index' =>  9, 'short' => 'seo',   'type' =>    'keyw_qe', 'class' =>            '', 'rel' => array('seo', 'view_in_store')),
			'descriptions'      => array('display' => 0, 'index' => 10, 'short' => 'desc',  'type' =>   'descr_qe', 'class' =>            '', 'rel' => array()),
			'view'              => array('display' => 1, 'index' => 11, 'short' => 'vw',    'type' =>       'view', 'class' =>            '', 'rel' => array()),
			'edit'              => array('display' => 1, 'index' => 12, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		),
		'module_catalog_quick_edit_catalog_categories' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'cp.category_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'parent'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>  'parent_qe', 'sort' =>                'path', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false),        'rel' => array('name')),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>                'name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'short_name', 'value' => 'category_id')))),
			'column'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'c.column', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'top'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>               'c.top', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'seo'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>        'seo', 'value' => 'category_id'))), 'rel' => array('view_in_store')),
			'filter'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  50, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'c.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'c.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  60, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  65, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_filters' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>  'fg.filter_group_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'group_name'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>            'fgd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'filter_group_id')))),
			'filter'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'filter_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>       'fg.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_attributes' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'a.attribute_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'ad.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'attribute_id')))),
			'attribute_group'   => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>   'group_qe', 'sort' =>     'attribute_group', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'a.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_attribute_groups' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                      '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'ag.attribute_group_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>              'agd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'attribute_group_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>         'ag.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  20, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                      '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_options' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>         'o.option_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'od.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'option_id')))),
			'type'              => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>    'type_qe', 'sort' =>              'o.type', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('option_value')),
			'option_value'      => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' => 'opt_val_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'option_value_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'o.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  30, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_manufacturers' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>   'm.manufacturer_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'm.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'manufacturer_id')))),
			'seo'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>    'seo', 'value' => 'manufacturer_id'))), 'rel' => array('view_in_store')),
			'store'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'm.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  35, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_downloads' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>       'd.download_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'dd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'download_id')))),
			'filename'          => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>          'd.filename', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'mask'              => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'd.mask', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>        'd.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  30, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_reviews' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>         'r.review_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'product'           => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' => 'product_qe', 'sort' =>             'pd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'product', 'value' => 'product_id'))), 'rel' => array('date_modified')),
			'author'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'r.author', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'text'              => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>    'text_qe', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'rating'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>            'r.rating', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'r.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_added'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'r.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_modified'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>   'text-left', 'type' =>           '', 'sort' =>     'r.date_modified', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  45, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'module_catalog_quick_edit_catalog_information' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>    'i.information_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'title'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>   'title_qe', 'sort' =>            'id.title', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'title', 'value' => 'information_id')))),
			'seo'               => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'seo', 'value' => 'information_id'))), 'rel' => array('view_in_store')),
			'bottom'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>            'i.bottom', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'i.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'i.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  45, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
	);

	private static $event_hooks = array(
		'admin_module_catalog_quick_edit_menu'                            => array('trigger' => 'admin/view/common/column_left/before',                       'action' => 'extension/module/catalog_quick_edit/menu_hook'),
		'admin_module_catalog_quick_edit_catalog_information_index'       => array('trigger' => 'admin/controller/catalog/information/before',                'action' => 'extension/module/catalog_quick_edit/catalog_information_index_hook'),
		'admin_module_catalog_quick_edit_catalog_information_delete'      => array('trigger' => 'admin/controller/catalog/information/delete/before',         'action' => 'extension/module/catalog_quick_edit/catalog_information_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_information_form'        => array('trigger' => 'admin/view/catalog/information_form/before',                 'action' => 'extension/module/catalog_quick_edit/catalog_information_form_hook'),
		'admin_module_catalog_quick_edit_catalog_review_index'            => array('trigger' => 'admin/controller/catalog/review/before',                     'action' => 'extension/module/catalog_quick_edit/catalog_review_index_hook'),
		'admin_module_catalog_quick_edit_catalog_review_delete'           => array('trigger' => 'admin/controller/catalog/review/delete/before',              'action' => 'extension/module/catalog_quick_edit/catalog_review_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_review_form'             => array('trigger' => 'admin/view/catalog/review_form/before',                      'action' => 'extension/module/catalog_quick_edit/catalog_review_form_hook'),
		'admin_module_catalog_quick_edit_catalog_download_index'          => array('trigger' => 'admin/controller/catalog/download/before',                   'action' => 'extension/module/catalog_quick_edit/catalog_download_index_hook'),
		'admin_module_catalog_quick_edit_catalog_download_delete'         => array('trigger' => 'admin/controller/catalog/download/delete/before',            'action' => 'extension/module/catalog_quick_edit/catalog_download_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_download_form'           => array('trigger' => 'admin/view/catalog/download_form/before',                    'action' => 'extension/module/catalog_quick_edit/catalog_download_form_hook'),
		'admin_module_catalog_quick_edit_catalog_manufacturer_index'      => array('trigger' => 'admin/controller/catalog/manufacturer/before',               'action' => 'extension/module/catalog_quick_edit/catalog_manufacturer_index_hook'),
		'admin_module_catalog_quick_edit_catalog_manufacturer_delete'     => array('trigger' => 'admin/controller/catalog/manufacturer/delete/before',        'action' => 'extension/module/catalog_quick_edit/catalog_manufacturer_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_manufacturer_form'       => array('trigger' => 'admin/view/catalog/manufacturer_form/before',                'action' => 'extension/module/catalog_quick_edit/catalog_manufacturer_form_hook'),
		'admin_module_catalog_quick_edit_catalog_option_index'            => array('trigger' => 'admin/controller/catalog/option/before',                     'action' => 'extension/module/catalog_quick_edit/catalog_option_index_hook'),
		'admin_module_catalog_quick_edit_catalog_option_delete'           => array('trigger' => 'admin/controller/catalog/option/delete/before',              'action' => 'extension/module/catalog_quick_edit/catalog_option_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_option_form'             => array('trigger' => 'admin/view/catalog/option_form/before',                      'action' => 'extension/module/catalog_quick_edit/catalog_option_form_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_group_index'   => array('trigger' => 'admin/controller/catalog/attribute_group/before',            'action' => 'extension/module/catalog_quick_edit/catalog_attribute_group_index_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_group_delete'  => array('trigger' => 'admin/controller/catalog/attribute_group/delete/before',     'action' => 'extension/module/catalog_quick_edit/catalog_attribute_group_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_group_form'    => array('trigger' => 'admin/view/catalog/attribute_group_form/before',             'action' => 'extension/module/catalog_quick_edit/catalog_attribute_group_form_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_index'         => array('trigger' => 'admin/controller/catalog/attribute/before',                  'action' => 'extension/module/catalog_quick_edit/catalog_attribute_index_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_delete'        => array('trigger' => 'admin/controller/catalog/attribute/delete/before',           'action' => 'extension/module/catalog_quick_edit/catalog_attribute_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_attribute_form'          => array('trigger' => 'admin/view/catalog/attribute_form/before',                   'action' => 'extension/module/catalog_quick_edit/catalog_attribute_form_hook'),
		'admin_module_catalog_quick_edit_catalog_filter_index'            => array('trigger' => 'admin/controller/catalog/filter/before',                     'action' => 'extension/module/catalog_quick_edit/catalog_filter_index_hook'),
		'admin_module_catalog_quick_edit_catalog_filter_delete'           => array('trigger' => 'admin/controller/catalog/filter/delete/before',              'action' => 'extension/module/catalog_quick_edit/catalog_filter_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_filter_form'             => array('trigger' => 'admin/view/catalog/filter_form/before',                      'action' => 'extension/module/catalog_quick_edit/catalog_filter_form_hook'),
		'admin_module_catalog_quick_edit_catalog_category_index'          => array('trigger' => 'admin/controller/catalog/category/before',                   'action' => 'extension/module/catalog_quick_edit/catalog_category_index_hook'),
		'admin_module_catalog_quick_edit_catalog_category_delete'         => array('trigger' => 'admin/controller/catalog/category/delete/before',            'action' => 'extension/module/catalog_quick_edit/catalog_category_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_category_form'           => array('trigger' => 'admin/view/catalog/category_form/before',                    'action' => 'extension/module/catalog_quick_edit/catalog_category_form_hook'),
		'admin_module_catalog_quick_edit_catalog_product_index'           => array('trigger' => 'admin/controller/catalog/product/before',                    'action' => 'extension/module/catalog_quick_edit/catalog_product_index_hook'),
		'admin_module_catalog_quick_edit_catalog_product_delete'          => array('trigger' => 'admin/controller/catalog/product/delete/before',             'action' => 'extension/module/catalog_quick_edit/catalog_product_delete_hook'),
		'admin_module_catalog_quick_edit_catalog_product_copy'            => array('trigger' => 'admin/controller/catalog/product/copy/before',               'action' => 'extension/module/catalog_quick_edit/catalog_product_copy_hook'),
		'admin_module_catalog_quick_edit_catalog_product_form'            => array('trigger' => 'admin/view/catalog/product_form/before',                     'action' => 'extension/module/catalog_quick_edit/catalog_product_form_hook'),
	);

	public function __construct($registry) {
		parent::__construct($registry);
	}

	// Interpreter hook
	public function __call($name, $arguments) {
		if (method_exists($this, $name)) {
			// Forward call to existing method
			return call_user_func_array(array($this, $name), $arguments);
		} else {
			// Validate the call name and forward call to appropriate class and method
			if (substr_count($name, "__") == 2) {
				list($catalog, $controller, $method) = explode("__", $name);
				return $this->load->controller("extension/module/quickedit/{$catalog}/{$controller}" . ($method ? "/{$method}" : ""), $arguments);
			} else {
				// Unknown method call
				$this->log->write("AQE PRO: unknown method call: " . $name);
			}
		}
	}

	public function index() {
		$this->load->language('extension/module/catalog_quick_edit');

		$this->document->addStyle('view/stylesheet/quickedit/module.min.css');

		$this->document->addScript('view/javascript/quickedit/module.min.js');

		$this->document->setTitle($this->language->get('extension_name'));

		$this->load->model('setting/setting');

		$ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && !$ajax_request && $this->validateForm($this->request->post)) {
			$original_settings = $this->model_setting_setting->getSetting('module_catalog_quick_edit');

			foreach (self::$config_defaults as $setting => $default) {
				$value = $this->config->get($setting);
				if ($value === null) {
					$original_settings[$setting] = $default;
				}
			}

			foreach (self::$column_defaults as $page => $columns) {
				$page_conf = $this->config->get($page);

				if ($page_conf === null) {
					$page_conf = $value;
				}

				foreach ($columns as $column => $attributes) {
					if (!isset($page_conf[$column])) {
						$page_conf[$column] = $attributes;
					} else {
						foreach ($attributes as $key => $value) {
							if (!isset($page_conf[$column][$key])) {
								$page_conf[$column][$key] = $value;
							} else {
								switch ($key) {
									case 'display':
										$page_conf[$column][$key] = (isset($this->request->post['display'][$page][$column])) ? 1 : 0;
										break;
									case 'index':
										$page_conf[$column][$key] = (isset($this->request->post['index'][$page][$column])) ? $this->request->post['index'][$page][$column] : $value;
										break;
									case 'qe_status':
										$page_conf[$column][$key] = (isset($this->request->post['qe_status'][$page][$column])) ? 1 : 0;
										break;
									default:
										$page_conf[$column][$key] = $value;
										break;
								}
							}
						}

						foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
							unset($page_conf[$column]);
						}
					}
				}

				foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
					unset($page_conf[$key]);
				}

				$this->request->post[$page] = $page_conf;
			}

			unset($this->request->post['index']);
			unset($this->request->post['display']);
			unset($this->request->post['qe_status']);

			$settings = array_merge($original_settings, $this->request->post);

			$settings['module_catalog_quick_edit_list_view_image_width'] = (int)$settings['module_catalog_quick_edit_list_view_image_width'];
			$settings['module_catalog_quick_edit_list_view_image_height'] = (int)$settings['module_catalog_quick_edit_list_view_image_height'];

			$this->model_setting_setting->editSetting('module_catalog_quick_edit', $settings);

			$this->session->data['success'] = $this->language->get('text_success_update');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			//$this->response->redirect($this->url->link('extension/module/catalog_quick_edit', 'user_token=' . $this->session->data['user_token'], true));

			
		} else if ($this->request->server['REQUEST_METHOD'] == 'POST' && $ajax_request) {
			$response = array();

			if ($this->validateForm($this->request->post)) {
				$original_settings = $this->model_setting_setting->getSetting('module_catalog_quick_edit');

				foreach (self::$config_defaults as $setting => $default) {
					$value = $this->config->get($setting);
					if ($value === null) {
						$original_settings[$setting] = $default;
					}
				}

				foreach (self::$column_defaults as $page => $columns) {
					$page_conf = $this->config->get($page);

					if ($page_conf === null) {
						$page_conf = $value;
					}

					foreach ($columns as $column => $attributes) {
						if (!isset($page_conf[$column])) {
							$page_conf[$column] = $attributes;
						} else {
							foreach ($attributes as $key => $value) {
								if (!isset($page_conf[$column][$key])) {
									$page_conf[$column][$key] = $value;
								} else {
									switch ($key) {
										case 'display':
											$page_conf[$column][$key] = (isset($this->request->post['display'][$page][$column])) ? 1 : 0;
											break;
										case 'index':
											$page_conf[$column][$key] = (isset($this->request->post['index'][$page][$column])) ? $this->request->post['index'][$page][$column] : $value;
											break;
										case 'qe_status':
											$page_conf[$column][$key] = (isset($this->request->post['qe_status'][$page][$column])) ? 1 : 0;
											break;
										default:
											$page_conf[$column][$key] = $value;
											break;
									}
								}
							}

							foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
								unset($page_conf[$column][$key]);
							}
						}
					}

					foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
						unset($page_conf[$key]);
					}

					$this->request->post[$page] = $page_conf;
				}

				unset($this->request->post['index']);
				unset($this->request->post['display']);
				unset($this->request->post['qe_status']);

				$settings = array_merge($original_settings, $this->request->post);

				$settings['module_catalog_quick_edit_list_view_image_width'] = (int)$settings['module_catalog_quick_edit_list_view_image_width'];
				$settings['module_catalog_quick_edit_list_view_image_height'] = (int)$settings['module_catalog_quick_edit_list_view_image_height'];

				if ((int)$original_settings['module_catalog_quick_edit_status'] != (int)$this->request->post['module_catalog_quick_edit_status']
					 || (int)$original_settings['module_catalog_quick_edit_override_menu_entry'] != (int)$this->request->post['module_catalog_quick_edit_override_menu_entry']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_categories_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_categories_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_products_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_products_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_filters_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_filters_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_attributes_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_attributes_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_attribute_groups_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_attribute_groups_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_options_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_options_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_manufacturers_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_manufacturers_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_downloads_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_downloads_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_reviews_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_reviews_status']
					 || (int)$original_settings['module_catalog_quick_edit_catalog_information_status'] != (int)$this->request->post['module_catalog_quick_edit_catalog_information_status']
					 )
				{
					$response['reload'] = true;
					$this->session->data['success'] = $this->language->get('text_success_update');
				}

				$this->model_setting_setting->editSetting('module_catalog_quick_edit', $settings);

				$response['success'] = true;
				$response['msg'] = $this->language->get("text_success_update");
			} else {
				$response = array_merge($response, array("error" => true), array("errors" => $this->error), array("alerts" => $this->alert));
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($response, JSON_UNESCAPED_SLASHES));
			return;
		}


		$data['heading_title'] = $this->language->get('extension_name');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
			'active'    => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_extension'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
			'active'    => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('extension_name'),
			'href'      => $this->url->link('extension/module/catalog_quick_edit', 'user_token=' . $this->session->data['user_token'], true),
			'active'    => true
		);

		$data['save'] = $this->url->link('extension/module/catalog_quick_edit', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		$data['upgrade'] = $this->url->link('extension/module/catalog_quick_edit/upgrade', 'user_token=' . $this->session->data['user_token'], true);
		$data['extension_installer'] = $this->url->link('marketplace/installer', 'user_token=' . $this->session->data['user_token'], true);
		$data['modifications'] = $this->url->link('marketplace/modification', 'user_token=' . $this->session->data['user_token'], true);
		$data['events'] = $this->url->link('marketplace/event', 'user_token=' . $this->session->data['user_token'], true);
		$data['services'] = html_entity_decode($this->url->link('extension/module/catalog_quick_edit/services', 'user_token=' . $this->session->data['user_token'], true));

			$this->updateEventHooks();

		$data['ssl'] = (
				(int)$this->config->get('config_secure') ||
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ||
				!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
				!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
			) ? 's' : '';

		# Loop through all settings for the post/config values
		foreach (array_keys(self::$config_defaults) as $setting) {
			if (isset($this->request->post[$setting])) {
				$data[$setting] = $this->request->post[$setting];
			} else {
				$data[$setting] = $this->config->get($setting);
				if ($data[$setting] === null) {
					if (!isset($this->alert['warning']['unsaved']) )  {
						$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
					}
					if (isset(self::$config_defaults[$setting])) {
						$data[$setting] = self::$config_defaults[$setting];
					}
				}
			}
		}

		// Check for multistore setup
		$this->load->model('setting/store');

		$multistore = $this->model_setting_store->getTotalStores();

		$data['installed_version'] = $this->installedVersion();

		$data['sorts'] = array();

		foreach (self::$column_defaults as $page => $columns) {
			$conf = $this->config->get($page);
			if (!is_array($conf)) {
				if (!isset($this->alert['warning']['unsaved']) )  {
					$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
				}
				$conf = $columns;
			}

			foreach ($columns as $column => $attributes) {
				if (!isset($conf[$column])) {
					if (!isset($this->alert['warning']['unsaved']) )  {
						$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
					}
					$conf[$column] = $attributes;
				}

				foreach ($attributes as $key => $value) {
					if (!isset($conf[$column][$key])) {
						if (!isset($this->alert['warning']['unsaved']) )  {
						$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
						}
						$conf[$column][$key] = $value;
					}
					switch ($key) {
						case 'display':
						case 'qe_status':
						case 'index':
							break;
						default:
							if ($conf[$column][$key] != $value) {
								if (!isset($this->alert['warning']['unsaved']) )  {
									$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
								}
							}
							break;
					}
				}

				if (array_diff(array_keys($conf[$column]), array_keys($columns[$column])) && !isset($this->alert['warning']['unsaved']) ) {
					$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
				}

				$conf[$column]['name'] = $this->language->get('txt_' . $column);

				if (!empty($attributes['sort'])) {
					$data['sorts'][$page][$column]['name'] = $conf[$column]['name'];
					$data['sorts'][$page][$column]['value'] = $attributes['sort'];
				}

				if ($column == 'view_in_store' && !$multistore) {
					unset($conf[$column]);
				}
			}

			if (array_diff(array_keys($conf), array_keys($columns)) && !isset($this->alert['warning']['unsaved']) ) {
				$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
			}

			uasort($conf, 'column_sort');
			$data[$page] = $conf;
		}

		if (isset($this->session->data['error'])) {
			$this->error = $this->session->data['error'];

			unset($this->session->data['error']);
		}

		if (isset($this->error['warning'])) {
			$this->alert['warning']['warning'] = $this->error['warning'];
		}

		if (isset($this->error['error'])) {
			$this->alert['error']['error'] = $this->error['error'];
		}

		if (isset($this->session->data['success'])) {
			$this->alert['success']['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}

		$data['errors'] = $this->error;

		$data['user_token'] = $this->session->data['user_token'];

		$data['alerts'] = $this->alert;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$template = 'extension/module/catalog_quick_edit';
		$this->response->setOutput($this->load->view($template, $data));
	}

	public function install() {
		$this->load->language('extension/module/catalog_quick_edit');

		$this->registerEventHooks();

		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('module_catalog_quick_edit', array_merge(self::$config_defaults, self::$column_defaults));
	}

	public function uninstall() {
		$this->load->language('extension/module/catalog_quick_edit');

		$this->removeEventHooks();

		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('module_catalog_quick_edit');
	}


	// Image
	public function image() {
		$this->load->model('tool/image');

		if (isset($this->request->get['size'])) {
			$width = $height = (int)$this->request->get['size'];
		} else if (isset($this->request->get['width']) && isset($this->request->get['height'])) {
			$width = (int)$this->request->get['width'];
			$height = (int)$this->request->get['height'];
		} else {
			$width = $height = 100;
		}

		if (isset($this->request->get['image'])) {
			$this->response->setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), $width, $height));
		}
	}

	// Event hooks
	public function menu_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && !(int)$this->config->get('module_catalog_quick_edit_override_menu_entry') && $this->user->hasPermission('access', 'extension/module/catalog_quick_edit')) {
			$this->load->language('extension/module/catalog_quick_edit');

			$menu_hooks = array(
				'catalog' => array(
					'category' => 'categories',
					'product' => 'products',
					'filter' => 'filters',
					'attribute' => 'attributes',
					'attribute_group' => 'attribute_groups',
					'option' => 'options',
					'manufacturer' => 'manufacturers',
					'download' => 'downloads',
					'review' => 'reviews',
					'information' => 'information',
				)
			);

			foreach ($data['menus'] as $l1_key => $l1_menu) {
				foreach ($menu_hooks as $catalog => $items) {
					if ($l1_menu['id'] == "menu-{$catalog}") {
						$children = array();
						foreach ($l1_menu['children'] as $l2_key => $l2_menu) {
							if ($l2_menu['children']) {
								$sub_children = array();
								foreach ($l2_menu['children'] as $l3_key => $l3_menu) {
									$new_entry = null;

									foreach ($items as $controller => $setting) {
										if ($this->config->get("module_catalog_quick_edit_{$catalog}_{$setting}_status") && strpos($l3_menu['href'], "route={$catalog}/{$controller}&") !== FALSE) {
											$new_entry = array(
												'name'      => $this->language->get("menu_{$catalog}_{$controller}"),
												'href'      => $this->url->link("extension/module/catalog_quick_edit/{$catalog}__{$controller}__", 'user_token=' . $this->session->data['user_token'], true),
												'children'  => array()
											);
										}
									}

									$sub_children[] = $l3_menu;
									if ($new_entry) $sub_children[] = $new_entry;
								}
								$l2_menu['children'] = $sub_children;
								$children[] = $l2_menu;
							} else {
								$new_entry = null;

								foreach ($items as $controller => $setting) {
									if ($this->config->get("module_catalog_quick_edit_{$catalog}_{$setting}_status") && strpos($l2_menu['href'], "route={$catalog}/{$controller}&") !== FALSE) {
										$new_entry = array(
											'name'      => $this->language->get("menu_{$catalog}_{$controller}"),
											'href'      => $this->url->link("extension/module/catalog_quick_edit/{$catalog}__{$controller}__", 'user_token=' . $this->session->data['user_token'], true),
											'children'  => array()
										);
									}
								}

								$children[] = $l2_menu;
								if ($new_entry) $children[] = $new_entry;
							}
						}
						$data['menus'][$l1_key]['children'] = $children;
					}
				}
			}
		}
	}


	public function catalog_information_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_information_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__information__';
		}
	}

	public function catalog_information_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_information_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__information__delete';
		}
	}

	public function catalog_information_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_information_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_review_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_reviews_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__review__';
		}
	}

	public function catalog_review_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_reviews_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__review__delete';
		}
	}

	public function catalog_review_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_reviews_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_download_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_downloads_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__download__';
		}
	}

	public function catalog_download_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_downloads_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__download__delete';
		}
	}

	public function catalog_download_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_downloads_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_manufacturer_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_manufacturers_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__manufacturer__';
		}
	}

	public function catalog_manufacturer_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_manufacturers_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__manufacturer__delete';
		}
	}

	public function catalog_manufacturer_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_manufacturers_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_option_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_options_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__option__';
		}
	}

	public function catalog_option_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_options_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__option__delete';
		}
	}

	public function catalog_option_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_options_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_attribute_group_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attribute_groups_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__attribute_group__';
		}
	}

	public function catalog_attribute_group_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attribute_groups_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__attribute_group__delete';
		}
	}

	public function catalog_attribute_group_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attribute_groups_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_attribute_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attributes_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__attribute__';
		}
	}

	public function catalog_attribute_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attributes_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__attribute__delete';
		}
	}

	public function catalog_attribute_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_attributes_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_filter_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_filters_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__filter__';
		}
	}

	public function catalog_filter_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_filters_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__filter__delete';
		}
	}

	public function catalog_filter_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_filters_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_category_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_categories_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__category__';
		}
	}

	public function catalog_category_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_categories_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__category__delete';
		}
	}

	public function catalog_category_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_categories_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	public function catalog_product_index_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_products_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']) || !empty($this->session->data['aqer']))) {
			unset($this->session->data['aqer']);
			$route = 'extension/module/catalog_quick_edit/catalog__product__';
		}
	}

	public function catalog_product_delete_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_products_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__product__delete';
		}
	}

	public function catalog_product_copy_hook(&$route, &$data) {
		if ((int)$this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_products_status') && ((int)$this->config->get('module_catalog_quick_edit_override_menu_entry') || isset($this->request->get['aqer']))) {
			$route = 'extension/module/catalog_quick_edit/catalog__product__copy';
		}
	}

	public function catalog_product_form_hook(&$route, &$data) {
		if ($this->config->get('module_catalog_quick_edit_status') && (int)$this->config->get('module_catalog_quick_edit_catalog_products_status') && isset($this->request->get['aqer'])) {
			$this->session->data['aqer'] = 1;
		}
	}

	// Private methods
	private function registerEventHooks() {
		$this->load->model('extension/module/catalog_quick_edit');
		$this->load->model('setting/event');

		if (isset($this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction) && is_callable($this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction)) {
			foreach (self::$event_hooks as $code => $hook) {
				$event = $this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction($code, $hook['trigger'], $hook['action']);

				if (!$event) {
					$this->model_setting_event->addEvent($code, $hook['trigger'], $hook['action']);
				}
			}
		}
	}

	private function removeEventHooks() {
		$this->load->model('setting/event');

		foreach (self::$event_hooks as $code => $hook) {
			$this->model_setting_event->deleteEventByCode($code);
		}
	}

	private function updateEventHooks() {
		$this->load->model('extension/module/catalog_quick_edit');
		$this->load->model('setting/event');

		if (isset($this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction) && is_callable($this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction)) {
			foreach (self::$event_hooks as $code => $hook) {
				$event = $this->model_extension_module_catalog_quick_edit->getEventByCodeTriggerAction($code, $hook['trigger'], $hook['action']);

				if (!$event) {
					$this->model_setting_event->addEvent($code, $hook['trigger'], $hook['action']);

					if (empty($this->alert['success']['hooks_updated'])) {
						$this->alert['success']['hooks_updated'] = $this->language->get('text_success_hooks_update');
					}
				}
			}

			// Delete old triggers
			$query = $this->db->query("SELECT `code` FROM " . DB_PREFIX . "event WHERE `code` LIKE 'admin_module_catalog_quick_edit_%'");
			$events = array_keys(self::$event_hooks);

			foreach ($query->rows as $row) {
				if (!in_array($row['code'], $events)) {
					$this->model_setting_event->deleteEventByCode($row['code']);

					if (empty($this->alert['success']['hooks_updated'])) {
						$this->alert['success']['hooks_updated'] = $this->language->get('text_success_hooks_update');
					}
				}
			}
		}
	}

	private function checkModulePermission() {
		$errors = false;

		if (!$this->user->hasPermission('modify', 'extension/module/catalog_quick_edit')) {
			$errors = true;
			$this->alert['error']['permission'] = $this->language->get('error_permission');
		}

		return $errors;
	}

	private function validate() {
		$errors = $this->checkModulePermission();


			return !$this->error;

	}


	private function validateForm($data) {
		$errors = false;

		if (!$data['module_catalog_quick_edit_list_view_image_width'] || !is_numeric($this->request->post['module_catalog_quick_edit_list_view_image_width']) || (int)$this->request->post['module_catalog_quick_edit_list_view_image_width'] < 1) {
			$errors = true;
			$this->error['list_view_image_width'] = $this->language->get('error_image_width');
		}

		if (!$data['module_catalog_quick_edit_list_view_image_height'] || !is_numeric($this->request->post['module_catalog_quick_edit_list_view_image_height']) || (int)$this->request->post['module_catalog_quick_edit_list_view_image_height'] < 1) {
			$errors = true;
			$this->error['list_view_image_height'] = $this->language->get('error_image_height');
		}

		if ($errors) {
			$errors = true;
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		if (!$errors) {
			return $this->validate();
		} else {
			return false;
		}
	}
}

/**
  * Sort columns by index key
  *
  **/
if (!function_exists('column_sort')) {
    function column_sort($a, $b) {

        if ($a['index'] == $b['index']) {
            return 0;
        }
        return ($a['index'] < $b['index']) ? -1 : 1;
    }
}


/**
  * Filter columns by display value
  *
  **/
if (!function_exists('column_display')) {
    function column_display($a) {
        return (isset($a['display'])) ? (int)$a['display'] : false;
    }
}
