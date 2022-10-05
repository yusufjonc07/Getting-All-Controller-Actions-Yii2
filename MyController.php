<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Inflector;

class TablesController extends Controller
{
  public function getAllControllerActions()
    {
        $controllers = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@app/controllers'), ['recursive' => true]);
        $actions = [];
        foreach ($controllers as $controller) {
            $contents = file_get_contents($controller);
            $controllerId = Inflector::camel2id(substr(basename($controller), 0, -14));
            preg_match_all('/public function action(\w+?)\(/', $contents, $result);
            foreach ($result[1] as $action) {
                $actionId = Inflector::camel2id($action);
                $route = $controllerId . '/' . $actionId;
                $actions[$route] = $route;
            }
        }
        asort($actions);
        return $actions;
    }
