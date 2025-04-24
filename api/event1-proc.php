<?php
/** ==============================================================================
 * File: 이벤트 응모 처리
 * Date: 2023-08-24 12:00
 * Created by @Mojito.DevGroup
 * Copyright 2023, doanddo.hlcompany.com(DevGroup). All rights are reserved
 *
 * 이벤트 응모 : 연락처기준 1일 3회 참여가능, 즉석당첨으로 연락처기준 1회만 당첨 가능.
 * TODO :: 운영오픈 전, 서버 시각 맞는지 반드시 확인할 것, 어뷰저로 인해 CSRF_TOKEN 기능 고려중..., CDN 으로 인해 IP 받아오는 부분 수정할 것
 * ==============================================================================*/
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";
exit;
use \DevGroup\Model\ModelBase;
use \DevGroup\Common\CommonFunc;
use \DevGroup\Library\Validator;

header("Content-Type: application/json");

$today_date = date("Y-m-d");
$today_time = date('Y-m-d H:i:s');      // ### 운영오픈 전, 서버시각 맞는지 반드시 확인할 것

if ($today_date > '2023-09-20') {
    $response['message'] = '이벤트가 종료되었습니다. 9/26 오픈하는 이벤트도 기대해주세요!';
    $response['result']  = false;
    $response['prize']	= 'N';
    $response['prize_name']	= '';
    echo json_encode($response);
    exit;
}

// 결과값 리턴
$response = array();
$response['result'] = false;
$response['message'] = '이벤트가 정상적으로 참여되지 않았습니다.';
$response['prize']	= 'N';
$response['prize_name']	= '';

$requestInfo = array(
    'user_name'     => $_POST['user_name'] ?? '',
    'user_phone'    => $_POST['user_phone'] ?? '',
    'is_agree1'     => $_POST['is_agree1'] ?? '',
    'is_agree2'     => $_POST['is_agree2'] ?? '',
    'user_ip'       => $USER_IP_
);

// 테스트 데이터 -----------------------------------------------------------------
//$requestInfo['user_name']   = '김동임';
//$requestInfo['user_phone']  = '010-2789-7151';
//$requestInfo['is_agree1']   = 'Y';
//$requestInfo['is_agree2']   = 'Y';
//
//$inArray = array("김", "이", "박", "최", "정", "강", "조", "윤", "장", "임", "한", "오", "서", "신", "권", "황", "안", "송", "류", "전", "홍", "고", "문", "양", "손", "배", "조", "백", "허", "유", "남", "심", "노", "정", "하", "곽", "성", "차", "주","우", "구", "신", "임", "나", "전", "민", "유", "진", "지", "엄", "채", "원", "천", "방", "공", "강", "현", "함", "변", "염", "양","변", "여", "추", "노", "도", "소", "신", "석", "선", "설", "마", "길", "주", "연", "방", "위", "표", "명", "기", "반", "왕", "금","옥", "육", "인", "맹", "제", "모", "장", "남", "탁", "국", "여", "진", "어", "은", "편", "구", "용");
//$inArray2 = array("가", "강", "건", "경", "고", "관", "광", "구", "규", "근", "기", "길", "나", "남", "노", "누", "다","단", "달", "담", "대", "덕", "도", "동", "두", "라", "래", "로", "루", "리", "마", "만", "명", "무", "문", "미", "민", "바", "박", "백", "범", "별", "병", "보", "빛", "사", "산", "상", "새", "서", "석", "선", "설", "섭", "성", "세", "소", "솔", "수", "숙", "순", "숭", "슬", "승", "시", "신", "아", "안", "애", "엄", "여", "연", "영", "예", "오", "옥", "완", "요", "용", "우", "원", "월", "위","유", "윤", "율", "으", "은", "의", "이", "익", "인", "일", "잎", "자", "잔", "장", "재", "전", "정", "제", "조", "종", "주", "준", "중", "지", "진", "찬", "창", "채", "천", "철", "초", "춘", "충", "치", "탐", "태", "택", "판", "하", "한", "해", "혁", "현", "형","혜", "호", "홍", "화", "환", "회", "효", "훈", "휘", "희", "운", "모", "배", "부", "림", "봉", "혼", "황", "량", "린", "을", "비","솜", "공", "면", "탁", "온", "디", "항", "후", "려", "균", "묵", "송", "욱", "휴", "언", "령", "섬", "들", "견", "추", "걸", "삼","열", "웅", "분", "변", "양", "출", "타", "흥", "겸", "곤", "번", "식", "란", "더", "손", "술", "훔", "반", "빈", "실", "직", "흠","흔", "악", "람", "뜸", "권", "복", "심", "헌", "엽", "학", "개", "롱", "평", "늘", "늬", "랑", "얀", "향", "울", "련");
//
//$random_name = $inArray[array_rand($inArray, 2)[0]].$inArray2[array_rand($inArray2, 2)[0]].$inArray2[array_rand($inArray2, 2)[1]];
//$random_phone = CommonFunc::hyphen_hp_number('010'.sprintf('%08d',rand(00000000,99999999)));
//
//$requestInfo['user_name']   = $random_name;
//$requestInfo['user_phone']  = $random_phone;
// -----------------------------------------------------------------

$validator = new Validator($requestInfo);
$validator->rule('required', 'user_name')->message('이름을 입력해주시기 바랍니다.');
$validator->rule('required', 'user_phone')->message('연락처를 입력해주시기 바랍니다.');
$validator->rule('required', 'is_agree1')->message('동의해주시기 바랍니다.');
$validator->rule('required', 'is_agree2')->message('동의해주시기 바랍니다.');
$validator->rule('in', 'is_agree1', array('Y'))->message('동의 여부를 확인해 주세요.');
$validator->rule('in', 'is_agree2', array('Y'))->message('동의 여부를 확인해 주세요.');

if ($validator->validate()) {
    $requestInfo = $validator->data();

    // 암호화 처리
    $requestInfo['user_name']   = CommonFunc::stringEncrypt($requestInfo['user_name'], $ENCRYPT_KEY_);
    $requestInfo['user_phone']  = CommonFunc::stringEncrypt($requestInfo['user_phone'], $ENCRYPT_KEY_);

} else {
    foreach ($validator->errors() as $key => $message) {
        $response['message'] = $message[0];
        $response['result']  = false;
        break;
    }

    echo json_encode($response);
    exit();
}

$db = new ModelBase();

// 참여 가능여부(횟수 체크) : 1일 최대3회
$db->from("EVENT_APPLY");
$db->where("user_phone",$requestInfo['user_phone']);
$db->where("DATE_FORMAT(reg_date,'%Y-%m-%d')", "'{$today_date}'", "=", false);
$applyCnt = $db->getCountAll();
if ($applyCnt >= 3){
    $response['result'] = false;
    $response['message'] = '오늘 응모 기회는 모두 사용하셨네요.';
    echo json_encode($response);
    exit;
}

$db->init();
$db->beginTransaction();

// 기존 당첨여부 판단(동일연락처로 1회만 당첨 가능)
$db->select("prize, prize_name", true);
$db->from("EVENT_PRIZE");
$db->where("prize", "1");
$db->where("user_phone",$requestInfo['user_phone']);
$db->limit(1);
$result = $db->getOne();
if( $result ) {
    $spot_prize = 'Y';      // 기존당첨자
}else{
    $spot_prize = 'N';
}

// 경품 당첨 체크
$db->init();
$db->select("seq, prize, prize_name", true);
$db->from("EVENT_PRIZE");
$db->where("base_date", "'{$today_date}'", '=', false);
$db->where("prize_date", "'{$today_time}'", '<=', false);
$db->where("event_seq", 'NULL', 'IS', false);
$db->where("user_phone", 'NULL', 'IS', false);

if ($spot_prize == 'Y') {       // 즉당 당첨된적이 있으면...
    $db->whereIn("prize",array(6));
}else{                          // 즉당 당첨된적이 없으면...
    $db->whereIn("prize",array(1));
}

$db->orderby("prize_date");
$db->limit(1);
$result = $db->getOne();
if( $result ) {
    $is_prize   = 'Y';      // 경품당첨
    $prize_seq  = $result['seq'];
    $prize_type = $result['prize'];
    $prize_name = $result['prize_name'];

    $requestInfo['is_prize']    = $is_prize;
    $requestInfo['prize_seq']   = $prize_seq;
}else{
    $is_prize                   = 'N';      // 경품 미당첨
    $requestInfo['is_prize']    = $is_prize;
}

$db->init();
$db->from("EVENT_APPLY");
if ($db->insert($requestInfo)) {
    $event_seq = $db->lastInsertId();

    if ($is_prize == 'N'){
        $db->executeTransaction();
        $db->close();

        $response['result']     = true;
        $response['message']    = '이벤트에 정상적으로 참여되었습니다.';
        $response['prize']      = 'N';
        $response['prize_name'] = '';

        echo json_encode($response);
        exit();
    }else{
        $prizeInfo = array(
            'event_seq'     => $event_seq,
            'user_name'     => $requestInfo['user_name'],
            'user_phone'    => $requestInfo['user_phone'],
            'reg_date'      => $today_time
        );

        $db->init();
        $db->from('EVENT_PRIZE');
        $db->where("seq", $prize_seq);
        $db->where("event_seq", 'NULL', 'IS', false);
        $db->where("user_phone", 'NULL', 'IS', false);

        if ( $db->update($prizeInfo) ) {
            $db->executeTransaction();

            $db->init();
            $db->select("seq, prize, prize_name", true);
            $db->from("EVENT_PRIZE");
            $db->where("base_date", "'{$today_date}'", '=', false);
            $db->where("event_seq", $event_seq);
            $db->limit(1);
            $lastResult = $db->getOne();
            if( $lastResult ) { // 최종당첨여부까지 확인
                $response['result'] = true;
                $response['message'] = '이벤트에 정상적으로 참여되었습니다.';
                $response['prize']    = 'Y';
                $response['prize_name']   = $prize_name;

                echo json_encode($response);
                exit();
            }else{              // 기존당첨자로 인해 당첨취소 처리 해야함

                $resetInfo = array(
                    'is_prize'      => 'N',
                    'prize_seq'     => '0'
                );

                $db->init();
                $db->from('EVENT_APPLY');
                $db->where("seq", $event_seq);
                $db->update($resetInfo);

                $response['result'] = true;
                $response['message'] = '이벤트에 정상적으로 참여되었습니다.';
                $response['prize']    = 'N';
                $response['prize_name']   = '';

                echo json_encode($response);

                $db->close();
                exit();
            }

        }else{
            $db->rollBack();
            $db->close();

            echo json_encode($response);
            exit();
        }
    }


}else{
    $db->rollBack();
    $db->close();

    echo json_encode($response);
    exit();
}