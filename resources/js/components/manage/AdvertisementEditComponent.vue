<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="updateAdvertisement">
            <template v-slot:message>更新します。よろしいでしょうか？</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">広告会社編集</h1>
                        <span class="en">Add Edit</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">会社名</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.company">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">URL</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.url">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">電話番号</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.tel">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">担当者名</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.charge">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__box">
                                        <input class="bgType" type="email" name="" v-model="advertisement.email">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">携帯電話</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" v-model="advertisement.phone">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">郵便番号（※半角数字のみ入力可）</div>
                                    <div class="input__wrap flex__wrap f__start v__center">
                                        <div class="input__box post__one">
                                            <input class="bgType" type="text" name="" placeholder="000" v-model="zip_first">
                                        </div>
                                        -
                                        <div class="input__box post__two">
                                            <input class="bgType" type="text" name="" placeholder="0000" v-model="zip_second">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">住所</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="text" name="" v-model="advertisement.address">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="content__input">
                                    <div class="headline">契約期間</div>
                                    <div class="input__wrap">
                                        <div class="input__box selectBox">
                                            <select class="bgType" name="">
                                                <option value="">1ヶ月</option>
                                                <option value="">3ヶ月</option>
                                                <option value="">6ヶ月</option>
                                                <option value="">12ヶ月</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">金額</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="" name="">
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__submit f__center">
                <div class="submit__box">
                    <input class="clickonce" type="submit" name="" value="編集内容を登録する" @click="confirm">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import Modal from '../common/Modal.vue'

    export default {
        components: {
            'modal' : Modal
        },
        // 必要に応じて、bladeから渡されるデータを定義
        props: {
            id: {
                type: Number
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                advertisement: null,
                zip_first: null,
                zip_second: null
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // 広告会社詳細を取得する
            axios.get('/api/advertisements/'+this.id, {})
                .then(result => {
                    this.advertisement = result.data
                    this.zip_first  = this.advertisement.zip.substr(0,3)
                    this.zip_second = this.advertisement.zip.substr(3,4)
                })
                .catch(result => {
                    alert('広告会社情報取得時にエラーが発生しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                this.$refs.modal.openModal()
            },
            // 広告会社情報を更新する
            updateAdvertisement: function() {
                // if (confirm('更新します。よろしいでしょうか？')) {
                    // OKボタンが押下された場合、広告会社更新APIを呼び出す
                    this.advertisement.zip = this.zip_first + this.zip_second
                    const params = this.advertisement
                    axios.put('/api/advertisements/' + this.id, params)
                        .then(result => {
                            alert('広告会社情報を更新しました。')
                        })
                        .catch(result => {
                            errorHandling.errorMessage(result)
                        })
                // }
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
