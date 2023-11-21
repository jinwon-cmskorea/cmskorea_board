<?php
class MemberDTO{
	private $pk;
	private $id;
	private $telNumber;
	private $email;
	private $position;
	private $insertTime;
	private $updateTime;
	
	public function getPk() {
		return $this->pk;
	}
	public function setPk($pk) {
		$this->pk = $pk;
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
}

?>