<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 1/28/2016 AD
 * Time: 10:59
 */

namespace App\Lib\Ggseven;


use App\Admin;
use app\Lib\Ggseven\Listeners\AdminListenerInterface;

class AdminService
{
    private $admin_model;

    public function __construct (Admin $admin_model)
    {
        $this->admin_model = $admin_model;
    }

    public function findAdminById ($admin_id)
    {
        return $this->admin_model->where('id', $admin_id)->first();
    }

    public function setStatus ($admin_id, $status_name, AdminListenerInterface $listener)
    {
        $admin = $this->admin_model->where('id', $admin_id)->first();

        if(!$admin) {
            return $listener->onAdminNotFound();
        }

        if(!$admin->setStatus($status_name)) {
            return $listener->onAdminUpdateError();
        }

        return $listener->onAdminUpdated();
    }

    public function createAdmin ($data, AdminListenerInterface $listener)
    {
        $admin = $this->admin_model->create($data);

        if(!$admin) {
            return $listener->onAdminCreateError();
        }

        return $listener->onAdminCreateComplete();
    }

    public function updateAdmin ($data, AdminListenerInterface $listener)
    {
        $admin = $this->findAdminById($data['id']);

        if(!$admin) {
            return $listener->onAdminNotFound();
        }

        if(!$admin->update(array_except($data, 'id'))) {
            return $listener->onAdminUpdateError();
        }


        return $listener->onAdminUpdated();
    }

    public function deleteAdmin ($admin_id, AdminListenerInterface $listener)
    {
        $admin = $this->findAdminById($admin_id);

        if(!$admin) {
            return $listener->onAdminNotFound();
        }

        if(!$admin->delete()) {
            return $listener->onAdminUpdateError();
        }

        return $listener->onAdminUpdated();
    }
}