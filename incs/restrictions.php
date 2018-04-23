<?php
$accessurl = explode('/', $_SERVER[REQUEST_URI]);
$accessurlcnt = count($accessurl);
$accessurl = $accessurl[2];
$restrictedarea = "http://www.communiloca.com/admin/main/";
if($accessurl == 'news' && ($row_getUserLimit['limit_navi_top_main'] == 1 || $row_getUserLimit['limit_navi_news'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'events' && ($row_getUserLimit['limit_navi_top_main'] == 1 || $row_getUserLimit['limit_navi_events'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'points' && ($row_getUserLimit['limit_navi_top_main'] == 1 || $row_getUserLimit['limit_navi_points'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'push' && ($row_getUserLimit['limit_navi_top_main'] == 1 || $row_getUserLimit['limit_navi_push'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'asks' && ($row_getUserLimit['limit_navi_top_main'] == 1 || $row_getUserLimit['limit_navi_asks'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'goods' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_goods'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'categories' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_categories'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'menue' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_menue'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'gifts' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_gifts'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'calendar' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_calendar'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'orders' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_orders'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'schedule' && ($row_getUserLimit['limit_navi_top_menue'] == 1 || $row_getUserLimit['limit_navi_schedule'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'clients' && ($row_getUserLimit['limit_navi_top_office'] == 1 || $row_getUserLimit['limit_navi_clients'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'personal' && ($row_getUserLimit['limit_navi_top_office'] == 1 || $row_getUserLimit['limit_navi_personal'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'professions' && ($row_getUserLimit['limit_navi_top_office'] == 1 || $row_getUserLimit['limit_navi_professions'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'office' && ($row_getUserLimit['limit_navi_top_office'] == 1 || $row_getUserLimit['limit_navi_office'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'reviews' && ($row_getUserLimit['limit_navi_top_support'] == 1 || $row_getUserLimit['limit_navi_reviews'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'support' && ($row_getUserLimit['limit_navi_top_support'] == 1 || $row_getUserLimit['limit_navi_support'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'statistic' && ($row_getUserLimit['limit_navi_top_statistic'] == 1 || $row_getUserLimit['limit_navi_statistic'] == 1)) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'profile' && $row_getUserLimit['limit_profile'] == 1) {
    header(sprintf("Location: %s", $restrictedarea));
}
else if($accessurl == 'gmcomp') {
    $query_getGMLimit = "SELECT * FROM gm WHERE gm_user = '".$colname_getUser."' && gm_del = '0'";
    $getGMLimit = mysql_query($query_getGMLimit, $echoloyalty) or die(mysql_error());
    $row_getGMLimit = mysql_fetch_assoc($getGMLimit);
    $getGMLimitNumRows  = mysql_num_rows($getGMLimit);
    if($getGMLimitNumRows == 0) {
        header(sprintf("Location: %s", $restrictedarea));
    }
}

?>