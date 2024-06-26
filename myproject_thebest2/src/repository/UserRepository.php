<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
                $user['name'] ?? '',
                $user['surname'] ?? ''
        );
    }


//    public function addUser(User $user)
//    {
//        $this->database->connect()->beginTransaction();
//
//        try {
//            $stmt = $this->database->connect()->prepare('
//            INSERT INTO users_details (name, surname, phone)
//            VALUES (?, ?, ?)
//        ');
//
//            $stmt->execute([
//                $user->getName(),
//                $user->getSurname(),
//                $user->getPhone()
//            ]);
//
//            $userDetailsId = $this->database->connect()->lastInsertId();
//
//            $stmt = $this->database->connect()->prepare('
//            INSERT INTO users (email, password, id_user_details)
//            VALUES (?, ?, ?)
//        ');
//
//            $stmt->execute([
//                $user->getEmail(),
//                $user->getPassword(),
//                $userDetailsId
//            ]);
//
//            $this->database->connect()->commit(); // Zatwierdzenie transakcji
//        } catch (PDOException $e) {
//            $this->database->connect()->rollBack(); // Wycofanie transakcji w przypadku błędu
//            throw $e;
//        }
//    }

//    public function addUser(User $user)
//    {
//        $pdo = $this->database->connect();
//        $pdo->beginTransaction();
//
//        try {
//            $stmt = $pdo->prepare('
//            INSERT INTO users_details (name, surname, phone)
//            VALUES (?, ?, ?)
//        ');
//
//            $stmt->execute([
//                $user->getName(),
//                $user->getSurname(),
//                $user->getPhone()
//            ]);
//
//            $userDetailsId = $pdo->lastInsertId();
//
//            $stmt = $pdo->prepare('
//            INSERT INTO users (email, password, id_user_details)
//            VALUES (?, ?, ?)
//        ');
//
//            $stmt->execute([
//                $user->getEmail(),
//                $user->getPassword(),
//                $userDetailsId
//            ]);
//
//            $pdo->commit(); // Zatwierdzenie transakcji
//        } catch (PDOException $e) {
//            $pdo->rollBack(); // Wycofanie transakcji w przypadku błędu
//            throw $e;
//        }
//    }

    public function addUser(User $user)
    {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare('
            INSERT INTO users_details (name, surname, phone)
            VALUES (?, ?, ?)
        ');

            $stmt->execute([
                $user->getName(),
                $user->getSurname(),
                $user->getPhone()
            ]);

            $userDetailsId = $pdo->lastInsertId('users_details_id_seq');

            $stmt = $pdo->prepare('
            INSERT INTO users (email, password, id_user_details)
            VALUES (?, ?, ?)
        ');

            $stmt->execute([
                $user->getEmail(),
                $user->getPassword(),
                $userDetailsId
            ]);

            $pdo->commit(); // Zatwierdzenie transakcji
        } catch (PDOException $e) {
            $pdo->rollBack(); // Wycofanie transakcji w przypadku błędu
            throw $e;
        }
    }


    public function getUserDetailsId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users_details WHERE name = :name AND surname = :surname AND phone = :phone
        ');
        $stmt->bindParam(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindParam(':phone', $user->getPhone(), PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }
}