<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 1/28/2016 AD
 * Time: 10:59
 */

namespace App\Lib\Ggseven;

use App\Affiliate;
use app\Lib\Ggseven\Listeners\AssociateListenerInterface;
use App\User;

class AssociateService
{
    private $associate_model;
    private $user_model;

    public function __construct (Affiliate $associate_model, User $user_model)
    {
        $this->associate_model = $associate_model;
        $this->user_model = $user_model;
    }

    public function findById ($associate_id)
    {
        return $this->associate_model->whereId($associate_id)->first();
    }
    public function listAll ($keyword = '')
    {
        $associates = $this->associate_model->orderBy('id', 'dsc');

        if($keyword != '') {
            $associates = $associates->where('id', $keyword)->orWhereHas('user', function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('username', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $associates;
    }

    public function setBan ($associate_id, AssociateListenerInterface $listener)
    {
        $associate = $this->associate_model->whereId($associate_id)->first();

        if(!$associate) {
            return $listener->onAssociateNotFound('ไม่พบข้อมูล Associate ที่ต้องการกรุณาลองใหม่');
        }

        if(!$associate->setBan()) {
            return $listener->onAssociateUpdateError('ไม่สามารถเปลี่ยนสถานะได้กรุณาลองใหม่');
        }

        return $listener->onAssociateUpdateComplete('เปลี่ยนสถานะเป็นระงับการใช้งานเรียบร้อย');
    }

    public function setActive ($associate_id, AssociateListenerInterface $listener)
    {
        $associate = $this->associate_model->whereId($associate_id)->first();

        if(!$associate) {
            return $listener->onAssociateNotFound('ไม่พบข้อมูล Associate ที่ต้องการกรุณาลองใหม่');
        }

        if(!$associate->setActive()) {
            return $listener->onAssociateUpdateError('ไม่สามารถเปลี่ยนสถานะได้กรุณาลองใหม่');
        }

        return $listener->onAssociateUpdateComplete('เปลี่ยนสถานะเป็นปกติเรียบร้อย');
    }

    public function setDisable ($associate_id, AssociateListenerInterface $listener)
    {
        $associate = $this->associate_model->whereId($associate_id)->first();

        if(!$associate) {
            return $listener->onAssociateNotFound('ไม่พบข้อมูล Associate ที่ต้องการกรุณาลองใหม่');
        }

        if(!$associate->setDisable()) {
            return $listener->onAssociateUpdateError('ไม่สามารถเปลี่ยนสถานะได้กรุณาลองใหม่');
        }

        return $listener->onAssociateUpdateComplete('เปลี่ยนสถานะเป็นปิดการใช้งานเรียบร้อย');
    }


}