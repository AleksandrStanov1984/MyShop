const gulp = require('gulp');
const environment = require('gulp-environments');
const concat = require('gulp-concat');

module.exports = {
    gulp: gulp,
    development: environment.development,
    production: environment.production,
    concat: concat,
    dist: '../catalog/view/theme/OPC080193_6/assets/',
}