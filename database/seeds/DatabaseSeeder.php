<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('CategoryTableSeeder');
        $this->call('CampaignCategoryTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('ProductOutlineTableSeeder');
        $this->call('ProductDescriptionTableSeeder');
        $this->call('ProductColorTableSeeder');
        $this->call('ProductSkuTableSeeder');
        $this->call('CampaignStatusTableSeeder');
        $this->call('CampaignTypeTableSeeder');
        $this->call('ShippingTypeTableSeeder');
        $this->call('OrderStatusTableSeeder');
        $this->call('OrderProduceStatusTableSeeder');
        $this->call('PaymentStatusTableSeeder');
        $this->call('PaymentTypeTableSeeder');
        $this->call('UserStatusTableSeeder');
        $this->call('UserRoleTableSeeder');
        $this->call('AdminTableSeeder');
        $this->call('ReportTypeTableSeeder');
        $this->call('CommissionStatusTableSeeder');
        $this->call('MonthlyCommissionStatusTableSeeder');
        $this->call('CommissionRateTableSeeder');
        $this->call('AssociateStatusTableSeeder');
    }
}
