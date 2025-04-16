<?php
require_once('../../../wp-load.php');
session_start();
unset($_SESSION['active_filters']);
wp_redirect(site_url('/resource-list'));
exit;