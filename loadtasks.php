
<?php
session_start();

include "core/controller/Database.php";
include "core/controller/Executor.php";
include "core/controller/Session.php";

include "core/modules/blog/model/ProjectData.php";
include "core/modules/blog/model/PriorityData.php";
include "core/modules/blog/model/TaskData.php";
include "core/modules/blog/model/TagData.php";
include "core/modules/blog/model/TaskTagData.php";

$_SESSION["last_selected"] = $_POST["project_id"];

if(!isset($_POST["q"])){
$projects = TaskData::getAllByProjectId($_POST["project_id"]);
}else{
$projects = TaskData::getLikeByProjectId($_POST["project_id"],$_POST["q"]);	
}
// $all = TaskData::countAllByProjectId($project->id);
$finished = TaskData::countFinishedByProjectId($_POST["project_id"]);
$unfinished = TaskData::countUnFinishedByProjectId($_POST["project_id"]);
?>

<ol class="breadcrumb">
  <li class="active"><?php echo $unfinished->q; ?> Pendientes</a></li>
  <li class="active"><?php echo $finished->q; ?> Finalizadas</a></li>
  <li class="active"><?php echo count($projects); ?> Todas</a></li>
</ol>
<?php
if(count($projects)>0){
echo "<ul type='none'>";
foreach ($projects as $project) {
	$priority = PriorityData::getById($project->priority_id);
	$checked = "";
	if($project->is_finish){
		$checked = "checked";
	}
$tags_str = "";
$tags = TaskTagData::getAllByTaskId($project->id);
foreach($tags as $t){
$tags_str.= "<span class='label label-default'><i class='fa fa-tag'></i> ".$t->getTag()->name."</span>";
}

 echo "<li class='task'>
<span class='pull-right'>$priority->name</span>
 <span href='#' class='checkbox task'><label>"."<input type='checkbox' $checked id='check-".$project->id."'>".$project->name."</label>
$tags_str
 </span>
 <div class='task-menu'><a href='' class='btn btn-default btn-xs'><i class='glyphicon glyphicon-edit'></i></a> <a href='#' id='delete-$project->id' class='btn btn-default btn-xs'><i class='glyphicon glyphicon-trash'></i></a></div>
</li>";
$project_id = $project->id;
echo <<<SSS
<script>
$("#check-$project_id").change(function(){
	var r = $(this).get(0).checked;
	var action = "start";
	if(r==true){ action="finish"; }
				$.post("taskaction.php","action="+action+"&task_id=$project_id", function(data){
//					console.log(data);
						loadtasks();
				});		


});
$("#delete-$project_id").click(function(e){
		e.preventDefault();
				$.post("taskaction.php","action=delete&task_id=$project_id", function(data){
						//alert(data);
//						console.log(data);
						loadtasks();
				});
});

</script>

SSS;
}
echo "</ul>";
}else{
	echo "<p class='alert alert-info'>No hay tareas</p>";
}
// print_r($_GET);
?>
<script>
		$(".task .task-menu").hide();
	$(".task").mouseover(function(){
		$(this).find(".task-menu").show();
	});
	$(".task").mouseout(function(){
		$(this).find(".task-menu").hide();
	});

</script>