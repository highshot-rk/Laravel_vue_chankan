<!-- vueファイル -->
<template>
    <div class="allWrapper">
        <div class="content__wrap">
            <div class="content__section">
                <div class="content__floar">
                    <div class="content__floar__inner">
                            <!-- スマホ表示 -->
                            <div class="calender__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><span class="prev"><img src="/assets/img/icon_arrow_left_black.png" alt="" @click="showPrevMonth"></span></th>
                                            <th colspan="5">{{ year }}年{{ month }}月</th>
                                            <th><span class="next"><img src="/assets/img/icon_arrow_right_black.png" alt="" @click="showNextMonth"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="sun">日</th>
                                            <th>月</th>
                                            <th>火</th>
                                            <th>水</th>
                                            <th>木</th>
                                            <th>金</th>
                                            <th class="sat">土</th>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">1</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">2</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <span class="date">3</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">4</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">5</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">6</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">7</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">8</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">9</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <span class="date">10</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">11</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">12</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">13</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">14</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">15</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">16</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <span class="date">17</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">18</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">19</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">20</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">21</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">22</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">23</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <span class="date">24</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td class="now">
                                                <a href="">
                                                    <span class="date">25</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">26</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">27</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">28</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">29</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="">
                                                    <span class="date">30</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <span class="date">31</span>
                                                    <ul>
                                                        <li><span class="time">PM - 99</span></li>
                                                        <li><span class="time">AM - 99</span></li>
                                                    </ul>
                                                </a>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="content__submit f__center">
                                    <div class="submit__box">
                                        <a href="">未解体案件一覧</a>
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

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['initialYear', 'initialMonth'],
        data() {
            // 必要に応じて変数を定義
            return {
                year: this.initialYear,
                month: this.initialMonth,
                projects: []
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

            // 前月の案件情報を取得
            showPrevMonth: function() {
                this.month++
                if (this.month < 1) {
                    month = 12
                    this.year--
                }
                this.fetch()
            },

            // 翌月の案件情報を取得
            showNextMonth: function() {
                if (this.month > 12) {
                    month = 1
                    this.year++
                }
                this.fetch()
            },

            // 年月をキーとし、案件情報を取得
            fetch: function() {
                const params = {
                    year: this.year,
                    month: this.month,
                }
                axios.get('/api/projects', params)
                    .then(result => {
                        // 取得成功時：カレンダーへ反映
                        this.projects = []
                        this.projects.push(result.data)
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('案件情報取得時にエラーが発生しました。')
                    })
            }
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>
