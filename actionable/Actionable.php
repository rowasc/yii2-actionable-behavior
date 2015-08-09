<?php
/**
 * Created by PhpStorm.
 * User: rsuarez
 * Date: 8/6/15
 * Time: 9:56 PM
 */

namespace common\components\actionable;


use yii\base\Behavior;
use yii\base\Component;
use yii\db\ActiveRecord;
use yii\base\Event;
use yii\helpers\VarDumper;

/**
 * Class Actionable
 *
 * @package common\components\actionable
 *          Tip: Within a behavior, you can access the component that the behavior is attached to through the yii\base\Behavior::$owner property.

 */
class Actionable extends Behavior
{
    private $events;

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->canGetProperty("events") && !empty($this->events) && is_array($this->events)){
            foreach($this->events as $event=>$data)
                Event::on(ActiveRecord::className(), $event, function ($closureEvent) {
                    $model = $closureEvent->sender;
                    $this->run($model,$closureEvent->data);
                },$data);
            }
        }

}

