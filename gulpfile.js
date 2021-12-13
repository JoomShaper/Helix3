const { src, dest, series } = require("gulp");
const zip = require("gulp-zip");
const clean = require("gulp-clean");

// Create a build
function cleanBuild() {
	return src("./dist/build", { read: false, allowEmpty: true }).pipe(clean());
}

function cleanZip() {
	return src("./dist/**.zip", { read: false, allowEmpty: true }).pipe(clean());
}

function copy_template() {
	return src(["./templates/shaper_helix3/**/*.*"]).pipe(dest("dist/build/template"));
}

function copy_template_lang() {
	return src("./language/en-GB/en-GB.tpl_shaper_helix3.ini").pipe(dest("dist/build/template"));
}

function copy_system_plugin() {
	return src(["./plugins/system/helix3/**/*.*"]).pipe(dest("dist/build/plugins/system"));
}

function copy_system_plugin_lang() {
	return src("./administrator/language/en-GB/en-GB.plg_system_helix3.ini").pipe(
		dest("dist/build/plugins/system/language")
	);
}

function copy_ajax_plugin() {
	return src(["./plugins/ajax/helix3/**/*.*"]).pipe(dest("dist/build/plugins/ajax"));
}

function copy_installer() {
	return src(["installer.script.php", "installer.xml"]).pipe(dest("dist/build"));
}

function makeTemplateZip() {
	return src("./dist/build/**/*.*").pipe(zip("helix3_template.zip")).pipe(dest("./dist/"));
}

function makeSystemPluginZip() {
	return src("./dist/build/plugins/system/**/*.*").pipe(zip("plg_system_helix.zip")).pipe(dest("./dist/"));
}

function makeAjaxPluginZip() {
	return src("./dist/build/plugins/ajax/**/*.*").pipe(zip("plg_ajax_helix.zip")).pipe(dest("./dist/"));
}

exports.copy = series(
	cleanBuild,
	cleanZip,
	copy_template,
	copy_template_lang,
	copy_system_plugin,
	copy_system_plugin_lang,
	copy_ajax_plugin,
	copy_installer
);

exports.default = series(exports.copy, makeSystemPluginZip, makeAjaxPluginZip, makeTemplateZip, cleanBuild);
