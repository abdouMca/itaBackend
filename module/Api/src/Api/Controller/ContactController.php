<?php
/**
 * User: khaled
 * Date: 8/10/15 at 10:48 AM
 */

namespace Api\Controller;

use Application\Entity\ContactMessage;
use Zend\View\Model\JsonModel;

class ContactController extends BaseController
{

    /**
     * send email
     *
     * @param $data
     * @return bool
     */
    public function create($data){

        $model = new JsonModel();

        /*
         //TODO filter & validate data
        $contact = new ContactMessage();
        $contact->setName($data['fromName']);
        $contact->setEmail($data['fromEmail']);
        $contact->setMessage($data['content']);

        $this->getEntityManager()->persist($contact);
        $this->getEntityManager()->flush();

        //TODO Send email
        $model->setVariables([
           "message"=>"message envoyer avec succes"
        ]);
        */
        //$model->setVariables($data);
        echo serialize($data);
        return false;

    }

}