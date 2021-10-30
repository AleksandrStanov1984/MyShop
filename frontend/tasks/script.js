const global = require('../settings');
const terser  = require("gulp-terser");
const include  = require("gulp-include");

const paths = [
    '../catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.min.js',
    '../catalog/view/theme/OPC080193_6/js/owlcarousel/owl.carousel.min.js',
    '../catalog/view/javascript/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js',
    '../catalog/view/javascript/bootstrap/js/bootstrap.min.js',
    '../catalog/view/theme/OPC080193_6/js/ajpag-fix.js',
    '../catalog/view/javascript/megnor/bootstrap-notify.min.js',
    '../catalog/view/javascript/ocfilter/nouislider.min.js',
    '../catalog/view/javascript/ocfilter/ocfilter.js',
    '../catalog/view/theme/OPC080193_6/js/jquery-1.11.0.min.js',
    '../catalog/view/theme/OPC080193_6/js/slick.min.js',
    '../catalog/view/theme/OPC080193_6/js/scripts.js',
    '../catalog/view/javascript/common.js',
    '../catalog/view/theme/OPC080193_6/js/maskedinput.js',
    '../catalog/view/theme/OPC080193_6/js/remodal.js'
    /*'../catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js',
    '../catalog/view/theme/OPC080193_6/js/owlcarousel/owl.carousel.min.js'*/
    ];

module.exports = {
    scripts: () => {
        return global.gulp.src(paths)
            .pipe(include())
                .on('error', console.log)
            .pipe(global.production(terser()))
            .pipe(global.gulp.dest(global.dist));
    },
    paths: paths
}