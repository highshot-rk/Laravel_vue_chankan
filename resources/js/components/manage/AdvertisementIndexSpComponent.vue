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

            <!-- スマホ表示 -->
            <div class="tab">
                <template v-for="advertisement in advertisements">
                    <div class="content__box common__list prime__list">
                        <a :href="url_show(advertisement.id)">
                            <div class="content__box__inner">
                                <div class="common__list__head">
                                    <div class="supplement">
                                        <span class="sub">会社名</span>
                                    </div>
                                    <div class="title"><span>{{ advertisement.company }}</span></div>
                                </div>

                                <div class="url">{{ advertisement.url }}</div>
                            </div>
                        </a>
                    </div>
                </template>
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
