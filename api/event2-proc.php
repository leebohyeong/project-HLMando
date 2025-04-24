<?php
/** ==============================================================================
 * File: 이벤트 응모 처리
 * Date: 2023-08-24 12:00
 * Created by @Mojito.DevGroup
 * Copyright 2023, doanddo.hlcompany.com(DevGroup). All rights are reserved
 *
 * 이벤트 응모 : 연락처기준 1일 5회 참여가능, 즉석당첨으로 연락처기준 1회만 당첨 가능.
 * TODO :: 운영오픈 전, 서버 시각 맞는지 반드시 확인할 것, 어뷰저로 인해 CSRF_TOKEN 기능 고려중..., CDN 으로 인해 IP 받아오는 부분 수정할 것
 * ==============================================================================*/
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \DevGroup\Model\ModelBase;
use \DevGroup\Common\CommonFunc;
use \DevGroup\Library\Validator;

header("Content-Type: application/json");

$today_date = date("Y-m-d");
$today_time = date('Y-m-d H:i:s');      // ### 운영오픈 전, 서버시각 맞는지 반드시 확인할 것

if ($today_date > '2023-10-23') {
    $response['message'] = '이벤트가 종료되었습니다.';
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
    $response['prize'] = 'N';
    $response['prize_name'] = '';

    $requestInfo = array(
        'user_name' => $_POST['user_name'] ?? '',
        'user_phone' => $_POST['user_phone'] ?? '',
        'is_agree1' => $_POST['is_agree1'] ?? '',
        'is_agree2' => $_POST['is_agree2'] ?? '',
        'user_challenge' => $_POST['user_challenge'] ?? '',
        'user_ip' => $USER_IP_
    );
	
	$filter = "18년|18놈|18새끼|ㄱㅐㅅㅐㄲl|ㄱㅐㅈㅏ|가슴만져|가슴빨아|가슴빨어|가슴조물락|가슴주물럭|가슴쪼물딱|가슴쪼물락|가슴핧아|가슴핧어|강간|개가튼년|개가튼뇬|개같은년|개걸레|개고치|개너미|개넘|개년|개놈|개늠|개똥|개떵|개떡|개라슥|개보지|개부달|개부랄|개불랄|개붕알|개새|개세|개쓰래기|개쓰레기|개씁년|개씁블|개씁자지|개씨발|개씨블|개자식|개자지|개잡년|개젓가튼넘|개좆|개지랄|개후라년|개후라들놈|개후라새끼|걔잡년|거시기|걸래년|걸레같은년|걸레년|걸레핀년|게부럴|게세끼|게이|게새끼|게늠|게자식|게지랄놈|고환|공지|공지사항|귀두|깨쌔끼|난자마셔|난자먹어|난자핧아|내꺼빨아|내꺼핧아|내버지|내자지|내잠지|내조지|너거애비|노옴|누나강간|니기미|니뿡|니뽕|니씨브랄|니아범|니아비|니애미|니애뷔|니애비|니할애비|닝기미|닌기미|니미|닳은년|덜은새끼|돈새끼|돌으년|돌은넘|돌은새끼|동생강간|동성애자|딸딸이|똥구녁|똥꾸뇽|똥구뇽|똥|띠발뇬|띠팔|띠펄|띠풀|띠벌|띠벨|띠빌|마스터|막간년|막대쑤셔줘|막대핧아줘|맛간년|맛없는년|맛이간년|멜리스|미친구녕|미친구멍|미친넘|미친년|미친놈|미친눔|미친새끼|미친쇄리|미친쇠리|미친쉐이|미친씨부랄|미튄|미티넘|미틴|미틴넘|미틴년|미틴놈|미틴것|백보지|버따리자지|버지구녕|버지구멍|버지냄새|버지따먹기|버지뚫어|버지뜨더|버지물마셔|버지벌려|버지벌료|버지빨아|버지빨어|버지썰어|버지쑤셔|버지털|버지핧아|버짓물|버짓물마셔|벌창같은년|벵신|병닥|병딱|병신|보쥐|보지|보지핧어|보짓물|보짓물마셔|봉알|부랄|불알|붕알|붜지|뷩딱|븅쉰|븅신|빙띤|빙신|빠가십새|빠가씹새|빠구리|빠굴이|뻑큐|뽕알|뽀지|뼝신|사까시|상년|새꺄|새뀌|새끼|색갸|색끼|색스|색키|샤발|서버|써글|써글년|성교|성폭행|세꺄|세끼|섹스|섹스하자|섹스해|섹쓰|섹히|수셔|쑤셔|쉐끼|쉑갸|쉑쓰|쉬발|쉬방|쉬밸년|쉬벌|쉬불|쉬붕|쉬빨|쉬이발|쉬이방|쉬이벌|쉬이불|쉬이붕|쉬이빨|쉬이팔|쉬이펄|쉬이풀|쉬팔|쉬펄|쉬풀|쉽쌔|시댕이|시발|시발년|시발놈|시발새끼|시방새|시밸|시벌|시불|시붕|시이발|시이벌|시이불|시이붕|시이팔|시이펄|시이풀|시팍새끼|시팔|시팔넘|시팔년|시팔놈|시팔새끼|시펄|실프|십8|십때끼|십떼끼|십버지|십부랄|십부럴|십새|십세이|십셰리|십쉐|십자석|십자슥|십지랄|십창녀|십창|십탱|십탱구리|십탱굴이|십팔새끼|ㅆㅂ|ㅆㅂㄹㅁ|ㅆㅂㄻ|ㅆㅣ|쌍넘|쌍년|쌍놈|쌍눔|쌍보지|쌔끼|쌔리|쌕스|쌕쓰|썅년|썅놈|썅뇬|썅늠|쓉새|쓰바새끼|쓰브랄쉽세|씌발|씌팔|씨가랭넘|씨가랭년|씨가랭놈|씨발|씨발년|씨발롬|씨발병신|씨방새|씨방세|씨밸|씨뱅가리|씨벌|씨벌년|씨벌쉐이|씨부랄|씨부럴|씨불|씨불알|씨붕|씨브럴|씨블|씨블년|씨븡새끼|씨빨|씨이발|씨이벌|씨이불|씨이붕|씨이팔|씨파넘|씨팍새끼|씨팍세끼|씨팔|씨펄|씨퐁넘|씨퐁뇬|씨퐁보지|씨퐁자지|씹년|씹물|씹미랄|씹버지|씹보지|씹부랄|씹브랄|씹빵구|씹뽀지|씹새|씹새끼|씹세|씹쌔끼|씹자석|씹자슥|씹자지|씹지랄|씹창|씹창녀|씹탱|씹탱굴이|씹탱이|씹팔|아가리|애무|애미|애미랄|애미보지|애미씨뱅|애미자지|애미잡년|애미좃물|애비|애자|양아치|어미강간|어미따먹자|어미쑤시자|영자|엄창|에미|에비|엔플레버|엠플레버|염병|염병할|염뵹|엿먹어라|오랄|오르가즘|왕버지|왕자지|왕잠지|왕털버지|왕털보지|왕털자지|왕털잠지|우미쑤셔|운디네|운영자|유두|유두빨어|유두핧어|유방|유방만져|유방빨아|유방주물럭|유방쪼물딱|유방쪼물럭|유방핧아|유방핧어|육갑|이그니스|이년|이프리트|자기핧아|자지|자지구녕|자지구멍|자지꽂아|자지넣자|자지뜨더|자지뜯어|자지박어|자지빨아|자지빨아줘|자지빨어|자지쑤셔|자지쓰레기|자지정개|자지짤라|자지털|자지핧아|자지핧아줘|자지핧어|작은보지|잠지|잠지뚫어|잠지물마셔|잠지털|잠짓물마셔|잡년|잡놈|저년|점물|젓가튼|젓가튼쉐이|젓같내|젓같은|젓까|젓나|젓냄새|젓대가리|젓떠|젓마무리|젓만이|젓물|젓물냄새|젓밥|정액마셔|정액먹어|정액발사|정액짜|정액핧아|정자마셔|정자먹어|정자핧아|젖같은|젖까|젖밥|젖탱이|조개넓은년|조개따조|조개마셔줘|조개벌려조|조개속물|조개쑤셔줘|조개핧아줘|조까|조또|족같내|족까|족까내|존나|존나게|존니|졸라|좀마니|좀물|좀쓰레기|좁빠라라|좃가튼뇬|좃간년|좃까|좃까리|좃깟네|좃냄새|좃넘|좃대가리|좃도|좃또|좃만아|좃만이|좃만한것|좃만한쉐이|좃물|좃물냄새|좃보지|좃부랄|좃빠구리|좃빠네|좃빠라라|좃털|좆같은놈|좆같은새끼|좆까|좆까라|좆나|좆년|좆도|좆만아|좆만한년|좆만한놈|좆만한새끼|좆먹어|좆물|좆밥|좆빨아|좆새끼|좆털|좋만한것|주글년|주길년|쥐랄|지랄|지랼|지럴|지뢀|쪼까튼|쪼다|쪼다새끼|찌랄|찌질이|창남|창녀|창녀버지|창년|처먹고|처먹을|쳐먹고|쳐쑤셔박어|촌씨브라리|촌씨브랑이|촌씨브랭이|크리토리스|큰보지|클리토리스|트랜스젠더|페니스|항문수셔|항문쑤셔|허덥|허버리년|허벌년|허벌보지|허벌자식|허벌자지|허접|허젚|허졉|허좁|헐렁보지|혀로보지핧기|호냥년|호로|호로새끼|호로자슥|호로자식|호로짜식|호루자슥|호모|호졉|호좁|후라덜넘|후장|후장꽂아|후장뚫어|흐접|흐젚|흐졉|bitch|fuck|fuckyou|nflavor|penis|pennis|pussy|sex";
	$search = $requestInfo['user_challenge'];
	
	// 도전목표가 1글자인 경우 추가 23.09.27
	if(mb_strlen($search) == 1){
        $response['result'] = false;
        $response['message'] = '도전목표를 다시 입력해주세요.';
        echo json_encode($response);
        exit();
	}
	// 금지 단어가 포함된 경우 추가 23.09.27
	if (preg_match_all('/('.$filter.')/', $search, $match) == true) {
        $response['result'] = false;
        $response['message'] = '금지 단어가 포함되어 있습니다.';
        echo json_encode($response);
        exit();
	}

// 테스트 데이터 -----------------------------------------------------------------
//    $requestInfo['user_name'] = '테스트';
//    $requestInfo['user_phone'] = '010-1234-1234';
//    $requestInfo['is_agree1'] = 'Y';
//    $requestInfo['is_agree2'] = 'Y';
//
//    $inArray = array("김", "이", "박", "최", "정", "강", "조", "윤", "장", "임", "한", "오", "서", "신", "권", "황", "안", "송", "류", "전", "홍", "고", "문", "양", "손", "배", "조", "백", "허", "유", "남", "심", "노", "정", "하", "곽", "성", "차", "주", "우", "구", "신", "임", "나", "전", "민", "유", "진", "지", "엄", "채", "원", "천", "방", "공", "강", "현", "함", "변", "염", "양", "변", "여", "추", "노", "도", "소", "신", "석", "선", "설", "마", "길", "주", "연", "방", "위", "표", "명", "기", "반", "왕", "금", "옥", "육", "인", "맹", "제", "모", "장", "남", "탁", "국", "여", "진", "어", "은", "편", "구", "용");
//    $inArray2 = array("가", "강", "건", "경", "고", "관", "광", "구", "규", "근", "기", "길", "나", "남", "노", "누", "다", "단", "달", "담", "대", "덕", "도", "동", "두", "라", "래", "로", "루", "리", "마", "만", "명", "무", "문", "미", "민", "바", "박", "백", "범", "별", "병", "보", "빛", "사", "산", "상", "새", "서", "석", "선", "설", "섭", "성", "세", "소", "솔", "수", "숙", "순", "숭", "슬", "승", "시", "신", "아", "안", "애", "엄", "여", "연", "영", "예", "오", "옥", "완", "요", "용", "우", "원", "월", "위", "유", "윤", "율", "으", "은", "의", "이", "익", "인", "일", "잎", "자", "잔", "장", "재", "전", "정", "제", "조", "종", "주", "준", "중", "지", "진", "찬", "창", "채", "천", "철", "초", "춘", "충", "치", "탐", "태", "택", "판", "하", "한", "해", "혁", "현", "형", "혜", "호", "홍", "화", "환", "회", "효", "훈", "휘", "희", "운", "모", "배", "부", "림", "봉", "혼", "황", "량", "린", "을", "비", "솜", "공", "면", "탁", "온", "디", "항", "후", "려", "균", "묵", "송", "욱", "휴", "언", "령", "섬", "들", "견", "추", "걸", "삼", "열", "웅", "분", "변", "양", "출", "타", "흥", "겸", "곤", "번", "식", "란", "더", "손", "술", "훔", "반", "빈", "실", "직", "흠", "흔", "악", "람", "뜸", "권", "복", "심", "헌", "엽", "학", "개", "롱", "평", "늘", "늬", "랑", "얀", "향", "울", "련");
//
//    $random_name = $inArray[array_rand($inArray, 2)[0]] . $inArray2[array_rand($inArray2, 2)[0]] . $inArray2[array_rand($inArray2, 2)[1]];
//    $random_phone = CommonFunc::hyphen_hp_number('010' . sprintf('%08d', rand(00000000, 99999999)));
////
//    $requestInfo['user_name'] = $random_name;
//    $requestInfo['user_phone'] = $random_phone;
//    $requestInfo['user_challenge'] = "하늘을 날자 " . $random_name;
// -----------------------------------------------------------------

    $validator = new Validator($requestInfo);
    $validator->rule('required', 'user_name')->message('이름을 입력해주시기 바랍니다.');
    $validator->rule('required', 'user_phone')->message('연락처를 입력해주시기 바랍니다.');
    $validator->rule('required', 'is_agree1')->message('동의해주시기 바랍니다.');
    $validator->rule('required', 'is_agree2')->message('동의해주시기 바랍니다.');
    $validator->rule('required', 'user_challenge')->message('도전목표를 입력해주시기 바랍니다.');
    $validator->rule('in', 'is_agree1', array('Y'))->message('동의 여부를 확인해 주세요.');
    $validator->rule('in', 'is_agree2', array('Y'))->message('동의 여부를 확인해 주세요.');

    if ($validator->validate()) {
        $requestInfo = $validator->data();

        // 암호화 처리
        $requestInfo['user_name'] = CommonFunc::stringEncrypt($requestInfo['user_name'], $ENCRYPT_KEY_);
        $requestInfo['user_phone'] = CommonFunc::stringEncrypt($requestInfo['user_phone'], $ENCRYPT_KEY_);

    } else {
        foreach ($validator->errors() as $key => $message) {
            $response['message'] = $message[0];
            $response['result'] = false;
            break;
        }

        echo json_encode($response);
        exit();
    }

$db = new ModelBase();

// 참여 가능여부(횟수 체크) : 1일 최대 5회
$db->from("EVENT_APPLY2");
$db->where("user_phone", $requestInfo['user_phone']);
$db->where("DATE_FORMAT(reg_date,'%Y-%m-%d')", "'{$today_date}'", "=", false);
$applyCnt = $db->getCountAll();
if ($applyCnt >= 5) {
    $response['result'] = false;
    $response['message'] = '오늘 응모 기회는 모두 사용하셨네요.';
    echo json_encode($response);
    exit;
}

$db->init();
$db->beginTransaction();

// 기존 당첨여부 판단(동일연락처로 1회만 당첨 가능)
$db->select("prize, prize_name", true);
$db->from("EVENT_PRIZE2");
$db->whereIn("prize", array(1, 2, 3));
$db->where("user_phone", $requestInfo['user_phone']);
$db->limit(1);
$result = $db->getOne();
if ($result) {
    $spot_prize = 'Y';      // 기존당첨자
} else {
    $spot_prize = 'N';
}

// 경품 당첨 체크
$db->init();
$db->select("seq, prize, prize_name", true);
$db->from("EVENT_PRIZE2");
$db->where("base_date", "'{$today_date}'", '=', false);
$db->where("prize_date", "'{$today_time}'", '<=', false);
$db->where("event_seq", 'NULL', 'IS', false);
$db->where("user_phone", 'NULL', 'IS', false);

if ($spot_prize == 'Y') {       // 즉당 당첨된적이 있으면...
    $db->whereIn("prize", array(6));
} else {                          // 즉당 당첨된적이 없으면...
    $db->whereIn("prize", array(1, 2, 3));
}

$db->orderby("prize_date");
$db->limit(1);
$result = $db->getOne();
if ($result) {
    $is_prize = 'Y';      // 경품당첨
    $prize_seq = $result['seq'];
    $prize_type = $result['prize'];
    $prize_name = $result['prize_name'];

    $requestInfo['is_prize'] = $is_prize;
    $requestInfo['prize_seq'] = $prize_seq;
} else {
    $is_prize = 'N';      // 경품 미당첨
    $requestInfo['is_prize'] = $is_prize;
}

$db->init();
$db->from("EVENT_APPLY2");
if ($db->insert($requestInfo)) {
    $event_seq = $db->lastInsertId();

    if ($is_prize == 'N') {
        $db->executeTransaction();
        $db->close();

        $response['result'] = true;
        $response['message'] = '이벤트에 정상적으로 참여되었습니다.';
        $response['prize'] = 'N';
        $response['prize_name'] = '';

        echo json_encode($response);
        exit();
    } else {
        $prizeInfo = array(
            'event_seq' => $event_seq,
            'user_name' => $requestInfo['user_name'],
            'user_phone' => $requestInfo['user_phone'],
            'reg_date' => $today_time
        );

        $db->init();
        $db->from('EVENT_PRIZE2');
        $db->where("seq", $prize_seq);
        $db->where("event_seq", 'NULL', 'IS', false);
        $db->where("user_phone", 'NULL', 'IS', false);

        if ($db->update($prizeInfo)) {
            $db->executeTransaction();

            $db->init();
            $db->select("seq, prize, prize_name", true);
            $db->from("EVENT_PRIZE2");
            $db->where("base_date", "'{$today_date}'", '=', false);
            $db->where("event_seq", $event_seq);
            $db->limit(1);
            $lastResult = $db->getOne();
            if ($lastResult) { // 최종당첨여부까지 확인
                $response['result'] = true;
                $response['message'] = '이벤트에 정상적으로 참여되었습니다.';
                $response['prize'] = 'Y';
                $response['prize_name'] = $prize_name;

                echo json_encode($response);
                exit();
            } else {              // 기존당첨자로 인해 당첨취소 처리 해야함

                $resetInfo = array(
                    'is_prize' => 'N',
                    'prize_seq' => '0'
                );

                $db->init();
                $db->from('EVENT_APPLY2');
                $db->where("seq", $event_seq);
                $db->update($resetInfo);

                $response['result'] = true;
                $response['message'] = '이벤트에 정상적으로 참여되었습니다.';
                $response['prize'] = 'N';
                $response['prize_name'] = '';

                echo json_encode($response);

                $db->close();
                exit();
            }

        } else {
            $db->rollBack();
            $db->close();

            echo json_encode($response);
            exit();
        }
    }


} else {
    $db->rollBack();
    $db->close();

    echo json_encode($response);
    exit();
}