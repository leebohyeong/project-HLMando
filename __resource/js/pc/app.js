import {findOne, find, on} from '../helper';
import Modal from "../Modal";
import Swiper from 'swiper';
import ClipboardJS from "clipboard";
import {set} from "js-cookie";
import {random} from "gsap/gsap-core";


const app = () => {

    //유튜브 자동재생
    // (() => {
    //     const tag = document.createElement('script');
    //
    //     tag.src = "https://www.youtube.com/iframe_api";
    //     const firstScriptTag = document.getElementsByTagName('script')[0];
    //     firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    //
    //     let player;
    //     window.onYouTubeIframeAPIReady = () => {
    //         player = new YT.Player('player', {
    //             // height: '360',
    //             // width: '640',
    //             videoId: 'YoickSkp8dU',
    //             // autoplay: 0,
    //
    //             events: {
    //                 onReady(event) {
    //                     event.target.playVideo();
    //                 },
    //                 onStateChange(event) {
    //                     console.log(event.data);
    //                 }
    //             }
    //         });
    //     }
    //
    //     // 4. The API will call this function when the video player is ready.
    //     function onPlayerReady(event) {
    //         event.target.playVideo();
    //     }
    //
    //     // 5. The API calls this function when the player's state changes.
    //     //    The function indicates that when playing a video (state=1),
    //     //    the player should play for six seconds and then stop.
    //     var done = false;
    //     function onPlayerStateChange(event) {
    //         if (event.data == YT.PlayerState.PLAYING && !done) {
    //             setTimeout(stopVideo, 6000);
    //             done = true;
    //         }
    //     }
    //     function stopVideo() {
    //         player.stopVideo();
    //     }
    //
    // })();

    //event02 modal
    (() => {
        const modal = new Modal();
        const event02ModalWrap = findOne('#event02-modal-wrap');
        const event02Modal = findOne('#event02-modal');
        const event02ModalButton = findOne('.event02-modal__button');
        const event02Modal2 = findOne('#event02-modal2');
        const event02Button = findOne('#event02-button');
        const form = findOne('form', event02ModalWrap);
        const userChallenge = findOne('[name="user_challenge"]', form);
        const formAgree1 = findOne('[name="is_agree1"]', form);
        const formAgree2 = findOne('[name="is_agree2"]', form);
        const formName = findOne('[name="user_name"]', form);
        const formNameCheck = /^[가-힣a]+$/;
        const formPhone = findOne('[name="user_phone"]', form);
        const formPhoneCheck = /^[0-9]+$/;
        const formPhoneCheck2 = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
        const count = findOne('[name="user_challenge"] + p span', form);
        const event02ModalResult = findOne('#event02-modal-result');
        const event02ModalResultButton = find('.event02-modal-result__button');
        const event02ModalResultCloseButton = findOne('.modal__close-button', event02ModalResult);
        const fail = findOne('.event02-modal-result__content--fail');
        const gift = findOne('.event02-modal-result__content--gift');
        const gift1 = findOne('.event02-modal-result__content--gift-v1');
        const gift2 = findOne('.event02-modal-result__content--gift-v2');
        const gift3 = findOne('.event02-modal-result__content--gift-v3');

        //도전목표 입력 팝업
        userChallenge.addEventListener('input', (event) => {
            event.preventDefault();

            const content = userChallenge.value;
            count.innerHTML = content.length;

            if(content.length > 20) {
                alert('최대 20자까지 입력이 가능합니다.');
                count.innerHTML = 20;
                return false;
            }
        });

        const isValid = () => {
            if (!formAgree1.checked) {
                alert('개인정보 수집 이용에 대한 안내 및 동의해 주세요');
                formAgree1.focus();
                return false;
            }

            if (!formAgree2.checked) {
                alert('이벤트 유의사항에 동의해 주세요');
                formAgree2.focus();
                return false;
            }

            if (!formName.value.trim()) {
                alert('이름을 입력해 주세요.');
                formName.focus();
                return false;
            }

            if (!formNameCheck.test(formName.value.trim())) {
                alert('한글로 입력해 주세요.');
                formName.focus();
                return false;
            }

            if (!formPhone.value.trim()) {
                alert('연락처를 입력해 주세요.');
                formPhone.focus();
                return false;
            }

            if (!formPhoneCheck.test(formPhone.value.trim())) {
                alert('숫자만 입력 가능합니다.');
                formPhone.focus();
                return false;
            }

            if (!formPhoneCheck2.test(formPhone.value.trim())) {
                alert('연락처를 확인해 주세요.');
                formPhone.focus();
                return false;
            }
            return true;
        };

        //event02 팝업 열기
        on(event02Button, 'click', (event) => {
            event.preventDefault();

            form.reset();
            count.innerHTML = 0;
            modal.open(event02Modal);
        });

        //event02 개인정보팝업 다음버튼 클릭시
        on(event02ModalButton, 'click', () => {
            if(isValid()) {
                modal.close(event02Modal);
                modal.open(event02Modal2);
            }
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (!userChallenge.value.trim()) {
                alert('도전목표를 입력해주시기 바랍니다.');
                userChallenge.focus();
                return false;
            }

            const formData = new FormData(form);

            fetch('/api/event2-proc.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    //console.log(data);
                    if (!data.result === false) {
                        if (data.prize === "N") {
                            // console.log('꽝');
                            modal.close(event02Modal2);
                            modal.open(event02ModalResult);
                            gift.style.display = 'none';

                        } else {
                            // console.log('당첨');
                            modal.close(event02Modal2);
                            modal.open(event02ModalResult);
                            fail.style.display = 'none';

                            if(data.prize_name === "반얀트리") {
                                gift2.style.display = 'none';
                                gift3.style.display = 'none';
                                gift1.style.backgroundImage = "url('/assets/images/img_popup_gift_banyantree-One-night-stay-ticket.jpg')";
                            }

                            if(data.prize_name === "배민상품권") {
                                gift1.style.display = 'none';
                                gift3.style.display = 'none';
                                gift2.style.backgroundImage = "url('/assets/images/img_popup_gift_baemin-5000won.jpg')";
                            }

                            if(data.prize_name === "에어팟맥스") {
                                gift1.style.display = 'none';
                                gift2.style.display = 'none';
                                gift3.style.backgroundImage = "url('/assets/images/img_popup_gift_AirPods-Max-Apple.jpg')";
                            }

                        }

                    } else {
                        alert(data.message);
                    }

                })
                .catch(error => {console.error(error)});
        });

        //경품 결과 팝업 페이지내 닫기 버튼
        event02ModalResultButton.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault();
                modal.close(event02ModalResult);
                location.reload();
            });
        })

        //경품 결과 x 닫기 버튼
        on(event02ModalResultCloseButton, 'click', (event) => {
            event.preventDefault();
            location.reload();
        });

    })();

    //해시태그 복사
    (() => {
        const hashtagButton = findOne('.hashtag_button');
        const clipboard = new ClipboardJS(hashtagButton);

        clipboard.on('success', function(event) {
            // console.info('Action:', event.action);
            // console.info('Text:', event.text);
            // console.info('Trigger:', event.trigger);
            alert('해시태그가 복사되었습니다.');
            event.clearSelection();
        });

        clipboard.on('error', function(event) {
            // console.error('Action:', event.action);
            // console.error('Trigger:', event.trigger);
        });
    })();

    //event02 게시판 페이징
    (() => {
        const notice = findOne('.event02-challenge__notice');
        const list = findOne('tbody', notice);
        const makeList = (data) => {
            list.innerHTML = data.data.map(item => `<tr><td>${item.user_challenge} <span>${item.name}</span></td></tr>`).join('');
        };
        const pagination = findOne('.event02-challenge-paging', notice);
        const paging = (target, currentPage, pageCount, totalPage) => {
            let items = '';

            //페이지 그룹
            let pageGroup = Math.ceil(currentPage / pageCount)

            //let 페이지 마지막값
            let lastNum = pageGroup * pageCount;

            //let 페이지시작값
            let startNum = lastNum - (pageCount - 1)
            if (lastNum > totalPage) {
                lastNum = totalPage
            }

            //이전값
            let prev = startNum - pageCount;
            if (prev < 1) {
                prev = 1;
            }

            //let 다음
            let next = lastNum + 1

            if (startNum === 1) {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--first"><a class="event02-challenge-paging__link event02-challenge-paging__link--disabled" href="#" data-page="1"><span class="visuallyhidden">처음</span></a></li>';
            } else {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--first"><a class="event02-challenge-paging__link" href="#" data-page="1"><span class="visuallyhidden">처음</span></a></li>';
            }

            if (startNum === 1) {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--prev"><a class="event02-challenge-paging__link event02-challenge-paging__link--disabled" href="#" data-page="' + prev + '"><span class="visuallyhidden">이전</span></a></li>';
            } else {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--prev"><a class="event02-challenge-paging__link" href="#" data-page="' + prev + '"><span class="visuallyhidden">이전</span></a></li>';
            }

            for (let i = startNum; i <= lastNum; i++) {
                if (currentPage === i) {
                    items += `<li class="event02-challenge-paging__item"><a class="event02-challenge-paging__link event02-challenge-paging__link--active" href="#" data-page="${i}">${i}</a></li>`;
                } else {
                    items += `<li class="event02-challenge-paging__item"><a class="event02-challenge-paging__link" href="#" data-page="${i}">${i}</a></li>`;
                }
            }

            if (lastNum === totalPage) {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--next"><a class="event02-challenge-paging__link event02-challenge-paging__link--disabled" href="#" data-page="' + next + '"><span class="visuallyhidden">다음</span></a></li>';
            } else {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--next"><a class="event02-challenge-paging__link" href="#" data-page="' + next + '"><span class="visuallyhidden">다음</span></a></li>';
            }

            if (lastNum === totalPage) {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--last"><a class="event02-challenge-paging__link event02-challenge-paging__link--disabled" href="#" data-page="' + totalPage + '"><span class="visuallyhidden">마지막</span></a></li>';
            } else {
                items += '<li class="event02-challenge-paging__item event02-challenge-paging__item--last"><a class="event02-challenge-paging__link" href="#" data-page="' + totalPage + '"><span class="visuallyhidden">마지막</span></a></li>';
            }

            target.innerHTML = '<ul class="event02-challenge-paging__list">' + items + '</ul>';

            const links = target.querySelectorAll('a');

            links.forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();

                    if (link.classList.contains('event02-challenge-paging__link--disabled')) { //disabled클래스 추가되면 클릭막기
                        return;
                    }
                    paging(target, link.dataset.page * 1, pageCount, totalPage);
                    // console.log(link.dataset.page * 1, pageCount, totalPage);
                });
            });
        };
        const makePagination = (data) => {
            paging(pagination, data.page, 5, data.pagetotalcnt);
        };
        const render = (page) => {
            fetch(`/api/challenge-list.php?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    makeList(data);
                    makePagination(data);
                })
                .catch(error => {console.error(error)});
        };

        render(1);

        on(pagination, 'click', (event) => {
            event.preventDefault();

            const target = event.target.closest('[data-page]');

            if (target) {
                render(target.dataset.page * 1);
            }
        });
    })();

    //도전현황 댓글 랜덤
    (() => {
        const list = findOne('.event02-challenge__contents');
        const items = find('.event02-challenge__contents-item', list);

        if (!items.length) return;

        const fadeInClass = 'event02-challenge__contents-item--fade-in';
        const fadeOutClass = 'event02-challenge__contents-item--fade-out';
        const positionGap = 20;
        const perViewItemSize = items.length < 10 ? items.length : 10;
        const fadeInDuration = 1.5;
        const fadeOutDuration = 1;
        const totalDuration = (fadeInDuration + fadeOutDuration + 6) * 1000;
        const getPerSize = () => ({
            x: ~~((list.clientWidth - positionGap * 4) / items[0].clientWidth),
            y: ~~((list.clientHeight - positionGap * 4) / items[0].clientHeight),
        });
        const getRandomOrder = () => {
            const {x, y} = getPerSize();
            return Array.from({length: x * y}, (_, index) => index).sort(() => Math.random() - 0.5);
        };
        const getRandomGap = () => [-1, 1][~~(Math.random() * 2)] * ~~(Math.random() * (positionGap + 1));
        const getBetween = (value) => ~~(Math.random() * value);
        const getPosition = () => {
            const {x, y} = getPerSize();
            const {clientWidth: width, clientHeight: height} = items[0];
            const perWidth = (list.clientWidth - positionGap * 4) / x;
            const perHeight = (list.clientHeight - positionGap * 4) / y;
            const position = [];

            for (let i = 0; i < y; i++) {
                for (let j = 0; j < x; j++) {
                    position.push({
                        x: perWidth * j + getRandomGap() + positionGap + getBetween(perWidth - width),
                        y: perHeight * i + getRandomGap() + positionGap + getBetween(perHeight - height),
                    })
                }
            }

            return position;
        };
        const motion = () => {
            if (currentOrderIndex >= order.length - 1) {
                position = getPosition();
            }
            currentOrderIndex = currentOrderIndex >= order.length - 1 ? 0 : currentOrderIndex + 1;
            currentItemIndex = currentItemIndex >= items.length - 1 ? 0 : currentItemIndex + 1;
            const {x, y} = position[order[currentOrderIndex]];
            const item = items[currentItemIndex];

            item.classList.remove(fadeInClass, fadeOutClass);
            item.style.cssText = `top: ${y}px; left: ${x}px; transition-duration: 0s`;
            setTimeout(() => {
                item.style.transitionDuration = `${fadeInDuration}s`;
                item.classList.add(fadeInClass);
            }, 17);
            setTimeout(() => {
                item.style.transitionDuration = `${fadeOutDuration}s`;
                item.classList.add(fadeOutClass);
            }, totalDuration - fadeOutDuration * 1000 - 100);

            setTimeout(motion, totalDuration);
        };
        const resize = () => {
            order = getRandomOrder();
            position = getPosition();
        };

        let order;
        let position;
        let currentOrderIndex = 0;
        let currentItemIndex = 0;

        resize();
        // on(window, 'resize', resize);

        for (let i = 0; i < perViewItemSize; i++) {
            setTimeout(motion, totalDuration / perViewItemSize * i);
        }
    })();

    //solution
    (() => {
        const solution = findOne('.main-solution');
        const solutionCarousel = new Swiper('.main-solution .swiper', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            slideToClickedSlide: true
        });
    })();

    //people
    (() => {
        const people = findOne('.main-people');
        const items = find('.swiper-slide a', people);
        const peopleCarousel = new Swiper('.main-people .swiper', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            slideToClickedSlide: true
        });
    })();

    //story
    (() => {
        const story = findOne('.main-story');
        const tab = findOne('.main-story__tab', story);
        const buttons = find('.main-story__tab-item', story);
        const items = find('.main-story__video-item', story);

        buttons.forEach((button, index) => {
            on(button, 'click', (event) => {
                event.preventDefault();

                tab.style.backgroundImage = `url(/assets/images/img_stroy_tab_${index + 1}.jpg)`;

                // const siblings = t => [...t.parentElement.children].filter(e => e != t);
                // const test = siblings(button);
                // console.log(test.dataset.target);


                const iframe = findOne(`.main-story__video-iframe-${index + 1}`);
                iframe.src = iframe.src;

                items.forEach(item => {
                    item.classList.remove('main-story__video-item--active');
                })

                items[index].classList.add('main-story__video-item--active');
            });
        });


    })();
}


document.addEventListener('DOMContentLoaded', app);