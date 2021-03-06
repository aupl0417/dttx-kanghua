<?php
namespace app\platform\controller;

use app\common\controller\Platform;

use think\Request;
use think\Db;

class Basemanage extends Platform
{
    protected $baseModel;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->baseModel = model('Base');
    }

    public function index(){
        $page['pageCurrent'] = input('post.page', 1, 'intval');
        $page['pageSize']    = input('post.pageSize', 30, 'intval');

        $baseId    = input('post.baseId', '', 'intval');
        $baseName  = input('post.basename', '', 'htmlspecialchars,strip_tags');
        $channel   = input('post.channel', '', 'htmlspecialchars,strip_tags');

        $where     = array('ba_isDelete' => 0, 'ba_projectId' => session('user.platformId'));

        !empty($baseId)   && $where['ba_id']      = $baseId;
        !empty($baseName) && $where['ba_name']    = array('LIKE', '%' . $baseName .'%');
        !empty($channel)  && $where['ba_channel'] = array('LIKE', '%' . $channel .'%');

        $page['totalCount']  = $this->baseModel->getBaseCount($where);
        $limit = ($page['pageCurrent'] - 1) * $page['pageCurrent'] . ',' . $page['pageSize'];
        $base  = $this->baseModel->getBaseList('*', $where, 'ba_id desc', $limit);

        $this->assign('baseList', $base);
        $this->assign('page',     $page);
        $this->assign('baseId',   $baseId ?: '');
        $this->assign('baseName', $baseName);
        $this->assign('channel',  $channel);

        return $this->fetch();
    }

    public function edit(){
        $input     = input('');
        (!isset($input['id']) || empty($input['id'])) && $this->ajaxReturn(array('statusCode' => 300, 'message' => '非法参数'));

        $id        = $input['id'] + 0;

        if(Request::instance()->isPost()){
            $params = array(
                'ba_name'        => trim($input['name']),
                'ba_description' => trim($input['description']),
                'ba_channel'     => str_replace("\r\n", '、', trim($input['channel'])),
                'ba_updateTime'  => time(),
                'ba_createId'    => session('user.userId')
            );

            $result = $this->baseModel->saveData($params, ['ba_id' => $id]);
            !$result && $this->ajaxReturn(array('statusCode' => 300, 'message' => '保存信息失败'));
            $this->ajaxReturn(array('statusCode'=>200, 'message' => '保存信息成功', 'closeCurrent' => 'true', 'tabid'=> 'Basemanage_index'));
        }else{
            $field  = 'ba_id as id,ba_name as name,ba_description as description,ba_channel as channel';
            $data   = $this->baseModel->getBaseById($id, $field);
            $data   && $data['channel'] = str_replace('、', "\r\n", $data['channel']);

            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    public function create(){
        if(Request::instance()->isPost()){
            $input  = input('');
            $time   = time();
            $userId = session('user.userId');
            $params = array(
                'ba_name'        => trim($input['name']),
                'ba_description' => trim($input['description']),
                'ba_channel'     => str_replace("\r\n", '、', trim($input['channel'])),
                'ba_updateTime'  => $time,
                'ba_createId'    => $userId,
                'ba_createTime'  => $time,
                'ba_operateId'   => $userId,
                'ba_projectId'   => session('user.platformId')
            );

            if(Db::name('base')->where(['ba_code' => 'parent', 'ba_isDelete' => 0])->count()){
                $params['ba_code'] = 'child';
            }else{
                $params['ba_code'] = 'parent';
            }

            $result = $this->baseModel->createData($params);
            !$result && $this->ajaxReturn(ajaxCallBack(300, '新增仓库失败'));
            $this->ajaxReturn(ajaxCallBack(200, '新增仓库成功', true, 'platform_Basemanage_Index'));
        }else {
            return $this->fetch();
        }
    }

    public function detail(){

        $input = input('');
        (!isset($input['id']) || empty($input['id'])) && $this->ajaxReturn(array('statusCode' => 300, 'message' => '非法参数'));

        $id    = $input['id'] + 0;
        $field = 'ba_id  as id,ba_name as name,ba_description as description,ba_channel as channel,ba_createId as createId,ba_createTime as createTime,ba_isDelete as isDelete';
        $where = array('ba_id' => $id, 'ba_isDelete' => 0, 'ba_projectId' => session('user.platformId'));

        $data  = $this->baseModel->getRow($where, $field);
        !$data&& $this->ajaxReturn(array('statusCode' => 300, 'message' => '数据不存在'));

        $user  = Db::name('user_platform up')->where(['up_id' => $data['createId']])->join('user u', 'up.up_uid=u.u_id', 'LEFT')->field('u_nick as nick')->find();
        !$user && $this->ajaxReturn(array('statusCode' => 300, 'message' => '用户不存在'));

        $data  = array_merge($data, $user);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function remove(){
        $input = input('');
        (!isset($input['id']) || empty($input['id'])) && $this->ajaxReturn(array('statusCode' => 300, 'message' => '非法参数'));
        $id    = $input['id'] + 0;

        $res   = $this->baseModel->deleteBase($id);
        $res === false && $this->ajaxReturn(array('statusCode' => 300, 'message' => '删除失败'));

        $this->ajaxReturn(array('statusCode' => 200, 'message' => '删除成功'));
    }

}
