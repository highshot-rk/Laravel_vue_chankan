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
            <!-- <form name="search" action="{{ route('admin.clients.index') }}" method="GET">
                @csrf -->
                <div class="content__search__inner flex__wrap v__center">
                <div class="content__search__content input__box">
                    <input class="bgType" type="text" name="keyword" placeholder="キーワード" @change="fetch">
                </div>
                <div class="content__search__content input__box selectBox">
                    <select name="manager_id" class="bgtype" @change="fetch">
                    <option value="">担当者を選択</option>
                    <template v-for="manager in managers">
                        <option :value="manager.id">{{ manager.name }}</option>
                    </template>
                    </select>
                </div>
                <!-- <div class="content__search__content submit__box">
                    <input class="bgType" type="submit" name="" placeholder="キーワード">
                </div> -->
                </div>
            <!-- </form> -->
        </div>
        <div class="content__tab">
            <div class="content__tab__box flex__wrap two">
            <div class="content__tab__content" :class="{selected: isActice == 1}" @click="changeIsActive(1)"><span>会員</span></div>
            <div class="content__tab__content" :class="{selected: isActice == 0}" @click="changeIsActive(0)"><span>退会済み</span></div>
            </div>
        </div>
        </div>
        <div class="content__floar">
        <div class="content__floar__inner">
            <table class="matrer__list">
                <thead>
                    <tr>
                    <th>会社名<br></th>
                    <!-- <th>URL<br>電話番号</th> -->
                    <th>名前<br>メールアドレス<br>携帯電話</th>
                    <th>担当者<br></th>
                    <th>都道府県<br></th>
                    <!-- <th>郵便番号<br>住所</th> -->
                    <!-- <th>契約期間<br>契約終了予定日<br>契約金額</th>
                    <th>広告出稿履歴（登録日・解約日）</th> -->
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
                        <!-- <td><span class="url">https://cuttobi.com</span><br><span class="phone">00000000000</span></td> -->
                        <td><span class="name">{{ user.name }}</span><br><span class="email">{{ user.email }}</span><br>{{ user.phone }}</td>
                        <td><span class="zip"></span><br><span class="address">{{ user.manager.name }}</span></td>
                        <td><span class="period"></span><br><span class="date">{{ user.prefecture.name }}</span></td>
                        <!-- <td><span class="zip">〒000-0000</span><br><span class="address">{{ user.prefecture->name }}</span></td> -->
                        <!-- <td><span class="period">3ヶ月</span><br><span class="date">2020年2月2日</span><br>¥30,000</td>
                        <td>
                        <table class="histroy">
                            <tr>
                            <th>1回目</th>
                            <td>2020-03-13</td>
                            <td>2020-04-13</td>
                            </tr>
                            <tr>
                            <th>2回目</th>
                            <td>2020-05-30</td>
                            <td></td>
                            </tr>
                        </table>
                        </td> -->
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

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['managers'],
        data() {
            // 必要に応じて変数を定義
            return {
                users:      [],
                manager_id: '',
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
                    manager_id: this.manager_id,
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
                this.isActice = number
                this.fetch()
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
