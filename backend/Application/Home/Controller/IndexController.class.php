<?php
// curd articles
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	echo 'i am index controller index action';
    }
    public function add(){
        print_r($_POST);
    }
}