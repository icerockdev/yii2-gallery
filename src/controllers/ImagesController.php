<?php
namespace dvizh\gallery\controllers;

use yii;
use yii\web\Controller;
use dvizh\gallery\ModuleTrait;

class ImagesController extends Controller
{
    use ModuleTrait;

    public function actionIndex()
    {
        echo "Hello, man. It's ok, dont worry.";
    }

    public function actionTestTest()
    {
        echo "Hello, man. It's ok, dont worry.";
    }

    public function actionImageByItemAndAlias($item = '', $dirtyAlias)
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
        $dotParts = explode('.', $dirtyAlias);

        if(!isset($dotParts[1])){
            throw new yii\web\HttpException(404, 'Image must have extension');
        }

        $dirtyAlias = $dotParts[0];

        $size = isset(explode('_', $dirtyAlias)[1]) ? explode('_', $dirtyAlias)[1] : false;
        $alias = isset(explode('_', $dirtyAlias)[0]) ? explode('_', $dirtyAlias)[0] : false;
        $image = $this->getModule()->getImage($item, $alias);

        if($image->getExtension() != $dotParts[1]){
            throw new yii\web\HttpException(404, 'Image not found (extenstion)');
        }

        if($image){
            $headers = Yii::$app->response->headers;
            $headers->add('Content-Type', 'image/jpg');
            return $image->getContent($size);
        }else{
            throw new \yii\web\HttpException(404, 'There is no images');
        }
    }
}
