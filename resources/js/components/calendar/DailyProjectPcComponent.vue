<template>
    <div class="content__section">
        <swiper :options="swiperOption" ref="mySwiper">
            <swiper-slide v-for="(workOnItem, index) in workOnArray" :key="index">
                <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">{{ dispWorkOnString(workOnItem) }}の案件</h1>
                        <span class="en">Day of Construction</span>
                    </div>
                </div>
                <div class="content__tab">
                    <div class="content__tab__box flex__wrap four__tab">
                        <div class="content__tab__content" :class="{selected: timeType == 3}" @click="changeTimeType(3)"><span>一覧</span></div>
                        <div class="content__tab__content" :class="{selected: timeType == 1}" @click="changeTimeType(1)"><span>AM</span></div>
                        <div class="content__tab__content" :class="{selected: timeType == 2}" @click="changeTimeType(2)"><span>PM</span></div>
                        <div class="content__tab__content" :class="{selected: timeType == 0}" @click="changeTimeType(0)"><span>未定</span></div>
                    </div>
                    <div class="content__tab__box flex__wrap">
                        <div class="content__tab__content" :class="{selected: projectType == 3}" @click="changeProjectType(3)"><span>一覧</span></div>
                        <div class="content__tab__content" :class="{selected: projectType == 0}" @click="changeProjectType(0)"><span>架設</span></div>
                        <div class="content__tab__content" :class="{selected: projectType == 2}" @click="changeProjectType(2)"><span>解体</span></div>
                    </div>
                </div>
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <table class="matrer__list">
                            <thead>
                                <tr>
                                    <th>案件名<br>ステータス</th>
                                    <th>施工日<br>当日到着時間<br>営業担当</th>
                                    <th>住所<br>元請け業者<br>元請け電話番号</th>
                                    <th>備考</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(project, index_in) in workOnProjects(index)">
                                    <tr>
                                        <td>
                                            <a :href="`${urlPrefix}/projects/detail/${project.id}`">
                                                <span class="title">{{ project.name }} /
                                                    <template v-if="project.project_type_name == '解体'">
                                                        <span class="colorRed">{{ project.project_type_name }}</span>
                                                    </template>
                                                    <template v-else="project.project_type_name">
                                                        <span class="colorBlue">
                                                        {{ project.project_type_name }}
                                                        </span>
                                                    </template>
                                                </span>
                                                <br>
                                                <ul class="flex__wrap f__start status">
                                                    <li :class="{ done: project.is_surveyed }"><span>現調</span></li>
                                                    <li :class="{ done: project.is_notified }"><span>前日</span></li>
                                                    <li :class="{ done: project.is_started }"><span>開始</span></li>
                                                    <li :class="{ done: project.is_finished }"><span>終了</span></li>
                                                </ul>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="date">{{ project.work_on_string }} / {{ project.time_type_name }}</span><br>
                                            <span class="other"><span v-if="project.scheduled_arrival_time_from">{{ project.scheduled_arrival_time_from }} ~ {{ project.scheduled_arrival_time_to }}</span></span><br>
                                            <span class="charge">{{ project.charge.name }}</span></td>
                                        <td>
                                            <span class="address">{{ project.address }}</span><br>
                                            <span class="company">{{ project.project_orderer.company }}</span><br>
                                            <template v-if="project.project_orderer.phone">
                                                <span class="phone">{{ project.project_orderer.phone }}</span>
                                            </template>
                                            <template v-if="!project.project_orderer.phone">
                                                <span class="phone red">電話番号が未登録</span>
                                            </template>
                                            </td>
                                        <td class="input__box"><textarea v-model="project.remark" class="bgType remark" ref="remark" @change="modifyRemark(project.id, index_in)"></textarea></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
            <div class="swiper-button-prev" slot="button-prev" @click="slidePrev"></div>
            <div class="swiper-button-next" slot="button-next" @click="slideNext"></div>
        </swiper>
    </div>
</template>

<script>
    import axios from './../../utilities/axios'
    import errorHandling from './../../utilities/handling'
    import format from 'date-fns/format'

    export default {
        // 必要に応じて、bladeから渡されるデータを定義
        props: ['workOn', 'isCharge', 'isViewer', 'urlPrefix'],
        data() {
            // 必要に応じて変数を定義
            return {
                timeType: 3,
                projectType: 3,
                allProjects: [], // ユーザーが持つ全案件を格納
                workOnArray: [], // ユーザーが持つ全案件の各施工日を格納
                swiperOption: {
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                }
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
            // 全案件のうち、施工日で絞り込みしたものを取得
            workOnProjects: function(index) {
                let searchProjectType
                let searchTimeType
                if (this.timeType === 3) {
                    searchTimeType = [0, 1, 2]
                } else {
                    searchTimeType = [this.timeType]
                }
                if (this.projectType === 3) {
                    searchProjectType = [0, 2]
                } else {
                    searchProjectType = [this.projectType]
                }
                let workOn = this.workOnArray[index]
                return this.allProjects.filter(project => {
                    return (project.work_on_date === workOn) &&
                        (searchTimeType.includes(project.time_type)) &&
                        (searchProjectType.includes(project.project_type))
                })
            },
            // 作業日、時間タイプ、案件タイプをキーとし、案件情報を取得
            fetch: function() {
                // 案件タイプ（time_type）の配列
                let timeTypeArray = []
                if (this.timeType == 3) {
                    timeTypeArray = [0, 1, 2]
                } else if (this.timeType == 1) {
                    timeTypeArray = [1]
                } else if (this.timeType == 2) {
                    timeTypeArray = [2]
                } else if (this.timeType == 0) {
                    timeTypeArray = [0]
                }
                // 案件タイプ（project_type）の配列
                let projectTypeArray = []
                if (this.projectType == 3) {
                    projectTypeArray = [0, 2]
                } else if (this.projectType == 0) {
                    projectTypeArray = [0]
                } else if (this.projectType == 2) {
                    projectTypeArray = [2]
                }
                const params = {
                    // work_on: this.workOnCurrent,
                    time_type: timeTypeArray,
                    project_type: projectTypeArray,
                }
                axios.get('/api/projects', params)
                    .then(result => {
                        // 取得成功時：カレンダーへ反映
                        this.allProjects = []
                        this.allProjects = result.data
                        // 施工日の配列の値をセット（重複は除外）
                        this.allProjects.forEach(project => {
                            if (!this.workOnArray.includes(project.work_on_date)) {
                                this.workOnArray.push(project.work_on_date)
                            }
                        })
                        // propsで受け取った施工日をデフォルトの表示位置とする
                        this.workOnArray.forEach((workOn, index) => {
                            if (workOn === this.workOn) {
                                this.$refs.mySwiper.$swiper.slideTo(index)
                            }
                        })
                    })
                    .catch(result => {
                        // エラー時：アラートを表示
                        alert('案件情報取得時にエラーが発生しました。')
                    })
            },
            changeTimeType: function(number) {
                this.timeType = number
            },
            changeProjectType: function(number) {
                this.projectType = number
            },
            dispWorkOnString: function(workOnCurrent) {
                let splitStr = workOnCurrent.split('-')
                return splitStr[0] + '年' + splitStr[1] + '月' + splitStr[2] + '日'
            },
            modifyRemark: function(id, index) {
                this.allProjects.forEach(project => {
                    if (project.id == id) {
                        const params = {
                            remark: project.remark,
                        }
                        axios.post('/api/projects/remark/' + id, params)
                        .catch(result => {
                            // エラー時：アラートを表示
                            alert("サーバーエラーが発生しました")
                        })
                    }
                })
            },
            slidePrev: function() {
                this.$refs.mySwiper.$swiper.slidePrev()
            },
            slideNext: function() {
                this.$refs.mySwiper.$swiper.slideNext()
            },
        },
        watch: {
            // 必要に応じてメソッドを定義
        }
    }
</script>

<style lang="scss" scoped>
@import 'swiper/swiper-bundle';
</style>
