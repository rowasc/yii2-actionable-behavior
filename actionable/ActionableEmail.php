<?php
/**
 * Created by PhpStorm.
 * User: rsuarez
 * Date: 8/6/15
 * Time: 11:15 PM
 */

namespace common\components\actionable;

use Yii;
use yii\base\Exception;
class ActionableEmail extends  Actionable
{

    protected function run($model,$attributes,$mailView="layouts/html"){
        if (!($model!==null && is_array($attributes) && isset($attributes["template"]))) {
            throw new Exception(Yii::t("actionableEmail", "ActionableEmail requires at least a template and a model to run"));
        }
        $mailAttributes = $attributes["template"];
        if (isset($attributes["replace"])){
            foreach($attributes['template'] as $key=>&$template){
                foreach($attributes["replace"] as $replaceKey=>$replaceWithModelAttribute){
                    $template = str_replace("{%".$replaceKey."%}",$model->getAttribute($replaceWithModelAttribute),$template);
                }
                $mailAttributes[$key]=$template;
            }
        }
        $sent=Yii::$app->mailer->compose($mailView,array("content"=>$mailAttributes["body"]))
                ->setFrom($mailAttributes["from"])
                ->setTo($mailAttributes["to"])
                ->setSubject($mailAttributes["subject"])
                ->send();
        if (!$sent){
            throw new \Swift_SwiftException(Yii::t("actionableEmail", "SwiftMailer Exception - Could not send the ActionableEmail"));
        }
        return $sent;
    }

}