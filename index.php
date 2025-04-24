<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \DevGroup\Model\ModelBase;
use \DevGroup\Common\CommonFunc;

$today_date = date("Y-m-d");
//$today_date = "2023-10-17";


$db = new ModelBase();
$db->select("seq, user_name, user_challenge, '' as name", true);
$db->from('EVENT_APPLY2');
$db->where("user_challenge",'', '<>');
$db->where("is_view",'Y');
$db->orderby('seq', 'DESC');
$db->limit(30);
$result = $db->getAll();
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HL만도 BIG 이벤트</title>
    <meta name="description" content="호텔 숙박권, 에어팟맥스 등 경품 증정!">
    <meta property="og:type" content="website">
    <meta property="og:title" content="HL만도 BIG 이벤트">
    <meta property="og:description" content="호텔 숙박권, 에어팟맥스 등 경품 증정!">
    <meta property="og:image" content="https://doanddo.hlcompany.com/assets/images/og_image2.png">
    <meta property="og:url" content="https://doanddo.hlcompany.com/">
    <meta property="og:site_name" content="HL만도 BIG 이벤트">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TXL9JBDR');</script>
    <!-- End Google Tag Manager -->

    <link rel="icon" type="image/png" sizes="16x16" href="/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pretendard/1.3.8/static/pretendard.css">
    <link rel="stylesheet" href="/assets/css/vendors.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/js/app.js"></script>

</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TXL9JBDR" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<main class="main">
    <input type="hidden" name="today_date" value="<?= $today_date ?>">
    <div class="main-intro">
        <video class="main-intro__video" autoplay muted loop>
            <source type="video/mp4" src="/assets/video/intro_video.mp4">
        </video>
        <div class="main-intro__inner">
            <header class="main-intro__header visuallyhidden">
                <h3>HL Mando</h3>
                <h2>
                    미래 모빌리티의 만 가지 가능성으로 <br>
                    새로운 도전에 주저하지 않는 <br>
                    HL만도 사람들처럼!
                </h2>
                <p>
                    우리도 <br>
                    해낼만도!
                </p>
                <p>MANDO</p>
            </header>
            <div class="main-intro__contents">
                <div class="main-intro__youtube">
                    <!--                        <div id="player"></div>-->
                    <iframe src="https://www.youtube.com/embed/lGT8BGOabo0?version=3&controls=0&autoplay=1&playsinline=1&playlist=lGT8BGOabo0&mute=1&loop=1&rel=0&fs=0"
                            title="[HL만도] do and do TVC 광고｜사람편(30")" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <section id="main-event02" class="main-event02">
        <div class="main-event02__contents main-event02__contents--1">
            <div class="main-event02__contents-inner">
                <header class="visuallyhidden">
                    <h2>
                        나do and 너do <br>
                        해낼만도 챌린지
                    </h2>
                    <p>
                        올해가 가기 전 꼭 도전하고 싶은 목표를 댓글로 남기고 <br>
                        즉석에서 추첨 선물을 확인하세요!
                    </p>
                    <p>이벤트 기간 : 9월 26일(화) ~ 10월 17일(화)</p>
                    <p>이벤트 문의: hlmandoevent@gmail.com</p>
                </header>
                <div class="visuallyhidden">
                    <h3>이벤트 경품 안내</h3>
                    <ul>
                        <li>
                            <span>1명</span>
                            반얀트리 2인 숙박권 <br>
                            (100만원 상당)
                        </li>
                        <li>
                            <span>2명</span>
                            AirPods Max
                        </li>
                        <li>
                            <span>1,000명</span>
                            배달의민족 <br>
                            상품권 5천원 권
                        </li>
                    </ul>
                    <p>새로운 도전에 주저하지 않고 결국 해내는 HL만도 사람들 처럼</p>
                    <p>
                        나는 __에 <br>
                        도전하고 해내고 싶습니다.
                    </p>
                </div>

                <?php
                if($today_date > '2023-10-17'){
                ?>
                    <p>
                        <button class="event02-button" type="button" onclick="alert('이벤트가 종료되었습니다.')">
                            <span class="visuallyhidden">이벤트가 종료되었습니다.</span>
                        </button>
                    </p>
                <?php }else{?>
                    <p>
                        <button id="event02-button" class="event02-button" type="button">
                            <span class="visuallyhidden">참여하기</span>
                        </button>
                    </p>
                <?php }
                ?>

            </div>
        </div>
        <div class="main-event02__contents main-event02__contents--2 event02-challenge">
            <video class="event02-challenge__video" autoplay muted loop>
                <source type="video/mp4" src="/assets/video/event02_video.mp4">
            </video>
            <div class="main-event02__contents-inner">
                <header class="event02-challenge__header">
                    <h2 class="visuallyhidden">
                        <strong>챌린지 현황</strong>
                        여러분들의 도전을 확인해보세요!
                    </h2>
                </header>

                <?php
                if($result) {
                ?>
                <div class="event02-challenge__contents">
                    <?php
                    $class = "blue";
                    foreach ($result as $idx => $row) {
                        $rename = CommonFunc::stringDecrypt($row['user_name'], $ENCRYPT_KEY_);
                        $user_name = mb_substr($rename,0,1,'utf-8').'*'.mb_substr($rename,2,50,'utf-8');
                    ?>
                    <div class="event02-challenge__contents-item event02-challenge__contents-item--<?=$class?>">
                        <span><?=$user_name?>님의 도전</span>
                        <?=$row['user_challenge']?>
                    </div>
                    <?php
                        $class = ($class == "blue") ? "white" : "blue";
                    }
                    ?>
                </div>
                <?php
                }
                ?>
                <div class="event02-challenge__notice">
                    <div class="event02-challenge__notice-container">
                        <table>
                            <tbody></tbody>
                        </table>
                    </div>
                    <nav class="event02-challenge-paging"></nav>
                </div>
            </div>
        </div>
        <div id="main-event02-3" class="main-event02__contents main-event02__contents--3">
            <div class="main-event02__contents-inner">
                <header>
                    <h2>보너스 EVENT</h2>
                    <p>
                        새로운 도전에 대한 다짐을 <br>
                        인스타그램에 필수해시태그와 함께 남긴 분들 중 <br>
                        선정을 통해  HL만도가 도전지원금을 드립니다!
                    </p>
                </header>
                <div>
                    <p>도전지원금</p>
                </div>
                <div>
                    <p>유의사항</p>
                    <p>
                        - 당첨자 선정은 랜덤으로 이루어집니다. <br>
                        - 이벤트 참여를 위해 개인정보 취급에 동의하여 주시기 바랍니다 <br>
                        - 입력하신 정보는 제세공과금 안내, 경품 발송 등 경품 관련 확인을 위해서 이용됩니다. <br>
                        - 배달의 민족 상품권은 이벤트 종료 후 10일 내에 입력하신 휴대폰 번호(연락처)를 통해 모바일 상품권(문자 메시지)로 일괄 발송될 예정이며 상황에 따라 발송 일자는 변동될 수 있습니다. <br>
                        - 5만원 이상의 경품은  제세공과금 안내를 위해 입력하신 연락처로 별도 연락드릴 예정입니다. <br>
                        - 5만원 이상의 경품 제공 시 부과되는 제세공과금(22%)는 당사 부담이며 제세공과금 처리에 필요한 서류(신분증 사본)을 제출하지 않을 경우 당첨이 취소 될 수 있습니다. <br>
                        - 당첨자에게 안내해드린 내용 관련하여 48시간 내 회신이 없는 경우 당첨은 무효 처리되며 상황에 따라 경품은 변동될 수 있습니다. <br>
                        - 잘못된 개인 정보 입력으로 인해 당첨자에게 연락이 불가능하거나 경품이 오발송 및 반송/분실될 경우 재발송 되지 않으며  당사에서 책임지지 않습니다.
                    </p>
                </div>
            </div>
            <p>
                <button class="hashtag_button" type="button" data-clipboard-text="#해낼만도 #DOANDDO #HL만도">
                    <span class="visuallyhidden">필수 해시태그 : #HL #HLMANDO #해낼만도</span>
                </button>
            </p>
        </div>
    </section>
    <section id="main-solution" class="main-solution">
        <div class="main-solution__inner">
            <header class="main-solution__header">
                <p>HL Mando</p>
                <h2>솔루션</h2>
                <h3>미래 모빌리티 기술을 이끌어갈 HL Mando 솔루션을 소개합니다</h3>
            </header>
            <div class="main-solution__contents">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_1.jpg')">
                                <a href="https://www.hlworld.com/389" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_2.jpg')">
                                <a href="https://www.hlworld.com/391" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_3.jpg')">
                                <a href="https://www.hlworld.com/392" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_4.jpg')">
                                <a href="https://www.hlworld.com/388" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_5.jpg')">
                                <a href="https://www.hlworld.com/386" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_6.jpg')">
                                <a href="https://www.hlworld.com/390" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_7.jpg')">
                                <a href="https://www.hlworld.com/387" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_1.jpg')">
                                <a href="https://www.hlworld.com/389" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_2.jpg')">
                                <a href="https://www.hlworld.com/391" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_3.jpg')">
                                <a href="https://www.hlworld.com/392" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_4.jpg')">
                                <a href="https://www.hlworld.com/388" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_5.jpg')">
                                <a href="https://www.hlworld.com/386" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_6.jpg')">
                                <a href="https://www.hlworld.com/390" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div style="background-image: url('/assets/images/img_solution_7.jpg')">
                                <a href="https://www.hlworld.com/387" target="_blank">
                                    <span>자세히 보기</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="main-people" class="main-people">
        <header class="main-people__header">
            <p>HL Mando</p>
            <h2>사람들</h2>
            <h3>지속가능한 성장을 위해 열일하는 미래 모빌리티계 떡상 주인공</h3>
        </header>
        <div class="main-people__contents">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/385" target="_blank"
                           style="background-image: url('/assets/images/img_people_1.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/381" target="_blank"
                           style="background-image: url('/assets/images/img_people_2.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/400" target="_blank"
                           style="background-image: url('/assets/images/img_people_3.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/399" target="_blank"
                           style="background-image: url('/assets/images/img_people_4.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/404" target="_blank"
                           style="background-image: url('/assets/images/img_people_5.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/385" target="_blank"
                           style="background-image: url('/assets/images/img_people_1.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/381" target="_blank"
                           style="background-image: url('/assets/images/img_people_2.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/400" target="_blank"
                           style="background-image: url('/assets/images/img_people_3.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/399" target="_blank"
                           style="background-image: url('/assets/images/img_people_4.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/404" target="_blank"
                           style="background-image: url('/assets/images/img_people_5.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/385" target="_blank"
                           style="background-image: url('/assets/images/img_people_1.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/381" target="_blank"
                           style="background-image: url('/assets/images/img_people_2.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/400" target="_blank"
                           style="background-image: url('/assets/images/img_people_3.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/399" target="_blank"
                           style="background-image: url('/assets/images/img_people_4.jpg')"></a>
                    </div>
                    <div class="swiper-slide">
                        <a href="https://www.hlworld.com/404" target="_blank"
                           style="background-image: url('/assets/images/img_people_5.jpg')"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="main-story" class="main-story">
        <div class="main-story__inner">
            <header class="main-story__header">
                <p>HL Mando</p>
                <h2>STORY</h2>
            </header>
            <div class="main-story__contents">
                <div class="main-story__tab">
                    <button class="main-story__tab-item" type="button">
                        <span class="main-story__tab-title">HL그룹</span>
                    </button>
                    <button class="main-story__tab-item" type="button">
                        <span class="main-story__tab-title">HL클레무브</span>
                    </button>
                    <button class="main-story__tab-item" type="button">
                        <span class="main-story__tab-title">HL만도</span>
                    </button>
                </div>
                <div class="main-story__video">
                    <div class="main-story__video-item main-story__video-item--active">
                        <iframe class="main-story__video-iframe-1"
                                src="https://www.youtube.com/embed/RATrBQ753k8?si=EORItCe2dLWeHp7q"
                                title="[HL 그룹] 본편 (Full ver.)"></iframe>
                    </div>
                    <div class="main-story__video-item">
                        <iframe class="main-story__video-iframe-2"
                                src="https://www.youtube.com/embed/NsnFaO9mzNc?si=3prRDLQDd0SLl4aS"
                                title="[HL 클레무브] 길을 잃어도 좋아"></iframe>
                    </div>
                    <div class="main-story__video-item">
                        <iframe class="main-story__video-iframe-3"
                                src="https://www.youtube.com/embed/bje44V_GMR8?si=YYW93R-767oZ1Qcx"
                                title="[HL 만도] 움직이는 모든 것에 자유를 TVC 광고(15초 종합편)"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="main-footer">
        <div class="main-footer__inner">
            <div class="main-footer__text">
                <h2>HL Mando</h2>
                <p>이벤트 문의: hlmandoevent@gmail.com</p>
                <p>HL</p>
                <p>
                    서울특별시 송파구 올림픽로 289 시그마 타워 <br>
                    Copyright HL Holdings Corp. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</main>

<!-- event2 -->
<div id="event02-modal-wrap">
    <form action="/api/event2-proc.php" method="post">
        <!-- event2 개인정보 입력창 팝업 -->
        <div id="event02-modal" class="event02-modal modal">
            <div class="modal__backdrop"></div>
            <div class="modal__dialog">
                <div class="modal__container event02-modal__container">
                    <div class="modal__content event02-modal__content">
                        <!-- 개인정보 수집 동의 -->
                        <div class="event02-modal__privacy">
                            <div class="event02-modal__privacy-content">
                                <p>개인정보 수집 · 이용 동의서</p>
                                <p><br></p>
                                <p>HL 캠페인 이벤트 참여 시 개인정보 수집 이용 목적은 다음과 같습니다. 내용을 자세히 읽어 보신 후 동의 여부를 결정하여 주시기 바랍니다.</p>
                                <p><br></p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th>수집항목</th>
                                        <td>- 이름, 휴대폰 번호</td>
                                    </tr>
                                    <tr>
                                        <th>수집목적</th>
                                        <td>
                                            - 이벤트 참여 신청 및 선정
                                            - 이벤트 신청 및 선정 통보 확인을 위한 경로 확보
                                            - 이벤트 운영 및 결과 분석
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>보유 및 이용기간</th>
                                        <td>
                                            - 비선정자의 개인정보는 본 행사 종료 후 즉시 폐기 <br><br>
                                            - 이벤트 참가자의 개인정보는 본 행사 종료 후 1년간 보유 및 이용되며, 경품 제공 이외의 다른 목적으로는 이용되지 않습니다.
                                            <br><br>
                                            -위의 개인정보 수집·이용은 수집목적에 한하여 사용됩니다. <br><br>
                                            -위의 개인정보 수집·이용에 동의를 거부할 권리가 있으며, 동의 거부할 경우 경품 증정이 제한되는 점 참고 부탁드립니다.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p><br></p>
                                <p>개인정보 처리업무 위탁</p>
                                <p>
                                    서비스 이행을 위해 아래와 같이 개인정보 처리업무를 외부 전문업체에 위탁하여 처리하고 있으며, 업체가 변경될 경우 서면, e-mail, 전화 또는 이와 유사한
                                    방법 중 1개 이상의 방법으로 알려드립니다.
                                </p>
                                <p><br></p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th>애드쿠아 인터렉티브</th>
                                        <td>이벤트 참여자 파악 및 경품 전달을 위한 정보 확인</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="event02-modal__privacy-agree">
                                <label>
                                    <input type="radio" name="is_agree1" value="Y">
                                    <span>동의합니다</span>
                                </label>
                                <label>
                                    <input type="radio" name="is_agree1" value="N">
                                    <span>동의하지 않습니다</span>
                                </label>
                            </div>
                        </div>

                        <!-- 이벤트 유의사항 -->
                        <div class="event02-modal__notice">
                            <p class="modal-visually-hidden">이벤트 유의사항</p>
                            <div class="event02-modal__notice-content">
                                <p>- 이벤트의 연속 참여는 가능하오나 중복 당첨은 불가하며 당첨자 선정은 랜덤으로 이루어집니다.</p>
                                <p><br></p>
                                <p>- 배달의민족 상품권은 이벤트 종료 후 10일 내에 입력하신 휴대폰 번호(연락처)를 통해 모바일 상품권 (문자 메시지)로 일괄 발송될 예정이며 상황에 따라 발송 일자는 변동될 수 있습니다.</p>
                                <p><br></p>
                                <p>- 5만원 이상의 경품은 제세공과금 안내를 위해 입력하신 연락처로 별도 연락드릴 예정입니다.</p>
                                <p><br></p>
                                <p>- 5만원 이상의 경품 제공 시 부과되는 제세공과금 (22%)는 당사 부담이며 제세공과금 처리에 필요한 서류(신분증 사본)을 제출하지 않을 경우 당첨이 취소 될 수 있습니다.</p>
                                <p><br></p>
                                <p>- 잘못된 개인 정보 입력으로 인해 당첨자에게 경품이 오발송 및 반송/분실될 경우 재발송 되지 않으며 당사에서 책임지지 않습니다.</p>
                                <p><br></p>
                                <p>- 부정행위(매크로, 본인 외 타인 번호 사용)발견 시 당첨이 취소될 수 있습니다.</p>
                            </div>
                            <div class="event02-modal__notice-checkbox">
                                <label>
                                    <input type="checkbox" name="is_agree2" value="Y">
                                    <span>확인했습니다.</span>
                                </label>
                            </div>
                        </div>

                        <!-- 참여자 정보 -->
                        <div class="event02-modal__information">
                            <p class="modal-visually-hidden">참여자 정보</p>
                            <div class="event02-modal__information-content">
                                <input type="text" placeholder="이름" name="user_name">
                                <input type="text" placeholder="연락처" name="user_phone" maxlength="11">
                            </div>
                        </div>

                        <!-- 다음 버튼 -->
                        <p class="event02-modal__button">
                            <button type="button">
                                <span class="modal-visually-hidden">다음</span>
                            </button>
                        </p>
                    </div>
                    <div class="modal__close">
                        <button class="modal__close-button" type="button">
                            <span class="modal-visually-hidden">팝업 닫기 버튼</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- event2 도전목표 입력창 팝업 -->
        <div id="event02-modal2" class="event02-modal2 modal">
            <div class="modal__backdrop"></div>
            <div class="modal__dialog">
                <div class="modal__container">
                    <div class="modal__content event02-modal2__content">
                        <!-- 도전 목표  -->
                        <div class="event02-modal2__challenge">
                            <input type="text" name="user_challenge" maxlength="20">
                            <p>
                                <span>0</span>
                                /20
                            </p>
                        </div>

                        <!-- 당첨 확인하기 -->
                        <p class="event02-modal2__button">
                            <button type="submit">
                                <span class="modal-visually-hidden">당첨 확인하기</span>
                            </button>
                        </p>
                    </div>
                    <div class="modal__close">
                        <button class="modal__close-button" type="button"><span class="modal-visually-hidden">닫기</span></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- event2 당첨 확인 팝업 -->
<div id="event02-modal-result" class="event02-modal-result modal">
    <div class="modal__backdrop"></div>
    <div class="modal__dialog">
        <div class="modal__container">
            <div class="modal__content">
                <div class="event02-modal-result__content event02-modal-result__content--gift">
                    <div class="event02-modal-result__content--gift-v1">
                        <div class="modal-visually-hidden">
                            <h2>축하합니다! 반얀트리 1박 숙박권에 당첨되셨습니다!</h2>
                            <p>
                                경품 발송을 위해 이벤트 종료 후 10일 이내 <br>
                                작성하신 연락처로 개별 연락드릴 예정입니다.
                            </p>
                        </div>
                        <p class="event02-modal-result__button">
                            <button type="button">
                                <span class="modal-visually-hidden">닫기</span>
                            </button>
                        </p>
                    </div>
                    <div class="event02-modal-result__content--gift-v2">
                        <div class="modal-visually-hidden">
                            <h2>축하합니다! <br>배달의민족 상품권 (5천원)에 당첨되셨습니다!</h2>
                            <p>
                                경품 발송을 위해 이벤트 종료 후 10일 이내 <br>
                                작성하신 연락처(문자 메세지)로 발송 될 예정입니다.
                            </p>
                        </div>
                        <p class="event02-modal-result__button">
                            <button type="button">
                                <span class="modal-visually-hidden">닫기</span>
                            </button>
                        </p>
                    </div>
                    <div class="event02-modal-result__content--gift-v3">
                        <div class="modal-visually-hidden">
                            <h2>축하합니다! <br> <strong>AirPods Max</strong>에 당첨되셨습니다!</h2>
                            <p>
                                경품 발송을 위해 이벤트 종료 후 10일 이내 <br>
                                작성하신 연락처로 개별 연락드릴 예정입니다.
                            </p>
                        </div>
                        <p class="event02-modal-result__button">
                            <button type="button">
                                <span class="modal-visually-hidden">닫기</span>
                            </button>
                        </p>
                    </div>
                </div>
                <div class="event02-modal-result__content event02-modal-result__content--fail">
                    <div class="modal-visually-hidden">
                        <p>
                            do and do <br>
                            아쉽지만 다시 한 번 <br>
                            도전하세요!
                        </p>
                    </div>
                    <p class="event02-modal-result__button">
                        <button type="button">
                            <span class="modal-visually-hidden">닫기</span>
                        </button>
                    </p>
                </div>
            </div>
            <div class="modal__close">
                <button class="modal__close-button" type="button"><span class="modal-visually-hidden">닫기</span></button>
            </div>
        </div>
    </div>
</div>

</body>
</html>