<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
	public function up()
	{
		$query = <<<'EOT'
create table `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `uid` bigint(20) not null,
    `openid` varchar(255) not null,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    unique (`uid`),
    unique (`openid`(40))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';
EOT;
		$this->forge->getConnection()->query($query);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
