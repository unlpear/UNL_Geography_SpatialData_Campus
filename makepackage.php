<?php
require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR/PackageFileManager/File.php';
require_once 'PEAR/Config.php';
require_once 'PEAR/Frontend.php';

unlink('data/spatialdata.sqlite');

require_once 'Campus.php';

$campus = new UNL_Geography_SpatialData_Campus();
$campus->getGeoCoordinates('501');

/**
 * @var PEAR_PackageFileManager
 */
PEAR::setErrorHandling(PEAR_ERROR_DIE);
chdir(dirname(__FILE__));
$pfm = PEAR_PackageFileManager2::importOptions('package.xml', array(
//$pfm = new PEAR_PackageFileManager2();
//$pfm->setOptions(array(
	'packagedirectory' => dirname(__FILE__),
	'baseinstalldir' => 'UNL/Geography/SpatialData',
	'filelistgenerator' => 'file',
	'ignore' => array('package.xml','.project','*.tgz','makepackage.php','Campus/*'),
	'simpleoutput' => true,
));
$pfm->setPackage('UNL_Geography_SpatialData_Campus');
$pfm->setPackageType('php'); // this is a PEAR-style php script package
$pfm->setSummary('This package contains spatial data, latitude and longitude for buildings on the UNL Campus.');
$pfm->setDescription('Spatial Data for buildings on the UNL Campus');
$pfm->setChannel('pear.unl.edu');
$pfm->setAPIStability('beta');
$pfm->setReleaseStability('beta');
$pfm->setAPIVersion('0.3.0');
$pfm->setReleaseVersion('0.3.7');
$pfm->setNotes('
Add SDPG
');
//$pfm->addMaintainer('lead','saltybeagle','Brett Bieber','brett.bieber@gmail.com');
$pfm->setLicense('BSD License', 'http://www1.unl.edu/wdn/wiki/Software_License');
$pfm->clearDeps();
$pfm->setPhpDep('5.0.0');
$pfm->setPearinstallerDep('1.4.3');
$pfm->addPackageDepWithChannel('required', 'UNL_Common', 'pear.unl.edu', '0.3.0');
foreach (array('Campus.php',) as $file) {
    $pfm->addReplacement($file, 'pear-config', '@@DATA_DIR@@', 'data_dir');
}
//$pfm->addGlobalReplacement('pear-config', '@web-dir@', 'web_dir');

$pfm->generateContents();
if (isset($_SERVER['argv']) && $_SERVER['argv'][1] == 'make') {
    $pfm->writePackageFile();
} else {
    $pfm->debugPackageFile();
}


?>