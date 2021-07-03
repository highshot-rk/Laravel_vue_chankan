<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="registerUser">
            <template v-slot:message>会員を登録してもよろしいでしょうか？</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">会員新規追加</h1>
                        <span class="en">User Edit</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="" required v-model="user.email">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="rememberCheckbox">
                                        <label type="checkbox">
                                            <input type="checkbox" name="" v-model="user.enable_sms">
                                            <span>SMSの送信を許可する</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="content__input">
                                    <template v-for="(option, index) in charges">
                                        <div class="content__input__box">
                                            <div class="content__input__box__inner">
                                                <div class="headline">担当者名</div>
                                                <div class="input__box addList">
                                                    <input class="bgType" type="text" name="" required v-model="charges[index].name">
                                                </div>
                                            </div>
                                            <div class="content__input__box__inner">
                                                <div class="headline">担当者携帯電話</div>
                                                <div class="input__box addList">
                                                    <input class="bgType" type="text" name="" required v-model="charges[index].phone">
                                                </div>
                                            </div>
                                            <div class="content__input__box__inner">
                                                <div class="headline">担当者メールアドレス</div>
                                                <div class="input__box addList">
                                                    <input class="bgType" type="text" name="" v-model="charges[index].email" required>
                                                </div>
                                            </div>
                                            <div class="content__input__box__inner">
                                                <div class="headline">担当者タイプ</div>
                                                <div class="input__wrap">
                                                    <div class="input__box selectBox">
                                                        <select class="bgType" v-model="charges[index].editType">
                                                            <option value="0">編集者</option>
                                                            <option value="1">閲覧者</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input__box__inner">
                                                <div class="headline">契約金額</div>
                                                <div class="input__wrap">
                                                    <div class="input__box selectBox">
                                                        <select name="" class="bgType" v-model="charges[index].contractPrice">
                                                            <option value="0">¥0</option>
                                                            <option value="5000">¥5,000</option>
                                                            <option value="10000">¥10,000</option>
                                                            <option value="15000">¥15,000</option>
                                                            <option value="20000">¥20,000</option>
                                                            <option value="25000">¥25,000</option>
                                                            <option value="30000">¥30,000</option>
                                                            <option value="35000">¥35,000</option>
                                                            <option value="40000">¥40,000</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input__box__inner">
                                                <div class="input__delete textCenter" @click="deleteCharge(index)">
                                                    <span><img src="/assets/img/icon_batu_white.png"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <div class="content__add flex__wrap f__center">
                                        <button @click="addCharge">担当者追加<span class="f__center"><img src="/assets/img/icon_add_white_bold.png" alt=""></span></button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__submit f__center">
                <div class="submit__box">
                    <button  class="clickonce" type="button" name="" value="" @click="confirm">会員追加</button>
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
        props: {},
        data() {
            // 必要に応じて変数を定義
            return {
                user: {
                    name: null
                },
                charges: [{
                    name: null,
                    phone: null,
                    email: null,
                    password: null,
                    editType: null,
                    contractPrice: null,
                }],
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

            // ユーザー登録することを確認メッセージを表示する
            confirm: function() {
                this.$refs.modal.openModal()
            },
            // ユーザー情報を登録する
            registerUser: function() {
                const params = {
                    user:       this.user,
                    // charges:    this.charges,
                    enable_sms: this.enable_sms,
                }
                axios.post('/api/users', params)
                    .then(result => {
                        location.href = '/clients/add/fin'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            addCharge: function() {
                const params = {
                    name: '',
                }
                this.charges.push(params)
            },
            deleteCharge: function(index) {
                this.charges.splice(index, 1)
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
