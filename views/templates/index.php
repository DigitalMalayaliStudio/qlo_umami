<?php
/**
 * Copyright since 2025 Digital Malayali Studio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/license/mit
 *
 * @author    Digital Malayali Studio https://studio.digitalmalayali.in/
 * @copyright 2025
 * @license   https://opensource.org/license/mit The MIT License (MIT)
 */
header('Expires: Mon, 26 Jul 1998 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

header('Location: ../');
exit;
