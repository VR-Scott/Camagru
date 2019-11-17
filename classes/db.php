<?php

	class DB{
		private static $_instance = null;
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;

		private function __construct() {
			try {
				$this->_pdo = new PDO('mysql:host=' . 
				Config::get('mysql/host') .';dbname=' . 
				Config::get('mysql/db_name'), Config::get('mysql/username'), 
				Config::get('mysql/password'));
				$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                
                // echo 'Connected';

			} catch (PDOException $e) {
				die($e->getMessage());
            }
		}
		public static function getInstance() {
			if(!isset(self::$_instance)) {
				self::$_instance = new DB();
			}
			return self::$_instance;
		}

		public function query($sql, $params = array()) {
			$this->_error = false;
			// echo $sql . "<br>";
			if ($this->_query = $this->_pdo->prepare($sql)) {

                // echo 'Success';
				$x = 1;
				if(count($params)) {
					foreach($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				if($this->_query->execute()) {

					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					
                    $this->_count = $this->_query->rowCount();
				} else {
					echo "<br>Fail!<br>";
					var_dump($this->_error);

					$this->_error = true;
				}
			}
			return $this;
		}

		public function query_arr($sql, $params = array()) {
			$this->_error = false;
			// echo $sql . "<br>";
			if ($this->_query = $this->_pdo->prepare($sql)) {

                // echo 'Success';
				$x = 1;
				if(count($params)) {
					foreach($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				if($this->_query->execute()) {

					$this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
					
                    $this->_count = $this->_query->rowCount();
				} else {
					echo "<br>Fail!<br>";
					var_dump($this->_error);

					$this->_error = true;
				}
			}
			return $this;
		}



		private function action($action, $table, $where = array()) {
			if (count($where) === 3) {
				$operators = array('=', '>', '<', '>=', '<=');

				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];

				if (in_array($operator, $operators)) {
					$sql= "{$action} FROM {$table} WHERE BINARY {$field} {$operator} ?";
					if(!$this->query($sql, array($value))->error()) {
						return $this;
					}
				}
			}
			return false;
		}

		public function get_like_status($liker_id, $i_id) {
			$eq = '=';
			$sql = "SELECT `status` FROM likes WHERE liker_id {$eq} {$liker_id} AND i_id {$eq} {$i_id} ";
			return $this->query($sql)->_results;
		}

		public function get_like_id($liker_id, $i_id) {
			$eq = '=';
			$sql = "SELECT `l_id` FROM likes WHERE liker_id {$eq} {$liker_id} AND i_id {$eq} {$i_id} "; 
			return $this->query($sql)->_results;
		}

		public function get_user_images($u_id, $page) {
			$eq= '=';
			$sql= "SELECT i_name, u_id, i_id FROM images WHERE u_id {$eq} {$u_id} ORDER BY i_id DESC LIMIT $page,6"; // set limit to display 6 images 
			return $this->query_arr($sql)->_results;
		}

		public function get_comments($i_id, $page) {
			$eq= '=';
			$sql= "SELECT comment, commenter_id FROM comments WHERE i_id {$eq} {$i_id} ORDER BY c_id DESC LIMIT $page,6"; // set limit to display 6 images 
			return $this->query($sql)->_results;
		}

		public function get_gallery($page) {
			$sql= "SELECT i_name, u_id, i_id FROM images ORDER BY i_id DESC LIMIT $page,6"; // set limit to display 6 images 
			return $this->query_arr($sql)->_results;
		}

		public function get_i_data($table, $where) {
			return $this->get($table, $where)->_results;
		}

		public function user_img_count($u_id) {
			$eql= '=';
			$sql= "SELECT i_name FROM images WHERE u_id {$eql} {$u_id}";  
				return $this->query($sql)->_query->rowCount();
		}
		public function comment_count($u_id) {
			$eql= '=';
			$sql= "SELECT i_name FROM images WHERE u_id {$eql} {$u_id}";  
				return $this->query($sql)->_query->rowCount();
		}

		public function gallery_count() {
			$sql= "SELECT i_name FROM images";  
			return $this->query($sql)->_query->rowCount();
		}

		public function get_property($property,$table, $where) {
			return $this->action('SELECT ' . $property , $table, $where)->_results;
		}

		public function get_property_count($property,$table, $field, $var) {
			$eql= '=';
			$sql= "SELECT {$property} FROM {$table} WHERE {$field} {$eql} {$var}";  
				return $this->query($sql)->_query->rowCount();
		}

		public function get($table, $where) {
			return $this->action('SELECT *', $table, $where);
		}

		public function delete($table, $where) {
			return $this->action('DELETE', $table, $where);
		}

		public function insert($table, $fields = array()) {
			if (count($fields)) {
				$keys = array_keys($fields);
				$values = null;
				$x = 1;

				foreach($fields as $field) {
					$values .= '?';
					if ($x < count($fields)) {
						$values .= ', ';
					}
					$x++;
				}

				$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

				if (!$this->query($sql, $fields)->error()) {
					return true;
				}
				echo "<br>";
			}

			return false;
		}
		
		public function update($table, $id, $fields) {
			$set = '';
			$x = 1;

			foreach($fields as $name => $value) {
				$set .= "{$name} = ?";
				if ($x < count($fields)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE {$table} SET {$set} WHERE u_id = {$id}";

			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}

		public function results() {
			return $this->_results;
		}

		public function first() {
			return $this->results()[0];
		}

        public function count() {
            return $this->_count;
        }

	    public function error() {
		    return $this->_error;
	}
}