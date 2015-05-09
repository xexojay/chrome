<?php
namespace Home\Controller;
use Think\Controller;
define('PWD_KEY','ohwqeqegrqergeq987423ewrgwq');
class CeshiController extends Controller
{

	public function register()
	{
		$this->display();
	}

	public function register_commit()
	{
		$model = D("Gap");
		$model->create();
		$model->password = md5(md5(($model->password).PWD_KEY));
		$model->create_time = time();
		$result = $model->add();
		//print_r($result);
		if($result){
			//ajax to the client
			$this->success('新增成功', 'welcome');
		}
	}

	public function login()
	{
		$this->display();	
	}

	public function login_check()
	{
		//echo 2323;
		//print_r($_GET);
		$obj = json_decode($_GET['val']);
		$data['name'] = $obj->n;
		//md5(md5($obj->p.PWD_KEY))
		$data['password'] = md5(md5($obj->p.PWD_KEY));
		//print_r($data);
		//exit;
		//success -> controller=>index action index set cookie
		//$data['name'] = I('post.name');
		//$data['password'] = md5(md5(I('post.password').PWD_KEY));
		$model = D("Gap");
		$result = $model->where($data)->select();
		if($result){
			foreach($result as $id=>$v){
				//print_r($v);
				echo json_encode(array('dulishuo_id'=>$v['_id'],'dulishuo_nickname'=>$v['name'],'code'=>1));
				break;
			}
			//cookie('_id',$arr['_id']);
			//cookie('nickname',$arr['name']);
			//ajax json success
		}else{
			echo json_encode(array('code'=>0));
		}
		
	}


	public function upload_text(){
		//echo 13232;
		$raw_data = file_get_contents("php://input");
		//print_r($raw_data);
		//var_dum(json_decode($raw_data));
		//var_dump($raw_data);
		//exit;
		
		//echo PHP_EOL;
		$data = json_decode($raw_data);
		//var_export($data);
		//die();
		$id = $data->_id;
		//$adata['content'] = array('push',$data->text);
		$adata['content'] = array('push',array('text'=>mysql_escape_string($data->text),'url'=>$data->url,'title'=>$data->title));
		//print_r($adata);
		//die();
		$model = D("Gap");
		$result = $model->where(array('_id'=>$id))->save($adata);
		//var_export($result);
		if($result){
		  echo json_encode(array('code'=>1,'msg'=>'success'));
		}
	}

	public function welcome(){
		//echo 123;
		$model = D("Gap");
		//$conditions['content1'] = array('$exists'=>true);
		//$result = $model->field('content1')->where($conditions)->select();
		$result = $model->select();
		//var_export($result);
		print_r($result);
		exit;
		$this->assign('content',$result);
		$this->display();
	}
}