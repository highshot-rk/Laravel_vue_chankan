<template>
    <div class="allWrapper">
        <modal ref="modalDelete" @parentMethod="deleteUser">
            <template v-slot:message>会員を停止させます。よろしいでしょうか？</template>
            <template v-slot:ok>停止させる</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <modal ref="modalRevive" @parentMethod="revivalUser">
            <template v-slot:message>会員を復帰させます。よろしいでしょうか？</template>
            <template v-slot:ok>復帰させる</template>
            <template v-slot:cancel>戻る</template>
        </modal>
        <div class="content__wrap">
            <div class="content__section">

                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">会員情報詳細</h1>
                        <span class="en">User Detail</span>
                    </div>
                    <div class="statusLabel">
                        <template v-if="user.is_active === 1">
                            <span>会員</span>
                        </template>
                        <template v-else>
                            <span>停止済み</span>
                        </template>
                    </div>
                </div>
                <div class="content__signal">
                    <ul class="flex__wrap">
                        <li><a :href="url_edit">会員編集</a></li>
                        <template v-if="user.is_active === 1">
                            <li><a @click.prevent="confirmDelete">停止させる</a></li>
                        </template>
                        <template v-else>
                            <li><a @click.prevent="confirmRevive">復帰させる</a></li>
                        </template>
                    </ul>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                    <div class="headline">管理者名</div>
                                    <div class="input__text">
                                        <span>{{ user.manager.name }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">担当者名</div>
                                    <div class="input__text">
                                        <span>{{ user.name }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">代表者の電話番号</div>
                                    <div class="input__text">
                                        <span>{{ user.phone }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">会社名（屋号）</div>
                                    <div class="input__text">
                                        <span>{{ user.company }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">メールアドレス</div>
                                    <div class="input__text">
                                        <span>{{ user.email }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">都道府県</div>
                                    <div class="input__text">
                                        <span>{{ user.prefecture.name }}</span>
                                    </div>
                                </div>
                                <div class="content__input">
                                    <div class="headline">SMS送信の可否</div>
                                    <div class="input__text">
                                        <span>
                                            <template v-if="user.enable_sms === 1">送信可</template>
                                            <template v-else>送信不可</template>
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
                user: null
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義

            // ユーザー詳細を取得する
            axios.get('/api/users/'+this.id, {})
                .then(result => {
                    this.user = result.data
                })
                .catch(result => {
                    alert('エラーが発生しました。')
                })
        },
        computed: {
            // 必要に応じてメソッドを定義
            url_edit: function() {
                return '/clients/detail/edit/' + this.id
            },
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義

            // ボタン押下時、確認メッセージを表示する
            confirmDelete: function() {
                this.$refs.modalDelete.openModal()
            },
            confirmRevive: function() {
                this.$refs.modalRevive.openModal()
            },
            // ユーザー情報を削除する
            deleteUser: function() {
                axios.delete('/api/users/' + this.id, {})
                    .then(result => {
                        alert('ユーザーを退会させました。')
                        // 退会処理後、ユーザー一覧へ遷移
                        location.href = '/clients'
                    })
                    .catch(result => {
                        errorHandling.errorMessage(result)
                    })
            },
            // ユーザー情報を復活させる
            revivalUser: function() {
                axios.put('/api/users/' + this.id, {
                    revival : 'true'
                })
                .then(result => {
                    alert('ユーザーを復帰させました。')
                    // 退会処理後、ユーザー一覧へ遷移
                    location.href = '/clients'
                })
                .catch(result => {
                    errorHandling.errorMessage(result)
                })
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
