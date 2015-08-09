# yii2-actionable-behavior
A base class to easily set yii2's behaviours to send emails, push notifications and others

# Usage

## Email action: 

### YourModel.php

   ``public function behaviors(){``
       ``return [``
            ``[``
                'class'=>ActionableEmail::className(),
                'events' => [
                    ActiveRecord::EVENT_BEFORE_DELETE=> [
                        "template"=>[
                            "from"=>"rowasc@gmail.com",
                            "to"=>"rowasc@gmail.com",
                            "subject"=>"An article with the id {%id%} was deleted.",
                            "body"=>"{%title%} - <br \/>{%body%}",
                        ],
                        "replace"=>[
                            "id"=>"id",
                            "title"=>"title",
                            "body"=>"body"
                        ]
                    ]
                ]
            ],``