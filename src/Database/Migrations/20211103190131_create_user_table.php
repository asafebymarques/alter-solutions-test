<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('firstName', 'string', ['limit' => 35])
            ->addColumn('lastName', 'string', ['limit' => 35])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('age', 'integer', ['limit' => 3, 'null' => true])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->create();
    }
}
