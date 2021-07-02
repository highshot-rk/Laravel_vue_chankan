<template>
<div>
<modal ref="modal" @parentMethod="executeMethod">
    <template v-slot:message>{{ message }}</template>
    <template v-slot:ok>OK</template>
    <template v-slot:cancel>戻る</template>
</modal>
<div class="content__manage">
    <div class="content__tab">
        <div class="content__tab__box flex__wrap two">
        <div class="content__tab__content" :class="{selected: isActive}" @click="changeIsActive(true)"><span>稼働中</span></div>
        <div class="content__tab__content"  :class="{selected: !isActive}" @click="changeIsActive(false)"><span>停止中</span></div>
        </div>
    </div>
    </div>
    <div class="content__floar">
    <div class="content__floar__inner manage_list">
    <template v-if="isActive" v-for="(manager, index) in activeManagers">
        <div class="content__box common__list manager_list">
            <a :href="url_edit(manager.id)">
                <div class="content__box__inner">
                    <div class="common__list__head">
                        <div class="title"><span>{{ manager.name }}</span></div>
                    </div>
                    <div class="common__list__body">
                        <ul class="others">
                        <li class="email bgCenterCover">{{ manager.email }}</li>
                        </ul>
                    </div>
                </div>
            </a>
            <ul class="edit edit flex__wrap f__end">
                <li class="delete" @click="confirmStop(manager.id)"><span>停止</span></li>
            </ul>

        </div>
    </template>

    <template v-if="!isActive" v-for="manager in stoppedManagers">
        <div class="content__box common__list manager_list">
            <a :href="url_edit(manager.id)">
                <div class="content__box__inner">
                    <div class="common__list__head">
                        <div class="title"><span>{{ manager.name }}</span></div>
                    </div>
                    <div class="common__list__body">
                        <ul class="others">
                        <li class="email bgCenterCover">{{ manager.email }}</li>
                        </ul>
                    </div>
                </div>
            </a>
            <ul class="edit edit flex__wrap f__end">
                <li class="revival" @click="confirmResurrect(manager.id)"><span>復活</span></li>
            </ul>
        </div>
    </template>

    <!-- <table class="matrer__list manager_list activeTable">
        <thead>
        <tr>
            <th>管理者名</th>
            <th>メールアドレス</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <template v-if="isActive" v-for="(manager, index) in activeManagers">
                <tr>
                    <td><span class="title">{{ manager.name }}</span></td>
                    <td>{{ manager.email }}</td>
                    <td>
                    <ul class="edit flex__wrap f__end">
                        <li class="edit"><a :href="url_edit(manager.id)">編集</a></li>
                        <li class="delete" @click="stopAccount(manager.id)"><span>停止</span></li>
                    </ul>
                    </td>
                </tr>
            </template>
            <template v-if="!isActive" v-for="manager in stoppedManagers">
                <tr class="stop">
                    <td><span class="title">{{ manager.name }}</span></td>
                    <td>{{ manager.email }}</td>
                    <td>
                    <ul class="edit flex__wrap f__end">
                        <li class="revival" @click="resurrectAccount(manager.id)"><span>復活</span></li>
                    </ul>
                    </td>
                </tr>
            </template>
        </tbody>
    </table> -->

    <!-- <table class="matrer__list manager_list stopTable">
        <thead>
        <tr>
            <th>管理者名</th>
            <th>メールアドレス</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <template v-if="!isActive" v-for="manager in stoppedManagers">
                <tr class="stop">
                    <td><span class="title">{{ manager.name }}</span></td>
                    <td>{{ manager.email }}</td>
                    <td>
                    <ul class="edit flex__wrap f__end">
                        <li class="revival"><span>復活</span></li>
                    </ul>
                    </td>
                </tr>
            </template>
        </tbody>
    </table> -->
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
        props: ['activeManagers', 'stoppedManagers'],
        data() {
            // 必要に応じて変数を定義
            return {
                isActive: true,
                selectedId: null,
                mode: '',
                message: ''
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

            // 編集画面のURLを取得する
            url_edit: function(id) {
                return '/manage/manager/edit/' + id
            },
            // 稼働中/停止中を切り替える
            changeIsActive: function(value) {
                this.isActive = value
            },
            confirmStop: function(id) {
                this.selectedId = id
                this.mode       = 'stop'
                this.message    = 'アカウントを停止します。よろしいでしょうか？'
                this.$refs.modal.openModal()
            },
            confirmResurrect: function(id) {
                this.selectedId = id
                this.mode       = 'resurrect'
                this.message    = 'アカウントを復活します。よろしいでしょうか？'
                this.$refs.modal.openModal()
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
