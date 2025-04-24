<?php
/** ==============================================================================
 * File: 이벤트 응모 처리
 * Date: 2023-08-24 12:00
 * Created by @Mojito.DevGroup
 * Copyright 2023, doanddo.hlcompany.com(DevGroup). All rights are reserved
 * ==============================================================================*/
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \DevGroup\Model\ModelBase;
use \DevGroup\Common\CommonFunc;
use \DevGroup\Library\Validator;

header("Content-Type: application/json");

$response               = array();
$response['code']       = false;
$response['message']    = "올바르지 않은 접근입니다.";

$requestInfo = array(
    'page'     => $_REQUEST['page'] ?? 1
);

$validator = new Validator($requestInfo);
$validator->rule('required', 'page')->message('no page');
$validator->rule('integer', 'page');

if ($validator->validate()) {
    $requestInfo = $validator->data();
    $page = $requestInfo['page'];
} else {
    echo json_encode($response);
    exit();
}


if( $validator->validate()) {       					// validation 성공
    $page        = $requestInfo['page'];   // 페이지 번호
    $db = new ModelBase();

    $db->from('EVENT_APPLY2');
    $db->where("user_challenge",'', '<>');
    $db->where("is_view",'Y');
    
    // paging setting
    $listCnt = $db->getCountAll();
    
    // pc는 10개, mobile 6개
//    $perPage = ($DEVICE_TYPE_ == "W") ? 10 : 6;
    $perPage = 3;
    $pageSize = ceil($listCnt / $perPage);
    $currentPage = ($page - 1) * $perPage;

    $db->select("user_name, user_challenge, '' as name", true);
    $db->orderby('seq', 'DESC');
    $db->limit($perPage, $currentPage);
    $result = $db->getAll();


    if($result) {
        foreach ($result as $idx => $row) {
            $rename = CommonFunc::stringDecrypt($row['user_name'], $ENCRYPT_KEY_);
            $user_name = mb_substr($rename,0,1,'utf-8').'*'.mb_substr($rename,2,50,'utf-8');
            $result[$idx]['name'] = $user_name;

            unset($result[$idx]['user_name']);
        }
    }
    //unset($result['user_name']);

    $db-> close();
} else {               									// validation 실패
    $error = $validator->errors();						// error 메세지 출력
    $returnData['msg'] = '입력값을 확인해 주세요.';
    $returnData['result'] = false;
}
$msgArr = array();
$msgArr['pagetotalcnt'] = ceil($listCnt / $perPage);
$msgArr['page'] = $page * 1;
$msgArr['data'] = $result;
//print_r ($arrrr);

echo json_encode($msgArr);