<?php

use app\models\Book;
use app\models\User;
use yii\db\Migration;
use app\models\Libary;
use app\models\Permission;

/**
 * Handles the creation of table `libary`.
 */
class m180620_203507_create_libary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('libary', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250)->notNull(),
            'post_code' => $this->string(250)->notNull(),
            'city' => $this->string(250)->notNull(),
            'street' => $this->string(250)->notNull(),
            'number' => $this->string(50)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user-libary_id',
            'users',
            'libary_id',
            'libary',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book-libary_id',
            'books',
            'libary_id',
            'libary',
            'id',
            'CASCADE'
        );

        //Add libary
        $libary1 = new Libary;
        $libary1->id = 1;
        $libary1->name = 'Biblioteka Politechniki Rzeszowskiej';
        $libary1->post_code = '35-001';
        $libary1->city = 'Rzeszów';
        $libary1->street = 'Powstańców Warszawy';
        $libary1->number = 1;
        $libary1->save();

        //Add libary
        $libary2 = new Libary;
        $libary2->id = 2;
        $libary2->name = 'Biblioteka Wyższej Szkoły Informatyki i Zarządzania z siedzibą w Rzeszowie';
        $libary2->post_code = '65-001';
        $libary2->city = 'Tyczyn';
        $libary2->street = 'Kielnarowa';
        $libary2->number = 2;
        $libary2->save();

        $book = new Book;
        $book->id = 1;
        $book->title = 'Wiedźmin';
        $book->ISBN = (string) rand(1000000000000, 9999999999999);
        $book->amount = '5';
        $book->author = 'Andrzej Sapkowski';
        $book->page_count = '300';
        $book->cover = 'soft';
        $book->libary_id = 1;
        $book->save();

        $book1 = new Book;
        $book1->id = 2;
        $book1->title = 'Władca Pierscieni';
        $book1->ISBN = (string) rand(1000000000000, 9999999999999);
        $book1->amount = '10';
        $book1->author = 'Tolkien';
        $book1->page_count = '500';
        $book1->cover = 'hard';
        $book1->libary_id = 2;
        $book1->save();

        $adminPermission = Permission::find()->where(['permission' => Permission::ADMIN_PERMISSION])->one();
        $librarianPermission = Permission::find()->where(['permission' => Permission::LIBRARIAN_PERMISSION])->one();
        $userPermission = Permission::find()->where(['permission' => Permission::USER_PERMISSION])->one();

        //Add admin user
        $admin = new User;
        $admin->username = 'admin';
        $admin->password = password_hash('admin', PASSWORD_DEFAULT);
        $admin->accessToken = (string) rand(10000000, 100000000);
        $admin->authKey = (string) rand(10000000, 100000000);
        $admin->permission_id = $adminPermission->id;
        $admin->save();

        $demo1 = new User;
        $demo1->username = 'bibliotekarz1';
        $demo1->password = password_hash('demo', PASSWORD_DEFAULT);
        $demo1->accessToken = (string) rand(10000000, 100000000);
        $demo1->authKey = (string) rand(10000000, 100000000);
        $demo1->permission_id = $librarianPermission->id;
        $demo1->libary_id = 1;
        $demo1->save();

        $demo2 = new User;
        $demo2->username = 'bibliotekarz2';
        $demo2->password = password_hash('demo', PASSWORD_DEFAULT);
        $demo2->accessToken = (string) rand(10000000, 100000000);
        $demo2->authKey = (string) rand(10000000, 100000000);
        $demo2->permission_id = $librarianPermission->id;
        $demo2->libary_id = 2;
        $demo2->save();

        $demo2 = new User;
        $demo2->username = 'uzytkownik';
        $demo2->password = password_hash('demo', PASSWORD_DEFAULT);
        $demo2->accessToken = (string) rand(10000000, 100000000);
        $demo2->authKey = (string) rand(10000000, 100000000);
        $demo2->permission_id = $userPermission->id;
        $demo2->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('libary');
    }
}