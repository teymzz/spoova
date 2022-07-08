<?php

/*NOTICE: PLEASE DO NOT TAMPER OR EDIT THIS FILE FOR ANY REASON WHATSOEVER !!!*/

// Load Emogrifier (embed to inline css converter)
use Pelago\Emogrifier\CssInliner;

if(!isset($mailer)){ 
  die('<div style="font-size:14px">The sender file uses $mailer variable for mail configuration. Please follow the code structure below.</div><br> 
       
       <code>
        <table style="font-size:12px;">
         <tr> <td>1| </td><td>include_once \'filebase.php\';</td> <td></td></tr>
         <tr> <td>2| </td><td>include_once \'mail-config.php\';</td> <td></td></tr> 
         <tr> <td>3| </td><td>$mailer = new /mailer;</td> <td></td></tr> 
         <tr> <td><span style="visibility:hidden">.</span></td><td></td><td></td></tr>
         <tr> <td>4| </td><td><b><i>... your code here</i></b></td> <td></td></tr>        
         <tr> <td><span style="visibility:hidden">.</span></td><td></td><td></td></tr>
         <tr> <td>5| </td><td>include_once \'sender.php\';</td><td></td></tr>
         <tr> <td></td><td></td><td></td></tr>         
         <tr> <td></td><td></td><td></td></tr>
         <tr> <td></td><td></td><td></td></tr>         
         <tr> <td></td><td>--------------------------------------</td><td>--------------------------</td></tr>         
         <tr> <td></td><td>$response1 = $mailer->response()</td> <td>//to get mail response in array format</td></tr>  
         <tr> <td></td><td>$response2 = $mailer->response(\'json\')</td> <td>//to get mail response in json format</td></tr>
         <tr> <td></td><td>$content   = $mailer->content()</td> <td> //get the content of your mail into $content </td></tr>                                              
        </table> 
       </code>  
       
       <br><div style="font-size:14px">Please check outline.php file to see sample of how to set up line 4 above.</div><br>      
    '); 
}

// if($mailer->process()){
//   try{
//     $mailer->response(['execTime'=>date('Y-m-d H:i:s')]);
//     $mailer->render();
//     $mail->setFrom($mailer->mail_info('webmail'),$mailer->mail_info('webname'));
//     $mail->addAddress($mailer->mail_info('usermail'),$mailer->mail_info('username'));

//     //configure some additional settings;
//     if($mailer->mail_info('reply')){ 
//       $mail->addReplyTo($mailer->mail_info('reply')['mail'], $mail->addCC($mailer->mail_info('reply')['name'])); 
//       if($mailer->mail_info('cc')){ 
//         $mail->addCC($mailer->mail_info('cc')['mail'], $mail->addCC($mailer->mail_info('cc')['name'])); 
//         if($mailer->mail_info('bcc')){ $mail->addCC($mailer->mail_info('bcc')['mail'], $mail->addCC($mailer->mail_info('bcc')['name'])); }
//       }
//     }    

//     $mail->isHTML(true);
//     $mail->Subject = $mailer->mail_info('header');
//     $body = CssInliner::fromHtml($mailer->mail_info('body'))->inlineCss()->render();  // construct a clean email friendly html text; 

//     $mail->Body = $body;
//     $mail->AltBody = strip_tags($mailer->mail_info('body'));
//     if($mailer->send()){

//        $mailer->response(['forward'=>true]); //tell mailer that forwarding was allowed

//        $mail->send();
//        $mailer->response([
//          'process'  => true,
//          'status'   => 1,
//          'message'  => 'mail sent',
//          'content'  => $body,
//          'success'  => true,
//        ]);
//     }else{
//        $mailer->response([
//          'process'  => true,
//          'message'  => 'mail has not been sent yet',
//          'content'  => $body,
//        ]);
//     }

//   }catch(Exception $e){
//     $error = $e->getMessage();

//     ob_start();
//     include('error.php');
//     $contents = ob_get_contents();
//     ob_end_clean();

//     $mailer->response([
//         'process'  => true,
//         'message'  => 'mail not sent: '.$error,
//         'content'  => $contents,
//         'error'    => true
//     ]);
//   }
// }else{

//   $mailer->response([
//     'message'  => 'mail not sent',
//   ]);

// }
  
