<?php

$error = ['username'=>'', 'password' =>'']; 
              
               if($user_name == ''){
                $error['username']= 'Username cannot be empty';
                }

                foreach($error as $key =>$value){
                    if(empty($value)){
                        unset($error[$key]);

                    }
                }//foreach end
  
               
               if(empty($error)){
                   login_user($user_name, $user_password);
                   
                   if(login_user($user_name, $user_password) === false){
                       $nologin = true;  
                  
                   }
               }

?>

<p style="color: red;"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>