<?php
class TagData {
	public static $tablename = "tag";

	public function TagData(){
		$this->created_at = "NOW()";
	}


	public function add(){
		$sql = "insert into ".self::$tablename." (name,project_id,created_at) ";
		 $sql .= "value (\"$this->name\",$this->project_id,$this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto TagData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}



	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TagData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function existTP($tag,$pid) {
		$sql = "select * from ".self::$tablename." where name=\"$tag\" and project_id=$pid";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TagData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
			$data->project_id = $r['project_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}


	public static function countAllByProjectId($project_id){
		$sql = "select count(*) as q from ".self::$tablename." where project_id=$project_id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TagData();
		while($r = $query[0]->fetch_array()){
			$data->q = $r['q'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function countFinishedByProjectId($project_id){
		$sql = "select count(*) as q from ".self::$tablename." where is_finish=1 and project_id=$project_id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TagData();
		while($r = $query[0]->fetch_array()){
			$data->q = $r['q'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function countUnFinishedByProjectId($project_id){
		$sql = "select count(*) as q from ".self::$tablename." where is_finish=0 and project_id=$project_id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TagData();
		while($r = $query[0]->fetch_array()){
			$data->q = $r['q'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TagData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->project_id = $r['project_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->is_finish = $r['is_finish'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByProjectId($project_id){
		$sql = "select * from ".self::$tablename." where project_id=$project_id order by priority_id desc,created_at desc;";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProjectData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->project_id = $r['project_id'];
			$array[$cnt]->priority_id = $r['priority_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->is_finish = $r['is_finish'];
			$cnt++;
		}
		return $array;
	}

	public static function getLikeByProjectId($project_id,$like){
		$sql = "select * from ".self::$tablename." where project_id=$project_id and name like '%$like%' order by priority_id desc,created_at desc;";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProjectData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->project_id = $r['project_id'];
			$array[$cnt]->priority_id = $r['priority_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->is_finish = $r['is_finish'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%' or content like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TagData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->project_id = $r['project_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


}

?>