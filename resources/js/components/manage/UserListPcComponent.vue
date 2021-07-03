<template>
<div class="manage_wrap">
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
            <div class="content__search__content submit__box" @click="fetch">
                <input class="bgType clickonce" type="submit" name="" placeholder="キーワード">
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
        <!-- PC表示 -->
        <table class="matrer__list">
        <thead>
            <tr>
                <th>会社名</th>
                <!-- <th>契約者</th> -->
                <th>名前</th>
                <th>メールアドレス<br>携帯電話</th>
                <th>都道府県</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="user in users">
                <tr :key="user.id">
                    <td><span class="title"><a :href="url_show(user.id)">{{ user.company }}</a></span></td>
                    <td><span class="name">{{ user.manager ? user.manager.name : "" }}</span></td>
                    <!-- <td><span v-if="user.manager.name !== null" class="name">{{ user.manager.name }}</span></td> -->
                    <!--
                    <td>
                        <template v-for="charge in user.charges">
                            <span class="name">{{ charge.name }}</span><br>
                        </template>
                    </td>
                    -->
                    <td><span class="email">{{ user.email }}</span><br>{{ user.phone }}</td>
                    <td><span class="address">{{ user.prefecture ? user.prefecture.name : "" }}</span></td>
                </tr>
            </template>
        </tbody>
        </table>
    </div>
    </div>
</div>
</template>

<script>
import axios from './../../utilities/axios'
import errorHandling from './../../utilities/handling'

export default {
    props: ['managers'],
    data() {
        return {
            users: [],
            isActive: 1,
            keyword: '',
            managerId: ''
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
        // アクティブであるか(退会していないか)をキーとし、ユーザー情報を取得
        fetch: function() {
            const params = {
                is_active:  this.isActive,
                keyword:    this.keyword,
                manager_id: this.managerId
            }
            // Ajax通信
            axios.get('/api/users', params)
            .then(result => {
                console.log(result)
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
        url_show: function(id) {
            return '/clients/detail/' + id
        }
    },
    watch: {
        // 必要に応じてメソッドを定義
    }
}
</script>
