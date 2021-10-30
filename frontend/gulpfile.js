const global = require('./settings');
const styles = require('./tasks/style');
const scripts = require('./tasks/script');

global.gulp.task('build', global.gulp.series(styles.styles,scripts.scripts));
global.gulp.task('watch', function () {
    global.gulp.watch('../catalog/view/theme/OPC080193_6/assets/', global.gulp.series(styles.styles));
    global.gulp.watch('../catalog/view/theme/OPC080193_6/assets_js/', global.gulp.series(scripts.scripts));
});