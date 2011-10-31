<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class StarsController
{
public function submitAction(Request $request){
   /* $request = $this->get('request');
    $name=$request->request->get('formName');
   
   if($name!=""){//if the user has written his name
      $greeting='Hello '.$name.'. How are you today?';
      $return=array("responseCode"=>200,  "greeting"=>$greeting);
   }
   else{
      $return=array("responseCode"=>400, "You have to write your name!");
   }
    */
    
    $form = $request->request->get('vote');
      $return=array("responseCode"=>200, 'news_id'=> $form['news_id'],  "average"=>5);
   $return=json_encode($return);//jscon encode the array
      return new Response($return,200);
}

}
