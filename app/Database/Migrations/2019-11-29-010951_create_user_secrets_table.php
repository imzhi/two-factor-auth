<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSecretsTable extends Migration
{
	public function up()
	{
		$query = <<<'EOT'
create table `user_secrets` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `sid` bigint(20) unsigned not null,
    `uid` bigint(20) unsigned not null,
    `title` varchar(255) not null,
    `name` varchar(255) not null,
    `secret` varchar(50) not null,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    index (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户密钥表';
EOT;
		$this->forge->getConnection()->query($query);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
