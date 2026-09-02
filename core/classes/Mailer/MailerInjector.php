<?php 

namespace spoova\mi\core\classes\Mailer;

use spoova\mi\core\classes\Mailer\Mailer;

class MailerInjector {

    private Mailer $mailer;

    public function __construct(Mailer $Mailer){
        $this->mailer = $Mailer; 
     }

    public function update() : MailerInjector{
         
         $this->mailer->update();

         return $this;

    }

}
