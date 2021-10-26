<?php 
	
	class MySql {

		private static $pdo;

		public static function connect(){
			
			if(self::$pdo == null){

					try{

					self::$pdo = new \PDO('mysql:host=localhost;dbname=dchat','root','',array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

					self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

					}catch(Exception $e){

						echo 'Erro ao conectar no banco de dados !';

						error_log($e->getMessage());

					}
				}

				return self::$pdo;
			}
			
	}

	class Functions{

		public static function getUserById($id){

			$pdo = MySql::connect();

			$pdo = $pdo->prepare("SELECT * FROM users WHERE id = ?");

			$pdo->execute(array($id));

			return $pdo->fetchAll();

		}

	}

?>