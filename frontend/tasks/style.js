const global = require('../settings');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleancss = require('gulp-clean-css');
const concats = require('gulp-concat');
const gcmq = require('gulp-group-css-media-queries');

const paths = [
         '../catalog/view/theme/OPC080193_6/stylesheet/page_product.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/404.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/page_sitemap.css',
         '../catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.css',
         '../catalog/view/theme/OPC080193_6/css/owlcarousel/owl.carousel.min.css',
         '../catalog/view/theme/OPC080193_6/css/owlcarousel/owl.theme.default.min.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/hint.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/info_page.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/page_contact.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/page_about.css',
         '../catalog/view/javascript/mCustomScrollbar/jquery.mCustomScrollbar.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/page_category.css',
         '../catalog/view/javascript/font-awesome/css/font-awesome-selected.min.css',
         '../catalog/view/theme/OPC080193_6/css/category_mod_style.css',
         '../catalog/view/javascript/ocfilter/nouislider.min.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/ocfilter/ocfilter.css',
         '../catalog/view/theme/OPC080193_6/css/reset.css',
         '../catalog/view/theme/OPC080193_6/css/slick.css',
         '../catalog/view/theme/OPC080193_6/css/bootstrap4-grid.min.css',
         '../catalog/view/theme/OPC080193_6/css/style.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/header.css',
         '../catalog/view/theme/OPC080193_6/css/remodal-default-theme.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/get_call.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/footer.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/category_wall.css',
         '../catalog/view/javascript/jquery/owl-carousel/owl.carousel.css',
         '../catalog/view/javascript/jquery/owl-carousel/owl.transitions.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/slideshow.css',
         '../catalog/view/theme/OPC080193_6/stylesheet/module_newsblog_article.css'
];

sass.compiler = require('node-sass');

module.exports = {
    styles: () => {
        return global.gulp.src(paths)
            .pipe(sass().on('error', sass.logError))
            .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: false }))
            .pipe(gcmq())
            .pipe(global.production(cleancss()))
            .pipe(global.gulp.dest(global.dist));
    },
    paths: paths
}
