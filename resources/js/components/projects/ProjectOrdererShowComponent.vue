<template>
    <div class="allWrapper">
        <modal ref="modal" @parentMethod="executeMethod">
            <template v-slot:message>{{ message }}</template>
            <template v-slot:ok>OK</template>
            <template v-slot:cancel>戻る</template>
        </modal>

        <div class="content__wrap">
            <div class="content__section">
                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">元請け情報詳細</h1>
                        <span class="en">Prime Contractor Details</span>
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
                                    <div class="headline">携帯電話</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.phone }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">会社名</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.company }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">会社名（カナ）</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.company_kana }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">郵便番号</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">〒{{ projectOrderer.zip }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">住所</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.address }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">代表者名</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.president }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">代表者名（カナ）</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.president_kana }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.email }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">電話番号</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.tel }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">ファックス</div>
                                    <div class="input__text">
                                        <span v-if="projectOrderer">{{ projectOrderer.fax }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">備考</div>
                                    <div class="input__text remark">
                                        <span v-if="projectOrderer">{{ projectOrderer.remark }}</span>
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
                projectOrderer: null,
                message: '',
                mode: '',
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // 元請け情報を取得
            axios.get('/api/project-orderers/'+this.id, {})
                .then(result => {
                    this.projectOrderer = result.data
                })
                .catch(result => {
                    alert('元請け情報の取得に失敗しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義

            url_edit: function() {
                return this.urlPrefix + '/orderers/edit/' + this.id
            }
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirm: function() {
                if (this.projectOrderer.has_project) {
                    this.message = '案件に紐づいている為、元請け情報を削除できません。'
                    this.mode = ''
                } else {
                    this.message = '元請け情報を削除します。よろしいでしょうか？'
                    this.mode = 'delete'
                }
                this.$refs.modal.openModal()
            },
            // (モーダル表示後)モードに応じた処理を行う
            executeMethod: function() {
                if (this.mode === 'delete') {
                    this.deleteProjectOrderer()
                }
            },
            // 元請け情報を削除する
            deleteProjectOrderer: function() {
                // OKボタンが押下された場合、案件削除APIを呼び出す
                axios.delete('/api/project-orderers/' + this.id, {})
                    .then(result => {
                        alert('元請け情報を削除しました。')
                        // 削除後、元請け一覧へ戻る
                        location.href = this.urlPrefix + '/orderers'
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
