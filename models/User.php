<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
    /**
     * Get User with given email and Password
     * For Login functionality
     * @param $userData
     * @return array|bool|false
     */
    public static function loginUser($userData)
    {
        $bind = [
            ':userName' => $userData['userName'],
            ':password' => md5($userData['password'])
        ];
        $user = Yii::$app->db->createCommand('SELECT * FROM users WHERE userName=:userName AND password=:password')
            ->bindValues($bind)
            ->queryOne();
        if(empty($user)){
            return false;
        }
        return $user;

    }

    /**
     * Get assigned tables for user
     * @param $userId
     * @return array
     */
    public static function getUserTablesByUserId($userId)
    {
        $bind = [
            ':userId' => $userId,
        ];
        $user = Yii::$app->db->createCommand("SELECT
                                                cafe_tables.tableId as tableId,
                                                cafe_tables.description as tableDescription,
                                                cafe_tables.seats as seats,
                                                orders.orderId as orderId
                                                FROM
                                                cafe_tables
                                                LEFT JOIN orders ON (orders.tableId = cafe_tables.tableId AND orders.status = 'pending')
                                                INNER JOIN users
                                                ON (cafe_tables.waiterId = users.userId)
                                                WHERE  users.userId =:userId")
            ->bindValues($bind)
            ->queryAll();

        return $user;
    }

    /**
     * get userData with given userId
     * @param $userId
     * @return array|false
     */
    public static function getUserById($userId)
    {
        $bind = [
            ':userId' => $userId,
        ];
        $user = Yii::$app->db->createCommand("SELECT
                                                IFNULL(count(cafe_tables.tableId),0) as assignedTables,
                                                users.userName,
                                                users.userId
                                                FROM
                                                users
                                                LEFT JOIN cafe_tables
                                                ON (cafe_tables.waiterId = users.userId)
                                                WHERE users.userType = 'waiter'
                                                AND users.userId =:userId
                                                GROUP BY users.userId")
            ->bindValues($bind)
            ->queryOne();

        return $user;

    }

    /**
     * GET User List with their assigned tables count
     * @return array
     */
    public static function getAllUsersWithTables()
    {
        $users = Yii::$app->db->createCommand("SELECT
                                                IFNULL(count(cafe_tables.tableId),0) as assignedTables,
                                                users.userName,
                                                users.userId
                                                FROM users
                                                LEFT JOIN cafe_tables
                                                ON (cafe_tables.waiterId = users.userId)
                                                WHERE users.userType = 'waiter'
                                                GROUP BY users.userId")
                ->queryAll();
        return $users;
    }

}
