<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="updateUser">
            <template v-slot:message>会員情報を更新します。よろしいでしょうか？</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">会員情報編集</h1>
                        <span class="en">User Edit</span>
                    </div>
                </div>

                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline attention must">メールアドレス</div>
                                    <div class="input__box">
                                        <input class="bgType" type="email" name="" v-model="user.email">
                                    </div>
                                </div>
                                <div class="content__input">
                                    <!-- <div class="headline attention must">担当者</div> -->
                                    <div class="input__wrap">
                                        <template v-for="(option, index) in charges">
                                            <div class="content__input__box">
                                                <div class="headline attention must">担当者</div>
                                                <div class="input__box minus__box">
                                                    <div class="content__input__box__inner">
                                                        <input class="bgType" type="text" name="" v-model="charges[index].name">
                                                    </div>
                                                    <div class="content__input__box__inner">
                                                        <input class="bgType" type="text" name="" v-model="charges[index].email">
                                                    </div>
                                                    <div class="content__input__box__inner">
                                                        <input class="bgType" type="text" name="" v-model="charges[index].phone">
                                                    </div>
                                                    <div class="content__input__box__inner">
                                                        <div class="input__box selectBox">
                                                            <select name="" class="bgType" v-model="charges[index].contract_price">
                                                                <option value="5000" selected>¥5,000</option>
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
                                                    <div class="content__input__box__inner">
                                                        <div class="input__box selectBox">
                                                            <select class="bgType" v-model="charges[index].edit_type">
                                                                <option value="0">編集者</option>
                                                                <option value="1">閲覧者</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="input__delete get">
                                                        <span @click="deleteCharge(index)"><img src="/assets/img/icon_minus_white.png"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="content__add flex__wrap f__center">
                                        <button>担当者追加
                                            <span class="f__center" @click="addCharge"><img src="/assets/img/icon_add_white_bold.png"></span>
                                        </button>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">会社名（屋号）</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="text" name="" v-model="user.company">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">代表者の電話番号（ハイフン不要）</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                            <input class="bgType" type="text" name="" v-model="user.phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline attention must">都道府県</div>
                                    <div class="input__wrap">
                                        <div class="input__box selectBox">
                                            <select class="bgType" name="" v-model="user.prefecture.id">
                                                <template v-for="option in prefectures">
                                                    <option :value="option.id">{{ option.name }}</option>
                                                </template>
                                            </select>
                                        </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__submit f__center">
                <div class="submit__box">
                    <button class="clickonce" type="button" name="" @click="confirm">会員情報更新</button>
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
        // 必要に応じて、bladeから渡されるデータを定義
        components: {
            'modal' : Modal
        },
        props: {
            id: {
                type: Number
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                user:               null,
                charges:            [],
                prefectures:        null,
                deleted_charge_ids: []
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // ユーザー詳細を取得する
            axios.get('/api/users/'+this.id, {})
                .then(result => {
                    this.user    = result.data
                    this.charges = result.data.charges
                    this.charges.forEach((charge, index, list) => {
                        if (charge.user_id == this.id) {
                            this.charges.splice(index, 1)
                        }
                    })
                })
                .catch(result => {
                    alert('会員詳細取得時にエラーが発生しました。')
                })
            // 都道府県を取得する
            axios.get('/api/prefectures', {})
                .then(result => {
                    this.prefectures = result.data
                })
                .catch(result => {
                    alert('都道府県取得時にエラーが発生しました。')
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
            // ユーザー情報を更新する
            updateUser: function() {
                const params = {
                    user              : this.user,
                    charges           : this.charges,
                    deleted_charge_ids: this.deleted_charge_ids
                }
                axios.put('/api/users/'+this.id, params)
                    .then(result => {
                        alert('会員情報を更新しました。')
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
                this.deleted_charge_ids.push(this.charges[index].id)
                this.charges.splice(index, 1)
            }

        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
