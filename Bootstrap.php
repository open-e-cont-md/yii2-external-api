<?php

namespace openecontmd\external_api;

use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле config/web.php
         */
        $app->setModule('external', 'openecontmd\external_api\modules\external\Module');
    }
}
