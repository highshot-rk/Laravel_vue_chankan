<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="executeMethod">
            <template v-slot:message>{{ message }}</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>

        <div class="content__wrap">
            <div class="content__section">
                <!-- ユーザー情報更新後のメッセージ表示 -->
                <div class="content__success" v-if="isSuccess">
                    <p>{{ this.isSuccess }}</p>
                </div>

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">スタッフ情報詳細</h1>
                        <span class="en">Charge Details</span>
                    </div>
                    <div class="content__edit">
                        <ul class="flex__wrap f__start">
                            <li><a :href="url_edit">編集</a></li>
                            <li><a @click.prevent="confirm">削除</a></li>
                        </ul>
                    </div>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">スタッフの名前</div>
                                    <div class="input__text">
                                        <span v-if="charge">{{ charge.name }}</span>
                                    </div>
                                </div>
                                <!-- <div class="content__input">
                                    <div class="headline">スタッフ専用のパスワード</div>
                                    <div class="input__text">
                                        <a v-if="charge" class="textLink" :href="'/charges/edit/password/' + charge.id" title="パスワード変更はコチラ">パスワード変更はコチラ</a>
                                    </div>
                                </div> -->
                                <div class="content__input">
                                    <div class="headline">スタッフの電話番号</div>
                                    <div class="input__text">
                                        <span v-if="charge">{{ charge.phone }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">スタッフに与える権限</div>
                                    <div class="input__text">
                                        <span v-if="charge">
                                            <span v-if="charge.edit_type == 0">編集者</span>
                                            <span v-if="charge.edit_type == 1">閲覧者</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            isSuccess: {
                type: String
            },
            isCharge: {
                type: String
            },
            isViewer: {
                type: String
            },
            urlPrefix: {
                type: String
            },
        },
        data() {
            // 必要に応じて変数を定義
            return {
                charge: null,
                message: '',
                mode: '',
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            // 担当者情報を取得
            axios.get('/api/charges/' + this.id, {})
                .then(result => {
                    this.charge = result.data
                })
                .catch(result => {
                    alert('担当者情報の取得に失敗しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義
            url_edit: function() {
                return this.urlPrefix + '/charges/edit/' + this.id
            }
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                if (this.charge.has_project) {
                    this.message = '案件に紐づいている為、担当者情報を削除できません。'
                    this.mode    = ''
                } else {
                    this.message = '担当者情報を削除します。よろしいでしょうか？'
                    this.mode    = 'delete'
                }
                this.$refs.modal.openModal()
            },
            // (モーダル表示後)モードに応じた処理を行う
            executeMethod: function() {
                if (this.mode === 'delete') {
                    this.deleteCharge()
                }
            },
            // 元請け情報を削除する
            deleteCharge: function() {
                // OKボタンが押下された場合、案件削除APIを呼び出す
                axios.delete('/api/charges/' + this.id, {})
                    .then(result => {
                        
                        alert('担当者情報を削除しました。')
                        // 削除後、元請け一覧へ戻る
                        location.href = this.urlPrefix + '/charges'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
