<?php

require __DIR__ . '/../composer/vendor/autoload.php';

require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../composer/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Controller
{



    public function registro()
    {

       
        require __DIR__ . '/../../web/templates/registro.php';
    }


    public function inicio()
    {   
     
        require __DIR__ . '/../../web/templates/inicio.php';
    }

   

    


}


