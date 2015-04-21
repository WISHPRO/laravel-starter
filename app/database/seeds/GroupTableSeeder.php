<?php

class GroupTableSeeder extends Seeder {

    public function run()
    {
        DB::table('groups')->delete();
        $now = date('Y-m-d H:i:s');

        Group::create(array(
    	        'id' => 1,
                'name' => 'Administrator',
    	        'permissions' => '{"home":1,"user.list":1,"group.delete":1,"group.create.post":1,"group.assign":1,"group.assign.post":1,"group.create":1,"user.create.post":1,"user.delete":1,"user.create":1,"user.update.put":1,"user.update":1,"onboard":1,"onboard.list":1,"onboard.create":1,"onboard.create.post":1,"onboard.update":1,"onboard.update.put":1,"onboard.delete":1,"list.new":1,"list.sent":1,"list.completed":1,"list.display":1,"create.index":1,"create.index.post":1,"config.consultant":1,"config.consultant.post":1,"config.consultant.update":1,"config.consultant.put":1,"config.consultant.delete":1,"config.contractor":1,"config.contractor.post":1,"config.contractor.update":1,"config.contractor.put":1,"config.contractor.delete":1,"config.supplier":1,"config.supplier.post":1,"config.supplier.update":1,"config.supplier.put":1,"config.supplier.delete":1,"questionnaire.consultant.id":1,"questionnaire.consultant":1,"questionnaire.consultant.post":1,"questionnaire.consultant.delete":1,"questionnaire.contractor.id":1,"questionnaire.contractor":1,"questionnaire.contractor.post":1,"questionnaire.contractor.delete":1,"questionnaire.supplier.id":1,"questionnaire.supplier":1,"questionnaire.supplier.post":1,"questionnaire.supplier.delete":1}',
    	        'created_at' => $now,
    			'updated_at' => $now));
    }

}