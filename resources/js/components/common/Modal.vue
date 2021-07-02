<template>
    <div class="wrap flex__wrap f__start f__center input__area l__wrapper">
        <div class="p__modal" :class="{'isOpen': isModalActive}">
            <div class="modal__inner">
                <div class="modal__content flex__wrap f__center v__center">
                    <div class="modal__content__inner">
                        <!-- <p class="attention">営業担当と元請けにメッセージが<br>送信されますが、よろしいでしょうか。</p> -->
                        <p class="attention">
                            <slot name="message"></slot>
                        </p>
                        <ul class="selectTab flex__wrap f__center">
                            <li class="go"><a href="" title="" @click.prevent="returnYes"><slot name="ok"></slot></a></li>
                            <li class="back"><a href="" title="" @click.prevent="closeItem"><slot name="cancel"></slot></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: {},
        data() {
            return {
                isModalActive: false,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {
            // 必要に応じてメソッドを定義

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義
            /**
            * clickイベントが発火されたタイミングで、
            * オーバーレイコンテンツを表示するフラグを持つdata(isModalActive)を切り替える
            */
            openItem: function() {
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
            },
            returnYes() {
                this.closeModal();
                this.$emit('parentMethod');
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
