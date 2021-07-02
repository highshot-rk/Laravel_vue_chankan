<template>
<div>
    <modal ref="modal" @parentMethod="executeMethod">
        <template v-slot:message>{{ message }}</template>
        <template v-slot:ok>OK</template>
        <template v-slot:cancel>戻る</template>
    </modal>
    <div class="content__manage">
        <div class="content__search">
            <div class="content__search__inner flex__wrap v__center">
                <div class="content__search__content input__box">
                    <input class="bgType" type="text" name="keyword" placeholder="キーワード" v-model="keyword">
                </div>
                <div class="content__search__content input__box selectBox">
                    <select name="manager_id" class="bgtype" v-model="managerId">
                        <option value="">担当者を選択</option>
                        <template v-for="manager in managers">
                            <option :value="manager.id">{{ manager.name }}</option>
                        </template>
                    </select>
                </div>
                <div class="content__search__content submit__box" @click="fetch()">
                    <input class="bgType clickonce" type="submit" name="" placeholder="キーワード" @change="fetch">
                </div>
            </div>
        </div>
        <div class="content__tab">
            <div class="content__tab__box flex__wrap two">
                <div class="content__tab__content" :class="{selected: isActive == 1}" @click="changeIsActive(1)"><span>出稿中</span></div>
                <div class="content__tab__content" :class="{selected: isActive == 0}" @click="changeIsActive(0)"><span>停止中</span></div>
            </div>
        </div>
    </div>
    <div class="content__floar">
        <div class="content__floar__inner">

            <div class="pc">
            <!-- PC表示 -->
                <table class="matrer__list">
                    <thead>
                        <tr>
                            <th>会社名<br></th>
                            <th>URL<br>電話番号</th>
                            <th>担当者名<br>メールアドレス<br>携帯電話</th>
                            <th>郵便番号<br>住所</th>
                            <th>契約期間<br>契約終了予定日<br>契約金額</th>
                            <th>広告出稿履歴（登録日・解約日）</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="advertisement in advertisements">
                        <tr>
                            <td>
                                <a :href="url_show(advertisement.id)">
                                    <span class="title">{{ advertisement.company }}</span>
                                </a>
                            </td>
                            <td><span class="url">{{ advertisement.url }}</span><br>
                                <span class="phone">{{ advertisement.tel }}</span></td>
                            <td><span class="name">{{ advertisement.charge }}</span><br>
                                <span class="email">{{ advertisement.email }}</span><br>{{ advertisement.phone }}</td>
                            <td><span class="zip">〒{{ advertisement.zip }}</span><br>
                                <span class="address">{{ advertisement.address }}</span></td>
                            <td><span class="period">
                                <template v-if="advertisement.contracts">
                                    {{ advertisement.contract.period }}
                                </template>
                                </span><br>
                                <span class="date">
                                <template v-if="advertisement.contracts">
                                    {{ advertisement.contract.schedule_ended_at }}
                                </template>
                                </span><br>
                                <template v-if="advertisement.contracts">
                                    {{ advertisement.contract.price }}
                                </template>
                            </td>
                            <td>
                                <table class="histroy">
                                    <template v-for="(contract, index) in advertisement.contracts">
                                        <tr>
                                            <th>{{ index + 1 }}回目</th>
                                            <td>{{ contract.started_at }}</td>
                                            <td>{{ contract.ended_at }}</td>
                                        </tr>
                                    </template>
                                </table>
                            </td>
                        </tr>
                        </template>
                    </tbody>
                </table>
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
        // props: ['activeAdvertisements', 'stoppedAdvertisements'],
        data() {
            // 必要に応じて変数を定義
            return {
                isActive: 1,
                managers: [],
                advertisements: [],
                managerId: null,
                selectedId: null,
                keyword: '',
                mode: '',
                message: '',
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetch()
            axios.get('/api/managers', {})
                .then(result => {
                    this.managers = []
                    this.managers = result.data
                })
                .catch(result => {
                    // エラー時：アラートを表示
                    alert('管理者情報取得時にエラーが発生しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義

        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // 編集画面のURLを取得する
            url_show: function(id) {
                return '/clients/ads/detail/' + id
            },
            fetch: function() {
                // 管理者一覧を取得し、変数へセット
                const params = {
                    status:     this.isActive,
                    keyword:    this.keyword,
                    manager_id: this.managerId
                }
                axios.get('/api/advertisements', params)
                    .then(result => {
                        this.advertisements = []
                        this.advertisements = result.data
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('広告会社情報取得時にエラーが発生しました。')
                    })
            },
            // 稼働中/停止中を切り替える
            changeIsActive: function(value) {
                this.isActive = value
                this.fetch()
            },
            // アカウントを停止する
            stopAccount: function(id) {
                const params = {
                    is_active:  false,
                }
                axios.post('/api/managers/is-active/' + this.selectedId, params)
                    .then(result => {
                        // 取得成功時：画面を更新
                        alert('アカウントを停止しました。')
                        location.href = '/manage/manager'
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('アカウント情報更新時にエラーが発生しました。')
                    })
            },
            // アカウントを復活する
            resurrectAccount: function(id) {
                const params = {
                    is_active:  true,
                }
                axios.post('/api/managers/is-active/' + this.selectedId, params)
                    .then(result => {
                        // 取得成功時：画面を更新
                        alert('アカウントを復活しました。')
                        location.href = '/manage/manager'
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('アカウント情報更新時にエラーが発生しました。')
                    })
            },
            // モーダルウインドウにてOKボタンが押下された後、対応する処理を行う
            executeMethod: function() {
                if (this.mode === 'stop') {
                    this.stopAccount()
                } else {
                    this.resurrectAccount()
                }
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
