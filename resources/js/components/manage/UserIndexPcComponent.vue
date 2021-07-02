<template>
    <div class="content__section">
        <div class="content__header">
        <div class="content__title">
            <h1 class="h1">会員情報一覧</h1>
            <span class="en">Users List</span>
        </div>
        </div>
        <div class="content__manage">
            <div class="content__search">
                    <div class="content__search__inner flex__wrap v__center">
                    <div class="content__search__content input__box">
                        <input class="bgType" type="text" name="keyword" placeholder="キーワード" @change="fetch">
                    </div>
                    <div class="content__search__content input__box selectBox">
                        <select name="" class="bgtype" @change="fetch" v-model="managerId">
                        <option value="">担当者を選択</option>
                        <template v-for="manager in managers">
                            <option :value="manager.id">{{ manager.name }}</option>
                        </template>
                        </select>
                    </div>
                    </div>
            </div>
            <div class="content__tab">
                <div class="content__tab__box flex__wrap two">
                <div class="content__tab__content" :class="{selected: isActive == 1}" @click="changeIsActive(1)"><span>会員</span></div>
                <div class="content__tab__content" :class="{selected: isActive == 0}" @click="changeIsActive(0)"><span>退会済み</span></div>
                </div>
            </div>
        </div>
        <div class="content__floar">
            <div class="content__floar__inner">
                <table class="matrer__list">
                    <thead>
                        <tr>
                        <th>会社名<br></th>
                        <th>名前<br>メールアドレス<br>携帯電話</th>
                        <th>担当者<br></th>
                        <th>都道府県<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="user in users">
                            <tr>
                                <td>
                                    <a :href="user.id">
                                        <span class="title">{{ user.company }}</span>
                                    </a>
                                </td>
                                <td><span class="name">{{ user.name }}</span><br><span class="email">{{ user.email }}</span><br>{{ user.phone }}</td>
                                <td><span class="zip"></span><br><span class="address">{{ user.manager.name }}</span></td>
                                <td><span class="period"></span><br><span class="date">{{ user.prefecture.name }}</span></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- </div> -->
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['managers'],
        data() {
            // 必要に応じて変数を定義
            return {
                users:      [],
                managerId:  '',
                keyword:    '',
                isActive:   true
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetch()
        },
        computed: {
            // 必要に応じてメソッドを定義
        },
        methods: {
            // 必要に応じて、ボタン押下時などに呼び出すLaravelのAPIを呼び出すメソッドを定義
            // 作業日、時間タイプ、案件タイプをキーとし、案件情報を取得
            fetch: function() {
                const params = {
                    is_active:  this.isActive,
                    manager_id: this.managerId,
                    keyword:    this.keyword,
                }
                axios.get('/api/users', params)
                    .then(result => {
                        // 取得成功時：一覧へ反映
                        this.users = []
                        this.users = result.data
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('会員情報取得時にエラーが発生しました。')
                    })
            },
            changeIsActive: function(number) {
                this.isActive = number
                this.fetch()
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
