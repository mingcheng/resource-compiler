<?php
// vim: set et sw=4 ts=4 sts=4 fdm=marker ff=unix fenc=utf8 nobomb:
/**
 * Resource Compiler
 *
 * @author mingcheng<i.feelinglucky#gmail.com>
 * @date   2010-12-27
 * @link   http://www.gracecode.com/
 */

define("CHAR_SET",     "utf-8");

define("URL_ROOT",     "http://lab.gracecode.com/resource-compiler/");
define("URL_DOWNLOAD", URL_ROOT."compiler/get.php?file=%s");

define("DIR_ROOT",     dirname(__FILE__));
define("DIR_ASSETS",   DIR_ROOT."/assets");
define("DIR_TMP",      DIR_ROOT."/tmp");
define("DIR_COMPILER", DIR_ROOT."/compiler");
define("DIR_LIBRARY",  DIR_ROOT."/library");

define("MAX_UPLOAD_FILE_SIZE",  1 * 1024 * 1024); // 1MB
define("MINIZED_FILE_SUFFIX",   "-min");

define("FLAG_COMPILING_FILE", "/tmp/flag-resource-compiler");

// Java Configure
define("JAVA_HOME", "/usr/lib/jvm/java-6-sun/");
define("JAVA_CMD",  "java -Xmx32m -Xms8m");

# Google Closure Compiler
define("CLOSURE_COMPILER_JAR", realpath(DIR_COMPILER . "/closure-compiler.jar"));
define("CLOSURE_COMPILER_OPT", "--warning_level QUIET --js %s --js_output_file %s");
define("CLOSURE_COMPILER_CMD", sprintf("%s -jar %s %s", JAVA_CMD, 
                                escapeshellarg(CLOSURE_COMPILER_JAR), CLOSURE_COMPILER_OPT));

# YUI Compressor
define("YUI_COMPRESSOR_JAR", realpath(DIR_COMPILER . "/yui-compressor.jar"));
define("YUI_COMPRESSOR_OPT", "%s -o %s");
define("YUI_COMPRESSOR_CMD", sprintf("%s -jar %s %s", JAVA_CMD, 
                                escapeshellarg(YUI_COMPRESSOR_JAR), YUI_COMPRESSOR_OPT));

