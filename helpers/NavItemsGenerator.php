<?php

namespace app\helpers;

use Yii;
use yii\helpers\Inflector;

class NavItemsGenerator{
    public static function generateNavItems($itemLinks, $current, $includeBadges = false){
        $returnArr = [];
        foreach ($itemLinks as $key => $value) {
            array_push($returnArr, [
                'label'         => Inflector::humanize($value, true).($includeBadges ?
                    ' <span class="badge purple">'.Yii::$app->user->identity->{$value.'Count'}.'</span>' :
                    ''),
                'url'           => [$value],
                'options'       => ['class' => isset($current) && $current == $value ? 'active' : ''],
                ]);
        }
        return $returnArr;
    }
}