<?php
//var_dump(json_encode(PHP_EOL));
//var_dump(json_encode(true));
//exit();

require_once '../settings/config.php';

try {

    // get ref page (eg index1.html, index2.html), throw Exception if none (prevent access to this script directly)
    // get Banner suffix eg 1, 2, throw Exception if not found
    $userHelper   = new \UserHelper;
	$bannerSuffix = $userHelper->getBannerSuffix();

    // check previous user visits, insert or update
    $ip      = \UserHelper::getIPAddress();
    $uAgent  = \UserHelper::getUserAgent();
    $pageUrl = $userHelper->getReferrerPage();

	$dbHelper = new DbHelper();

    if ($dbHelper->isUserPreviousVisit($ip, $uAgent, $pageUrl)) {
        $dbHelper->updateUserDataBanners($ip, $uAgent, $pageUrl);
    } else {
        $dbHelper->insertUserDataBanners($ip, $uAgent, $pageUrl);
    }

    // display banner
    \BannerHelper::getBannerImage('../png/png_banner_' . $bannerSuffix . '.png');

} catch (Exception $e) {

    echo $e->getMessage() . '<br/>';
    exit();
}

