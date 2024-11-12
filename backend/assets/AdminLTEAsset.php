<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminLTEAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/adminlte.min.css',
    ];
    public $js = [
        'js/adminlte.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
