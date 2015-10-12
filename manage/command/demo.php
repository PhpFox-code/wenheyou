<?php
/**
 * 1. cd /var/spool/cron
 * 2. vi root
 * 
 */
//定时执行任务      */10 * * * * /usr/bin/php /data/web/youa.daxiangw.com/application/cli sync  > /dev/null 2>&1 
\Db\Card\Store::sync_store(20);
/**
 * 同步卡券参数：
 * 1、offset
 * 2、count
 */
\DB\Card\Coupon::sync_coupon(155, 1);
