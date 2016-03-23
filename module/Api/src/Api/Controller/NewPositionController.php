<?php
/**
 * User: khaled
 * Date: 8/3/15 at 11:05 AM
 */

namespace Api\Controller;


use Application\Entity\Position;
use Zend\File\Transfer\Adapter\Http;
use Zend\Filter\File\Rename;
use Zend\View\Model\JsonModel;

class NewPositionController extends BaseController
{

    /**
     * save new position and return the current sent data
     *
     * @param $data
     * @return JsonModel
     */
    public function create($data)
    {
        $file = $this->params()->fromFiles();
        $data['filename'] = $this->uploadImage($file);
        $this->_savePosition($data);
        return new JsonModel($data);;
    }

    /**
     * upload files
     *
     * @param $file
     * @return mixed|string
     */
    public function uploadImage($file){

        $filename = $file['file']['name'];
        $adapter = new Http();
        $path = BASE_PATH.'/img/position';
        $fileRenameFilter = new Rename(array(
            'target' => $path . '/usr.jpg',
            'randomize' => true,
        ));
        $adapter->addFilters(array($fileRenameFilter));
        if($adapter->receive($filename)){
            $fileFullPath = explode('/', $adapter->getFileName());
            $newFileName = array_pop($fileFullPath);
            return $newFileName;
        }else {
            return 'no-image.png';
        }
    }

    /**
     * save
     *
     * @param $data
     */
    protected function _savePosition($data){
        $position = new Position();
        $position->setLatitude($data['latitude']);
        $position->setLongitude($data['longitude']);
        $position->setComment($data['comment']);
        $position->setStatus($data['status']);

        $isAccident = isset($data['isAccident']) ?1:0;
        $position->setIsAccident($isAccident);

        $position->setImage($data['filename']);
        $position->setCreatedDate(time());

        $this->getEntityManager()->persist($position);
        $this->em->flush();
        //TODO use Object logger
        error_log(sprintf("position with data %s saved %s \n", serialize($data), date("d-m-Y_H-i")),
            3,
            BASE_PATH."/../data/log/my-errors.log"
        );
    }
}
