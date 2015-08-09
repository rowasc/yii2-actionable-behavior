#STILL UNDER HEAVY DEVELOPMENT - Do not use
# yii2-actionable-behavior
A base class to easily set yii2's behaviours to send emails, push notifications and other common stuff.

It's pretty basic, I need it for a small project I am working on, and I thought it could be useful to someone else. 

***IMPORTANT: Only the email action is working so far! I will be adding APNS and google messaging cloud notifications soon.***  

# Usage

## Email action: 

You can setup a behavior so your actions trigger an email update to a pre defined email. This can be useful if you need to notify administrators or other personel of certain actions like a 
deleted article or a page that changed its content.
 
### Required params for this behavior when you need to replace values with the Model's values: 

   ```php
   "template"=>[                   
       "from"=>"frommail@gmail.com", //Email's SENDER. SwiftMailer's "setFrom"        
       "to"=>"frommail@gmail.com", //Email's TO . SwiftMailer's "setTo"
       "subject"=>"An article with the id {%_id%} was deleted.", //Email's SUBJECT SwiftMailer's "setSubject"                       
       "body"=>"{%_title%} - <br \/>{%_content%}", // the $content param for the HTML mail's view .
   ], 
   "replace"=>[ 
        //"_id" replaced the _id param from subject with the model's id.
       "_id"=>"id",   
       "_title"=>"title",//"_title" replaced the _id param from the body template key with the model's title.           
       "_content"=>"body"//"_content" replaced the _content param from the body template key with the model's body.
   ]
   ```
       
## Example : YourModel.php
  ```php
    use rowasc\yii2ActionableBehaviour\actionableActionableEmail;
   
    public function behaviors(){  
       return [           
          [                
                'class'=>ActionableEmail::className(),                
                'events' => [                
                    ActiveRecord::EVENT_BEFORE_DELETE=> [                    
                        "template"=>[                        
                            "from"=>"frommail@gmail.com",                            
                            "to"=>"frommail@gmail.com",                            
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
            ],
    ```
