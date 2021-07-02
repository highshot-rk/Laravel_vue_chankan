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
                        <h1 class="h1">広告会社詳細</h1>
                        <span class="en">Ads Detail</span>
                    </div>

                    <div class="content__edit">
                        <ul class="flex__wrap f__start">
                            <li><a :href="url_edit">編集</a></li>
                            <li><a @click.prevent="confirmDelete">削除</a></li>
                        </ul>
                    </div>
                </div>
                <div class="content__signal">
                    <ul class="flex__wrap">
                        <li :class="{a : url_contract}"><a @click="linkToStart">広告開始</a></li>
                        <li :class="{a : url_contract}"><a @click="confirmFin">広告終了</a></li>
                    </ul>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">会社名</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.company }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">URL</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.url }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">電話番号</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.tel }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">担当者名</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.charge }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.email }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">携帯電話</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.phone }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">郵便番号</div>
                                    <div class="input__text">
                                        <span>〒{{ advertisement.zip }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">住所</div>
                                    <div class="input__text">
                                        <span>{{ advertisement.address }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">契約期間</div>
                                    <div class="input__text">
                                        <span v-if="advertisement.contracts.length > 0">
                                            {{ advertisement.contracts[0].period }}
                                        </span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">契約終了予定日</div>
                                    <div class="input__text">
                                        <span v-if="advertisement.contracts.length > 0">
                                            {{ advertisement.contracts[0].schedule_ended_at }}
                                        </span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">契約金額</div>
                                    <div class="input__text">
                                        <span v-if="advertisement.contracts.length > 0">
                                            {{ advertisement.contracts[0].price }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">広告出稿履歴</h1>
                        <span class="en">Advertising Placement History</span>
                    </div>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__table">
                                    <table class="placementHistory">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>登録日</th>
                                                <th>解約日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(option, index) in advertisement.contracts">
                                                <tr>
                                                    <th>{{ index + 1 }}回目</th>
                                                    <td>{{ option.started_at }}</td>
                                                    <td>{{ option.ended_at }}</td>
                                                </tr>
                                            </template>
                                            <!-- <tr>
                                                <th>2回目</th>
                                                <td>2020-06-13</td>
                                                <td></td>
                                            </tr> -->
                                        </tbody>
                                    </table>
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
        },
        data() {
            // 必要に応じて変数を定義
            return {
                advertisement: null,
                mode: '',
                message: ''
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // 広告会社詳細を取得する
            axios.get('/api/advertisements/'+this.id, {})
                .then(result => {
                    this.advertisement = result.data
                })
                .catch(result => {
                    errorHandling.errorMessage(result)
                })
        },
        computed: {
            // 必要に応じてメソッドを定義

            url_edit: function() {
                return '/clients/ads/detail/edit/' + this.id
            },
            url_contract: function() {
                return '/clients/ads/' + this.id + '/submit/'
            }
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirmDelete: function() {
                if (this.advertisement.status == 1) {
                    this.mode    = ''
                    this.message = '出稿中の広告が存在する為、広告会社を削除できません。'
                    this.$refs.modal.openModal()
                } else {
                    this.mode    = 'delete'
                    this.message = '広告会社を削除します。よろしいでしょうか？'
                    this.$refs.modal.openModal()
                }
            },
            // ボタン押下時、確認メッセージを表示する
            confirmFin: function() {
                if (this.advertisement.status == 0) {
                    this.mode    = ''
                    this.message = '出稿中の広告が存在しません。'
                    this.$refs.modal.openModal()
                } else {
                    this.mode    = 'fin'
                    this.message = '広告を終了します。よろしいでしょうか？'
                    this.$refs.modal.openModal()
                }
            },
            // 広告会社情報を削除する
            deleteAdvertisement: function() {
                axios.delete('/api/advertisements/' + this.id, {})
                    .then(result => {
                        alert('広告会社を削除しました。')
                        // 削除後、広告会社一覧へ遷移
                        location.href = '/clients/ads'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // 広告を終了する
            finishContract: function() {
                // OKボタンが押下された場合、広告終了APIを呼び出す
                axios.post('/api/contracts/fin/' + this.id, {})
                    .then(result => {
                        alert('広告を終了しました。')
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // モーダルウインドウにてOKボタンが押下された後、対応する処理を行う
            executeMethod: function() {
                if (this.mode === 'delete') {
                    this.deleteAdvertisement()
                } else if (this.mode === 'fin') {
                    this.finishContract()
                }
            },
            // 出稿中でない場合、広告追加画面へ遷移
            linkToStart: function() {
                if (this.advertisement.status == 0) {
                    location.href = this.url_contract
                }
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
