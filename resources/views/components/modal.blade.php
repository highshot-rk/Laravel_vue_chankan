<!-- コンポーネント -->
<!-- スマホのみのメニューバー -->
<?php if (is_mobile()) { ?>
@include("../components/nav")
<?php } ?>
<div class="wrap flex__wrap f__start f__center input__area l__wrapper">
    <div class="p__modal" :class="{'isOpen': isModalActive}">
        <div class="modal__inner">
            <div class="modal__content flex__wrap f__center v__center">
                <div class="modal__content__inner">
                    <p class="attention">営業担当と元請けにメッセージが<br>送信されますが、よろしいでしょうか。</p>
                    <ul class="selectTab flex__wrap f__center">
                        <li class="go"><a href="" title="">はい</a></li>
                        <li class="back"><a href="" title="" @click="closeItem">戻る</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
<script>
    new Vue({
    el: '.l__wrapper',
    data() {
        return {
            isModalActive: false,
        }
    },
    methods: {
        /**
        * clickイベントが発火されたタイミングで、
        * オーバーレイコンテンツを表示するフラグを持つdata(isModalActive)を切り替える
        */
        openItem() {
        this.openModal();
        },
        closeItem() {
        this.closeModal();
        },
        /**
        * active状態を切り替える。
        */
        openModal() {
        this.isModalActive = true;
        },
        closeModal() {
        this.isModalActive = false;
        }
    }
    });
</script>
