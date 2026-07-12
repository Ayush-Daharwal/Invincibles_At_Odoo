#!/usr/bin/env node
const yargs = require("yargs/yargs");
const { hideBin } = require("yargs/helpers");
const lint = require("./index");

const argv = yargs(hideBin(process.argv))
	.option("silent", {
		alias: "s",
		type: "boolean",
		description: "Run in silent mode",
	})
	.option("path", {
		alias: "p",
		type: "string",
		description: "Path to the Ember project",
		default: "./app",
	})
	.option("translation-path", {
		type: "string",
		description: "Path to the translation YAML file",
		default: "./translations/en-us.yaml",
	}).argv;

lint({
	silent: argv.silent,
	path: argv.path,
	translationPath: argv["translation-path"],
});
